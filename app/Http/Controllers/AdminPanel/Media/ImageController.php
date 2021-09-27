<?php

namespace App\Http\Controllers\AdminPanel\Media;

use App\Http\Controllers\Controller;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    protected $imageRepository;

    public function __construct()
    {
        $this->imageRepository = new ImageRepository();
    }

    public function destroy($id)
    {
        $this->imageRepository->getObject($id)->delete();

        return redirect()->back();
    }
}
