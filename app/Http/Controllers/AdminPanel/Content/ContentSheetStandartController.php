<?php

namespace App\Http\Controllers\AdminPanel\Content;


use App\Http\Controllers\Controller;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use App\Repositories\Content\ContentSheetStandartRepository;

class ContentSheetStandartController extends Controller
{
    protected $contentSheetStandartRepository;
    protected $createAndUpdateContentTableService;

    public function __construct()
    {
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();
        $this->contentSheetStandartRepository = new ContentSheetStandartRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $standards = $this->contentSheetStandartRepository->getStandardsFromIndex();

        return view('admin_panel.content.sheet.standard.index', compact('standards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_panel.content.sheet.standard.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->contentSheetStandartRepository->startConditions();
        $this->createAndUpdateContentTableService->save($model, $request);

        return redirect()
            ->route('content.sheet.standard.index')
            ->with(['success' => 'Стандарт добавлен']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $standard = $this->contentSheetStandartRepository->getEdit($id);

        return view('admin_panel.content.sheet.standard.edit', compact('standard'));
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
        $model = $this->contentSheetStandartRepository->getObject($id);
        $this->createAndUpdateContentTableService->update($model, $request);

        return redirect()
            ->route('content.sheet.standard.index')
            ->with(['success' => 'Стандарт "' . $model->h1 . '" обновлен']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contentSheetStandartRepository->getObject($id)->delete();

        return redirect()
            ->route('content.sheet.standard.index')
            ->with(['success' => 'Стандарт удален']);
    }
}
