@extends('admin_panel.layouts.main.main')
@section('title')
    Категории продукции
@endsection
@section('pageheader-title')
    Категории продукции
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            @include('admin_panel.layouts.main.alerts')
            <div class="row">
                <div class="col-lg-12">
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <h4 class="font-weight-semibold">{{ $category->category_name }}
                                            <a href="{{ route('catalog.product.parentcategory.create', $category->id) }}" class="btn">
                                                <i class="icon-plus22"></i>
                                            </a></h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if($category->children->count() > 0)
                                            <ul class="list list-unstyled">
                                                @foreach($category->children as $child)
                                                    <li><a href="{{ route('catalog.product.category.edit', $child->id) }}">{{ $child->category_name }}</a></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
@endsection
@section('include-footer')

@endsection