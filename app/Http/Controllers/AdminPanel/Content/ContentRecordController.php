<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentRecordCategoryRepository;
use App\Repositories\Content\ContentRecordRepository;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentRecordController extends Controller
{

    protected $imageHelper;
    protected $contentRecordCategoryRepository;
    protected $contentRecordRepository;
    protected $imageRepository;

    public function __construct()
    {
        $this->imageHelper = new ImageHelper();
        $this->contentRecordCategoryRepository = new ContentRecordCategoryRepository();
        $this->contentRecordRepository = new ContentRecordRepository();
        $this->imageRepository = new ImageRepository();

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
        $data = $request->input();

        $contentRecordModel = $this->contentRecordRepository->startConditions();

        //Обработка поля из редактора summernote
        $data['content'] = $request->input('content');

        if(!empty($data['content'])) {
            $data['content'] = $this->imageHelper->saveImageFromSummernote($data['content']);
        }

        $record = $contentRecordModel->create([
                    'content_record_category_id' => $data['content_record_category_id'],
                    'h1' => $data['h1'],
                    'title' => $data['title'],
                    'content' => $data['content'],
                    'description' => $data['description'],
                    'slug' => $data['slug'],
                    'is_published' => (empty($data['is_published']) == true) ? 0 : 1
                ]);

        $this->imageHelper->saveOrUpdateImageFromModel($record, $request->file('img'));

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

        session(['content_lenth' => mb_strlen($record->content)]);

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

        //Обработка поля из редактора summernote
        $data['content'] = $request->input('content');

        if(!empty($data['content']) &&
            mb_strlen($data['content']) != session('content_lenth')) {

            $data['content'] = $this->imageHelper->saveImageFromSummernote($data['content']);
        }

        $contentRecordModel->update([
            'h1' => $data['h1'],
            'title' => $data['title'],
            'description' => $data['description'],
            'slug' => $data['slug'],
            'content' => $data['content'],
            'content_record_category_id' => $data['content_record_category_id'],
            'is_published' => (empty($data['is_published']) == true) ? 0 : 1,
        ]);

        $this->imageHelper->saveOrUpdateImageFromModel($contentRecordModel, $request->file('img'));

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
