<?php

namespace App\Http\Controllers\Frontend\Company\Sections\Catalog;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;
use App\Repositories\Catalog\CatalogCategoryProductRepository;


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
        $categories = $this->catalogCategoryProductRepository->getPublishedCategoriesFromCompanyForFrontend($company);

        $frontendCompanyViewHelper->addValue('categories', $categories);
        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.index');

        return $frontendCompanyViewHelper->getView();
    }

    public function showParent(FrontendCompanyViewHelper $frontendCompanyViewHelper, $id)
    {
//        dd(__METHOD__, $id);

        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.parent');

        return $frontendCompanyViewHelper->getView();
    }
}
