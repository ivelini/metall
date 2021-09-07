<?php

namespace App\Observers;

use App\Helpers\ObserveHelper;
use App\Models\ContentRecordCategory;
use Illuminate\Support\Str;

class ContentRecordCategoryObserver
{

    protected $observeHelper;

    public function __construct()
    {
        $this->observeHelper = new ObserveHelper();
    }

    public function creating(ContentRecordCategory $contentRecordCategory)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentRecordCategory);
    }

    public function updating(ContentRecordCategory $contentRecordCategory)
    {
        $contentRecord = $this->observeHelper->checkH1AndSlugColumns($contentRecordCategory);
    }

}
