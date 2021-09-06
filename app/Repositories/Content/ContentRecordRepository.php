<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\ContentRecord as Model;
use Illuminate\Support\Facades\Auth;

class ContentRecordRepository extends CoreRepository
{

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
}