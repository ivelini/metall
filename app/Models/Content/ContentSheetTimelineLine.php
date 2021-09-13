<?php

namespace App\Models\Content;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetTimelineLine extends Model
{
    use HasFactory;

    protected $table = 'content_sheet_timeline_line';
    protected $guarded = [];

    public function image() {
        return $this->hasOne(Image::class, 'content_sheet_timeline_line_id', 'id');
    }

    public function page() {
        return $this->belongsTo(ContentSheetTimelinePage::class, 'timeline_page_id', 'id');
    }
}
