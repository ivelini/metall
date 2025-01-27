<?php

namespace App\Providers;

use App\Models\Content\ContentRecord;
use App\Models\Content\ContentRecordCategory;
use App\Models\Content\ContentSheetShipment;
use App\Models\Content\ContentSheetTimelineLine;
use App\Models\Content\ContentSheetTimelinePage;
use App\Observers\Content\ContentSheetShipmentObserver;
use App\Observers\Content\ContentSheetTimelineLineObserver;
use App\Observers\Content\ContentSheetTimelinePageObserver;
use App\Observers\ContentRecordCategoryObserver;
use App\Observers\ContentRecordObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        ContentRecordCategory::observe(ContentRecordCategoryObserver::class);
        ContentRecord::observe(ContentRecordObserver::class);
        ContentSheetTimelinePage::observe(ContentSheetTimelinePageObserver::class);
        ContentSheetTimelineLine::observe(ContentSheetTimelineLineObserver::class);
        ContentSheetShipment::observe(ContentSheetShipmentObserver::class);
    }
}
