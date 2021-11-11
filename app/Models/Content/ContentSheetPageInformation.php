<?php

namespace App\Models\Content;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetPageInformation extends Model
{
    use HasFactory;

    protected $table = 'content_sheet_page_information';
    protected $guarded = [];

    public function image() {
        return $this->hasOne(Image::class, 'content_sheet_page_information_id', 'id');
    }
}
