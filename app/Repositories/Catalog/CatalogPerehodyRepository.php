<?php


namespace App\Repositories\Catalog;

use App\Helpers\ModelAttributeHelper;
use App\Repositories\Catalog\Interfaces\CatalogFilterInterface;
use App\Repositories\Catalog\Traits\CatalogFilterTrait;
use App\Repositories\CoreRepository;
use App\Models\Catalog\CatalogPerehody as Model;

class CatalogPerehodyRepository extends CoreRepository implements CatalogFilterInterface
{
    use CatalogFilterTrait;

    public function getModelClass()
    {
        return Model::class;
    }

    public function getAllForCompanyId($id)
    {

        $list = $this->startConditions()
            ->where('company_id', $id)
            ->with(['standardProduct', 'markaStali'])
            ->get();

        $list->map(function ($product) {

            $product->steel = $product->markaStali->name;
            $product->standard = $product->standardProduct->name;

            $keyProduct = ['du1', 'h1', 'du2', 'h2'];
            foreach ($keyProduct as $key) {
                $product->$key = rtrim(rtrim($product->$key, '0'), '.');
            }

            if ($product->model == NULL) {
                $product->model = 'К';
            }

            if ($product->price == NULL) {
                $product->price = 'По запросу';
            }

            $product->fullName = 'Переход '. $product->model . ' ' . $product->du1 . 'х' .
                $product->h1 . '-' . $product->du2 . 'х' .
                $product->h2 . ' ' . $product->steel . ' ' . $product->standard;

            return $product;
        });

//        dd($list->first());
        return $list;
    }

    // TODO: Implement getFilteredProducts() method.
    public function getFilteredProducts($params)
    {
        $modelAttributeHelper = new ModelAttributeHelper();

        $products = $this->filterForRepository($params);

        foreach ($products as $product) {
            $product->du1 = trim(number_format($product->du1, 2, '.', ' '), '0.');
            $product->h1 = trim(number_format($product->h1, 2, '.', ' '), '0.');
            $product->du2 = trim(number_format($product->du2, 2, '.', ' '), '0.');
            $product->h2 = trim(number_format($product->h2, 2, '.', ' '), '0.');
            $filter[] = $product->category;
            $filter[] = $product->standard_code;
            $filter[] = $product->du1 . '-' . $product->du2;
            $product->filter = $filter;
            unset($filter);
            $product->name = 'Переход ' . $product->du1 . 'х' . $product->du2;
            $product->name2 = 'Переход ' . $product->model . ' ' . $product->du1 . 'х' . $product->h1 . '-'
                . $product->du2 . 'х' . $product->h2 . ' ст.' . $product->steel . ' ' . $product->gost;
            $product->razmer = $product->du1 . 'х' . $product->h1 . ' - ' . $product->du2 . 'х' . $product->h2;
        }

        $products = $modelAttributeHelper->getAttributesFromCollectionModels($products,
            ['id', 'du1', 'h1', 'du2', 'h2', 'model', 'gost', 'steel', 'filter', 'name', 'name2', 'razmer']);

        return $products;
    }
}