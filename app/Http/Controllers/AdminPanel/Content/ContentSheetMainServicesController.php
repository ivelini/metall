<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetMainServicesRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentSheetMainServicesController extends Controller
{

    protected $contentSheetMainServicesRepository;
    protected $createAndUpdateContentTableService;


    public function __construct()
    {
        $this->contentSheetMainServicesRepository = new ContentSheetMainServicesRepository();
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Auth::user()->company()->first();
        $services = $this->contentSheetMainServicesRepository->getServicesFromCompany($company);

        return view('admin_panel.content.sheet.main.lines.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_panel.content.sheet.main.lines.services.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->contentSheetMainServicesRepository->startConditions();
        $this->createAndUpdateContentTableService->save($model, $request);

        return redirect()
            ->route('content.sheet.main.services.index')
            ->with(['success' => 'Услуга добавлена']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $service = $this->contentSheetMainServicesRepository->getServiceForEdit($id);

        return view('admin_panel.content.sheet.main.lines.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $serviceModel = $this->contentSheetMainServicesRepository->getService($id);
        $this->createAndUpdateContentTableService->update($serviceModel, $request);

        return redirect()
            ->route('content.sheet.main.services.index')
            ->with(['success' => 'Услуга обновлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contentSheetMainServicesRepository->getService($id)->delete();

        return redirect()
            ->route('content.sheet.main.services.index')
            ->with(['success' => 'Услуга удалена']);
    }
}
