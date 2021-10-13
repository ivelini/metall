<?php

namespace App\Http\Controllers\Frontend\Company\Sections\Records;

use App\Http\Controllers\Controller;


class RecordController extends Controller
{
    public function show($categoryId, $id)
    {
        dd(__METHOD__, $categoryId, $id);

    }
}
