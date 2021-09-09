@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить рубрику
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить рубрику
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">

@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            @include('admin_panel.layouts.main.alerts')
                <form action="{{ route('content.records.category.store') }}" method="POST">
                    @csrf
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Добавить новую рубрику</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Название</label>
                            <div class="col-lg-10">
                                <input name="h1" type="text" class="form-control" value="{{ old('h1') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Описание</label>
                            <div class="col-lg-10">
                                <textarea name="description"
                                          rows="3"
                                          cols="3"
                                          class="form-control"
                                          id="summernote">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">SEO</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">title</label>
                            <div class="col-lg-10">
                                <input name="title" type="text" class="form-control" value="{{ old('title') }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Ярлык</label>
                            <div class="col-lg-10">
                                <input name="slug" type="text" class="form-control" value="{{ old('slug') }}">
                            </div>
                        </div>

                    </fieldset>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Добавить <i class="icon-floppy-disk ml-2"></i></button>
                    </div>
                </form>
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