@extends('admin_panel.layouts.main.main')
@section('title')
    Редактировать запись
@endsection
@section('pageheader-title')
    Каталог продукции
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">

@endsection
@section('content-area')
    <form action="{{ route('content.sheet.info-update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <input name="sheet_name"
                               value="page_catalog"
                               hidden>
                        @include('admin_panel.content.sheet.include.page-info-form')
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')
    @include('admin_panel.content.sheet.include.js-text-edit')
@endsection