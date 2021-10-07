<?php

namespace App\Http\Controllers\Frontend\Company\Page;

use App\Http\Controllers\Controller;
use App\Services\Frontend\Company\TemplateService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(TemplateService $templateService)
    {
         return view($templateService->getMainTemplate());
    }
}
