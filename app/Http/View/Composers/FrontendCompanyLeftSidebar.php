<?php


namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Repositories\Catalog\CatalogCategoryProductRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;


class FrontendCompanyLeftSidebar
{
    /**
     * Привязать данные к шаблону.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $catalogCategoryProductRepository = new CatalogCategoryProductRepository();

        $categoriesSidebar = $catalogCategoryProductRepository->getPublishedCategoriesFromCompanyForFrontendSidebar($company);

//        dd(__METHOD__, $categoriesSidebar);
        $view->with('categoriesSidebar', $categoriesSidebar);
    }

}