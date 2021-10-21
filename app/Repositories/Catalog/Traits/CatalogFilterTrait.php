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
            ->with('standardProduct:id,name', 'markaStali:id,name')
            ->get();

        foreach ($products as $product) {
            $product->gost = $product->standardProduct->name;
            $product->steel = $product->markaStali->name;;
        }

        return $products;
    }
}