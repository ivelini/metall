<?php


namespace App\Repositories\Catalog;

use App\Helpers\ModelAttributeHelper;
use App\Repositories\Catalog\Interfaces\CatalogFilterInterface;
use App\Repositories\Catalog\Traits\CatalogFilterTrait;
use App\Repositories\CoreRepository;
use App\Models\Catalog\CatalogFlancy as Model;

class CatalogFlancyRepository extends CoreRepository implements CatalogFilterInterface
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

            $keyProduct = ['du', 'davlenie'];
            foreach ($keyProduct as $key) {
                $product->$key = rtrim(rtrim($product->$key, '0'), '.');
            }

            if ($product->price == NULL) {
                $product->price = 'По запросу';
            }

            $product->fullName = 'Фланец ' . $product->du . 'х' .
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
            $product->du = rtrim(rtrim($product->du, '0'), '.');
            $product->davlenie = rtrim(rtrim($product->davlenie, '0'), '.');
            $filter[] = $product->category;
            $filter[] = $product->standard_code;
            $filter[] = $product->du;
            $product->filter = $filter;
            unset($filter);
            $product->name = 'Фланец Ду ' . $product->du;
            $product->davlenie = $product->davlenie;
            $product->name2 = 'Фланец Ду ' . $product->du . ' Ру ' . $product->davlenie . ' ст.' . $product->steel . ' ' . $product->gost;
        }

        $result = $modelAttributeHelper->getAttributesFromCollectionModels($products,
            ['id', 'du', 'h', 'gost', 'steel', 'filter', 'name', 'name2', 'davlenie']);

        return $result;
    }
}