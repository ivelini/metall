<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetWorkerCategoryRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class WorkerController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $contentSheetWorkerCategoryRepository = new ContentSheetWorkerCategoryRepository();

        $company = CompanyInformationSingleton::getCompanyFromDomain();

        $page = $contentSheetWorkerCategoryRepository->startConditions();
        $page->title = 'Сотрудники';
        $page->description = 'Сотрудники';
        $page->h1 = 'Сотрудники';
        $frontendCompanyViewHelper->addModel($page);

        $workers = $contentSheetWorkerCategoryRepository->getAttributeCategoriesIncludeWorkersFromCompanyForFrontend($company);
        $frontendCompanyViewHelper->addValue('workers', $workers);
        $frontendCompanyViewHelper->setViewPath('sections.page.workers');
        return $frontendCompanyViewHelper->getView();
    }
}
