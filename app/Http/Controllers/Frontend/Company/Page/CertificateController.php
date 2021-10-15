<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;
use App\Repositories\Content\ContentSheetCertificateRepository;

class CertificateController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper, ContentSheetCertificateRepository $contentSheetCertificateRepository)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();

        $certificates = $contentSheetCertificateRepository->getCertificatesFromCompanyForIndexFrontend($company);

        $page = $contentSheetCertificateRepository->startConditions();
        $page->title = 'Сертификаты';
        $page->description = 'Сертификаты';
        $page->h1 = 'Сертификаты';
        $frontendCompanyViewHelper->addModel($page);

        $frontendCompanyViewHelper->addValue('objects', $certificates);
        $frontendCompanyViewHelper->setViewPath('sections.page.gallery');
        return $frontendCompanyViewHelper->getView();
    }
}
