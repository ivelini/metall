<?php

namespace App\Http\Controllers\Frontend\Company\Action;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderSender;
use App\Repositories\Settings\SettingsCompanyInformationRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class SendFormController extends Controller
{
    private $toEmail;
    private $companyInformationRepository;

    public function __construct()
    {
        $companyInformationRepository = new SettingsCompanyInformationRepository();

    }

    public function sendRequest(Request $request)
    {
        $company = CompanyInformationSingleton::getCompanyFromDomain();
        $this->toEmail = $this->companyInformationRepository->getAttribute($company, 'site_email');
        Mail::to($this->toEmail)->queue(new OrderSender($request));
        return redirect()
            ->back()
            ->with(['success' => 'Ok']);
    }

    public function sendSubscribe(Request $request)
    {
        dd(__METHOD__, $request);
    }
}
