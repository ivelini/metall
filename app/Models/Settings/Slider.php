<?php

namespace App\Models\Settings;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $table = 'slider';
    protected $guarded = [];

    public function slides() {

        return $this->hasMany(SliderImage::class, 'slider_id', 'id');
    }

}
