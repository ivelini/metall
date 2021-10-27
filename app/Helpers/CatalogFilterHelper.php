<?php


namespace App\Helpers;


use Illuminate\Support\Str;

/*
 * Помощник по фильтрации содержимого таблицы по входным параметрам.
 * На входе фильтруемая таблица, параметры фильтрации
 */
class CatalogFilterHelper
{
    //Фильтруемая таблица
    private $tableName;
    //Параметры фильтрации вида [[название столбца, значение], ...]
    private $params;
    //Репозиторрий таблицы, участвующей в фильтрации
    private $tableRepositoryClass;
    protected $is_filterForGost = false;

    public function __construct()
    {
        $this->params = [];
    }

    public function setTable($tableName)
    {
        $this->tableName = $tableName;
        $this->tableRepositoryClass = 'App\Repositories\Catalog\\' . ucfirst(Str::camel($tableName)) . 'Repository';
    }


    public function addParams(...$value)
    {
        if (count($value) == 1) {
            switch (gettype($value[0])) {
                case 'string':
                    $arrKeyValue = (array) json_decode($value[0]);

                    $filtr = [];
                    $paramsFiltr = [];
                    foreach ($arrKeyValue as $key => $value) {
                        $filtr[] = $key;
                        $filtr[] = '=';
                        $filtr[] = $value;
                        $paramsFiltr[] = $filtr;
                        unset($filtr);
                    }

                    $this->params = array_merge($this->params, $paramsFiltr);
                    break;

                case 'array':

                    $filtr = [];
                    foreach ($value[0] as $key => $value) {
                        $filtr[] = $key;
                        $filtr[] = '=';
                        $filtr[] = $value;;
                    }

                    $this->params[] = $filtr;
                    break;
            }
        }
        elseif (count($value) == 2) {

            $filtr[] = $value[0];
            $filtr[] = '=';
            $filtr[] = $value[1];;

            $this->params[] = $filtr;
        }
    }

    private function groupProducts($products, $endLevel)
    {
        //Если фильтруем только по полю ГОСТ
        if (count($this->params) == 1 && $this->params[0][0] == 'catalog_standards_product_id') {

            $result = $products->groupBy('name');

            switch ($this->tableName) {
                case 'catalog_perehody':
                case 'catalog_troiniki':

                $result->transform(function ($groupProducts) {
                    return $groupProducts->sortBy('h1');
                });
                    break;

                default:

                    $result->transform(function ($groupProducts) {
                        return $groupProducts->sortBy('h');
                    });
            }
        }
        else {
            switch ($this->tableName) {
                case 'catalog_perehody':
                case 'catalog_troiniki':

                if ($endLevel == false) {
                    $result = $products->sortBy('du1')->sortBy('h1');
                }
                else {
                    $result = $products->sortBy('du1');
                }

                    break;

                default:

                    if ($endLevel == false) {
                        $result = $products->sortBy('du');
                    }
                    else {
                        $result = $products->sortBy('du')->sortBy('h');
                    }
            }
        }
        return $result;
    }

    public function getResult($endLevel = false)
    {
        $tableRepository = new $this->tableRepositoryClass();

        $products = $tableRepository->getFilteredProducts($this->params);

        $result = $this->groupProducts($products, $endLevel);

        return $result;
    }


}