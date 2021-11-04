<section>
    <div class="container wow fadeInUp" data-wow-duration="1s">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h2 class="text-uppercase line-bottom-double-line-centered mt-0">Наша <span class="text-theme-colored2">Команда</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="team-members">
                @foreach($workers as $worker)
                    <div class="col-sm-6 col-md-4">
                        <div class="team-member service-box maxwidth400 mb-sm-15">
                            <div class="team-thumb">
                                <img class="img-fullwidth mt-15" src="{{ $worker->get('img') }}" alt="">
                            </div>
                            <div class="team-details text-center pt-20 pb-5">
                                <div class="member-biography">
                                    <h3 class="mt-0 text-theme-colored2">{{ $worker->get('name') }}</h3>
                                    <p class="mb-0">{{ $worker->get('email') }}</p>
                                    <h5 class="mt-0 text-theme-colored2">{{ $worker->get('phone') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>