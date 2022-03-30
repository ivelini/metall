<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetPageInformationRepository;
use Illuminate\Http\Request;

class ContentSheetContactController extends Controller
{
    public function edit()
    {
        $contentSheetPageInformationRepository = new ContentSheetPageInformationRepository();
        $page = $contentSheetPageInformationRepository->getInformationFromSheetPage('page_contacts');

        return view('admin_panel.content.sheet.contact.edit', compact('page'));
        dd(__METHOD__);
    }

}
