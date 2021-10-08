<?php

namespace App\Http\Controllers\Frontend\Company\Sections\Records;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecordCategoryController extends Controller
{
    public function show($id)
    {
//        dd(__METHOD__);
        $headMetateg = collect();

        return view('frontend.company.tpl1.sections.records.category', compact('headMetateg'));
    }
}
