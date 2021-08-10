<?php


namespace App\Services\Catalog;


use App\Models\CatalogOtvody;
use App\Repositories\CatalogMarkiStaliRepository;
use App\Repositories\CatalogProductTablesRepository;
use App\Repositories\CatalogStandardRepository;
use Illuminate\Support\Arr;
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
        $resultValidateKeysFromExcel = $this->validateKeysFromExcel($keysFromExcel);

        //Если есть ошибки заполнения прайса (коллекция не пустая)
        if ($resultValidateKeysFromExcel->isNotEmpty()) {
            return $resultValidateKeysFromExcel;
        }

        //Добавляем марки стали и стандарты изготовления, если есть новые
        $this->importSteelAndStandardTable($spreadsheet, $keysFromExcel);

        //Парсим прайс
//        $price = $this->parsingPrice($spreadsheet, $keysFromExcel);

        //Удаляем из таблиц данные о продукции организации
        $this->deleteProductionFromTable($keysFromExcel);

        dd(__METHOD__, $price);

    }


    /**
     * Формирование ключей прайс листа вида [Название листа][Ключ колонки => Буква колонки]
     *
     * @param $path // путь к загруженному прайсу
     * @return bool|\Illuminate\Support\Collection
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
     * @return \Illuminate\Support\Collection //Коллекция с ошибками
     */
    protected function validateKeysFromExcel($keysFromExcel)
    {
        //Обязательнве табличные значения для листов

        $etalonKeys['Отводы']   =   ['du', 'h', 'steel', 'standard'];
        $etalonKeys['Переходы'] =   ['du', 'h', 'du2', 'h2', 'steel', 'standard'];
        $etalonKeys['Тройники'] =   ['du', 'h', 'du2', 'h2', 'steel', 'standard'];
        $etalonKeys['Фланцы']   =   ['du', 'davlenie'];
        $etalonKeys['Днища']    =   ['du', 'h'];

        //Проверка названия листов на корректность
        $errSheet = [];
        foreach ($keysFromExcel as $value) {

            $sheetExist = Arr::exists($etalonKeys, $value['sheet']);

            if ($sheetExist == false) {
                $errSheet[] = 'Название листа не корректно: ' . $value['sheet'];
            }
        }

        if (count($errSheet) > 0) {
            return collect($errSheet);
        };

        //Проверка существования обязательных ключей для каждого листа
        $resultKeysNotFound = $keysFromExcel->map(function ($value) use ($etalonKeys) {

            $etalonKeysFromSheet = $etalonKeys[$value['sheet']];
            $sheetName = $value['sheet'];
            $etalonKeysFromSheet = collect($etalonKeysFromSheet);
            $value = $value->keys();

            $keysNotFound  = $etalonKeysFromSheet->diff($value);

            if ($keysNotFound->isNotEmpty()) {

                $keysNotFound = Arr::flatten($keysNotFound);

                $strKeys = '';
                foreach ($keysNotFound as $item) {
                    $strKeys .= $item . ' ';
                }

                $strErr = 'Отсутствуют ключи: Лист: ' . $sheetName . ' - ' . $strKeys;
                return $strErr;
            }

        });


        // Если возвращены все пустые значения, то обнуляем коллекцию
        $isNull = true;
        $resultKeysNotFound->each(function ($value) {
            if ($value != null) {
                $isNull = false;
                return false;
            }
        });

        if ($isNull) {
            unset($resultKeysNotFound);
            $resultKeysNotFound = collect();
        }

        return $resultKeysNotFound;


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

    protected function importPriceTable($sheet, $rows) {
        switch ($sheet) {
            case 'Отводы':
                $modelOtvody = new CatalogOtvody();
                foreach ($rows as $row) {
                    $modelOtvody->create($row);
                }
                break;

        }

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
                $rows[] = $row;
            }

            $price[$keySheet['sheet']] = $rows;
            unset($rows);
        }

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

}