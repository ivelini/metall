<?php

namespace App\Observers\Content;

use App\Helpers\ObserveHelper;
use App\Models\Content\ContentSheetShipment;

class ContentSheetShipmentObserver
{
    protected $observeHelper;

    public function __construct()
    {
        $this->observeHelper = new ObserveHelper();
    }

    public function creating(ContentSheetShipment $contentSheetShipment)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentSheetShipment);
    }

    public function updating(ContentSheetShipment $contentSheetShipment)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentSheetShipment);
    }
}
