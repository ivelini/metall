<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Repositories\ImageRepository;

/*
 *Обработка вставленного изображения
 */

class ImageHelper
{

    protected $imageRepository;

    public function __construct()
    {
        $this->imageRepository = new ImageRepository();
    }

    protected function getImgPath()
    {
        $userId = Auth::id();
        $imgPath = '/User' . $userId . '/images/' . Str::random(6) . '.jpg';

        return $imgPath;
    }

    public  function saveOrUpdateImageFromModel($model, $img, $relation = 'image')
    {
        dd(__METHOD__, $model, $img, $relation);
            $imgPath = $this->saveImage($img);

            if (!empty($model->$relation) || $relation = 'gallery') {

                $imageModel = $this->imageRepository->startConditions();
                $imageModel->path = $imgPath;
                $imageModel->is_head = $relation == 'image' ? 1 : 0;
                $model->$relation()->save($imageModel);
            }
            elseif($relation == 'image') {

                $model->image->update(['path' => $imgPath]);
            }

            return true;
    }

    protected function saveImage($image)
    {
        $imgPath = $this->getImgPath();
        $img = Image::make($image);

        $imgW = $img->width();
        $imgH = $img->height();

        $sizeH = 600;
        $sizeW = 800;

        if ($imgW / $imgH >= 1) {
            $img->resize(null, $sizeH, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        else {
            $img->resize($sizeW, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
        $img->save(Storage::path('public') . '' . $imgPath, 100);

        $this->crop($imgPath);

        return $imgPath;
    }


    protected function crop($imgPath)
    {
        $template = [
            'small' =>  [250,250],
            'medium' => [350,350],
            'large' =>  [450,450],
        ];

        $img = Image::make(Storage::path('public') . '' . $imgPath);
        $imgW = $img->width();
        $imgH = $img->height();

        foreach ($template as $key => $size) {

            $imgClone = clone $img;

            if ($imgW / $imgH >= 1) {
                $imgClone->resize(null, $size[1], function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            else {
                $imgClone->resize($size[0], null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            $imgCloneW = $imgClone->width();
            $imgCloneH = $imgClone->height();


            $marginW = round((($imgCloneW - $size[0]) / 2), 0, PHP_ROUND_HALF_DOWN);
            $marginH = round((($imgCloneH - $size[1]) / 2), 0, PHP_ROUND_HALF_DOWN);

            if($imgCloneW > $size[0]) {
                if ($imgCloneH > $size[1]) {
                    $imgClone->crop($size[0], $size[1], $marginW, $marginH);
                }
                else {
                    $imgClone->crop($imgCloneH, $imgCloneH, $marginW, 0);
                }
            }
            else {
                if ($imgCloneH > $size[1]) {
                    $imgClone->crop($imgCloneW, $imgCloneW, 0, $marginH);
                }
                else {
                    if ($imgCloneW > $imgCloneH) {
                        $imgClone->crop($imgCloneH, $imgCloneH, $marginW);
                    }
                    else {
                        $imgClone->crop($imgCloneW, $imgCloneW, 0, $marginH);
                    }
                }
            }

            $imgCropPath = mb_substr($imgPath, 0, mb_strripos($imgPath, '/', -1)) . '/' . $img->filename . '_'
                . $key . '.jpg';

            $imgClone->save(Storage::path('public') . '/' . $imgCropPath);
        }

        return true;
    }

    /**
     * Сохраняет изображения из summernote и возващает строку html с ссылкой на сохраненые изображения
     *
     * @param $content
     * @return string
     */
    public function saveImageFromSummernote($content)
    {

        $imgPath = $this->getImgPath();
        $dom = new \DOMDocument();
        $dom->loadHtml($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');

        foreach($images as $k => $img){
            $data = $img->getAttribute('src');

            if (mb_strlen($img->getAttribute('src')) > 1000) {

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);

                $path = Storage::path('public') . $imgPath;

                file_put_contents($path, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', '/storage/' . $imgPath);
            }
        }

        $content = utf8_decode($dom->saveHTML($dom->documentElement));

        return $content;
    }

    public function getImgPathGalleryFromModel($model, $format = 'medium', $originalPath = false)
    {
        if($model->gallery->count() > 0) {
            foreach ($model->gallery as $img) {
                $this->getPath($img, $format, $originalPath);
            }
        }
        return $model;
    }

    public function getImgPathFromModel($model, $format = 'medium', $originalPath = false)
    {

        if(!empty($model->image->path)) {
            $this->getPath($model->image, $format, $originalPath);
        }

        return $model;
    }

    private function getPath($model, $format = 'medium', $originalPath = false)
    {
        $model->img = '/storage' . mb_substr($model->path, 0, mb_strripos($model->path, '.'))
            . '_' . $format . '.jpg';

        $originalPath == true ? $model->img_original = '/storage' . $model->path : NULL;

        return $model;
    }
}