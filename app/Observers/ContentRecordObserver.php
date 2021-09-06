<?php

namespace App\Observers;

use App\Models\ContentRecord;
use Illuminate\Support\Str;

class ContentRecordObserver
{
    public function creating(ContentRecord $contentRecord)
    {
        if($contentRecord->title == NULL) {
            $contentRecord->title = $contentRecord->h1;
        }

        if($contentRecord->slug == NULL) {
            $contentRecord->slug = Str::slug($contentRecord->h1);
        }
    }
}
