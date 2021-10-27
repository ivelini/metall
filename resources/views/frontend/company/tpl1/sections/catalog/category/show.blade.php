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
                            <div class="entry-header">
                                <div class="post-thumb thumb"> <img src="{{ $content->get('img') }}" alt="" class="img-responsive img-fullwidth"> </div>
                            </div>
                            <div class="entry-title pt-10 pl-15">
                                <h4>{{ $content->get('h1') }}</h4>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-icon theme-colored square">
                                        <li><i class="fa fa-clock-o"></i>Lorem ipsum dolor sit elit</li>
                                        <li><i class="fa fa-hand-o-right"></i>Lorem ipsum dolor sit elit</li>
                                        <li><i class="fa fa-thumbs-o-up"></i>Lorem ipsum dolor sit elit</li>
                                        <li><i class="fa fa-arrow-right"></i>Lorem ipsum dolor sit elit
                                            <ul>
                                                <li><i class="fa fa-clock-o"></i>Lorem ipsum dolor sit elit</li>
                                                <li><i class="fa fa-hand-o-right"></i>Lorem ipsum dolor sit elit</li>
                                                <li><i class="fa fa-thumbs-o-up"></i>Lorem ipsum dolor sit elit
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i>Lorem ipsum dolor sit elit</li>
                                                        <li><i class="fa fa-hand-o-right"></i>Lorem ipsum dolor sit elit</li>
                                                    </ul>
                                                </li>
                                                <li><i class="fa fa-arrow-right"></i>Lorem ipsum dolor sit elit</li>
                                            </ul>
                                        </li>
                                        <li><i class="fa fa-pencil-square-o"></i>Lorem ipsum dolor sit elit</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-icon theme-colored square">
                                        <li><i class="fa fa-clock-o"></i>Lorem ipsum dolor sit elit</li>
                                        <li><i class="fa fa-hand-o-right"></i>Lorem ipsum dolor sit elit</li>
                                        <li><i class="fa fa-thumbs-o-up"></i>Lorem ipsum dolor sit elit</li>
                                        <li><i class="fa fa-arrow-right"></i>Lorem ipsum dolor sit elit
                                            <ul>
                                                <li><i class="fa fa-clock-o"></i>Lorem ipsum dolor sit elit</li>
                                                <li><i class="fa fa-hand-o-right"></i>Lorem ipsum dolor sit elit</li>
                                                <li><i class="fa fa-thumbs-o-up"></i>Lorem ipsum dolor sit elit
                                                    <ul>
                                                        <li><i class="fa fa-clock-o"></i>Lorem ipsum dolor sit elit</li>
                                                        <li><i class="fa fa-hand-o-right"></i>Lorem ipsum dolor sit elit</li>
                                                    </ul>
                                                </li>
                                                <li><i class="fa fa-arrow-right"></i>Lorem ipsum dolor sit elit</li>
                                            </ul>
                                        </li>
                                        <li><i class="fa fa-pencil-square-o"></i>Lorem ipsum dolor sit elit</li>
                                    </ul>
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