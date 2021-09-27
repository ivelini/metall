<?php


namespace App\Services\Content;


/*
 * Сервис сохранения или обновления записей в таблицах, принадлежащих к контентной части
 * Поле "content" всегда с форматированием из под редактора, перед вставкой обрабатываем.
 * Если есть изображение, то вставляем в таблицу img с привязкой к id обрабатываемой модели
 */

use App\Repositories\FileRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAndUpdateContentTableService
{
    protected $imageHelper;
    private $columnsListing;
    private $companyId;
    private $modifiedData = [];
    protected $fileRepository;
    private $relationsImages = [];
    private $relationsFiles = [];

    public function __construct()
    {
        $this->imageHelper = new ImageHelper();
        $this->fileRepository = new FileRepository();

        $this->relationsImages = [
            'images',
            'logo',
        ];

        $this->relationsFiles = [
            'file',
            'price',
            'requisites',
        ];
    }


    /**
     * Заполняем свойства класса
     *
     * @param $model
     * @param $request
     */
    private function fillProperty($model, $request)
    {
        $this->columnsListing = array_diff(Schema::getColumnListing($model->getTable()), ['id', 'created_at', 'updated_at']);
        $this->companyId = Auth::user()->company()->first()->id;
    }

    public function setModifiedData($column, $value)
    {
        $this->modifiedData[$column] = $value;
    }

    public function setSessionColumnContentLenth($model)
    {
        if(!empty($model->content)) {
            session(['content_lenth' => mb_strlen($model->content)]);
        }
    }

    /*
     * Обработка входных данных
     * Формирование массива данных вида ['columnName' => value ] для вставки в таблицу
     *
     * @param $data
     * @param bool $is_update
     * @return array массив вида [column => value]
     */
    private function dataProcessing($data, $is_update = false)
    {
        //Если найдены измененные данные
        if(count($this->modifiedData) > 0) {
            foreach ($this->modifiedData as $column => $value) {
                $data[$column] = $value;
            }
        }

        $insertColumns = [];
        foreach($this->columnsListing as $column) {

            //Если таблица содержит поле id компании
            if ($column == 'company_id') {
                $data[$column] = $this->companyId;
            }


            //Если таблица содержит поле "content"
            if (
                ($column == 'content' && !empty($data[$column]) && $is_update == false)
                ||
                ($column == 'content' && !empty($data[$column]) && $is_update == true
                && mb_strlen($data['content']) != session('content_lenth'))
                )
            {
                $data[$column] = $this->imageHelper->saveImageFromSummernote($data[$column]);
            }

            //Если таблица содержит поле "is_published" и request с полем "is_published" пусто,
            //то data[is_published] = 0
            if ($column == 'is_published' && empty($data[$column])) {
                $data[$column] = 0;
            }
            elseif ($column == 'is_published' && !empty($data[$column])) {
                $data[$column] = 1;
            }

            //Если табличное поле с отправленным
            //Если найдено, то вставляем
            if (!empty($data[$column])) {
                $insertColumns[$column] = $data[$column];
            }
        }

        return $insertColumns;
    }

    /**
     * Сохраняем прикрепленный файл в каталог app/public/UserID/files
     *
     * @param $model
     * @param $file
     * @return bool
     */
    private function saveOrUpdateFileFromModel($model, $file)
    {
        if(!empty($file)) {

            $pathToFile = 'User' . Auth::user()->id . '/files';
            $fileName = Str::random(6) . mb_substr($file->getClientOriginalName(), mb_strripos($file->getClientOriginalName(), '.'));

            $filePath = $file->storeAs($pathToFile, $fileName, 'public');

            if (empty($model->file)) {

                $fileModel = $this->fileRepository->startConditions();
                $fileModel->path = $filePath;
                $model->file()->save($fileModel);
            }
            else {

                $model->file->update(['path' => $filePath]);
            }

            return true;
        }

        return false;
    }

    private function saveOrUpdateMedia($model, $request)
    {
        //Если прикреплено основное изображение - поле "img"
        if (!empty($request->file('img'))) {
            $this->imageHelper->saveOrUpdateImageFromModel($model, $request->file('img'));
        }

        //Если прикреплена галлерея - поле "gallery"
        if (!empty($request->file('gallery'))) {

            foreach($request->file('gallery') as $img) {

                $this->imageHelper->saveOrUpdateImageFromModel($model, $img, 'gallery');
            }
        }

        //Если прикреплен файл- поле "file"
        if (!empty($request->file('file'))) {
            $this->saveOrUpdateFileFromModel($model, $request->file('file'));
        }
    }


    public function save($model, $request)
    {
        $this->fillProperty($model, $request);
        $data = $this->dataProcessing($request->input());
        $model = $model->create($data);

        $this->saveOrUpdateMedia($model, $request);

        return $model;
    }

    public function update($model, $request)
    {
        $this->fillProperty($model, $request);
        $data = $this->dataProcessing($request->input(), true);

        $model->update($data);

        $this->saveOrUpdateMedia($model, $request);

        return $model;
    }
}