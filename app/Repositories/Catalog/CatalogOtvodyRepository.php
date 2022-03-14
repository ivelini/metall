<?php


namespace App\Repositories\Catalog;

use App\Repositories\CoreRepository;
use App\Models\Catalog\CatalogOtvody as Model;
use App\Helpers\ModelAttributeHelper;
use App\Repositories\Catalog\Traits\CatalogFilterTrait;
use App\Repositories\Catalog\Interfaces\CatalogFilterInterface;


class CatalogOtvodyRepository extends CoreRepository implements CatalogFilterInterface
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

            $keyProduct = ['du', 'h', 'ugol_giba'];
            foreach ($keyProduct as $key) {
                $product->$key = rtrim(rtrim($product->$key, '0'), '.');
            }

            if ($product->price == NULL) {
                $product->price = 'По запросу';
            }

            $product->fullName = 'Отвод '. $product->ugol_giba . ' ' . $product->du . 'х' .
                $product->h . ' ' . $product->steel . ' ' . $product->standard;

            return $product;
        });

        return $list;
    }

    // TODO: Implement getFilteredProducts() method.
    public function getFilteredProducts($params)
    {
        $modelAttributeHelper = new ModelAttributeHelper();

        $products = $this->filterForRepository($params);

        foreach ($products as $product) {
            $product->ugol_giba = number_format($product->ugol_giba, 0);
            $product->du = rtrim(rtrim($product->du, '0'), '.');
            $product->h = rtrim(rtrim($product->h, '0'), '.');
            $filter[] = $product->category;
            $filter[] = $product->standard_code;
            $filter[] = $product->du;
            $product->filter = $filter;
            unset($filter);
            $product->name = 'Отвод DU ' . $product->du;
            $product->razmer = $product->du . 'х' . $product->h;
            $product->name2 = 'Отвод ' . $product->ugol_giba. ' ' . $product->du . 'х' . $product->h . ' ст.' . $product->steel . ' ' . $product->gost;
        }

        $products = $modelAttributeHelper->getAttributesFromCollectionModels($products,
            ['id', 'du', 'h', 'ugol_giba', 'gost', 'steel', 'filter', 'category', 'name', 'name2', 'razmer']);

//        dd(__METHOD__, $products);
        return $products;
    }
}