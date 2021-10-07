<?php

namespace App\Http\Middleware;

use App\Repositories\CompanyRepository;
use Closure;
use Illuminate\Http\Request;


class MappingDomainCompany
{
    public function handle(Request $request, Closure $next)
    {
        $companyRepository = new CompanyRepository();
        $company = $companyRepository->getCompanyFromDomainForTheme();

        return $next($request);
    }
}
