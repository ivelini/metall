<?php

namespace App\Observers\Content;

use App\Helpers\ObserveHelper;
use App\Models\Content\ContentSheetTimelinePage;

class ContentSheetTimelinePageObserver
{
    protected $observeHelper;

    public function __construct()
    {
        $this->observeHelper = new ObserveHelper();
    }

    public function creating(ContentSheetTimelinePage $contentSheetTimelinePage)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentSheetTimelinePage);
    }

    public function updating(ContentSheetTimelinePage $contentSheetTimelinePage)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentSheetTimelinePage);
    }
}
