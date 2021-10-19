@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section>
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Portfolio Gallery Grid -->
                        <div class="gallery-isotope default-animation-effect grid-4 gutter-small clearfix" data-lightbox="gallery" style="position: relative; height: 477.651px;">
                            <!-- Portfolio Item Start -->
                            <div class="gallery-item design" style="position: absolute; left: 0px; top: 0px;">
                                <div class="thumb">
                                    <img class="img-fullwidth" src="/frontend/company/themes/tpl1/images/gallery/1.jpg" alt="project">
                                    <div class="overlay-shade"></div>
                                    <div class="text-holder">
                                        <div class="title text-center">Sample Title</div>
                                    </div>
                                    <div class="icons-holder">
                                        <div class="icons-holder-inner">
                                            <div class="styled-icons icon-sm icon-dark icon-circled icon-theme-colored">
                                                <a href="/frontend/company/themes/tpl1/images/gallery/1.jpg" data-lightbox-gallery="gallery" title="Your Title Here"><i class="fa fa-picture-o"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Portfolio Item End -->
                        </div>
                        <!-- End Portfolio Gallery Grid -->

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection