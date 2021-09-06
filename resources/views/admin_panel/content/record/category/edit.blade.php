@extends('admin_panel.layouts.main.main')
@section('title')
    Редактировать рубрику
@endsection
@section('pageheader-title')
    Редактировать рубрику
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">

@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            @include('admin_panel.layouts.main.alerts')
                <form action="{{ route('content.records.category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Рубрика "{{ $category->h1 }}"</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Название</label>
                            <div class="col-lg-10">
                                <input name="h1" type="text" class="form-control" value="{{ old('h1', $category->h1) }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Описание</label>
                            <div class="col-lg-10">
                                <textarea name="description"
                                          rows="3"
                                          cols="3"
                                          class="form-control"
                                          id="summernote">{{ old('description', $category->description) }}</textarea>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">SEO</legend>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">title</label>
                            <div class="col-lg-10">
                                <input name="title" type="text" class="form-control" value="{{ old('title', $category->title) }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Ярлык</label>
                            <div class="col-lg-10">
                                <input name="slug" type="text" class="form-control" value="{{ old('slug', $category->slug) }}">
                            </div>
                        </div>

                    </fieldset>

                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Обновить <i class="icon-paperplane ml-2"></i></button>
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