<?php

namespace App\Models\Content;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentRecordCategory extends Model
{
    use HasFactory;
    protected $table = 'content_record_category';
    protected $guarded = [];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function records() {
        return $this->hasMany(ContentRecord::class, 'content_record_category_id', 'id');
    }
}
