@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @include('frontend.company.tpl1.sections.include.inner-banner')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="sidebar sidebar-left mt-sm-30">
                        @include('frontend.company.tpl1.sections.include.left-sidebar')
                    </div>
                </div>
                <div class="col-md-9 blog-pull-right">
                    <div class="blog-posts single-post">
                        <article class="post clearfix mb-0">
                            <div class="entry-title pt-10 pl-15">
                                <h4>{{ $content->get('h1') }}</h4>
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="{{ $content->get('img') }}" alt="">
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-icon theme-colored square">
                                            @if (!empty($infoFilteredProduct))
                                                @foreach($infoFilteredProduct as $key=>$value)
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-sm-12 col-md-7"><i class="fa fa-arrow-circle-right"></i>{{$key}}</div>
                                                            <div class="col-sm-12 col-md-5">{{$value}}</div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @elseif(empty($infoFilteredProduct))
                                                        <li>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <i class="fa fa-arrow-circle-right"></i>В наличии на складе в Челябинске
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <i class="fa fa-arrow-circle-right"></i>Отгрузим в срок от 1 дня
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <i class="fa fa-arrow-circle-right"></i>Рассчитаем заявку в течение 45 минут
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="row">
                                                                <div class="col-sm-12 col-md-12">
                                                                    <i class="fa fa-arrow-circle-right"></i>Актуальные цены уточняйте у менеджера по телефону
                                                                    8 (351) 239-55-99 или отправьте заявку
                                                                </div>
                                                            </div>
                                                        </li>
                                            @endif
                                        </ul>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12" style="text-align: center">
                                                <a href="#" class="btn btn-border btn-theme-colored btn-xl">Зделать заказ</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @if($is_filterForGostOnly == true)
                                @include('frontend.company.tpl1.sections.catalog.category.include.table.gost')
                            @else
                                @if($is_endLevel == false)
                                    @include('frontend.company.tpl1.sections.catalog.category.include.table.all')
                                @else
                                    @include('frontend.company.tpl1.sections.catalog.category.include.table.end-level')
                                @endif
                            @endif
                            @if(!empty($content->get('content')))
                                <div class="entry-content mt-10">
                                   {!! $content->get('content') !!}
                                </div>
                            @endif
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection