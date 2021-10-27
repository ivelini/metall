<section id="blog" class="bg-silver-light">
    <div class="container">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2 class="text-uppercase line-bottom-double-line-centered mt-0">Последние <span class="text-theme-colored2">Отгрузки</span></h2>
                </div>
            </div>
        </div>
        <div class="section-content">
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel-3col owl-nav-top" data-nav="true">
                        @foreach($shipments as $shipment)
                            <div class="item">
                                <article class="post clearfix campaign mb-30">
                                    <div class="entry-header">
                                        <div class="post-thumb thumb">
                                            <img src="{{ $shipment->get('img') }}" alt="" class="img-responsive img-fullwidth">
                                        </div>
                                        <div class="entry-date media-left text-center flip bg-theme-colored border-top-theme-colored2-3px pt-5 pr-15 pb-5 pl-15">
                                            <ul>
                                                <li class="font-16 text-white font-weight-600">{{ $shipment->get('date_d') }}</li>
                                                <li class="font-12 text-white text-uppercase">{{ $shipment->get('date_m') }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="entry-content p-20 border-bottom-2px border-theme-colored2 bg-white">
                                        <div class="entry-meta media mt-0 mb-10">
                                            <div class="media-body pl-0">
                                                <div class="event-content pull-left flip">
                                                    <h4 class="entry-title text-white text-uppercase font-weight-600 m-0 mt-5">
                                                        <a href="{{ route('frontend.company.content.sheet.shipment.page', $shipment->get('id')) }}">
                                                            {{ $shipment->get('h1') }}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>