<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use App\Repositories\Content\ContentSheetWorkerCategoryRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class WorkerController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $contentSheetWorkerCategoryRepository = new ContentSheetWorkerCategoryRepository();
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $workers = $contentSheetWorkerCategoryRepository->getAttributeCategoriesIncludeWorkersFromCompanyForFrontend($company);

        $frontendCompanyViewHelper->addModel($contentSheetPageInformationRepository->getModelFromSheetPageForFontend('page_workers', $company->id));
        $frontendCompanyViewHelper->addValue('workers', $workers);
        $frontendCompanyViewHelper->setViewPath('sections.page.workers');
        return $frontendCompanyViewHelper->getView();
    }
}
