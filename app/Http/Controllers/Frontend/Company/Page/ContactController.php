<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use App\Repositories\Settings\SettingsCompanyInformationRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class ContactController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();

        $page = $contentSheetPageInformationRepository->getModelFromSheetPageForFontend('page_contacts', $company->id);
        $frontendCompanyViewHelper->addModel($page);
        $frontendCompanyViewHelper->addValue('content', $page->content);
        $frontendCompanyViewHelper->setViewPath('sections.page.contacts');

        return $frontendCompanyViewHelper->getView();
    }
}
