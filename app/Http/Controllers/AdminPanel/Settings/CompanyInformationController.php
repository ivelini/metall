<?php

namespace App\Http\Controllers\AdminPanel\Settings;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\CompanyRepository;
use App\Repositories\Settings\SettingsCompanyInformationRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;

class CompanyInformationController extends Controller
{
    protected $settingsCompanyInformationRepository;

    public function __construct()
    {
        $this->settingsCompanyInformationRepository = new SettingsCompanyInformationRepository();
    }

    public function edit()
    {
        $page = $this->settingsCompanyInformationRepository->getEdit();

        return view('admin_panel.settings.company_information.edit', compact('page'));

    }


    public function update(Request $request, CreateAndUpdateContentTableService $createAndUpdateContentTableService)
    {
        $page = $this->settingsCompanyInformationRepository->getObject();
        $createAndUpdateContentTableService->update($page, $request);
        dd(__METHOD__, $request,$page);
    }

    public function destroy()
    {
        //
    }
}
