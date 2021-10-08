<?php

namespace App\Http\Controllers\AdminPanel\Settings;

use App\Http\Controllers\Controller;

class MenuController extends Controller
{
    public function edit()
    {
        return view('admin_panel.settings.menu.edit');
    }
}
