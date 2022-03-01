<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Repositories\Settings\SettingsCompanyInformationRepository;
use App\Repositories\Singletone\Frontend\Company\CompanyInformationSingleton;

class OrderSender extends Mailable
{
    use Queueable, SerializesModels;

    private $sender;
    private $fromEmail;
    private $fromSiteName;
    private $company;

    public function __construct($request)
    {
        $this->sender = collect();
        $this->sender->put('name', $request->input('send_name'));
        $this->sender->put('email', $request->input('send_email'));
        $this->sender->put('phone', $request->input('send_phone'));
        $this->sender->put('description', $request->input('send_desc'));

        if ($request->hasFile('send_file')) {
            $this->sender->put('file', $request->file('send_file'));
        }

        $this->company = CompanyInformationSingleton::getCompanyFromDomain();
        $companyInformationRepository = new SettingsCompanyInformationRepository();
        $this->fromEmail = 'site@' . $this->company->domain;
        $this->fromSiteName = $companyInformationRepository->getAttribute($this->company, 'site_name');
    }

    public function build()
    {
        $this->from('ivelini@yandex.ru', $this->fromSiteName)
            ->subject('Сообщение с сайта "' . $this->company->domain . '"')
            ->view('emails.order.sender')
            ->with([
                'name' => $this->sender->get('name'),
                'email' => $this->sender->get('email'),
                'phone' => $this->sender->get('phone'),
                'description' => $this->sender->get('description'),
            ]);

        return $this;
    }
}
