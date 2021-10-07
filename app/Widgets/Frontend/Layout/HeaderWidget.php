<?php

namespace App\Widgets\Frontend\Layout;

use App\Services\Frontend\Company\TemplateService;
use Arrilot\Widgets\AbstractWidget;

class HeaderWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run(TemplateService $templateService)
    {
        $tpl = $templateService->getThemeSettings();
        $headerValues = $templateService->getValuesForHeaderTemplate();

//        dd(__METHOD__, $headerValues);
        return view('frontend.company.' . $tpl->get('tplName') . '.layout.header.' .
            $tpl->get('tplHeaderName'), compact('headerValues'));
    }
}
