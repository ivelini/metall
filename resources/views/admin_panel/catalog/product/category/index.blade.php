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
                                        <h4 class="font-weight-semibold">
                                            <a href="{{ route('catalog.product.category.editParent', $category->id) }}">
                                                {{ $category->category_name }}
                                            </a>
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
                                                    <li>
                                                        <div class="row @if($child->is_published == 0) not-active @endif">
                                                            <div class="col-lg-3">
                                                                <a href="{{ route('catalog.product.category.edit', $child->id) }}">
                                                                    {{ $child->category_name }}</a>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                {{ $child->columns_name }}
                                                            </div>
                                                            <div class="col-lg-3">
                                                                <form action="{{ route('catalog.product.category.destroy', $child->id) }}" method="POST">
                                                                    @method('DELETE')
                                                                    @csrf
                                                                    <div class="text-right">
                                                                        <button type="submit" class="btn"> <i class="icon-bin"></i></button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </li>
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