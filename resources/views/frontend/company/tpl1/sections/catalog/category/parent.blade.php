@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="sidebar sidebar-left mt-sm-30">
                        @include('frontend.company.tpl1.sections.include.left-sidebar')
                    </div>
                </div>
                <div class="col-md-9 blog-pull-right">
                    <div class="blog-posts single-post">
                        <article class="post clearfix mb-0">
                            @if($childrenCat->count() > 0)
                                <div class="row">
                                    @foreach($childrenCat as $child)
                                        <a href="{{ route('frontend.company.catalog.product.category', [$child->get('parent_id'), $child->get('id')]) }}">
                                            <div class="col-xs-12 col-sm-4 col-md-4" style="padding-top: 15px;">
                                                <div class="image-box-thum">
                                                    <img src="{{ $child->get('img') }}" alt="">
                                                </div>
                                                <div class="image-box-details text-center p-20 pt-30 pb-30 bg-lighter">
                                                    <h3 class="title mt-0">{{ $child->get('category_name') }}</h3>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection