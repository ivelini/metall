<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetWorkerCategory extends Model
{
    use HasFactory;

    protected $table = 'content_sheet_worker_category';

    public function workers() {

        return $this->hasMany(ContentSheetWorker::class, 'content_sheet_worker_category_id', 'id');
    }
}
