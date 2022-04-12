<?php

namespace App\Http\Controllers\AdminPanel\Settings;

use App\Http\Controllers\Controller;
use App\Repositories\Settings\SliderImageRepository;
use App\Repositories\Settings\SliderRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;

class SliderImageController extends Controller
{
    private $createAndUpdateContentTableService;
    private $sliderRepository;
    private $sliderImageReposytory;

    public function __construct()
    {
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();
        $this->sliderRepository = new SliderRepository();
        $this->sliderImageReposytory = new SliderImageRepository();
    }

    public function index()
    {
        //
    }

    public function create($sliderId)
    {
        $page = $this->sliderRepository->getPageForEdit($sliderId);

        return view('admin_panel.settings.slider.slide.create', compact('page'));
    }

    public function store(Request $request, $sliderId)
    {
        $object = $this->sliderImageReposytory->startConditions();
        $order = $this->sliderImageReposytory->getNextOrderSlideFromSlider($sliderId);
        $this->createAndUpdateContentTableService->setModifiedData('slider_id', $sliderId);
        $this->createAndUpdateContentTableService->setModifiedData('order', $order);
        $slide = $this->createAndUpdateContentTableService->save($object, $request);

        return redirect()
            ->route('settings.slider.slide.edit', [$sliderId, $slide->id])
            ->with(['success' => 'Слайд добавлен']);
    }

    public function show($id)
    {
        //
    }

    public function edit($sliderId, $id)
    {
        $page = $this->sliderRepository->getPageForEdit($sliderId);
        $slide = $this->sliderImageReposytory->getSlideForEdit($id);

        return view('admin_panel.settings.slider.slide.edit', compact('page', 'slide'));
    }

    public function update(Request $request, $sliderId, $id)
    {
        $object = $this->sliderImageReposytory->getObject($id);
        $this->createAndUpdateContentTableService->update($object, $request);

        return redirect()
            ->route('settings.slider.slide.edit', [$sliderId, $id])
            ->with(['success' => 'Слайд обновлен']);

    }

    public function destroy($sliderId, $id)
    {
        $this->sliderImageReposytory->getObject($id)->delete();

        return redirect()
            ->route('settings.slider.show', $sliderId)
            ->with(['success' => 'Слайд удален']);
    }
}
