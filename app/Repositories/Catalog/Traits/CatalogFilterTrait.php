<?php


namespace App\Repositories\Catalog\Traits;

/*
 * Реализация методов получения значений из репозитория таблицы
 */

trait CatalogFilterTrait
{
    /*
     * Получить значения таблицы по указанным параметрам
     * На выходе коллекция значений
     */
    public function filterForRepository($params)
    {
        $products = $this->startConditions()
            ->where($params)
            ->with('standardProduct:id,name,code', 'markaStali:id,name')
            ->get();

        foreach ($products as $product) {
            $product->gost = $product->standardProduct->name;
            $product->steel = $product->markaStali->name;
            $product->standard_code = $product->standardProduct->code;
            $product->category = mb_substr($product->getTable(), mb_strripos($product->getTable(), '_') + 1);
            $filter[] = $product->category;
            $filter[] = $product->standard_code;
            $product->filter = $filter;
            unset($filter);
        }

        return $products;
    }
}