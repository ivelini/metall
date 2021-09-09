<?php

namespace App\Models\Catalog;

use App\Models\Company;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogProductsCategory extends Model
{
    use HasFactory;
    protected $table = 'catalog_product_category';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(CatalogProductsCategory::class, 'parent_id', 'id');
    }

    public function image()
    {
        return $this->hasOne(Image::class, 'catalog_product_category_id', 'id');
    }
}
