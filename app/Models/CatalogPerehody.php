<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogPerehody extends Model
{
    use HasFactory;
    protected $table = 'catalog_perehody';

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function standardProduct() {
        return $this->belongsTo(CatalogStandardsProduct::class, 'catalog_standards_product_id', 'id');
    }

    public function markaStali() {
        return $this->belongsTo(CatalogMarkiStali::class, 'catalog_marki_stali_id', 'id');
    }
}
