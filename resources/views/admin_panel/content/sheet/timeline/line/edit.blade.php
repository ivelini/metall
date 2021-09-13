@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить линию
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить линию
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
                            {{ $page->h1 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('content.sheet.timeline.line.update', [$page->id, $line->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                                               placeholder="Название линии"
                                               value="{{ old('h1', $line->h1) }}"
                                                required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="content"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control"
                                                  id="summernote">{{ old('content', $line->content) }}</textarea>
                                    </div>
                                </div>

                            </fieldset>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-floppy-disk ml-2"></i></button>
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
                                <img class="card-img img-fluid" src="@if(empty($line->img))
                                                                            /admin_panel/global_assets/images/placeholders/placeholder.jpg
                                                                        @else
                                                                            {{ $line->img }}
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
    <div class="row">
        <div class="col-lg-9"></div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="text-right">
                        <form action="{{ route('content.sheet.timeline.line.destroy', [$page->id, $line->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-primary">Удалить <i class="icon-bin"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('include-footer')
            <script>
                $(document).ready(function() {
                    $('#summernote').summernote();
                });
            </script>

@endsection