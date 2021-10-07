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
        $relations = $model->getRelations();

        $filtered = $this->findAttributes($model, $attributes);

        if (count($relations) > 0) {
            foreach ($relations as $key => $relation) {
                $filtered = $filtered->merge($this->findAttributes($relation, $attributes));
            }
        }

        return $filtered;
    }

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
}