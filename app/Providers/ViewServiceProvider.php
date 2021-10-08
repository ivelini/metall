<?php

namespace App\Providers;

use App\Http\View\Composers\Frontend\Company\HeadMeta;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        dd(__METHOD__,$company);
        View::composer('frontend.company.tpl1.sections.include.head-meta', HeadMeta::class);

    }
}
