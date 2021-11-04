<?php

namespace App\Http\Controllers\Frontend\Company\Action;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SendFormController extends Controller
{
    public function sendRequest(Request $request)
    {
        dd(__METHOD__, $request);
        return redirect()
            ->back()
            ->with(['success' => 'Ok']);
    }

    public function sendSubscribe(Request $request)
    {
        dd(__METHOD__, $request);
    }
}
