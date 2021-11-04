<header id="header" class="header modern-header modern-header-theme-colored">
    <div class="header-top bg-theme-colored sm-text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="widget text-white">
                        <i class="fa fa-clock-o text-theme-colored2"></i> Часы работы:  {{ $headerValues->get('clockWork') }}
                    </div>
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>
    </div>
    <div class="header-middle p-0 bg-light xs-text-center">
        <div class="container pt-30 pb-30">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <div class="widget sm-text-center">
                        <i class="fa fa-envelope text-theme-colored2 font-32 mt-5 mr-sm-0 sm-display-block pull-left flip sm-pull-none"></i>
                        <a href="#" class="font-12 text-gray text-uppercase">Почта для связи</a>
                        <h5 class="font-13 text-black m-0"> {{ $headerValues->get('siteEmail') }}</h5>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-6">
                    <div class="widget text-center">
                        <a class="" href="index-mp-layout1.html"><img src="{{ $headerValues->get('imgOriginal') }}" alt=""></a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-3">
                    <div class="widget sm-text-center">
                        <i class="fa fa-building-o text-theme-colored2 font-32 mt-5 mr-sm-0 sm-display-block pull-left flip sm-pull-none"></i>
                        <a href="#" class="font-12 text-gray text-uppercase">Адрес коммпании</a>
                        <h5 class="font-13 text-black m-0"> {{ $headerValues->get('address') }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-nav">
        <div class="header-nav-wrapper navbar-scrolltofixed">
            <div class="container">
                @include('frontend.company.tpl1.layout.header.menu')
            </div>
        </div>
    </div>
</header>