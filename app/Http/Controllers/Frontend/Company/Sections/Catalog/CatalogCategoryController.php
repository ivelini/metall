<?php

namespace App\Http\Controllers\Frontend\Company\Sections\Catalog;

use App\Helpers\FrontendCompanyViewHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogCategoryController extends Controller
{
    protected function index(FrontendCompanyViewHelper $frontendCompanyViewHelper)
    {

//        dd(__METHOD__);

        $frontendCompanyViewHelper->setViewPath('sections.catalog.category.index');

        return $frontendCompanyViewHelper->getView();
    }
}
