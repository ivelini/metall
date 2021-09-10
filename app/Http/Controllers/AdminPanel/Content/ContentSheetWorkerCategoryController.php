<?php

namespace App\Http\Controllers\AdminPAnel\Content;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetWorkerCategoryRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentSheetWorkerCategoryController extends Controller
{

    protected $contentSheetWorkerCategoryRepository;
    protected $company;
    protected $createAndUpdateContentTableService;

    public function __construct()
    {
        $this->contentSheetWorkerCategoryRepository = new ContentSheetWorkerCategoryRepository();
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

        $categoryes = $this->contentSheetWorkerCategoryRepository->getWorkerCategoryesFromCompany($this->company);

        return view('admin_panel.content.sheet.worker.category.index', compact('categoryes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_panel.content.sheet.worker.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $name = $request->name;
        $sheetWorkerCategory = $this->contentSheetWorkerCategoryRepository->startConditions();
        $nextOrder = $this->contentSheetWorkerCategoryRepository->getNextOrderFromCompany($this->company);

        $this->createAndUpdateContentTableService->setModifiedData('order', $nextOrder);
        $this->createAndUpdateContentTableService->save($sheetWorkerCategory, $request);

        return redirect()
            ->route('content.sheet.worker.category.index')
            ->with(['success' => 'Подразделение успешно добавлено']);
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

        $category = $this->contentSheetWorkerCategoryRepository->getCategory($id);

        return view('admin_panel.content.sheet.worker.category.edit', compact('category'));
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
        $category = $this->contentSheetWorkerCategoryRepository->getCategory($id);
        $this->createAndUpdateContentTableService->update($category, $request);

        return redirect()
            ->route('content.sheet.worker.category.index')
            ->with(['success' => 'Подразделение успешно обноввлено']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $this->contentSheetWorkerCategoryRepository
            ->getCategory($id)
            ->delete();

        return redirect()
            ->route('content.sheet.worker.category.index')
            ->with(['success' => 'Подразделение удалено']);
    }

    public function orderRenew(Request $request) {

        $orderId = $request->input('content_sheet_worker_category_id');

        $contentSheetWorkerCategoryModel = $this->contentSheetWorkerCategoryRepository->startConditions();

        if(!empty($orderId)) {
            foreach ($orderId as $key => $value) {
                $contentSheetWorkerCategoryModel->where('id', $value)->update(['order' => $key + 1]);
            }
        }

        return redirect()
            ->back()
            ->with(['success' => 'Подразделения успешно обновлены']);
    }
}
