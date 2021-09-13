<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetTimelineLineRepository;
use App\Repositories\Content\ContentSheetTimelinePageRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;

class ContentSheetTimelineLineController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($pageId)

    {
        $page = $this->contentSheetTimelinePageRepository->getPage($pageId);

        return view('admin_panel.content.sheet.timeline.line.create', compact('page'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $pageId)
    {
        $lineModel = $this->contentSheetTimelineLineRepository->startConditions();
        $nextOrder = $this->contentSheetTimelinePageRepository->getNextOrderLineFromPage($pageId);

        $this->createAndUpdateContentTableService->setModifiedData('timeline_page_id', $pageId);
        $this->createAndUpdateContentTableService->setModifiedData('order', $nextOrder);
        $this->createAndUpdateContentTableService->save($lineModel, $request);

        return redirect()
            ->route('content.sheet.timeline.page.show', $pageId)
            ->with(['success' => 'Линия успешно добавлена']);
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
    public function edit($pageid, $id)
    {
        $line = $this->contentSheetTimelineLineRepository->getLineForEdit($id);
        $page = $line->page;
        $this->createAndUpdateContentTableService->setSessionColumnContentLenth($line);

        return view('admin_panel.content.sheet.timeline.line.edit', compact('line', 'page'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $pageId, $id)
    {
        $line = $this->contentSheetTimelineLineRepository->getLine($id);
        $this->createAndUpdateContentTableService->update($line, $request);

        return redirect()
            ->route('content.sheet.timeline.page.show', $pageId)
            ->with(['success' => 'Страница успешно обноввлена']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($pageId, $id)
    {
        $this->contentSheetTimelineLineRepository->getLine($id)->delete();

        return redirect()
            ->route('content.sheet.timeline.page.show', $pageId)
            ->with(['success' => 'Линия удалена']);
    }
}
