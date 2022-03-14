@extends('admin_panel.layouts.main.main')
@section('title')
    Главная страница
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Главная страница
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">
@endsection
@section('content-area')
    <div class="row">
        <div class="col-lg-12">
            <div class="card-group-control card-group-control-right">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <a class="text-body collapsed" data-toggle="collapse" href="#collapsible-control-right-group2" aria-expanded="false">
                                Контент
                            </a>
                        </h6>
                    </div>

                    <div id="collapsible-control-right-group2" class="collapse" style="">
                        <div class="card-body">
                            <form action="{{ route('content.sheet.info-update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input name="sheet_name"
                                       value="page_main"
                                       hidden>
                                @include('admin_panel.content.sheet.include.page-info-form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-body border-top-primary">
                <div class="text-right">
                    <a href="{{ route('content.sheet.main.divider.index') }}" class="btn btn-primary"><i class="icon-page-break mr-2"></i> Разделители</a>
                    <a href="{{ route('content.sheet.main.services.index') }}" class="btn btn-primary"><i class="icon-grid4 mr-2"></i> Список услуг</a>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('content.sheet.main.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="card">
            <div class="card-body">
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Параметры полей</legend>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Наша команда</label>
                            <div class="col-lg-10">
                                    @if ($workerCategories->count() > 0)
                                        <select class="form-control" name="worker_category_id">
                                            @foreach($workerCategories as $workerCategory)
                                                <option value="{{ $workerCategory->get('id') }}"
                                                    @if ($workerCategory->get('id') == $mainPage->get('worker_category_id'))
                                                        selected
                                                    @endif
                                                >{{ $workerCategory->get('h1') }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                    <label class="col-form-label col-lg-12">
                                       <a href="{{ route('content.sheet.worker.index') }}">Добавить сотрудников</a></label>
                                    @endif
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Обновить <i class="icon-paperplane ml-2"></i></button>
                    </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')
    @include('admin_panel.content.sheet.include.js-text-edit')
@endsection