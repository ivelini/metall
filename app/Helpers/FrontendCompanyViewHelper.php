<?php


namespace App\Helpers;


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
        $this->compactValues['innerBanner'] = collect();
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
    public function setHeadMetateg($model)
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

    public function setInnerBanner($model)
    {
        $innerBanner = collect();

        $innerBanner->put('h1', $model->h1);
//        dd(__METHOD__, $model);

        $this->compactValues['innerBanner'] = $innerBanner;
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