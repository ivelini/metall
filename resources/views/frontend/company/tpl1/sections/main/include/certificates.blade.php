<section class="divider layer-overlay overlay-theme-colored-5"
         data-background-ratio="0.5"
         data-bg-img="/frontend/company/themes/tpl1/images/bg/bg5.jpg">
    <div class="container pb-50">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2 class="text-uppercase line-bottom-double-line-centered text-white mt-0">Наши <span class="text-theme-colored2">Сертификаты</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-10">
                <div class="owl-carousel-2col" data-dots="true">
                    @foreach($certificates as $certificat)
                        <div class="item">
                            <div class="testimonial pt-10">
                                <div class="thumb pull-left mb-0 mr-0 pr-20">
                                    <a class="image-popup-vertical-fit" href="{{ $certificat->get('img_original') }}">
                                        <img src="{{ $certificat->get('img_original') }}" style="height: 300px">
                                    </a>
                                </div>
                                <div class="ml-100 ">
                                    <p class="author mt-10">
                                        <span class="text-theme-colored2">{{ $certificat->get('h1') }}</span>
                                    </p>
                                    <p class="text-white mt-0">
                                        {{ $certificat->get('description') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>