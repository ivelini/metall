<?php

namespace App\Widgets\Frontend\Layout;

use App\Services\Frontend\Company\TemplateService;
use Arrilot\Widgets\AbstractWidget;

class FooterWidget extends AbstractWidget
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

        return view('frontend.company.' . $tpl->get('tplName') . '.layout.footer.' .
            $tpl->get('tplFooterName'));
    }
}
