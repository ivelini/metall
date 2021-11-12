<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ModelAttributeHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Content\CreateAndUpdateContentTableService;

class ContentSheetMainCatalogController extends Controller
{
    public function edit()
    {
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $page = $contentSheetPageInformationRepository->getInformationFromSheetPage('page_catalog');

        return view('admin_panel.content.sheet.catalog.edit', compact('page'));
    }
}
