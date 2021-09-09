<?php

namespace App\Http\Controllers\AdminPanel\Content;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Content\ContentSheetCertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContentSheetCertificateController extends Controller
{
    protected $contentSheetCertificateRepository;
    protected $imageHelper;
    protected $company;

    public function __construct()
    {
        $this->contentSheetCertificateRepository = new ContentSheetCertificateRepository();
        $this->imageHelper = new ImageHelper();

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
        $data = $request->input();

        $contentSheetCertificateMoel = $this->contentSheetCertificateRepository->startConditions();

        $contentSheetCertificateMoel->company_id = $this->company->id;
        $contentSheetCertificateMoel->name = $data['name'];
        $contentSheetCertificateMoel->description = !empty($data['description']) == true ? $data['description'] : NULL;
        $contentSheetCertificateMoel->save();

        $this->imageHelper->saveOrUpdateImageFromModel($contentSheetCertificateMoel, $request->file('img'));

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
        $data = $request->input();

        $certificate = $this->contentSheetCertificateRepository->getCertificate($id);

        $certificate->update([
            'name' => $data['name'],
            'description' => $data['description']
        ]);

        $this->imageHelper->saveOrUpdateImageFromModel($certificate, $request->file('img'));

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
