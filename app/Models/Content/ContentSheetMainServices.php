<?php

namespace App\Models\Content;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetMainServices extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = [];

    public function image() {
        return $this->hasOne(Image::class, 'services_id', 'id');
    }
}
