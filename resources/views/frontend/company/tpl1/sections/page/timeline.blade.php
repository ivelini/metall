@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section id="cd-timeline" class="cd-container mt-100 mb-100">
        @if($lines->count() > 0)
            @foreach($lines as $line)
                <div class="cd-timeline-block">
                    <div class="cd-timeline-img cd-picture">
                        <img src="/frontend/company/themes/tpl1/js/vertical-timeline/img/cd-icon-picture.svg" alt="Picture">
                    </div> <!-- cd-timeline-img -->

                    <div class="cd-timeline-content">
                        <article class="post clearfix">
                            <div class="entry-header">
                                <div class="post-thumb"> <img alt="" src="{{ $line->get('img') }}" class="img-fullwidth img-responsive"> </div>
                                <h5 class="entry-title">{{ $line->get('h1') }}</h5>
                            </div>
                            <div class="entry-content">
                                {!! $line->get('content')  !!}
                            </div>
                        </article>
                    </div> <!-- cd-timeline-content -->
                </div> <!-- cd-timeline-block -->
            @endforeach
        @endif
    </section>

@endsection