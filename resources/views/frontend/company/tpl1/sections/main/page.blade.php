@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @if($slider->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.header-slider')
    @endif
    @if($catalog->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.catalog')
    @endif
    @if($certificates->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.certificates')
    @endif
    @if($shipments->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.shipments')
    @endif
    @include('frontend.company.tpl1.sections.main.include.managers')
@endsection