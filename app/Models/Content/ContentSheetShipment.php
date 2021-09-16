<?php

namespace App\Models\Content;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetShipment extends Model
{
    use HasFactory;

    protected $table = 'content_sheet_shipment';
    protected $guarded = [];
    protected $casts = [
        'products_json' => 'array',
    ];

    public function image() {
        return $this->hasOne(Image::class, 'content_sheet_shipment_id', 'id')
            ->where('is_head', '=', 1);
    }

    public function gallery() {
        return $this->hasMany(Image::class, 'content_sheet_shipment_id', 'id')
            ->where('is_head', '=', 0);
    }
}
