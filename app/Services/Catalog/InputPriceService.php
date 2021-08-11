<?php


namespace App\Services\Catalog;


use App\Models\CatalogOtvody;
use App\Repositories\CatalogMarkiStaliRepository;
use App\Repositories\CatalogProductTablesRepository;
use App\Repositories\CatalogStandardRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InputPriceService
{

    protected $catalogMarkiStaliRepository;
    protected $catalogStandardRepository;
    protected $catalogProductTablesRepository;

    public function __construct()
    {
        $this->catalogMarkiStaliRepository = new CatalogMarkiStaliRepository();
        $this->catalogStandardRepository = new CatalogStandardRepository();
        $this->catalogProductTablesRepository = new CatalogProductTablesRepository();
    }

    public function input($path)
    {
        $spreadsheet = IOFactory::load(Storage::disk('local')->path($path));

        //Собираем ключи
        $keysFromExcel = $this->getKyesFromExcel($spreadsheet);

        //Валидируем ключи
        $resultValidate = $this->validateKeysFromExcel($keysFromExcel);

        /**
        * Если валидация вернула строку, то ошибка
        * Если коллекцию, то сопоставляем провалидированные ключи
        */
        if (gettype($resultValidate) == 'string') {
            return $resultValidate;
        }
        else {
            $keysFromExcel = $this->collationKeysFromExcel($keysFromExcel, $resultValidate);
        }

        //Добавляем марки стали и стандарты изготовления, если есть новые
        $this->importSteelAndStandardTable($spreadsheet, $keysFromExcel);

        //Парсим прайс
        $price = $this->parsingPrice($spreadsheet, $keysFromExcel);

        //Удаляем из таблиц данные о продукции организации
        $this->deleteProductionFromTable($keysFromExcel);

        //Добавление каталога в таблицу
        $this->insertPriceToTable($price);

        dd(__METHOD__, $price);

    }


    /**
     * Формирование ключей прайс листа вида [Название листа][Ключ колонки => Буква колонки]
     *
     * @param $path // путь к загруженному прайсу
     * @return bool|Collection
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    protected function getKyesFromExcel($spreadsheet)
    {
        ;

        $keysFromExcel = [];
        $sheets = $spreadsheet->getAllSheets();
        foreach ($sheets as $sheet) {

            $colCol = $sheet->getCellCollection()->getHighestColumn();
            $cells = $sheet->getCellCollection();
            $keysFromSheet['sheet'] = $sheet->getTitle();

            for ($col = 'A'; $col <= $colCol; $col++) {
                $keysFromSheet[mb_strtolower($cells->get($col.'1')->getValue())] = $col;
            }

            $keysFromSheet = collect($keysFromSheet);
            $keysFromExcel[] = $keysFromSheet;
            unset($keysFromSheet);

        }

        $keysFromExcel = collect($keysFromExcel);
        return $keysFromExcel;

    }

    /**
     * Проерка коректности заполнения названий листов и ключей к ним
     *
     * @param $keysFromExcel
     * @return Collection|string
     */
    protected function validateKeysFromExcel($keysFromExcel)
    {
        /*
         * Обязательнве табличные значения для листов
         * Массив вида [Название листа][Ключ1*, Ключ2, ...]
         * Звездочка (*) - обязательный ключ
         */

        $etalonKeys['Отводы']   =   ['du*', 'h*', 'steel*', 'standard*', 'ugol_giba', 'ed_izm', 'price'];
        $etalonKeys['Переходы'] =   ['du1*', 'h1*', 'du2*', 'h2*', 'model','steel*', 'standard*', 'ed_izm', 'price'];
        $etalonKeys['Тройники'] =   ['du1*', 'h1*', 'du2*', 'h2*', 'steel*', 'standard*', 'ed_izm', 'price'];
        $etalonKeys['Фланцы']   =   ['du', 'davlenie*', 'steel*', 'standard*', 'price'];
        $etalonKeys['Днища']    =   ['du*', 'h*', 'steel*', 'standard*', 'price'];

        //Проверка названия листов на корректность

        foreach ($keysFromExcel as $value) {

            $sheetExist = Arr::exists($etalonKeys, $value['sheet']);

            if ($sheetExist == false) {
                $err = 'Название листа не корректно: ' . $value['sheet'];

                return $err;
            }
        }


        $validateKeys = [];
        //Проверка существования ключей для каждого листа
        foreach ($keysFromExcel as $keysFromSheet) {

            $validateKeysFromSheet = [];
            $sheetName = $keysFromSheet['sheet'];
            $etalonKeysFromSheet = $etalonKeys[$sheetName];
            $keysFromSheet = array_slice($keysFromSheet->keys()->all(), 1);

            $etalonKeysFromSheetRequiredNotFound = [];

            foreach ($etalonKeysFromSheet as $etalonKey) {

                $etalonKeyFound = false;
                //Если эталонный ключ обязательный
                if (gettype(mb_strpos($etalonKey, '*')) == 'integer') {
                    $etalonKey = mb_substr($etalonKey, 0, mb_strpos($etalonKey, '*'));

                    foreach ($keysFromSheet as $key) {
                        if ($key == $etalonKey) {

                            $etalonKeyFound = true;
                            $validateKeysFromSheet[] = $key;

                        }
                    }

                    ($etalonKeyFound == false)? $etalonKeysFromSheetRequiredNotFound[] = $etalonKey: '';
                }
                else {

                    foreach ($keysFromSheet as $key) {
                        if ($key == $etalonKey) {
                            $validateKeysFromSheet[] = $key;
                        }
                    }
                }
            }

            //Если массив с ненайденными обязательными ключами не пуст
            if (count($etalonKeysFromSheetRequiredNotFound) > 0) {

                $err = 'Отсутствуют обязательные ключи: Лист - ' . $sheetName . '; Ключи - '
                    . implode(', ', $etalonKeysFromSheetRequiredNotFound);
                return  $err;
            }

            $validateKeys[$sheetName] = $validateKeysFromSheet;
            unset($validateKeysFromSheet);
        }

        $validateKeys = collect($validateKeys);

        return $validateKeys;
    }

    /**
     * Оставляет только провалидированные ключи в коллекции $keysFromExcel
     *
     * @param $keysFromExcel
     * @param $resultValidate
     * @return Collection
     */
    protected function collationKeysFromExcel($keysFromExcel, $resultValidate) {

        $keysFromExcel = $keysFromExcel->map(function ($keysFromSheet, $key) use ($resultValidate) {

            $sheetName = $keysFromSheet['sheet'];
            $resultValidate = $resultValidate[$sheetName];

            $keysFromSheet = $keysFromSheet->filter(function ($value, $key) use ($resultValidate) {

                if ($key == 'sheet') {
                    return true;
                    }

                foreach ($resultValidate as $resultKey) {
                    if ($key == $resultKey) {
                        return true;
                    }
                }
            });

            return $keysFromSheet;
        });

        return $keysFromExcel;
    }

    /**
     *      Парсим прайс и ищем новые значения стали (steel) и стандартов (standard) и
     *      загружаем в соответствующие таблицы "catalog_marki_stali", "catalog_standards_product"
     *
     * @param $keysFromExcel    // Массив вида [Название листа][Ключ колонки => Буква колонки]
     * @param $spreadsheet      // Объект загруженного прайса Excel
     * @return bool             // Если новые параметры для занрузки - true, если нет - false
     */
    protected function importSteelAndStandardTable($spreadsheet, $keysFromExcel)
    {
        $is_importTrue = false;
        $keysFromExcel->map(function ($sheetKeys) use ($spreadsheet) {

            $headKeys = ['steel', 'standard'];
            foreach ($headKeys as $headKey) {

                $workSheet = $spreadsheet->getSheetByName($sheetKeys['sheet']);
                $cells = $workSheet->getCellCollection();
                $colRaw = $cells->getHighestRow();

                $cellsValue = [];
                for ($iRow = 2; $iRow <= $colRaw; $iRow++) {

                    $cellsValue[] = $cells->get($sheetKeys[$headKey]. $iRow)->getValue();
                }

                $cellsValue = array_unique($cellsValue);

                //Чистка массива значений
                $cellsValueTemp = [];
                foreach ($cellsValue as $value) {

                    $cellsValueTemp[] = $this->cleanInputSteelAndStandard($value);
                }
                $cellsValue = $cellsValueTemp;

                //Получаем таблицы в зависимости от значения $headKey
                switch ($headKey) {
                    case 'steel':
                        $modelRepository = $this->catalogMarkiStaliRepository;
                        break;
                    case 'standard':
                        $modelRepository = $this->catalogStandardRepository;
                        break;
                }

                $tableListName = $modelRepository->getListNames();
                $cellsValue = collect($cellsValue);
                $diffCollectValue = $cellsValue->diff($tableListName);

                //Если есть элементы, которых нет в таблице, то вставляем
                if($diffCollectValue->isNotEmpty()) {

                    $diffCollectValue->map(function ($value) use ($modelRepository) {
                        $model = $modelRepository->startConditions();
                        $model->name = $value;
                        $model->save();
                    });

                    $is_importTrue = true;
                }

            }

        });

        if ($is_importTrue) {
            return true;
        }
        else {
            return false;
        }

    }

    /**
     * Очистка значения стали и стандарта от мусора
     *
     * @param $value
     * @return string
     */
    protected function cleanInputSteelAndStandard ($value)
    {
        $value = trim($value);
        $value = mb_strtoupper($value);

        $searchReplace = ['CТ', 'СТ.', 'СТАЛЬ'];
        foreach ($searchReplace as $item) {
            $value = str_replace($item, '', $value);
        }
        $value = trim($value);

        return $value;
    }

    /**
     * Парсим прайс лист по ключам
     *
     * @param $spreadsheet
     * @param $keysFromExcel
     * @return mixed // Массив вида [Название листа][Ключ => Значение]
     */
    protected function parsingPrice($spreadsheet, $keysFromExcel)
    {

        // Парсим каждый лист прайса
        foreach ($keysFromExcel as $keySheet) {

            $workSheet = $spreadsheet->getSheetByName($keySheet['sheet']);
            $colCol = $workSheet->getHighestRow();

            //Подставляем вместо названия стали и стандарта ID
            for ($col = 2; $col <= $colCol; $col++) {
                foreach ($keySheet as $key => $value) {
                    if ($key != 'sheet') {
                        switch ($key) {
                            case 'steel':
                                $name = $workSheet->getCell($value.$col)->getValue();
                                $name = $this->cleanInputSteelAndStandard($name);
                                $row['catalog_marki_stali_id'] = $this->catalogMarkiStaliRepository->getID($name);
                                break;
                            case 'standard':
                                $name = $workSheet->getCell($value.$col)->getValue();
                                $name = $this->cleanInputSteelAndStandard($name);
                                $row['catalog_standards_product_id'] = $this->catalogStandardRepository->getID($name);
                                break;
                            default:
                                $row[$key] = $workSheet->getCell($value.$col)->getValue();
                        }
                    }
                }
                $row['company_id'] = Auth::user()->company()->first()->id;
                dd(__METHOD__, $row);
                $rows[] = $row;
                unset($row);
            }

            $price[$keySheet['sheet']] = $rows;
            unset($rows);
        }

        $price = collect($price);

        return $price;
    }

    /**
     * @param $keysFromExcel
     */
    protected function deleteProductionFromTable($keysFromExcel)
    {
        $companyId = Auth::user()->company()->first()->id;
        $sheetsName = $keysFromExcel->pluck('sheet');

        $tablesName = $this->catalogProductTablesRepository->getTablesName($sheetsName);

        $tablesName->map(function ($tableName) use ($companyId) {
            DB::table($tableName)
                ->where('company_id', '=', $companyId)
                ->delete();
        });

        return true;
    }

    protected function insertPriceToTable($price) {

        $sheetsName = $price->keys();
        $tablesName = $this->catalogProductTablesRepository->getTablesName($sheetsName);
        $price = $tablesName->combine($price);

        $price->each(function ($value, $tableName) {

            $i = 0;
            $inc = 49;
            $length = 50;
            while ($i < count($value)) {

                $products = array_slice($value, $i, $length);
                DB::table($tableName)->insert($products);

                $i += $inc;
            }
        });

        return true;
    }

}