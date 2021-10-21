<?php


namespace App\Repositories\Catalog\Interfaces;

/*
 * Методы получения и обработки продуктов по уакузакнным параметрам для репоситория продуктов
 */
interface CatalogFilterInterface
{
    //Получение значений с помошью трейта "App\Repositories\Catalog\Traits\CatalogFilterTrait" с дальнейшей обработкой
    public function getFilteredProducts($params);
}