<?php

namespace App\Http\Middleware;

use App\Repositories\CompanyRepository;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


class MappingDomainCompany
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
