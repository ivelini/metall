<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ModelAttributeHelper;
use App\Http\Controllers\Controller;
use App\Services\Content\CreateAndUpdateContentTableService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentSheetMainPageController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelAttributeHelper $modelAttributeHelper)
    {
        $company = Auth::user()->company()->first();
        $mainPage = $modelAttributeHelper->getAttributesFromModel($company->contentSheetMainPage);
        $workerCategories = $modelAttributeHelper->getAttributesFromCollectionModels($company->contentSheetWorkerCategory, ['id', 'h1']);

//        dd(__METHOD__, $mainPage);

        return view('admin_panel.content.sheet.main.edit', compact('mainPage', 'workerCategories'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $object = Auth::user()->company()->first()->contentSheetMainPage;

        $createAndUpdateContentTableService = new CreateAndUpdateContentTableService();

        $createAndUpdateContentTableService->update($object, $request);

        return redirect()
            ->route('content.sheet.main.edit')
            ->with(['success' => 'Страница обновлена']);
    }

}
