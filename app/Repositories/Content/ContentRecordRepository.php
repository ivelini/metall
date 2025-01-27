<?php


namespace App\Repositories\Content;


use App\Helpers\ImageHelper;
use App\Repositories\CoreRepository;
use App\Models\Content\ContentRecord as Model;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ModelAttributeHelper;


class ContentRecordRepository extends CoreRepository
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

    /**
     * Если запись с таким именем существует - true, если нет - false
     *
     * @param $recordName
     * @return bool
     */
    public function isRecordNameExist($recordName) {
        $nameCount = $this->startConditions()
            ->select('id', 'company_id', 'h1')
            ->where('company_id', Auth::user()->company()->first()->id)
            ->where('h1', $recordName)
            ->get()->count();

        if ($nameCount > 0) {
            return true;
        }
        return false;
    }

    public function getAllRecordsFromCompanyId($companyId)
    {
        $records = $this->startConditions()
            ->select('id', 'content_record_category_id', 'h1', 'is_published', 'created_at')
            ->with([
                'category' => function($query) use ($companyId) {
                    $query->select('id', 'company_id', 'h1')
                        ->where('company_id', $companyId);
                }
            ])
            ->latest()
            ->get();

        foreach ($records as $record) {
            $record->category_id = $record->category->id;
            $record->category_h1 = $record->category->h1;
        }

        return $records;
    }

    public function getRecord($id)
    {
        $record = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $record;
    }

    public function getRecordForEdit($id)
    {
        $record = $this->startConditions()
            ->where('id', $id)
            ->with(['image' => function($query) {
                        $query->select('id', 'path', 'content_record_id');
                        },
                    'category' => function($query) {
                        $query->select('id', 'company_id', 'h1');
                        }
                    ])
            ->first();

        $this->imageHelper->getImgPathFromModel($record, 'large', true);

        $record->category_id = $record->category->id;
        $record->category_h1 = $record->category->h1;

        return $record;
    }

    public function getAttributeRecordsFromCategoryIdForFrontedCategory($id)
    {
        $records = $this->getRecordsFromCategoryId($id);

        foreach ($records as $record) {

            $created_at['j'] = $record->created_at->format('j');
            $created_at['m'] = $record->created_at->format('M');

            $record->created = $created_at;

            $record->category_id = $record->content_record_category_id;

        }

        $records = $this->modelAttributeHelper->getAttributesFromCollectionModels($records, ['id', 'category_id', 'h1', 'slug', 'description', 'img', 'created']);

        return $records;
    }

    private function getRecordsFromCategoryId($id)
    {
        $records = $this->startConditions()
            ->where('content_record_category_id', $id)
            ->where('is_published', 1)
            ->with('image')
            ->get();

        foreach ($records as $record) {
            $this->imageHelper->getImgPathFromModel($record, 'medium');
            $record->img = !empty($record->image->img) == true ? $record->image->img : '';
        }

        return $records;
    }

    public function getAttributeRecordForFrontendContent($id)
    {
        $record = $this->getRecordForEdit($id);
        $record->img = $record->image->img_original;
        $record->created = $record->created_at->format('j.m.Y');
        $content = $this->modelAttributeHelper->getAttributesFromModel($record, ['h1', 'img', 'content', 'created']);

        return $content;
    }
}