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

//        dd(__METHOD__, $records);

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
        $data = $request->input();

        $contentRecordModel = $this->contentRecordRepository->startConditions();

        //Обработка поля из редактора summernote
        $data['description'] = $request->input('description');

        if(!empty($data['description'])) {
            $data['content'] = $this->imageHelper->saveImageFromSummernote($data['content']);
        }

        $contentRecordModel->create([
            'content_record_category_id' => $data['content_record_category_id'],
            'h1' => $data['h1'],
            'title' => $data['title'],
            'content' => $data['content'],
            'description' => $data['description'],
            'slug' => $data['slug'],
            'is_published' => (empty($data['is_published']) == true) ? 0 : 1
        ]);

        if (!empty($request->file('img'))) {

            $image = $request->file('img');
            $imgPath = $this->imageHelper->seveImage($image);

            $imageModel = $this->imageRepository->startConditions();
            $imageModel->path = $imgPath;

            $contentRecordModel->image()->save($imageModel);
        }

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
