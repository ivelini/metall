<?php

namespace App\Models\Settings;

use App\Models\File;
use App\Models\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingsCompanyInformation extends Model
{
    use HasFactory;
    protected $table = 'company_information';
    protected $guarded = [];
    protected $casts = [
        'storages' => 'array',
        'agency' => 'array',
    ];

    public function logo() {
        return $this->hasOne(Image::class, 'company_information_id', 'id');
    }

    public function price() {
        return $this->hasOne(File::class, 'price_company_information_id', 'id');
    }

    public function requisites() {
        return $this->hasOne(File::class, 'requisites_company_information_id', 'id');
    }
}
