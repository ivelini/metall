<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetStandartRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class StandardController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $contentSheetStandartRepository = new ContentSheetStandartRepository();

        $page = $contentSheetStandartRepository->startConditions();
        $page->title = 'Стандарты, применяемые на производстве';
        $page->description = 'Стандарты, применяемые на производстве';
        $page->h1 = 'Стандарты продукции';

        $frontendCompanyViewHelper->addModel($page);
        $standards = $contentSheetStandartRepository->getStandardsForFrontendIndexFromCompany($company);

        $frontendCompanyViewHelper->addValue('standards', $standards);
        $frontendCompanyViewHelper->setViewPath('sections.page.standards');

        return $frontendCompanyViewHelper->getView();
    }
}
