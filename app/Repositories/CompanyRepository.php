<?php


namespace App\Repositories;

use App\Models\Company as Model;
use Illuminate\Support\Facades\Auth;

class CompanyRepository extends CoreRepository
{

    public function getModelClass()
    {
        return Model::class;
    }

    public function getInformationFromCompany()
    {
        $information = Auth::user()->company()->first()->information;

        return $information;
    }

    public function getCompaniesUrl()
    {
        $companies = $this->startConditions()
            ->select('id', 'domain')
            ->get();

         return $companies;
    }

    public function getCompanyFromDomainForTheme()
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            $company = $this->startConditions()
                ->select('id', 'domain')
                ->where('domain', $_SERVER['HTTP_HOST'])
                ->with('theme', 'information', 'information.image')
                ->first();

            return $company;
        }

    }
}