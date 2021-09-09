<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetCertificate as Model;
use Illuminate\Support\Facades\Auth;

class ContentSheetCertificateRepository extends CoreRepository
{
    protected $imageHelper;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
    }
    public function getModelClass()
    {
        return Model::class;
    }

    public function getCertificatesFromCompanyForIndex($company)
    {
        $certificates =$this->startConditions()
            ->where('company_id', $company->id)
            ->with('image:id,path,content_sheet_certificates_id')
            ->get();

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
}