<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetTimelinePage as Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;
use App\Helpers\ModelAttributeHelper;

class ContentSheetTimelinePageRepository extends CoreRepository
{
    protected $imageHelper;
    protected $modelAttributeHelper;

    public function __construct()
    {
        parent::__construct();
        $this->imageHelper = new ImageHelper();
        $this->modelAttributeHelper = new ModelAttributeHelper();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    public function getPagesForIndex()
    {
        $pages = $this->startConditions()
            ->select('id', 'company_id', 'h1', 'created_at', 'is_published')
            ->where('company_id', Auth::user()->company->first()->id)
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

    private function getPageIncludeLines($pageId)
    {
        $page = $this->startConditions()
            ->where('id', $pageId)
            ->with(['image:id,path,content_sheet_timeline_page_id',
                'lines',
                'lines.image:id,path,content_sheet_timeline_line_id'])
            ->first();

        return $page;
    }

    public function getPageIncludeLinesForShow($pageId)
    {
        $page = $this->getPageIncludeLines($pageId);

        $this->imageHelper->getImgPathFromModel($page, 'medium');

        foreach($page->lines as $line) {
            $this->imageHelper->getImgPathFromModel($line, 'small');
        }

        return $page;
    }

    public function getPageContentAndLinesForFrontendShow($pageId)
    {
        $page = $this->getPageIncludeLines($pageId);

        $this->imageHelper->getImgPathFromModel($page, 'small', true);
        $page->img = !empty($page->image->img_original) ? $page->image->img_original : NULL;
        $arr['content'] = $this->modelAttributeHelper->getAttributesFromModel($page, ['h1', 'content', 'img']);

        foreach($page->lines as $line) {
            $this->imageHelper->getImgPathFromModel($line, 'medium');
            $line->img = !empty($line->image->img) ? $line->image->img : NULL;
        }

        $arr['lines'] = $this->modelAttributeHelper->getAttributesFromCollectionModels($page->lines, ['h1', 'content', 'img']);

        return $arr;
    }
}