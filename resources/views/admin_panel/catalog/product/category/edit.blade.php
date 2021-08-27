@extends('admin_panel.layouts.main.main')
@section('title')

@endsection
@section('pageheader-title')

@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('catalog.product.category.update', $category->id) }}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="catalog_product_table_name" value="{{ $category->catalog_product_table_name }}">
                <input type="hidden" name="parent_id" value="{{ $category->parent_id }}">
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="custom-control custom-control-right custom-switch text-right mb-2">
                                <input type="checkbox" name="is_published" class="custom-control-input" id="sc_rs_c"
                                    @if($category->is_published == 1)   checked @endif
                                >
                                <label class="custom-control-label" for="sc_rs_c">Опубликованна</label>
                            </div>
                        </div>
                    </div>
                </div>
                @include('admin_panel.layouts.main.alerts')
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Параметры фильтра</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Название категории</label>
                        <div class="col-lg-10">
                            <input name="category_name" type="text" class="form-control" value="{{ $category->category_name }}">
                        </div>
                    </div>

                    @foreach($uniqVolumesAndSelected as $keyName => $volumeCollect)
                        <div class="form-group row">
                                <label class="col-form-label col-lg-2">{{ $keyName }}</label>
                                <div class="col-lg-10">
                                    <select name="{{ $keyName }}:" class="form-control">
                                        <option value=""></option>
                                        @foreach($volumeCollect as $volume)
                                            @php
                                                if (gettype(mb_strripos($volume, '+', 0, 'utf8')) == 'integer') {
                                                    if (gettype(mb_strripos($volume, ':', 0, 'utf8')) == 'integer') {
                                                        print '<option value="' . mb_substr($volume, mb_strripos($volume, ':', 0, 'utf8') + 1)
                                                            . '" selected>'
                                                            . mb_substr($volume, mb_strripos($volume, '+', 0, 'utf8') + 1, mb_strripos($volume, ':', 0, 'utf8') - 1)
                                                            . '</option>';
                                                    }
                                                    else {
                                                        print '<option value="' . mb_substr($volume, mb_strripos($volume, '+', 0, 'utf8') + 1, mb_strripos($volume, ':', 0, 'utf8') - 1)
                                                            . '" selected>'
                                                            . mb_substr($volume, mb_strripos($volume, '+', 0, 'utf8') + 1, mb_strripos($volume, ':', 0, 'utf8') - 1)
                                                            . '</option>';
                                                    }
                                                }
                                                else {
                                                    if (gettype(mb_strripos($volume, ':', 0, 'utf8')) == 'integer') {
                                                        print '<option value="' . mb_substr($volume, mb_strripos($volume, ':', 0, 'utf8') + 1)
                                                            . '">'
                                                            . mb_substr($volume, 0, mb_strripos($volume, ':', 0, 'utf8'))
                                                            . '</option>';
                                                    }
                                                    else {
                                                        print '<option value="' . $volume
                                                            . '">'
                                                            . $volume
                                                            . '</option>';
                                                    }
                                                }
                                            @endphp
                                        @endforeach
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