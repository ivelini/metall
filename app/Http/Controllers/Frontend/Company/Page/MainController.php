<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;


class MainController extends Controller
{
    public function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {
        $frontendCompanyViewHelper->setViewPath('layout.index');

        $view =  $frontendCompanyViewHelper->getView();

        return $view;

    }
}
