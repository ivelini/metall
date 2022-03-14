<section id="features" class="bg-lighter">
    <div class="container">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2 class="text-uppercase line-bottom-double-line-centered mt-0">Наши услуги <span class="text-theme-colored2">по организации и сопроождении сделки</span></h2>
                </div>
            </div>
        </div>
        <div class="row mtli-row-clearfix">
            @foreach($services as $service)
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="service-box icon-box iconbox-theme-colored bg-white p-30 mb-30 border-1px">
                        <div class="icon icon-dark border-left-theme-colored2-3px pull-left flip mb-0 mr-0 mt-5" style="padding-top:15px">
                            <img src="{{ $service->get('img') }}" width="50px" height="40px">
                        </div>
                        <div class="icon-box-details">
                            <h4 class="icon-box-title m-0 mb-5">{{ $service->get('h1') }}</h4>
                            <p class="text-gray mb-0">{{ $service->get('description') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>