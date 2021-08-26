@extends('admin_panel.layouts.main.main')
@section('title')
    Категория "{{ $parentCategory->category_name }}" - добавление подкатегории
@endsection
@section('pageheader-title')
    Категория "{{ $parentCategory->category_name }}" - добавление подкатегории
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('catalog.product.category.store') }}" method="POST">
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
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Параметры фильтра</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Название категории</label>
                        <div class="col-lg-10">
                            <input name="category_name" type="text" class="form-control">
                        </div>
                    </div>

                    @foreach($uniqVolumes as $keyName => $volumeCollect)
                        <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{ $keyName }}</label>
                                <div class="col-lg-10">
                                    <select name="{{ $keyName }}:" class="form-control">
                                        <option value=""></option>
                                        @if($keyName == 'catalog_standards_product_id' || $keyName == 'catalog_marki_stali_id')
                                            @foreach($volumeCollect as $volume)
                                                <option value="@php
                                                    echo mb_substr($volume, strpos($volume, ':'));
                                                @endphp">{{ $volume }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                        </div>
                    @endforeach
                    </fieldset>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Добавить <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
        </div>
@endsection
@section('include-footer')

@endsection