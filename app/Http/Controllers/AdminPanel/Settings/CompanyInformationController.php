<?php

namespace App\Http\Controllers\AdminPanel\Settings;

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
        $storages = $page->storages_json;
        $agencys = $page->agency_json;
        return view('admin_panel.settings.company_information.edit', compact('page', 'storages', 'agencys'));
    }

    public function update(Request $request, CreateAndUpdateContentTableService $createAndUpdateContentTableService)
    {
        $page = $this->settingsCompanyInformationRepository->getObject();

        $request->merge(['site_phone' => $page->site_phone,
            'site_email' => $page->site_email,
            'site_name' => $page->site_name,
            'site_description' => $page->site_description]);

        $createAndUpdateContentTableService->update($page, $request);

        return redirect()
            ->route('settings.companyInformation.edit')
            ->with(['success' => 'Информация обновлена']);
    }

    public function generalEdit()
    {
        $page = $this->settingsCompanyInformationRepository->getEdit();

        return view('admin_panel.settings.general.edit', compact('page'));
    }

    public function generalUpdate(Request $request, CreateAndUpdateContentTableService $createAndUpdateContentTableService)
    {
        $page = $this->settingsCompanyInformationRepository->getObject();

        $request->merge([
            'full_name' => $page->full_name,
            'slim_name' => $page->slim_name,
            'index' => $page->index,
            'oreal' => $page->oreal,
            'sity' => $page->sity,
            'address' => $page->address,
            'phone' => $page->phone,
            'storages_json' => $page->storages_json,
            'agency_json' => $page->agency_json,
            'clock_work' => $page->clock_work,
            'map' => $page->map
        ]);

        $createAndUpdateContentTableService->update($page, $request);
        $createAndUpdateContentTableService->update(\Auth::user()->company()->first(), $request);

        return redirect()
            ->route('settings.companyInformation.generalEdit')
            ->with(['success' => 'Информация обновлена']);
    }
}
