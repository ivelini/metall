<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Settings\SettingsCompanyInformationRepository;

class ContactController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $settingsCompanyInformationRepository = new SettingsCompanyInformationRepository();

        $page = $settingsCompanyInformationRepository->startConditions();
        $page->title = 'Контактная информация';
        $page->description = 'Контактная информация';
        $page->h1 = 'Контактная информация компании ЮУАЗ "СТАН-2000"';
//        dd(__METHOD__);

        $frontendCompanyViewHelper->addModel($page);
        $frontendCompanyViewHelper->setViewPath('sections.page.contacts');

        return $frontendCompanyViewHelper->getView();

    }
}
