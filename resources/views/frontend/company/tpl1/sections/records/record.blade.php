@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="blog-posts single-post">
                        <article class="post clearfix mb-0">
                            <div class="entry-header">
                                <div class="post-thumb thumb">
                                    <img src="{{ $content->get('img') }}" alt=""
                                         class="img-responsive img-fullwidth">
                                </div>
                            </div>
                            <div class="entry-title pt-10 pl-15">
                                <h4>{{ $content->get('h1') }}</h4>
                            </div>
                            <div class="entry-content mt-10">
                                {!! $content->get('content') !!}
                            </div>
                            <div class="entry-meta pl-15">
                                <ul class="list-inline">
                                    <li>Дата публикации: <span class="text-theme-colored2"> {{ $content->get('created') }}</span></li>
                                </ul>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection