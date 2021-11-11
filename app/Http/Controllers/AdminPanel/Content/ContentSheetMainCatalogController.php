<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ModelAttributeHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Content\CreateAndUpdateContentTableService;

class ContentSheetMainCatalogController extends Controller
{
    public function edit(ModelAttributeHelper $modelAttributeHelper)
    {
        $company = Auth::user()->company()->first();
        $page = $modelAttributeHelper->getAttributesFromModel($company->contentSheetMainCatalog);

        return view('admin_panel.content.sheet.catalog.edit', compact('page'));
    }

    public function update(Request $request)
    {
        $object = Auth::user()->company()->first()->contentSheetMainCatalog;

        $createAndUpdateContentTableService = new CreateAndUpdateContentTableService();

        $createAndUpdateContentTableService->update($object, $request);

        return redirect()
            ->route('content.sheet.main.catalog.edit')
            ->with(['success' => 'Страница обновлена']);
    }
}
