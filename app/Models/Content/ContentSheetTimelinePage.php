<?php

namespace App\Models\Content;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetTimelinePage extends Model
{
    use HasFactory;

    protected $table = 'content_sheet_timeline_page';
    protected $guarded = [];

    public function lines() {
        return $this->hasMany(ContentSheetTimelineLine::class, 'timeline_page_id', 'id')
            ->orderBy('order');
    }

    public function image() {
        return $this->hasOne(Image::class, 'content_sheet_timeline_page_id', 'id');
    }
}
