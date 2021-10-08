<?php


namespace App\Http\View\Composers\Frontend\Company;

use Illuminate\View\View;


class HeadMeta
{
    public function compose(View $view)
    {
        $headMetateg = collect();

        $view->with('headMetateg', $headMetateg);
    }

}