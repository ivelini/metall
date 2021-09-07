@extends('admin_panel.layouts.main.main')
@section('title')
    Редактировать запись
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Редактировать запись
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">

@endsection
@section('content-area')
    <form action="{{ route('content.records.record.update', $record->id) }}" method="POST" enctype="multipart/form-data">
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
                                               placeholder="Название записи"
                                                value="{{ $record->h1 }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="content"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control"
                                                  id="summernote">{{ old('content', $record->content) }}</textarea>
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">SEO</legend>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="title"
                                               class="form-control"
                                               placeholder="Title"
                                               value="{{ $record->title }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="slug"
                                               class="form-control"
                                               placeholder="Ярлык"
                                               value="{{ $record->slug }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="description"
                                                  placeholder="Описание"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control">{{ old('description', $record->description) }}</textarea>
                                    </div>
                                </div>
                            </fieldset>

                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="custom-control custom-control-right custom-switch text-right mb-2">
                            <input type="checkbox" name="is_published" class="custom-control-input" id="sc_rs_c"
                                @if ($record->is_published == 1) checked @endif>
                            <label class="custom-control-label" for="sc_rs_c">Опубликованна</label>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" readonly="" value="Создание: {{ $record->created_at }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" readonly="" value="Изменение: {{ $record->updated_at }}">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Обновить <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Рубрика</legend>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <select name="content_record_category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                @if($category->id == $record->category_id)
                                                    selected="selected"
                                                @endif
                                            >{{ $category->h1 }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Изображение</legend>

                            <div class="card-img-actions m-1">
                                <img class="card-img img-fluid" src="@if(empty($record->img))
                                                                            /admin_panel/global_assets/images/placeholders/placeholder.jpg
                                                                        @else
                                                                            {{ $record->img}}
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
            <script>
                $(document).ready(function() {
                    $('#summernote').summernote();
                });
            </script>

@endsection