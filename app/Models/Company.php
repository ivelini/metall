<?php

namespace App\Models;

use App\Models\Catalog\CatalogProductsCategory;
use App\Models\Content\ContentSheetWorkerCategory;
use App\Models\Settings\SettingsCompanyInformation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';

    public function users() {
        return $this->belongsToMany(User::class, 'user_company', 'user_id', 'id');
    }

    public function catalogProductCategories() {
        return $this->hasMany(CatalogProductsCategory::class, 'company_id', 'id');
    }

    public function contentSheetWorkerCategory()
    {
        return $this->hasMany(ContentSheetWorkerCategory::class, 'company_id', 'id');
    }

    public function information() {
        return $this->hasOne(SettingsCompanyInformation::class, 'company_id', 'id');
    }
}
