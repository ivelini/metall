<?php


namespace App\Helpers;


/*
 * Формирование хлебных крошек. Родитель ищется по отношению "breadcrumbsParent" у модели.
 * Если есть, то формируем массив маршрутов вида [[название, имя, ...id], ]
 *
 */

class BreadcrumbsStepHelper
{
    public function getBreadcrumbsFromModel($model)
    {
        $step = $model;
        $steps[] = $step;

        while (!empty($step->breadcrumbsParent)) {
            $steps[] = $step->breadcrumbsParent;

            $step = $step->breadcrumbsParent;
        }

        $steps = array_reverse($steps);

        $breadcrumbs = [];
        foreach ($steps as $key => $step) {
            if ($key > 0) {
                $breadcrumbs[] = $this->breadcrumbStep($step, [$steps[$key - 1]->id]);
            }
            else {
                $breadcrumbs[] = $this->breadcrumbStep($step);
            }

        }

        return $breadcrumbs;
    }

    private function breadcrumbStep($model, $parameter = [])
    {
        $step['route_title'] = $model->h1;

        $route_name_table = str_replace('_', '.', $model->getTable());

        if(mb_strripos($model->getTable(), 'worker') > 0) {
            $route_name_table = 'workers';
        }

        $route_name = 'frontend.company.' . $route_name_table;

        $step['route_name'] = $route_name;

        $route_parameter[] = $model->id;

        if (count($parameter) > 0) {
            $route_parameter = array_merge($parameter, $route_parameter);
        }

        $step['route_parameter'] = $route_parameter;

        return $step;
    }
}