<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetTimelineLineRepository;
use Illuminate\Http\Request;
use App\Repositories\Content\ContentSheetTimelinePageRepository;
use App\Services\Content\CreateAndUpdateContentTableService;

class ContentSheetTimelinePageController extends Controller
{
    protected $contentSheetTimelinePageRepository;
    protected $createAndUpdateContentTableService;
    protected $contentSheetTimelineLineRepository;

    public function __construct()
    {
        $this->contentSheetTimelinePageRepository = new ContentSheetTimelinePageRepository();
        $this->createAndUpdateContentTableService =new CreateAndUpdateContentTableService();
        $this->contentSheetTimelineLineRepository = new ContentSheetTimelineLineRepository();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = $this->contentSheetTimelinePageRepository->getPagesForIndex();
        return view('admin_panel.content.sheet.timeline.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_panel.content.sheet.timeline.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $timelinePageModel = $this->contentSheetTimelinePageRepository->startConditions();
        $this->createAndUpdateContentTableService->save($timelinePageModel, $request);

        return redirect()
            ->route('content.sheet.timeline.page.index')
            ->with(['success' => 'Страница успешно добавлена']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = $this->contentSheetTimelinePageRepository->getPageIncludeLinesForShow($id);
        $lines = $page->lines;

        return view('admin_panel.content.sheet.timeline.page.show', compact('page', 'lines'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = $this->contentSheetTimelinePageRepository->getPageForEdit($id);
        $this->createAndUpdateContentTableService->setSessionColumnContentLenth($page);

        return view('admin_panel.content.sheet.timeline.page.edit', compact('page'));
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
        $page = $this->contentSheetTimelinePageRepository->getPage($id);
        $this->createAndUpdateContentTableService->update($page, $request);

        return redirect()
            ->route('content.sheet.timeline.page.index')
            ->with(['success' => 'Страница успешно обноввлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contentSheetTimelinePageRepository->getPage($id)->delete();

        return redirect()
            ->route('content.sheet.timeline.page.index')
            ->with(['success' => 'Страница удалена']);
    }

    public function orderrenew(Request $request, $pageId)
    {
        $orderId = $request->input('content_sheet_timeline_line_id');

        $contentSheetTimelineLineModel = $this->contentSheetTimelineLineRepository->startConditions();

        if(!empty($orderId)) {
            foreach ($orderId as $key => $value) {
                $contentSheetTimelineLineModel->where('id', $value)->update(['order' => $key + 1]);
            }
        }

        return redirect()
            ->back()
            ->with(['success' => 'Порядок линий обновлен']);
    }
}
