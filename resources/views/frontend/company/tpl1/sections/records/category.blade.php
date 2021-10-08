@extends('frontend.company.tpl1.layout.index')
@include('frontend.company.tpl1.sections.include.head-meta')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section id="news">
        <div class="container">
            <div class="section-content">
                <div class="row">
                    <div class="col-sm-6 col-md-4">
                        <article class="post clearfix mb-30 mb-sm-30">
                            <div class="entry-header">
                                <div class="post-thumb thumb">
                                    <img src="/themes/tpl1/images/blog/1.jpg" alt="" class="img-responsive img-fullwidth">
                                </div>
                            </div>
                            <div class="entry-content p-20 pr-10 bg-lighter">
                                <div class="entry-meta media mt-0 no-bg no-border">
                                    <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                                        <ul>
                                            <li class="font-16 text-white font-weight-600 border-bottom">28</li>
                                            <li class="font-12 text-white text-uppercase">Feb</li>
                                        </ul>
                                    </div>
                                    <div class="media-body pl-15">
                                        <div class="event-content pull-left flip">
                                            <h4 class="entry-title text-white text-uppercase m-0 mt-5"><a href="#">Post title here</a></h4>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-10">Lorem ipsum dolor sit amet, consectetur adipisi cing elit. Molestias eius illum libero dolor nobis deleniti, sint assumenda Pariatur iste.</p>
                                <a class="btn btn-theme-colored2 btn-sm text-white" href="blog-single-left-sidebar.html"> View Details</a>
                                <div class="clearfix"></div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection