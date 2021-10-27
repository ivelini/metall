<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Settings\SliderRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;
use App\Repositories\Catalog\CatalogCategoryProductRepository;
use App\Repositories\Content\ContentSheetCertificateRepository;
use App\Repositories\Content\ContentSheetShipmentRepository;


class MainController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $sliderRepository = new SliderRepository();
        $catalogCategoryProductRepository = new CatalogCategoryProductRepository();
        $contentSheetCertificateRepository = new ContentSheetCertificateRepository();
        $contentSheetShipmentRepository = new ContentSheetShipmentRepository();

        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $slider = $sliderRepository->getSliderFrontendMainFromCompanyId($company->id);
        $catalog = $catalogCategoryProductRepository->getPublishedCategoriesFromCompanyForFrontend($company);
        $certificates = $contentSheetCertificateRepository->getCertificatesFromCompanyForIndexFrontend($company);
        $shipments = $contentSheetShipmentRepository->getShipmentForMainFrontendFromCompany($company);

        $frontendCompanyViewHelper->addValue('slider', $slider);
        $frontendCompanyViewHelper->addValue('catalog', $catalog);
        $frontendCompanyViewHelper->addValue('certificates', $certificates);
        $frontendCompanyViewHelper->addValue('shipments', $shipments);

        $frontendCompanyViewHelper->setViewPath('sections.main.page');


        return  $frontendCompanyViewHelper->getView();
    }
}
