@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-hover-effect effect-barlin">
                                <div class="effect-wrapper">
                                    <div class="thumb">
                                        <img class="img-fullwidth" src="{{ $content->get('img') }}" alt="project">
                                    </div>
                                    <div class="overlay-shade bg-theme-colored-transparent-9"></div>
                                    <div class="text-holder text-holder-middle text-center">
                                        <div class="text_holder_inner">
                                            <div class="text_holder_inner2">
                                                <h2 class="title1 text-white mb-0">{{ $content->get('h1') }}</h2>
                                                <h5 class="title2 text-white mt-5">Дата отгрузки: {{ $content->get('date') }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="entry-content mt-10">
                                <div class="fulltext">
                                    {!! $content->get('content') !!}
                                </div>
                                @if($content->get('products')->count() > 0)
                                    <div class="separator">
                                        <span>Состав отгрузки</span>
                                    </div>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <td width="70%">Продукция</td>
                                            <td width="30%">ГОСТ/ТУ</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($content->get('products') as $product)
                                                <tr>
                                                    <td>{{ $product['name'] }}</td>
                                                    <td>{{ $product['gost'] }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                                @if($content->get('gallery')->count() > 0)
                                    <div class="separator">
                                        <span>Галерея</span>
                                    </div>
                                    <div class="popup-gallery">
                                        @foreach($content->get('gallery') as $img)
                                            <a href="{{ $img->get('img_original') }}"><img src="{{ $img->get('img') }}" style="margin-bottom: 3px; width: 245px;"></a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection