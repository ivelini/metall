<?php


namespace App\Helpers;


use Illuminate\Support\Str;

class ObserveHelper
{

    public function checkH1AndSlugColumns($model)
    {
        if($model->title == NULL) {
            $model->title = $model->h1;
        }

        if($model->slug == NULL) {
            $model->slug = Str::slug($model->h1);
        }

        return $model;
    }
}