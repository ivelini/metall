<?php


namespace App\Repositories\Content;


use App\Repositories\CoreRepository;
use App\Models\Content\ContentSheetStandart as Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ContentSheetStandartRepository extends CoreRepository
{

    public function getModelClass()
    {
        return Model::class;
    }

    public function getStandardsFromIndex()
    {
        $starndards = $this->startConditions()
            ->where('company_id', Auth::user()->company()->first()->id)
            ->with('file:id,path,content_sheet_standarts_id')
            ->get();

        foreach ($starndards as $starndard) {

            $starndard->file = '/storage/' . $starndard->file->path;
        }

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

}