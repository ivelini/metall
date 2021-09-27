@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить отгрузку
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить отгрузку
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">
    <script>
        $(document).ready(function(){
            var i = $('#data_inputs .form-control').length;
            if (i == 0) {
                i = 1;
            }
            else {
                i = i / 2 + 1;
            }
            $('#add').click(function() {
                $('<div class="field form-group row"><div class="col-lg-12"><div class="form-group row"><div class="col-8"><input class="form-control" type="text" name="products_json[' + i + '][name]" value="" placeholder="Наименование"></div><div class="col-4"><input class="form-control" type="text" name="products_json[' + i + '][gost]" value="" placeholder="ГОСТ"></div></div></div></div>').fadeIn('slow').appendTo('.inputs');
                i++;
            });

            $('#remove').click(function() {
                if(i > 1) {
                    $('.field:last').remove();
                    i--;
                }
            });
        });
    </script>
@endsection
@section('content-area')
    <form action="{{ route('content.sheet.shipment.store') }}" method="POST" enctype="multipart/form-data">
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
                                           placeholder="Название записи"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <label>Дата отгрузки</label>
                                    <input name="date"
                                           type="date"
                                           class="form-control"
                                           placeholder="Дата отгрузки"
                                           required>
                                </div>
                                <div class="col-lg-6">
                                    <label>Город отгрузки</label>
                                    <input name="point"
                                           type="text"
                                           class="form-control"
                                           placeholder="Город отгрузки"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                        <textarea name="content"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control"
                                                  id="summernote">{{ old('content') }}</textarea>
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Галерея</legend>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input name="gallery[]"
                                           type="file"
                                           class="form-control"
                                           multiple>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Отгруженная подукция</legend>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <a href="#" id="add">Добавить</a> | <a href="#" id="remove">Удалить</a>
                                    <div class="inputs"></div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">SEO</legend>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input name="title" class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input name="slug" class="form-control" placeholder="Ярлык">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                        <textarea name="description"
                                                  placeholder="Описание"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control">{{ old('description') }}</textarea>
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
                            >
                            <label class="custom-control-label" for="sc_rs_c">Опубликованна</label>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" readonly="" value="Публикация:">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-lg-12">
                                <input type="text" class="form-control" readonly="" value="Изменение:">
                            </div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Добавить <i class="icon-floppy-disk ml-2"></i></button>
                        </div>
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