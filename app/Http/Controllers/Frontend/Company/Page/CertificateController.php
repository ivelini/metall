<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;
use App\Repositories\Content\ContentSheetCertificateRepository;

class CertificateController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper, ContentSheetCertificateRepository $contentSheetCertificateRepository)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $certificates = $contentSheetCertificateRepository->getCertificatesFromCompanyForIndexFrontend($company);

        $frontendCompanyViewHelper->addModel($contentSheetPageInformationRepository->getModelFromSheetPageForFontend('page_certificates', $company->id));

        $frontendCompanyViewHelper->addValue('objects', $certificates);
        $frontendCompanyViewHelper->setViewPath('sections.page.gallery');
        return $frontendCompanyViewHelper->getView();
    }
}
