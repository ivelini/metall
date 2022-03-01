<?php


namespace App\Repositories\Settings;

use App\Helpers\ImageHelper;
use App\Helpers\ModelAttributeHelper;
use App\Models\Settings\SettingsCompanyInformation as Model;
use App\Repositories\CoreRepository;
use Illuminate\Support\Facades\Auth;

class SettingsCompanyInformationRepository extends CoreRepository
{
    private $imageHelper;
    private $modelAttributeHelper;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
        $this->modelAttributeHelper = new ModelAttributeHelper();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getEdit()
    {
        $object= $this->getObject();

        $object->email = Auth::user()->email;
        $object->domain = Auth::user()->company()->first()->domain;

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

    public function getInformationForHeader($company)
    {
        $this->imageHelper->getImgPathFromModel($company->information, 'medium', true);

        $company->information->img_original = !empty($company->information->image->img_original) ? $company->information->image->img_original : NULL;

        $findAttrributes = [
            'site_name',
            'site_description',
            'site_phone',
            'site_email',
            'address',
            'img_original',
            'clock_work',
            ];

        $values = $this->modelAttributeHelper->getAttributesFromModelCamelCase($company->information, $findAttrributes);

        return $values;
    }

    public function getAttribute($company, $attributeName)
    {
        $collect = $this->modelAttributeHelper->getAttributesFromModel($company->information, $attributeName);
        $value = $collect->get($attributeName);

        return $value;
    }

}