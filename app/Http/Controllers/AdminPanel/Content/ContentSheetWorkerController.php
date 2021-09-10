<?php

namespace App\Http\Controllers\AdminPAnel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetWorkerCategoryRepository;
use App\Repositories\Content\ContentSheetWorkerRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentSheetWorkerController extends Controller
{
    protected $contentSheetWorkerCategoryRepository;
    protected $company;
    protected $contentSheetWorkerRepository;
    protected $imageHelper;
    protected $createAndUpdateContentTableService;

    public function __construct()
    {
        $this->contentSheetWorkerCategoryRepository = new ContentSheetWorkerCategoryRepository();
        $this->contentSheetWorkerRepository = new ContentSheetWorkerRepository();
        $this->imageHelper = new ImageHelper();
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();

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
        $workerModel= $this->contentSheetWorkerRepository->startConditions();
        $this->createAndUpdateContentTableService->save($workerModel, $request);

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
        $contentSheetWorkerModel = $this->contentSheetWorkerRepository->getWorker($id);
        $this->createAndUpdateContentTableService->update($contentSheetWorkerModel, $request);

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
        $this->contentSheetWorkerRepository->getWorker($id)->delete();

        return redirect()
            ->route('content.sheet.worker.index')
            ->with(['success' => 'Сотрудник удален']);
    }
}
