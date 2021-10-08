<?php


namespace App\Repositories\Singletone\Frontend\Company;


use App\Repositories\CompanyRepository;

class CompanyInformationSingleton
{
    private static $company;

    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }

    public static function getCompanyFromDomain()
    {
        if(empty(self::$company)) {
            $companyRepository = new CompanyRepository();
            self::$company = $companyRepository->getCompanyFromDomainForTheme();
        }

        return self::$company;
    }
}