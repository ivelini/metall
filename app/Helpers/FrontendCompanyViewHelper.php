<?php


namespace App\Helpers;


use App\Helpers\BreadcrumbsStepHelper;
use \App\Services\Frontend\Company\TemplateService;


/*
 * Помошник при формировании view для frontend шаблона
 *
 */

class FrontendCompanyViewHelper
{
    private $viewPath;
    private $compactValues = [];

    private $templateService;

    public function __construct()
    {
        $this->templateService = new TemplateService();
        $this->compactValues['headMetateg'] = collect();
        $this->compactValues['headerPage'] = collect();
        $this->compactValues['breadcrumbs'] = collect();
    }

    public function addModel($model)
    {
        $this->setHeadMetateg($model);
        $this->setHeaderPageValue($model);
        $this->setBreadcrumbs($model);

    }

    public function addValue($key, $value)
    {
        $this->compactValues[$key] = $value;
    }

    /**
     * Формирует путь до шаблона
     *
     * @param $stringPath - переданный путь от директоии шаблона
     */
    public function setViewPath($stringPath)
    {
        $tpl = $this->templateService->getThemeSettings();

        $path = 'frontend.company.' . $tpl->get('tplName') . '.' . $stringPath;

        $this->viewPath = $path;

    }

    /**
     * Устанавливает обязательные метатеги title, description, keywords
     *
     * @param $model
     */
    private function setHeadMetateg($model)
    {
        $headMetateg = collect();

        $headMetateg->put('title', $model->title);
        $headMetateg->put('description', $model->description);

        if (!empty($model->keywords)) {
            $headMetateg->put('keywords', $model->keywords);
        }
        else {
            $headMetateg->put('keywords', '');
        }

        $this->compactValues['headMetateg'] = $headMetateg;

    }

    /**
     * @param $model
     */
    private function setHeaderPageValue($model)
    {
        $headerPage = collect();

        $headerPage->put('h1', $model->h1);

        if (!empty($model->breadcrumbsParent->image)) {
            $headerPage->put('img', '/storage' . $model->breadcrumbsParent->image->path);
        }
        else {
            $headerPage->put('img', $model->img);
        }

        $this->compactValues['headerPage'] = $headerPage;
    }

    private function setBreadcrumbs($model)
    {
        $breadcrumbsStepHelper = new BreadcrumbsStepHelper();
        $this->compactValues['breadcrumbs'] = $breadcrumbsStepHelper->getBreadcrumbsFromModel($model);
    }

    /**
     * Возвращает view с переменными для вывода
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getView()
    {
//        dd(__METHOD__, $this->compactValues);
        return view($this->viewPath, $this->compactValues);
    }
}