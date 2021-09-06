<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    protected function getImgPath()
    {
        $userId = Auth::id();
        $imgPath = '/User' . $userId . '/images/' . Str::random(6) . '.jpg';

        return $imgPath;
    }

    public function seveImage($image)
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
            'large' =>  [350,350]
        ];

        $img = Image::make(Storage::path('public') . '' . $imgPath);
        $imgW = $img->width();
        $imgH = $img->height();

        foreach ($template as $key => $size) {

            $imgClone = clone $img;

            $marginW = round((($imgW - $size[0]) / 2), 0, PHP_ROUND_HALF_DOWN);
            $marginH = round((($imgH - $size[1]) / 2), 0, PHP_ROUND_HALF_DOWN);

            if($imgW > $size[0]) {
                if ($imgH > $size[1]) {
                    $imgClone->crop($size[0], $size[1], $marginW, $marginH);
                }
                else {
                    $imgClone->crop($imgH, $imgH, $marginW, 0);
                }
            }
            else {
                if ($imgH > $size[1]) {
                    $imgClone->crop($imgW, $imgW, 0, $marginH);
                }
                else {
                    if ($imgW > $imgH) {
                        $imgClone->crop($imgH, $imgH, $marginW);
                    }
                    else {
                        $imgClone->crop($imgW, $imgW, 0, $marginH);
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
}