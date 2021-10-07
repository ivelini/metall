<?php

namespace App\Http\Controllers\Frontend\Main;

use App\Http\Controllers\Controller;
use App\Services\Frontend\TemplateService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('frontend.main.index');
    }
}
