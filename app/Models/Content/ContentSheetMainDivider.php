<?php

namespace App\Models\Content;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetMainDivider extends Model
{
    use HasFactory;

    protected $table = 'divider';
    protected $guarded = [];

    public function image() {
        return $this->hasOne(Image::class, 'divider_id', 'id');
    }
}
