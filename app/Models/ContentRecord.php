<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentRecord extends Model
{
    use HasFactory;
    protected $table = 'content_record';
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(ContentRecordCategory::class, 'content_record_category_id', 'id');
    }

    public function image() {
        return $this->hasOne(Image::class, 'content_record_id', 'id');
    }
}
