<?php

namespace App\Models\Content;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentSheetStandart extends Model
{
    use HasFactory;

    protected $table = 'content_sheet_standarts';
    protected $guarded = [];

    public function file() {
        return $this->hasOne(File::class, 'content_sheet_standarts_id', 'id');
    }
}
