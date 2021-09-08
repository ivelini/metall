<?php

namespace App\Http\Controllers\AdminPAnel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetWorkerCategoryRepository;
use App\Repositories\Content\ContentSheetWorkerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentPageWorkerController extends Controller
{
    protected $contentSheetWorkerCategoryRepository;
    protected $company;
    protected $contentSheetWorkerRepository;
    protected $imageHelper;

    public function __construct()
    {
        $this->contentSheetWorkerCategoryRepository = new ContentSheetWorkerCategoryRepository();
        $this->contentSheetWorkerRepository = new ContentSheetWorkerRepository();
        $this->imageHelper = new ImageHelper();

        $this->middleware(function ($request, $next) {
            $this->company= Auth::user()->company()->first();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->contentSheetWorkerCategoryRepository->getCategoriesIncludeWorkersFromCompany($this->company);

//        dd(__METHOD__, $categories);

        return view('admin_panel.content.sheet.worker.page.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->contentSheetWorkerCategoryRepository->getWorkerCategoryesFromCompany($this->company);
        return view('admin_panel.content.sheet.worker.page.create', compact('categories'));
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

        $workerModel= $this->contentSheetWorkerRepository->startConditions();
        $workerModel->content_sheet_worker_category_id = $data['content_sheet_worker_category_id'];
        $workerModel->name = $data['name'];
        $workerModel->position = $data['position'];
        $workerModel->phone = $data['phone'];
        $workerModel->email = $data['email'];
        $workerModel->save();

        $this->imageHelper->saveOrUpdateImageFromModel($workerModel, $request->file('img'));

        return redirect()
            ->route('content.sheet.worker.index')
            ->with(['success' => 'Сотрудник добавлен']);
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
        $worker = $this->contentSheetWorkerRepository->getWorkerForEdit($id);
        $categories = $this->contentSheetWorkerCategoryRepository->getWorkerCategoryesFromCompany($this->company);

        return view('admin_panel.content.sheet.worker.page.edit', compact('worker', 'categories'));
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

        $contentSheetWorkerModel = $this->contentSheetWorkerRepository->getWorker($id);

        $contentSheetWorkerModel->update([
            'name' => $data['name'],
            'position' => $data['position'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'content_sheet_worker_category_id' => $data['content_sheet_worker_category_id'],
        ]);

        $this->imageHelper->saveOrUpdateImageFromModel($contentSheetWorkerModel, $request->file('img'));

        return redirect()
            ->route('content.sheet.worker.index')
            ->with(['success' => 'Сотрудник обновлен']);


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
