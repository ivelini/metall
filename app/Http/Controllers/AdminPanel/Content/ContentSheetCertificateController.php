<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetCertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Content\CreateAndUpdateContentTableService;

class ContentSheetCertificateController extends Controller
{
    protected $contentSheetCertificateRepository;
    protected $imageHelper;
    protected $company;
    protected $createAndUpdateContentTableService;

    public function __construct()
    {
        $this->contentSheetCertificateRepository = new ContentSheetCertificateRepository();
        $this->imageHelper = new ImageHelper();
        $this->createAndUpdateContentTableService = new CreateAndUpdateContentTableService();

        $this->middleware(function ($request, $next) {
            $this->company= Auth::user()->company()->first();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificatesChunk = $this->contentSheetCertificateRepository
            ->getCertificatesFromCompanyForIndex($this->company);

        return view('admin_panel.content.sheet.certificate.index', compact('certificatesChunk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin_panel.content.sheet.certificate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contentSheetCertificateModel = $this->contentSheetCertificateRepository->startConditions();
        $this->createAndUpdateContentTableService->save($contentSheetCertificateModel, $request);

        return redirect()
            ->route('content.sheet.certificate.index')
            ->with(['success' => 'Сертификат добавлен']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $certificate = $this->contentSheetCertificateRepository->getCertificateForEdit($id);

        return view('admin_panel.content.sheet.certificate.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $certificate = $this->contentSheetCertificateRepository->getCertificate($id);
        $this->createAndUpdateContentTableService->update($certificate, $request);

        return redirect()
            ->route('content.sheet.certificate.index')
            ->with(['success' => 'Сертификат обновлен']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->contentSheetCertificateRepository->getCertificate($id)->delete();

        return redirect()
            ->route('content.sheet.certificate.index')
            ->with(['success' => 'Сертификат удален']);
    }
}
