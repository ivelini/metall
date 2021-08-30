<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Random;

class ImageHelper
{
    public function seveImage($image)
    {
        $userId = Auth::id();
        $imgPath = '/User' . $userId . '/images/' . Str::random(6) . '.jpg';

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

            $marginW = ($imgW - $size[0]) / 2;
            $marginH = ($imgH - $size[1]) / 2;

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
}