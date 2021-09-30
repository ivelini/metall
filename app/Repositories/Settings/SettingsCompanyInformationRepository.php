<?php


namespace App\Repositories\Settings;

use App\Models\Settings\SettingsCompanyInformation as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;

class SettingsCompanyInformationRepository extends CoreRepository
{

    public function getModelClass()
    {
        return Model::class;
    }

    public function getEdit()
    {
        $object= $this->getObject();

        $object->email = Auth::user()->email;

        return $object;
    }

    public function getObject()
    {
        $object = $this->startConditions()
            ->where('company_id', Auth::user()->company()->first()->id)
            ->with('image','price','requisites')
            ->first();

        return $object;
    }

}