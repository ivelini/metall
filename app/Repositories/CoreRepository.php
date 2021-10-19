<?php

namespace App\Repositories;

use App\Helpers\ImageHelper;

abstract class CoreRepository
{
    protected $model;

    abstract public function getModelClass();

    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    public function startConditions()
    {
        return clone $this->model;
    }
}