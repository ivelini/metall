<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetWorker extends Model
{
    use HasFactory;

    protected $table = 'content_sheet_worker';
    protected $guarded = [];

    public function image() {
        return $this->hasOne(Image::class, 'content_sheet_worker_id', 'id');
    }

    public function category() {
        return $this->belongsTo(ContentSheetWorkerCategory::class, 'content_sheet_worker_category_id', 'id');
    }
}
