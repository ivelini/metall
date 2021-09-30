<?php

namespace App\Models\Settings;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
    use HasFactory;
    protected $table = 'slider_image';
    protected $guarded = [];

    public function image() {

        return $this->hasOne(Image::class, 'slider_image_id', 'id');
    }
}
