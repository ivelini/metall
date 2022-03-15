@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section>
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        @if($categories->count() > 0)
                            <div class="gallery-isotope default-animation-effect grid-4 gutter-small clearfix" data-lightbox="gallery" style="position: relative; height: 477.651px;">
                                <!-- Portfolio Item Start -->
                                @foreach($categories as $category)
                                    <div class="gallery-item design" style="position: absolute; left: 0px; top: 0px;">
                                        <div class="thumb">
                                            <img class="img-fullwidth" src="{{ $category->get('img') }}" alt="project">
                                            <div class="overlay-shade"></div>
                                            <div class="text-holder">
                                                <div class="title text-center">{{ $category->get('category_name') }}</div>
                                            </div>
                                            <div class="icons-holder">
                                                <div class="icons-holder-inner">
                                                    <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                        <a href="{{ route('frontend.company.catalog.category.parent', $category->get('slug')) }}" data-lightbox-gallery="gallery" title="{{ $category->get('category_name') }}"><i class="fa fa-picture-o"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!-- Portfolio Item End -->
                            </div>
                        @endif
                        <!-- End Portfolio Gallery Grid -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-posts single-post">
                            <article class="post clearfix mb-0">
                                <div class="entry-content mt-10">
                                    {!! $content !!}
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection