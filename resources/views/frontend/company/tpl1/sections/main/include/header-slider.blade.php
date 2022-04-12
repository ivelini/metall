<section id="home" class="divider">
    <div class="fullwidth-carousel" data-nav="true">
        @foreach($slider as $slide)
            <div class="carousel-item" style="background-image: url('{{ $slide->get('img') }}'); background-size: cover !important;">
                <div class="display-table">
                    <div class="display-table-cell">
                        <div class="container pt-200 pb-200">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="bg-white-transparent text-center pt-20 pb-50 outline-border">
                                        <h1 class="text-white text-uppercase font-54">{{ $slide->get('h1') }}</h1>
                                        <h5 class="text-white font-weight-400">{{ $slide->get('description') }}</h5>
                                        <a class="btn btn-colored btn-theme-colored btn-flat smooth-scroll-to-target mt-15"
                                           href="{{ $slide->get('link_href') }}">{{ $slide->get('link_name') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>