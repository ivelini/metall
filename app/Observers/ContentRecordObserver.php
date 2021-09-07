<?php

namespace App\Observers;

use App\Helpers\ObserveHelper;
use App\Models\ContentRecord;

class ContentRecordObserver
{

    protected $observeHelper;

    public function __construct()
    {
        $this->observeHelper = new ObserveHelper();
    }

    public function creating(ContentRecord $contentRecord)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentRecord);
    }

    public function updating(ContentRecord $contentRecord)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentRecord);
    }
}
