<?php

namespace App\Http\Controllers\Frontend\Company\Sections\Catalog;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;
use App\Repositories\Catalog\CatalogCategoryProductRepository;
use App\Repositories\Content\ContentSheetMainCatalogRepository;


class CatalogCategoryController extends Controller
{
    private $catalogCategoryProductRepository;

    public function __construct()
    {
        $this->catalogCategoryProductRepository = new CatalogCategoryProductRepository();
    }

    protected function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $categories = $this->catalogCategoryProductRepository->getPublishedParentCategoriesFromCompanyForFrontend($company);
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $content = $contentSheetPageInformationRepository->getContentFromSheetPageForFontend('page_catalog', $company->id);

        $frontendCompanyViewHelper->addModel($contentSheetPageInformationRepository->getModelFromSheetPageForFontend('page_catalog', $company->id));
        $frontendCompanyViewHelper->addValue('categories', $categories);
        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.index');

        return $frontendCompanyViewHelper->getView();
    }

    public function showParent(FrontendCompanyViewHelper $frontendCompanyViewHelper, $id)
    {
        $childrenCat = $this->catalogCategoryProductRepository->getChildrenCategoryFromParentIdForCompanyFrontend($id);
        $parentCategory = $this->catalogCategoryProductRepository->getModelForId($id);
        $content = $parentCategory->content;

        $frontendCompanyViewHelper->addModel($parentCategory);
        $frontendCompanyViewHelper->addValue('childrenCat', $childrenCat);
        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.parent');

        return $frontendCompanyViewHelper->getView();
    }

    public function show(FrontendCompanyViewHelper $frontendCompanyViewHelper, $parentId, $id)
    {
        $porducts = $this->catalogCategoryProductRepository->getProductsFromFilterCategoryId($id);
        $content = $this->catalogCategoryProductRepository->getCategoryContentForForntendCompany($id);
        $category = $this->catalogCategoryProductRepository->getCategory($id);
        $category->img = $this->catalogCategoryProductRepository->getImgPathFromCategoryId($category->parent_id, 'medium', true);

        $frontendCompanyViewHelper->addModel($category);

        $frontendCompanyViewHelper->addValue('is_filterForGostOnly', $this->catalogCategoryProductRepository->is_filterForGostOnly($id));
        $frontendCompanyViewHelper->addValue('is_endLevel', false);
        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->addValue('products', $porducts);
        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.show');

        return $frontendCompanyViewHelper->getView();
    }

    /*
     * Выборка продуктов по параметрам Категория -> ГОСТ -> DU
     */
    public function categoryFilter(FrontendCompanyViewHelper $frontendCompanyViewHelper, $categoryName, $standard, $du)
    {
        $porducts = $this->catalogCategoryProductRepository->getProductsFromCategoryStandardDu($categoryName, $standard, $du);
        $content = collect();

        $filterCategory = $this->catalogCategoryProductRepository->getCategoryForCategoryName($categoryName);
        $filterCategory->title = $porducts->first()->get('name') . ' ' . $porducts->first()->get('gost');
        $filterCategory->title = $filterCategory->category_name . ''
            .mb_substr($filterCategory->title, mb_strpos($filterCategory->title, ' '));
        $filterCategory->h1 = $filterCategory->title;

        $content->put('h1', $filterCategory->h1);

        $infoFilteredProduct = $this->catalogCategoryProductRepository->getInfoFromFilteredProducts($porducts);

        $infoForCategoryFromStandardName = $this->catalogCategoryProductRepository
            ->getInfoForCategoryFromStandard($infoFilteredProduct->get('Стандарт'));

        if(empty($infoForCategoryFromStandardName)) {
            $infoForCategoryFromStandardName = $this->catalogCategoryProductRepository
                ->getInfoForCategoryId($filterCategory->id);
        }

        $content->put('img', $infoForCategoryFromStandardName->get('img'));

        $frontendCompanyViewHelper->addModel($filterCategory);
        $frontendCompanyViewHelper->addValue('is_filterForGostOnly', false);
        $frontendCompanyViewHelper->addValue('is_endLevel', true);
        $frontendCompanyViewHelper->addValue('products', $porducts);
        $frontendCompanyViewHelper->addValue('infoFilteredProduct', $infoFilteredProduct);
        $frontendCompanyViewHelper->addValue('content', $content);

        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.show');

        return $frontendCompanyViewHelper->getView();
    }
}
