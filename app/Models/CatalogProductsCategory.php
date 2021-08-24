<?php

namespace App\Models;

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
}
