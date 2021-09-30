<?php

namespace App\Http\Controllers\AdminPanel\Settings;

use App\Http\Controllers\Controller;
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
        $storages = $page->storages_json;
        $agencys = $page->agency_json;
        return view('admin_panel.settings.company_information.edit', compact('page', 'storages', 'agencys'));

    }


    public function update(Request $request, CreateAndUpdateContentTableService $createAndUpdateContentTableService)
    {
        $page = $this->settingsCompanyInformationRepository->getObject();

        $createAndUpdateContentTableService->update($page, $request);

        return redirect()
            ->route('settings.companyInformation.edit')
            ->with(['success' => 'Информация обновлена']);
    }
}
