<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Repositories\ImageRepository;

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

    public  function saveOrUpdateImageFromModel($model, $requestImg)
    {
        if (!empty($requestImg)) {

            $image = $requestImg;
            $imgPath = $this->saveImage($image);

            $imageModel = $this->imageRepository->startConditions();
            $imageModel->path = $imgPath;

            if (empty($model->image)) {

                $model->image()->save($imageModel);
            }
            else {

                $model->image->update(['path' => $imageModel->path]);
            }

            return true;
        }

        return false;
    }

    public function saveImage($image)
    {
        $imgPath = $this->getImgPath();
        $img = Image::make($image);
        $img->save(Storage::path('public') . '' . $imgPath, 100);

        $this->crop($imgPath);

        return $imgPath;
    }

    public function crop($imgPath)
    {
        $template = [
            'small' =>  [150,150],
            'medium' => [250,250],
            'large' =>  [350,350],
            'extralarge' =>  [450,450]
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

    public function getImgPathFromModel($model, $format = 'medium')
    {
        if(!empty($model->image->path)) {
            $model->img = '/storage' . mb_substr($model->image->path, 0, mb_strripos($model->image->path, '.'))
                . '_' . $format . '.jpg';
        }

        return $model;
    }
}