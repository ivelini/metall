<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentRecordCategoryRepository;
use App\Repositories\Content\ContentRecordRepository;
use App\Repositories\ImageRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentRecordController extends Controller
{

    protected $imageHelper;
    protected $contentRecordCategoryRepository;
    protected $contentRecordRepository;
    protected $imageRepository;
    protected $createAndUpdateContentTableService;

    public function __construct()
    {
        $this->imageHelper = new ImageHelper();
        $this->contentRecordCategoryRepository = new ContentRecordCategoryRepository();
        $this->contentRecordRepository = new ContentRecordRepository();
        $this->imageRepository = new ImageRepository();
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = Auth::user()->company()->first()->id;
        $records = $this->contentRecordRepository->getAllRecordsFromCompanyId($companyId);

        return view('admin_panel.content.record.page.index', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyId = Auth::user()->company()->first()->id;
        $categories = $this->contentRecordCategoryRepository->getCategoriesFromCompanyIdForRecord($companyId);

        return view('admin_panel.content.record.page.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'h1' => 'required'
        ]);

        $contentRecordModel = $this->contentRecordRepository->startConditions();

        $this->createAndUpdateContentTableService->save($contentRecordModel, $request);

        return redirect()
            ->route('content.records.record.index')
            ->with(['success' => 'Запись успешно добавлена']);
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
        $companyId = Auth::user()->company()->first()->id;
        $record = $this->contentRecordRepository->getRecordForEdit($id);
        $categories = $this->contentRecordCategoryRepository->getCategoriesFromCompanyIdForRecord($companyId);

        $this->createAndUpdateContentTableService->setSessionColumnContentLenth($record);

        return view('admin_panel.content.record.page.edit', compact('record', 'categories'));
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
        $data = $request->input();

        $contentRecordModel = $this->contentRecordRepository->getRecord($id);
        $this->createAndUpdateContentTableService->update($contentRecordModel, $request);

        return redirect()
            ->route('content.records.record.index')
            ->with(['success' => 'Запись "' . $data['h1'] . '" успешно обновлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->contentRecordRepository
            ->getRecord($id)
            ->delete();

        return redirect()
            ->route('content.records.record.index')
            ->with(['success' => 'Запись успешно удалена']);
    }
}
