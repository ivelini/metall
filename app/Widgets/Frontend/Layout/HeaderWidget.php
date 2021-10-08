<?php

namespace App\Widgets\Frontend\Layout;

use App\Services\Frontend\Company\TemplateService;
use Arrilot\Widgets\AbstractWidget;
use Harimayco\Menu\Models\Menus;

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

        $menu = Menus::find(1);
        $header_menu = $menu->items->toArray();

        return view('frontend.company.' . $tpl->get('tplName') . '.layout.header.' .
            $tpl->get('tplHeaderName'), compact('headerValues', 'header_menu'));
    }
}