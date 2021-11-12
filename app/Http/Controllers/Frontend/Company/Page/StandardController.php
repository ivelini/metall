<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use App\Repositories\Content\ContentSheetStandartRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class StandardController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $contentSheetStandartRepository = new ContentSheetStandartRepository();
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();

        $frontendCompanyViewHelper->addModel($contentSheetPageInformationRepository->getModelFromSheetPageForFontend('page_standards', $company->id));
        $standards = $contentSheetStandartRepository->getStandardsForFrontendIndexFromCompany($company);

        $frontendCompanyViewHelper->addValue('standards', $standards);
        $frontendCompanyViewHelper->setViewPath('sections.page.standards');

        return $frontendCompanyViewHelper->getView();
    }
}
