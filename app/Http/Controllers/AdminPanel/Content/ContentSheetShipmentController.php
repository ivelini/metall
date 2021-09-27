<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetShipmentRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentSheetShipmentController extends Controller
{

    protected $contentSheetShipmentRepository;
    protected $createAndUpdateContentTableService;


    public function __construct()
    {
        $this->contentSheetShipmentRepository = new ContentSheetShipmentRepository();
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->contentSheetShipmentRepository->getShipmentForIndex();

        return view('admin_panel.content.sheet.shipment.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dates = collect([]);
        return view('admin_panel.content.sheet.shipment.create', compact('dates'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = $this->contentSheetShipmentRepository->startConditions();
        $this->createAndUpdateContentTableService->save($model, $request);

        return redirect()
            ->route('content.sheet.shipment.index')
            ->with(['success' => 'Отгрузка добавлена']);
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
        $page = $this->contentSheetShipmentRepository->getEdit($id);
        $products = $page->products_json;
        $gallery = $page->gallery;

        $this->createAndUpdateContentTableService->setSessionColumnContentLenth($page);

        return view('admin_panel.content.sheet.shipment.edit', compact('page', 'products', 'gallery'));
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
        $object = $this->contentSheetShipmentRepository->getObject($id);
        $this->createAndUpdateContentTableService->update($object, $request);

        return redirect()
            ->route('content.sheet.shipment.edit', $id)
            ->with(['success' => 'Запись обновлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contentSheetShipmentRepository->getObject($id)->delete();

        return redirect()
            ->route('content.sheet.shipment.index')
            ->with(['success' => 'Отгрузка удалена']);
    }
}
