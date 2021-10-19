<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetStandart as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ModelAttributeHelper;


class ContentSheetStandartRepository extends CoreRepository
{
    private $modelAttributeHelper;

    public function __construct()
    {
        parent::__construct();
        $this->modelAttributeHelper = new ModelAttributeHelper();
    }

    public function getModelClass()
    {
        return Model::class;
    }

    private function getStandards($company)
    {
        $starndards = $this->startConditions()
            ->where('company_id', $company->id)
            ->with('file:id,path,content_sheet_standarts_id')
            ->get();

        foreach ($starndards as $starndard) {

            $starndard->file = '/storage/' . $starndard->file->path;
        }

        return $starndards;
    }

    public function getStandardsFromIndex()
    {
        $starndards = $this->getStandards(Auth::user()->company()->first());

        return $starndards;
    }

    public function getEdit($id)
    {
        $starndard = $this->startConditions()
            ->where('id', $id)
            ->with('file:id,path,content_sheet_standarts_id')
            ->first();

        $starndard->file = '/storage/' . $starndard->file->path;

        return $starndard;
    }

    public function getObject($id)
    {
        $starndard = $this->startConditions()
            ->where('id', $id)
            ->first();

        return $starndard;
    }

    public function getStandardsForFrontendIndexFromCompany($company)
    {
        $starndards = $starndards = $this->getStandards($company);

        $starndards = $this->modelAttributeHelper->getAttributesFromCollectionModels($starndards, ['h1', 'description', 'file']);

        return $starndards;
    }

}