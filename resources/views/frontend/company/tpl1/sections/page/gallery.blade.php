@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')

    <section>
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        <div id="grid" class="gallery-isotope default-animation-effect grid-3 gutter clearfix">
                            @if($objects->count() > 0)
                                @foreach($objects as $object)
                                    <div class="gallery-item branding photography">
                                        <div class="thumb">
                                            <img class="img-fullwidth" src="{{ $object->get('img') }}" alt="project">
                                            <div class="overlay-shade"></div>
                                            <div class="text-holder">
                                                <div class="title text-center">{{ $object->get('h1') }}</div>
                                                <div class="title text-center">-</div>
                                                <div class="title text-center">{{ $object->get('description') }}</div>
                                            </div>
                                            <div class="icons-holder">
                                                <div class="icons-holder-inner">
                                                    <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                        <a href="{{ $object->get('img_original') }}" data-lightbox-gallery="gallery" title="Your Title Here"><i class="fa fa-picture-o"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!-- End Portfolio Gallery Grid -->

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection