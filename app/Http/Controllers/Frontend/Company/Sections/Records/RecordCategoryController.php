<?php

namespace App\Http\Controllers\Frontend\Company\Sections\Records;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentRecordCategoryRepository;
use App\Repositories\Content\ContentRecordRepository;

class RecordCategoryController extends Controller
{
    public function show(FrontendCompanyViewHelper $frontendCompanyViewHelper, $id)
    {
        $contentRecordCategoryRepository = new ContentRecordCategoryRepository();
        $contentRecordRepository = new ContentRecordRepository();

        $category = $contentRecordCategoryRepository->getCategoryAndImageRelation($id);
        $recordsAttribute = $contentRecordRepository->getAttributeRecordsFromCategoryIdForFrontedCategory($id);

        $frontendCompanyViewHelper->addModel($category);
        $frontendCompanyViewHelper->addValue('records', $recordsAttribute);
        $frontendCompanyViewHelper->setViewPath('sections.records.category');

        $view =  $frontendCompanyViewHelper->getView();

        return $view;


    }
}
