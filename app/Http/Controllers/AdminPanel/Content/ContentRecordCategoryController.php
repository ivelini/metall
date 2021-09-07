<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentRecordCategoryRepository;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentRecordCategoryController extends Controller
{

    protected $imageHelper;
    protected $contentRecordCategoryRepository;

    public function __construct()
    {
        $this->imageHelper = new ImageHelper();
        $this->contentRecordCategoryRepository = new ContentRecordCategoryRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = Auth::user()->company()->first()->id;
        $categories = $this->contentRecordCategoryRepository->getCategoriesFromCompanyId($companyId);

        return view('admin_panel.content.record.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_panel.content.record.category.create');
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
            'h1' => [
                'required',
                function($attribute, $value, $fail) {
                    $categoryNameExist = $this->contentRecordCategoryRepository->isCategoryNameExist($value);
                    if($categoryNameExist) {
                        $fail('Категория "' . $value . '" уже существует');
                    }
                }
            ],
        ]);

        $data = $request->input();

        $contentRecordCategoryModel = $this->contentRecordCategoryRepository->startConditions();

        //Обработка поля из редактора summernote
        $data['description'] = $request->input('description');

        if(!empty($data['description'])) {
            $data['description'] = $this->imageHelper->saveImageFromSummernote($data['description']);
        }

        $contentRecordCategoryModel->create([
            'company_id' => Auth::user()->company()->first()->id,
            'h1' => $data['h1'],
            'title' => $data['title'],
            'description' => $data['description'],
            'slug' => $data['slug'],
        ]);

        return redirect()
            ->route('content.records.category.index')
            ->with(['success' => 'Категория успешно добавлена']);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $records = $this->contentRecordCategoryRepository->getRecordsFromCategoryId($id);
        $category = $this->contentRecordCategoryRepository->getCategory($id);

        return view('admin_panel.content.record.category.show', compact('records', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->contentRecordCategoryRepository->getCategory($id);
        session(['description_lenth' => mb_strlen($category->description)]);

        return view('admin_panel.content.record.category.edit', compact('category'));
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

        $contentRecordCategoryModel = $this->contentRecordCategoryRepository->getCategory($id);

        //Обработка поля из редактора summernote
        $data['description'] = $request->input('description');

        if(!empty($data['description']) &&
            mb_strlen($data['description']) != session('description_lenth') - 1) {

            $data['description'] = $this->imageHelper->saveImageFromSummernote($data['description']);
        }

        $contentRecordCategoryModel->update([
            'company_id' => Auth::user()->company()->first()->id,
            'h1' => $data['h1'],
            'title' => $data['title'],
            'description' => $data['description'],
            'slug' => $data['slug'],
        ]);

        return redirect()
            ->route('content.records.category.index')
            ->with(['success' => 'Категория "' . $data['h1'] . '" успешно обновлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->contentRecordCategoryRepository
            ->getCategory($id)
            ->delete();

        return redirect()
            ->route('content.records.category.index')
            ->with(['success' => 'Категория успешно удалена']);
    }
}
