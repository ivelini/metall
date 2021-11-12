<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use App\Services\Content\CreateAndUpdateContentTableService;

class ContentSheetPageInformationController extends Controller
{
    /*
     * Создает / обновляет информацию для тематических страниц в таблице "content_sheet_page_information"
     * На входе request с информационными полями. Сопоставление по полям "company_id", "sheet_name"
     */
    public function update(ContentSheetPageInformationRepository $contentSheetPageInformationRepository,
                           CreateAndUpdateContentTableService $createAndUpdateContentTableService, Request $request)
    {
        $sheetName = $request->input('sheet_name');

        $object = $contentSheetPageInformationRepository->getModelFromSheetPage($sheetName);

        if (!empty($object)) {
            $createAndUpdateContentTableService->update($object, $request);
        }
        else {
            $model = $contentSheetPageInformationRepository->startConditions();
            $createAndUpdateContentTableService->save($model, $request);
        }

        $routePage = $contentSheetPageInformationRepository->getoutePage($sheetName);

        return redirect()
            ->route($routePage)
            ->with(['success' => 'Страница обновлена']);
    }
}
