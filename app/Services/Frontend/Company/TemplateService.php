<?php


namespace App\Services\Frontend\Company;

use App\Repositories\CompanyRepository;
use App\Repositories\Frontend\Company\Theme\ThemeSettingsRepository;
use App\Repositories\Settings\SettingsCompanyInformationRepository;
use Illuminate\Support\Str;


class TemplateService
{
    private $company;
    private $themeSettingsRepository;
    private $settingsCompanyInformationRepository;

    public function __construct()
    {
        $companyRepository = new CompanyRepository();
        $this->company = $companyRepository->getCompanyFromDomainForTheme();

        $this->themeSettingsRepository = new ThemeSettingsRepository();
        $this->settingsCompanyInformationRepository = new SettingsCompanyInformationRepository();

    }

    public function getThemeSettings()
    {
        $settings = $this->camelCaseNameAttributes($this->themeSettingsRepository->getThemeVolumes($this->company));

        return $settings;
    }

    public function getValuesForHeaderTemplate()
    {
        $values = $this->settingsCompanyInformationRepository->getInformationForHeader($this->company);

        return $values;
    }

    public function getMainTemplate()
    {
        $tpl = $this->getThemeSettings();

        return 'frontend.company.' . $tpl->get('tplName') . '.layout.index';

    }

    private function camelCaseNameAttributes($collect)
    {
        $arr = collect();
        foreach ($collect as $key => $value) {
            $arr->put(Str::camel($key), $value);
        }

        return $arr;
    }
}