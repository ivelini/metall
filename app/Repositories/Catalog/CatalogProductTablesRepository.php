<?php


namespace App\Repositories\Catalog;

use Illuminate\Support\Facades\DB;

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
}