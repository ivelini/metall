<?php


namespace App\Repositories\Catalog;

use App\Helpers\ModelAttributeHelper;
use App\Repositories\Catalog\Interfaces\CatalogFilterInterface;
use App\Repositories\Catalog\Traits\CatalogFilterTrait;
use App\Repositories\CoreRepository;
use App\Models\Catalog\CatalogDnisha as Model;

class CatalogDnishaRepository extends CoreRepository implements CatalogFilterInterface
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

            $keyProduct = ['du', 'h'];
            foreach ($keyProduct as $key) {
                $product->$key = rtrim(rtrim($product->$key, '0'), '.');
            }

            if ($product->price == NULL) {
                $product->price = 'По запросу';
            }

            $product->fullName = 'Днище ' . $product->du . 'х' .
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
            $product->du = trim(number_format($product->du, 2, '.', ' '), '0.');
            $product->h = trim(number_format($product->h, 2, '.', ' '), '0.');
            $filter[] = $product->category;
            $filter[] = $product->standard_code;
            $filter[] = $product->du;
            $product->filter = $filter;
            unset($filter);
            $product->name = 'Днище ' . $product->du;
            $product->razmer = $product->du . 'х' . $product->h;
            $product->name2 = 'Днище ' . $product->du . 'х' . $product->h . ' ст.' . $product->steel . ' ' . $product->gost;
        }

        $result = $modelAttributeHelper->getAttributesFromCollectionModels($products,
            ['id', 'du', 'h', 'gost', 'steel', 'filter', 'name', 'name2', 'razmer']);

        return $result;
    }
}