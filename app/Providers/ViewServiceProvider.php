<?php

namespace App\Providers;

use App\Http\View\Composers\FrontendCompanyLeftSidebar;
use App\Services\Frontend\Company\TemplateService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot(TemplateService $templateService)
    {
        $companyFromDomain = CompanyInformationSingleton::getCompanyFromDomain();

        //Если загружается шаблон компании
        if (!empty($companyFromDomain)) {

            $theme = $templateService->getThemeSettings();

            View::composer('frontend.company.' . $theme->get('tplName') . '.sections.include.left-sidebar', FrontendCompanyLeftSidebar::class);
        }

    }
}
