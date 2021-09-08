@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить подразделение
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить подразделение
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">

@endsection
@section('content-area')
    <form action="{{ route('content.sheet.worker.category.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-9">
                        <input name="name"
                               class="form-control"
                               placeholder="Название подразделения"
                               required
                               value="">
                    </div>
                    <div class="col-lg-3">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        @include('admin_panel.layouts.main.alerts')
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')

@endsection