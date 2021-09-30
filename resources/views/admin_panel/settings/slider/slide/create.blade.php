@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить слайд
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить слайд
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">

@endsection
@section('content-area')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            Слайдер "{{ $page->h1 }}"
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('settings.slider.slide.store',  $page->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        @include('admin_panel.layouts.main.alerts')
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="h1"
                                               class="form-control"
                                               placeholder="Название слайда"
                                                required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="description"
                                               class="form-control"
                                               placeholder="Описание слайда"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="link_name"
                                               class="form-control"
                                               placeholder="Название ссылки"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="link_href"
                                               class="form-control"
                                               placeholder="Адрес ссылки"
                                               required>
                                    </div>
                                </div>
                            </fieldset>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Добавить <i class="icon-floppy-disk ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Изображение</legend>
                            <div class="card-img-actions m-1">
                                <img class="card-img img-fluid" src="@if(empty($slide->img))
                                                                            /admin_panel/global_assets/images/placeholders/placeholder.jpg
                                                                        @else
                                                                            {{ $slide->img}}
                                                                        @endif" alt="">
                                <div class="card-img-actions-overlay card-img">
                                    <input name="img" type="file" class="form-control-plaintext" style="width: 65px">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

        </div>
    </form>
@endsection
@section('include-footer')

@endsection