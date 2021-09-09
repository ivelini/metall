<?php

namespace App\Models\Content;

use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetCertificate extends Model
{
    use HasFactory;
    protected $table = 'content_sheet_certificates';
    protected $guarded = [];

    public function image() {
        return $this->hasOne(Image::class, 'content_sheet_certificates_id', 'id');
    }
}
