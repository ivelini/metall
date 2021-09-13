<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetTimelinePage as Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ContentSheetTimelinePageRepository extends CoreRepository
{
    protected $imageHelper;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getPagesForIndex()
    {
        $pages = $this->startConditions()
            ->select('id', 'h1', 'created_at', 'is_published')
            ->get();

        return $pages;
    }

    public function getPageForEdit($id)
    {
        $page = $this->startConditions()
            ->where('id', $id)
            ->first();

        $this->imageHelper->getImgPathFromModel($page, 'medium');

        return $page;

    }

    public function getPage($id)
    {
        $page = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $page;
    }

    public function getNextOrderLineFromPage($pageId)
    {
        $nextOrder = $this->startConditions()
            ->where('id', $pageId)
            ->with('lines')
            ->first()
            ->lines
            ->max('order') + 1;

        return $nextOrder;
    }

    public function getPageIncludeLinesForShow($pageId)
    {
        $page = $this->startConditions()
            ->where('id', $pageId)
            ->with(['image:id,path,content_sheet_timeline_page_id',
                'lines',
                'lines.image:id,path,content_sheet_timeline_line_id'])
            ->first();

        $this->imageHelper->getImgPathFromModel($page, 'medium');

        foreach($page->lines as $line) {
            $this->imageHelper->getImgPathFromModel($line, 'small');
        }

        return $page;
    }
}