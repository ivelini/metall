<?php


namespace App\Repositories\Catalog;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;


class CatalogProductTablesRepository
{

    /**
     * Получаем массив названий таблиц, соответствующим названиям листов
     *
     * @param $sheetName
     * @return mixed
     */
    public function getTablesName($sheetName)
    {

        $catalogTables = $this->getCatalogProductTables();

        $tablesName = $sheetName->map(function ($sheet) use ($catalogTables) {

            $sheet = mb_strtolower($sheet);
            $sheet = $this->translit($sheet);

            foreach ($catalogTables as $table) {

                if (strpos($table, $sheet) > 0) {
                    return $table;
                }
            }
        });

        return $tablesName;
    }

    protected function getCatalogProductTables()
    {
        $tablesAll = DB::select('SHOW TABLES');

        $catalogTables = [];
        foreach ($tablesAll as $key => $value) {
            $value = head($value);

            if (gettype(strpos($value, 'catalog_')) == 'integer'
                && strpos($value, 'marki_stali') == false
                && strpos($value, 'standards_product') == false
                && strpos($value, 'product_category') == false) {

                $catalogTables[] = $value;
            }
        }

        return $catalogTables;
    }

    protected function translit($input){
        $arr = array(
            "а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
            "е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i",
            "й"=>"i","к"=>"k","л"=>"l", "м"=>"m","н"=>"n",
            "о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t",
            "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch",
            "ш"=>"sh","щ"=>"sh","ы"=>"y","э"=>"e","ю"=>"u",
            "я"=>"ya",
            "А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
            "Е"=>"E","Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I",
            "Й"=>"I","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
            "О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
            "У"=>"Y","Ф"=>"F","Х"=>"H","Ц"=>"C","Ч"=>"Ch",
            "Ш"=>"Sh","Щ"=>"Sh","Ы"=>"I","Э"=>"E","Ю"=>"U",
            "Я"=>"Ya",
            "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"",
            "ї"=>"j","і"=>"i","ґ"=>"g","є"=>"ye",
            "Ї"=>"J","І"=>"I","Ґ"=>"G","Є"=>"YE"
        );
        return strtr($input, $arr);
    }

    /**
     * Выборка таблиц каталога, если продлукты данной компании присутствуют
     *
     * @param $companyId
     * @return array
     */
    public function getTablesProductFromCompanyId($companyId)
    {
        $catalogTables = $this->getCatalogProductTables();

        $tablesProductFromCompany = [];
        foreach ($catalogTables as $table) {
            $porductionCount = DB::table($table)
                ->select('id', 'company_id')
                ->where('company_id', '=', $companyId)
                ->count();

            if ($porductionCount > 0) {

                $tablesProductFromCompany[] = $table;
            }
        }

        return $tablesProductFromCompany;
    }

    public function getColumnsFromTableNameForFilter($tableName)
    {

        $listColumnsTable = collect(Schema::getColumnListing($tableName));

        $excludeColumn = collect([
            'id',
            'company_id',
            'ed_izm',
            'price',
            'created_at',
            'updated_at'
        ]);

        $columnForFilter = $listColumnsTable->diff($excludeColumn);

        return $columnForFilter;
    }

    public function getUniqVolumeFromColumn($columns, $tableName)
    {
        $model = $this->getModelClass($tableName);
        $companyId = Auth::user()->company()->first()->id;

        $uniqVolume = [];
        foreach ($columns as $column) {
            $listVolume = $model->select('id', $column)
                ->where('company_id', $companyId)
                ->pluck($column)
                ->unique();

            $uniqVolume[$column] = $listVolume;
        }

        $generalTables['catalog_standards_product_id'] = 'catalog_standards_product';
        $generalTables['catalog_marki_stali_id'] = 'catalog_marki_stali';

        foreach ($generalTables as $key => $tableName) {
            $uniqVolume[$key] = $uniqVolume[$key]->map(function ($volume) use ($tableName) {
                $standardName = $this->getModelClass($tableName)
                    ->select('id', 'name')
                    ->where('id', $volume)
                    ->first()
                    ->name;
                $standardName = $standardName . ':' . $volume;
                return $standardName;
            });
        }

        return $uniqVolume;
    }

    public function selectUniqVolumes($uniqVolumes, $selectedVolumeFromColumns)
    {
        foreach ($selectedVolumeFromColumns as $keyName => $selectVolume) {
            if ($keyName != 'catalog_standards_product_id' && $keyName != 'catalog_marki_stali_id') {
                $uniqVolumes[$keyName] = $uniqVolumes[$keyName]->map(function ($volume) use ($selectVolume) {
                    if ($volume == $selectVolume) {
                        return '+' . $volume;
                    }

                    return $volume;
                });
            }
            else {
                $uniqVolumes[$keyName] = $uniqVolumes[$keyName]->map(function ($value) use ($selectVolume) {
                    $valueIdSelected = mb_substr($value, mb_strripos($value, ':', 0, 'utf8') + 1);

                    if ($valueIdSelected == $selectVolume) {
                        return '+' . $value;
                    }

                    return $value;
                });
            }

        }

        return $uniqVolumes;
    }

    public function getModelClass($tableName)
    {
        $modelClass = 'App\Models\Catalog\\' . ucfirst(Str::camel($tableName));
        $model = new $modelClass();

        return $model;
    }
}