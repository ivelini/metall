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
        $content = $contentSheetPageInformationRepository->getContentFromSheetPageForFrontend('page_catalog', $company->id);

        $frontendCompanyViewHelper->addModel($contentSheetPageInformationRepository->getModelFromSheetPageForFontend('page_catalog', $company->id));
        $frontendCompanyViewHelper->addValue('categories', $categories);
        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.index');

        return $frontendCompanyViewHelper->getView();
    }

    public function showParent(FrontendCompanyViewHelper $frontendCompanyViewHelper, $parentCategorySlug)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $parentId = $this->catalogCategoryProductRepository->getIdCategoryFromSlug($parentCategorySlug);
        $childrenCat = $this->catalogCategoryProductRepository->getChildrenCategoryFromParentIdForCompanyFrontend($parentId);
        $parentCategory = $this->catalogCategoryProductRepository->getModelForId($parentId);
        $content = $parentCategory->content;

        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $headerPage = collect();
        $headerPage->put('h1', $parentCategory->h1);
        $headerPage->put('img', $contentSheetPageInformationRepository->getImageFromSheetPageForFrontend('page_catalog', $company->id));

        $frontendCompanyViewHelper->addModel($parentCategory);
        $frontendCompanyViewHelper->addValue('childrenCat', $childrenCat);
        $frontendCompanyViewHelper->addValue('parentCategorySlug', $parentCategorySlug);
        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->addValue('headerPage', $headerPage);
        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.parent');

        return $frontendCompanyViewHelper->getView();
    }

    public function show(FrontendCompanyViewHelper $frontendCompanyViewHelper, $parentCategorySlug, $categorySlug)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $categoryId = $this->catalogCategoryProductRepository->getIdCategoryFromSlug($categorySlug);
        $porducts = $this->catalogCategoryProductRepository->getProductsFromFilterCategoryId($categoryId);
        $content = $this->catalogCategoryProductRepository->getCategoryContentForForntendCompany($categoryId);
        $category = $this->catalogCategoryProductRepository->getCategory($categoryId);
        $content->put('img', $this->catalogCategoryProductRepository->getImgPathFromCategoryId($category->id, 'medium', true));
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $headerPage = collect();
        $headerPage->put('h1', $category->h1);
        $headerPage->put('img', $contentSheetPageInformationRepository->getImageFromSheetPageForFrontend('page_catalog', $company->id));

        $frontendCompanyViewHelper->addModel($category);

        $frontendCompanyViewHelper->addValue('is_filterForGostOnly', $this->catalogCategoryProductRepository->is_filterForGostOnly($categoryId));
        $frontendCompanyViewHelper->addValue('is_endLevel', false);
        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->addValue('products', $porducts);
        $frontendCompanyViewHelper->addValue('headerPage', $headerPage);
        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.show');

        return $frontendCompanyViewHelper->getView();
    }

    /*
     * Выборка продуктов по параметрам Категория -> ГОСТ -> DU
     */
    public function categoryFilter(FrontendCompanyViewHelper $frontendCompanyViewHelper, $categoryName, $standard, $du)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $porducts = $this->catalogCategoryProductRepository->getProductsFromCategoryStandardDu($categoryName, $standard, $du);
        $filterCategory = $this->catalogCategoryProductRepository->getCategoryForCategoryName($categoryName);
        $infoFilteredProduct = $this->catalogCategoryProductRepository->getInfoFromFilteredProducts($porducts);

        $infoForCategoryFromStandardName = $this->catalogCategoryProductRepository
            ->getInfoForCategoryFromStandard($infoFilteredProduct->get('Стандарт'));

        if(empty($infoForCategoryFromStandardName)) {
            $infoForCategoryFromStandardName = $this->catalogCategoryProductRepository
                ->getInfoForCategoryId($filterCategory->id);
        }

        $synonymized = $this->catalogCategoryProductRepository
            ->getSynonymizerContentFromCategoryId($infoForCategoryFromStandardName->get('id'), $infoFilteredProduct);

        $filterCategory->h1 = $porducts->first()->get('name') . ' ' . $porducts->first()->get('gost');
        $filterCategory->h1 = $filterCategory->category_name . ''
            .mb_substr($filterCategory->h1, mb_strpos($filterCategory->h1, ' '));
        $filterCategory->title = $synonymized->get('synonymizer_title');
        $filterCategory->description = $synonymized->get('synonymizer_description');

        $content = collect();
        $content->put('h1', $filterCategory->h1);
        $content->put('img', $infoForCategoryFromStandardName->get('img'));
        $content->put('synonymizer_content', $synonymized->get('synonymizer_content'));

        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $headerPage = collect();
        $headerPage->put('h1', $filterCategory->h1);
        $headerPage->put('img', $contentSheetPageInformationRepository->getImageFromSheetPageForFrontend('page_catalog', $company->id));

        $frontendCompanyViewHelper->addModel($filterCategory);
        $frontendCompanyViewHelper->addValue('is_filterForGostOnly', false);
        $frontendCompanyViewHelper->addValue('is_endLevel', true);
        $frontendCompanyViewHelper->addValue('products', $porducts);
        $frontendCompanyViewHelper->addValue('infoFilteredProduct', $infoFilteredProduct);
        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->addValue('headerPage', $headerPage);

        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.show');

        return $frontendCompanyViewHelper->getView();
    }
}
