<?php


namespace App\Helpers;

/*
 *  Помощник для обработки атрибутов модели
 */

use Illuminate\Support\Str;

class ModelAttributeHelper
{

    /**
     * Поиск атрибутов у модели, поиск отношений и аттрибутов в этих отношених
     * На входе модель, массив искомых аттибутов вида [аттрибут1, аттрибут2, ..]
     *
     * @param $model
     * @param $attributes
     * @return \Illuminate\Support\Collection
     */
    public function getAttributesFromModel($model, $attributes = [])
    {
        $attributes = collect($attributes);
        $filtered = $this->findAttributes($model, $attributes);


        return $filtered;
    }


    /**
     * Поиск аттрибутов у модели
     * Все, если массив $attributes пустой, либо толькко знаяений массива
     *
     * @param $model
     * @param array $attributes
     * @return \Illuminate\Support\Collection
     */
    private function findAttributes($model, $attributes = [])
    {
        $modelAttributes = collect($model->getAttributes());

        if ($attributes->count() > 0) {
            $filtered = $modelAttributes->filter(function ($value, $key) use ($attributes) {
                return $attributes->contains($key);
            });
        }
        else {
            $filtered = $modelAttributes;
        }

        return $filtered;
    }

    private function camelCaseNameAttributes($collect)
    {
        $arr = collect();
        foreach ($collect as $key => $value) {
            $arr->put(Str::camel($key), $value);
        }

        return $arr;
    }

    public function getAttributesFromModelCamelCase($model, $attributes = [])
    {
        $filtered = $this->getAttributesFromModel($model, $attributes);

        return $this->camelCaseNameAttributes($filtered);
    }

    public function getAttributesFromCollectionModels($collection, $attributes = [])
    {
        $attributes = collect($attributes);

        $arr = [];
        foreach ($collection as $model) {

            $arr[] = $this->findAttributes($model, $attributes);
        }

        $arr = collect($arr);

        return $arr;
    }
}