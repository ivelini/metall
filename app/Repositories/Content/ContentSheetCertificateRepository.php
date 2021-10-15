<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetCertificate as Model;
use App\Helpers\ModelAttributeHelper;

class ContentSheetCertificateRepository extends CoreRepository
{
    protected $imageHelper;
    protected $modelAttributeHelper;

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

    private function getCetificatesFromCompany($company)
    {
        $certificates =$this->startConditions()
            ->where('company_id', $company->id)
            ->with('image:id,path,content_sheet_certificates_id')
            ->get();

        return $certificates;
    }

    public function getCertificatesFromCompanyForIndex($company)
    {

        $certificates = $this->getCetificatesFromCompany($company);

        foreach ($certificates as $certificate) {
            $this->imageHelper->getImgPathFromModel($certificate, 'medium', true);
        }

        $certificates = $certificates->chunk(4);

        return $certificates;
    }

    public function getCertificateForEdit($id)
    {
        $certificate = $this->startConditions()
            ->where('id', $id)
            ->with('image:id,path,content_sheet_certificates_id')
            ->first();

        $this->imageHelper->getImgPathFromModel($certificate, 'medium');

        return $certificate;
    }

    public function getCertificate($id)
    {
        $certificate = $this->startConditions()
            ->where('id', $id)
            ->first();

        return$certificate;
    }

    public function getCertificatesFromCompanyForIndexFrontend($company)
    {
        $certificates = $this->getCetificatesFromCompany($company);

        foreach ($certificates as $certificate) {
            $this->imageHelper->getImgPathFromModel($certificate, 'large', true);
            $certificate->img = $certificate->image->img;
            $certificate->img_original = $certificate->image->img_original;
        }

        $certificates = $this->modelAttributeHelper->getAttributesFromCollectionModels($certificates,
            ['h1', 'description', 'img', 'img_original']);

        return $certificates;
    }
}