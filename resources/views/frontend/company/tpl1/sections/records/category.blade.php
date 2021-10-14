@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section id="news">
        <div class="container">
            <div class="section-content">
                <div class="row">
                    @if($records->count() > 0)
                        @foreach($records as $record)
                            <div class="col-sm-6 col-md-4">
                                <article class="post clearfix mb-30 mb-sm-30">
                                    <div class="entry-header">
                                        <div class="post-thumb thumb">
                                            <img src="{{ $record->get('img') }}" alt="" class="img-responsive img-fullwidth">
                                        </div>
                                    </div>
                                    <div class="entry-content p-20 pr-10 bg-lighter">
                                        <div class="entry-meta media mt-0 no-bg no-border">
                                            <div class="entry-date media-left text-center flip bg-theme-colored pt-5 pr-15 pb-5 pl-15">
                                                <ul>
                                                    <li class="font-16 text-white font-weight-600 border-bottom">{{ $record->get('created')['j'] }}</li>
                                                    <li class="font-12 text-white text-uppercase">{{ $record->get('created')['m'] }}</li>
                                                </ul>
                                            </div>
                                            <div class="media-body pl-15">
                                                <div class="event-content pull-left flip">
                                                    <h4 class="entry-title text-white text-uppercase m-0 mt-5"><a href="{{ route('frontend.company.content.record', [$record->get('category_id'), $record->get('id')]) }}">{{ $record->get('h1') }}</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="mt-10">{{ $record->get('description') }}</p>
                                        <a class="btn btn-theme-colored2 btn-sm text-white" href="{{ route('frontend.company.content.record', [$record->get('category_id'), $record->get('id')]) }}"> Подробнее</a>
                                        <div class="clearfix"></div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection