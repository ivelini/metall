<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetTimelinePageRepository;


class TimelinePageController extends Controller
{
    public function show(FrontendCompanyViewHelper $frontendCompanyViewHelper,
                         ContentSheetTimelinePageRepository $contentSheetTimelinePageRepository, $id)
    {
        $arr = $contentSheetTimelinePageRepository->getPageContentAndLinesForFrontendShow($id);
        $page = $contentSheetTimelinePageRepository->getPage($id);

        $frontendCompanyViewHelper->addModel($page);
        $frontendCompanyViewHelper->addValue('content', $arr['content']);
        $frontendCompanyViewHelper->addValue('lines', $arr['lines']);
        $frontendCompanyViewHelper->setViewPath('sections.page.timeline');

        return $frontendCompanyViewHelper->getView();
    }
}
