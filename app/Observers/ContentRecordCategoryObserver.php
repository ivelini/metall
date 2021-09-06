<?php

namespace App\Observers;

use App\Models\ContentRecordCategory;
use Illuminate\Support\Str;

class ContentRecordCategoryObserver
{

    /**
     * Handle the ContentRecordCategory "created" event.
     *
     * @param  \App\Models\ContentRecordCategory  $contentRecordCategory
     * @return void
     */
    public function creating(ContentRecordCategory $contentRecordCategory)
    {
        if($contentRecordCategory->title == NULL) {
            $contentRecordCategory->title = $contentRecordCategory->h1;
        }

        if($contentRecordCategory->slug == NULL) {
            $contentRecordCategory->slug = Str::slug($contentRecordCategory->h1);
        }
    }

    /**
     * Handle the ContentRecordCategory "updated" event.
     *
     * @param  \App\Models\ContentRecordCategory  $contentRecordCategory
     * @return void
     */
    public function updated(ContentRecordCategory $contentRecordCategory)
    {
        //
    }

    /**
     * Handle the ContentRecordCategory "deleted" event.
     *
     * @param  \App\Models\ContentRecordCategory  $contentRecordCategory
     * @return void
     */
    public function deleted(ContentRecordCategory $contentRecordCategory)
    {
        //
    }

    /**
     * Handle the ContentRecordCategory "restored" event.
     *
     * @param  \App\Models\ContentRecordCategory  $contentRecordCategory
     * @return void
     */
    public function restored(ContentRecordCategory $contentRecordCategory)
    {
        //
    }

    /**
     * Handle the ContentRecordCategory "force deleted" event.
     *
     * @param  \App\Models\ContentRecordCategory  $contentRecordCategory
     * @return void
     */
    public function forceDeleted(ContentRecordCategory $contentRecordCategory)
    {
        //
    }
}
