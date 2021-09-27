<?php


namespace App\Repositories;

use App\Models\Company as Model;
use Illuminate\Support\Facades\Auth;

class CompanyRepository extends CoreRepository
{
    private $company;

    public function __construct()
    {
        $this->company = Auth::user()->company()->first();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getInformationFromCompany()
    {
        $information = $this->company->information;

        return $information;
    }

}