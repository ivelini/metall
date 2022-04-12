<?php

namespace App\Http\Controllers\AdminPanel\Settings;

use App\Http\Controllers\Controller;
use App\Repositories\Settings\SliderRepository;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use App\Repositories\Settings\SliderImageRepository;

class SliderController extends Controller
{
    private $createAndUpdateContentTableService;
    private $sliderRepository;

    public function __construct()
    {
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();
        $this->sliderRepository = new SliderRepository();
    }

    public function index()
    {
        $pages = $this->sliderRepository->getSlidersForIndex();
        return view('admin_panel.settings.slider.index', compact('pages'));
    }

    public function create()
    {
        return view('admin_panel.settings.slider.page.create');
    }

    public function store(Request $request)
    {
        $object = $this->sliderRepository->startConditions();
        $this->createAndUpdateContentTableService->save($object, $request);

        return redirect()
            ->route('settings.slider.index')
            ->with(['success' => 'Слайдер добавлен']);
    }

    public function show($id)
    {
        $page = $this->sliderRepository->getSliderForShow($id);
        $slides = $page->slides;

        return view('admin_panel.settings.slider.page.show', compact('page', 'slides'));
    }

    public function edit($id)
    {
        $page = $this->sliderRepository->getPageForEdit($id);

        return view('admin_panel.settings.slider.page.edit', compact('page'));

    }

    public function update(Request $request, $id)
    {
        $page = $this->sliderRepository->getPageForEdit($id);
        $this->createAndUpdateContentTableService->update($page, $request);

        return redirect()
            ->route('settings.slider.edit', $id)
            ->with(['success' => 'Слайдер обновлен']);
    }

    public function destroy($id)
    {
        $this->sliderRepository->getPageForEdit($id)->delete();

        return redirect()
            ->route('settings.slider.index')
            ->with(['success' => 'Слайдер удален']);
    }

    public function orderRenew(Request $request, $pageId)
    {

        $sliderImageRepository = new SliderImageRepository();
        $orderId = $request->input('slider_id');

        $sliderModel = $sliderImageRepository->startConditions();

        if(!empty($orderId)) {
            foreach ($orderId as $key => $value) {
                $sliderModel->where('id', $value)->update(['order' => $key + 1]);
            }
        }

        return redirect()
            ->back()
            ->with(['success' => 'Порядок слайдов обновлен']);
    }
}
