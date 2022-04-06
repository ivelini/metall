@extends('admin_panel.layouts.main.main')
@section('title')
    Категория "{{ $parentCategory->category_name }}" - добавление подкатегории
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Категория "{{ $parentCategory->category_name }}" - добавление подкатегории
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('catalog.product.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="catalog_product_table_name" value="{{ $parentCategory->catalog_product_table_name }}">
                <input type="hidden" name="parent_id" value="{{ $parentCategory->id }}">
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="custom-control custom-control-right custom-switch text-right mb-2">
                                <input type="checkbox" name="is_published" class="custom-control-input" id="sc_rs_c">
                                <label class="custom-control-label" for="sc_rs_c">Опубликованна</label>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin_panel.layouts.main.alerts')
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Параметры фильтра</legend>

                    @foreach($uniqVolumes as $keyName => $volumeCollect)
                        <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{ $keyName }}</label>
                                <div class="col-lg-10">
                                    <select name="{{ $keyName }}:" class="form-control">
                                        <option value=""></option>
                                        @if($keyName == 'catalog_standards_product_id' || $keyName == 'catalog_marki_stali_id')
                                            @foreach($volumeCollect as $volume)
                                                @php
                                                     print '<option value="' . mb_substr($volume, mb_strripos($volume, ':', 0, 'utf8') +1) . '">'
                                                        . mb_substr($volume, 0, mb_strripos($volume, ':', 0, 'utf8')) . '</option>'
                                                @endphp
                                            @endforeach
                                        @elseif($keyName != 'catalog_standards_product_id')
                                            @foreach($volumeCollect as $volume)
                                                <option value="{{ $volume }}">{{ $volume }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                        </div>
                    @endforeach
                    </fieldset>
                <fieldset>
                    <div class="form-group row">
                        <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">SEO</legend>
                        <label class="col-form-label col-lg-2">Название категории (для меню)</label>
                        <div class="col-lg-10">
                            <input name="category_name" type="text" class="form-control" value="{{ old('category_name') }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Название категории (на странице)</label>
                        <div class="col-lg-10">
                            <input name="h1" type="text" class="form-control" value="{{ old('h1') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">title</label>
                        <div class="col-lg-10">
                            <input name="title" type="text" class="form-control" value="{{ old('title') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">description</label>
                        <div class="col-lg-10">
                            <input name="description" type="text" class="form-control" value="{{ old('description') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">slug</label>
                        <div class="col-lg-10">
                            <input name="slug" type="text" class="form-control" value="{{ old('slug') }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-10">
                            <div class="form-group">
                                <label>Описание категории</label>
                                <textarea name="content"
                                          rows="5"
                                          cols="3"
                                          class="form-control"
                                          id="summernote">{{ old('content') }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="card">
                                <div class="card-img-actions m-1">
                                    <img class="card-img img-fluid" src="/admin_panel/global_assets/images/placeholders/placeholder.jpg" alt="">
                                    <div class="card-img-actions-overlay card-img">
                                        <input name="img" type="file" class="form-control-plaintext" style="width: 65px">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Добавить <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
@endsection
@section('include-footer')
            <script>
                $(document).ready(function() {
                    $('#summernote').summernote();
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('#summernote2').summernote();
                });
            </script>
@endsection