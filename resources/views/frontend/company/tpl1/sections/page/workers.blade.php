@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')

    <section id="team">
        <div class="container">
                @if($workers->count() > 0)
                    @foreach($workers as $key => $workerCategory)
                    <h4 class="text-uppercase line-bottom-double-line-centered mt-0">{{ $key }}</h4>
                            <div class="row mtli-row-clearfix">
                                @foreach($workerCategory as $worker)
                                    <div class="col-xs-12 col-sm-6 col-md-3 sm-text-center mb-sm-30">
                                        <div class="team-block service-box maxwidth400">
                                            <div class="team-thumb">
                                                <img class="img-fullwidth" alt="" src="{{ $worker->get('img') }}">
                                            </div>
                                            <div class="team-bottom-part">
                                                <h4 class="text-uppercase text-theme-colored2">{{ $worker->get('name') }}</h4>
                                                <h6 class="text-uppercase text-theme-colored4">{{ $worker->get('position') }}</h6>
                                                <ul class="list-inline font-14 mb-10">
                                                    <li><i class="fa fa-phone text-theme-colored5 mr-10"></i>{{ $worker->get('phone') }}</li>
                                                    <li><i class="fa fa-envelope-o text-theme-colored5 mr-10"></i>{{ $worker->get('email') }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                    @endforeach
                @endif
        </div>
    </section>
    <!-- Divider: Clients -->
    <section class="clients bg-theme-colored2">
        <div class="container pt-10 pb-0">
            <div class="row">
                <div class="col-md-12">
                    <!-- Section: Clients -->
                    <div class="owl-carousel-6col text-center">
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w1.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w2.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w3.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w4.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w5.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w6.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w3.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w4.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w5.png" alt=""></a></div>
                        <div class="item"> <a href="#"><img src="/frontend/company/themes/tpl1/images/clients/w6.png" alt=""></a></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection