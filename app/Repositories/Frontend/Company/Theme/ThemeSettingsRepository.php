<?php


namespace App\Repositories\Frontend\Company\Theme;

use App\Models\Settings\ThemeSettings as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ThemeSettingsRepository extends CoreRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getThemeVolumes($company)
    {
        $columns = Schema::getColumnListing('theme_settings');
        $columns = array_splice($columns, 1);

        $arr = [];
        $themeSettings = $company->theme;

        foreach ($columns as $column) {
            $arr[$column] = $themeSettings->$column;
        }

        return collect($arr);
    }

}