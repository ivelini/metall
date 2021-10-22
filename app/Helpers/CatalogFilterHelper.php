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

    private function groupProducts($products)
    {
        //Если фильтруем только по полю ГОСТ
        if (count($this->params) == 1 && $this->params[0][0] == 'catalog_standards_product_id') {

            //Группируем продукты в зависимости от категории
            switch ($this->tableName) {
                case 'catalog_otvody':
                    $groups = $products->groupBy('du');

                    $groups->transform(function ($value) {
                        return $value->groupBy('ugol_giba');
                    });

                    $result = $groups->transform(function ($groupDU) {
                        return $groupDU->transform(function ($groupUgolGiba, $key) {
                                    return $groupUgolGiba->sortBy('h');
                                });
                    });
                    break;

                case 'catalog_perehody':

                    $groups = $products->groupBy('du1');

                    $result = $groups->transform(function ($groupDU1) {
                                    return $groupDU1->sortBy('du2')->groupBy('du2');
                                });

                    break;

                case 'catalog_troiniki':

                    $groups = $products->groupBy('du1');

                    $result = $groups->transform(function ($groupDU1) {
                                return $groupDU1->sortBy('du2')->groupBy('du2');
                            });

                    break;

                default:

                    $result = $products->groupBy('du');
            }
        }
        else {
            switch ($this->tableName) {
                case 'catalog_perehody':
                case 'catalog_troiniki':

                    $result = $products->groupBy('du1');
                    break;

                default:

                    $result = $products->groupBy('du');
            }

        }

        return $result;
    }

    public function getResult()
    {
        $tableRepository = new $this->tableRepositoryClass();

        $products = $tableRepository->getFilteredProducts($this->params);
        $result = $this->groupProducts($products);

        return $result;
    }

}