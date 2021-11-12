<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use App\Repositories\Content\ContentSheetShipmentRepository;
use App\Helpers\FrontendCompanyViewHelper;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class ShipmentController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $contentSheetShipmentRepository = new ContentSheetShipmentRepository();
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();

        $shipments = $contentSheetShipmentRepository->getShipmentForIndexFrontendFromCompany($company);

        $frontendCompanyViewHelper->addModel($contentSheetPageInformationRepository->getModelFromSheetPageForFontend('page_shipments', $company->id));
        $frontendCompanyViewHelper->addValue('shipments', $shipments);
        $frontendCompanyViewHelper->setViewPath('sections.shipment.category');

        return $frontendCompanyViewHelper->getView();
    }

    public function show(FrontendCompanyViewHelper $frontendCompanyViewHelper, $id)
    {
        $contentSheetShipmentRepository = new ContentSheetShipmentRepository();
        $content = $contentSheetShipmentRepository->getObjectForFrontendPage($id);
        $model = $contentSheetShipmentRepository->getObject($id);

        $frontendCompanyViewHelper->addModel($model);


        $frontendCompanyViewHelper->addValue('content', $content);
        $frontendCompanyViewHelper->setViewPath('sections.shipment.page');

        return $frontendCompanyViewHelper->getView();
    }
}
