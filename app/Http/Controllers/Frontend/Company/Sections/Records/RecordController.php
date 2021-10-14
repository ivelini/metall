<?php

namespace App\Http\Controllers\Frontend\Company\Sections\Records;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentRecordRepository;


class RecordController extends Controller
{
    public function show(FrontendCompanyViewHelper $frontendCompanyViewHelper, $categoryId, $id)
    {
        $contentRecordRepository = new ContentRecordRepository();
        $record = $contentRecordRepository->getRecord($id);
        $recordContent = $contentRecordRepository->getAttributeRecordForFrontendContent($id);

        $frontendCompanyViewHelper->addModel($record);
        $frontendCompanyViewHelper->setViewPath('sections.records.record');
        $frontendCompanyViewHelper->addValue('content', $recordContent);
        return $frontendCompanyViewHelper->getView();
    }
}
