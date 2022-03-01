<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetMainDividerRepository;
use App\Repositories\Content\ContentSheetShipmentRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentSheetMainDividerController extends Controller
{

    protected $contentSheetMainDividerRepository;
    protected $createAndUpdateContentTableService;


    public function __construct()
    {
        $this->contentSheetMainDividerRepository = new ContentSheetMainDividerRepository();
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();
    }

    public function index()
    {
        $company = Auth::user()->company()->first();
        $dividers = $this->contentSheetMainDividerRepository->getDividersFromCompany($company);

        return view('admin_panel.content.sheet.main.lines.divider.index', compact('dividers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_panel.content.sheet.main.lines.divider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->contentSheetMainDividerRepository->startConditions();
        $this->createAndUpdateContentTableService->save($model, $request);

        return redirect()
            ->route('content.sheet.main.divider.index')
            ->with(['success' => 'Разделитель добавлен']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $divider = $this->contentSheetMainDividerRepository->getDividerForEdit($id);

        return view('admin_panel.content.sheet.main.lines.divider.edit', compact('divider'));
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
        $dividerModel = $this->contentSheetMainDividerRepository->getDivider($id);
        $this->createAndUpdateContentTableService->update($dividerModel, $request);

        return redirect()
            ->route('content.sheet.main.divider.index')
            ->with(['success' => 'Разделитель обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contentSheetMainDividerRepository->getDivider($id)->delete();

        return redirect()
            ->route('content.sheet.main.divider.index')
            ->with(['success' => 'Разделитель удален']);
    }
}
