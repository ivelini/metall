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

                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection