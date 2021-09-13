<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetTimelineLine as Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ImageHelper;

class ContentSheetTimelineLineRepository extends CoreRepository
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

    public function getLineForEdit($id)
    {
        $line = $this->startConditions()
            ->where('id', $id)
            ->with('page:id,company_id,h1,content', 'image:id,path,content_sheet_timeline_line_id')
            ->first();

        $this->imageHelper->getImgPathFromModel($line, 'medium');

        return $line;
    }

    public function getLine($id)
    {
        $line = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $line;
    }
}