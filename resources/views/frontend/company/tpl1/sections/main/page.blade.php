@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @if($slider->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.header-slider')
    @endif
    @if($services->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.service')
    @endif
    @include('frontend.company.tpl1.sections.main.include.divider0')
    @if($catalog->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.catalog')
    @endif
    @if($certificates->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.certificates')
    @endif
    @if($shipments->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.shipments')
    @endif
    @if($workers->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.managers')
    @endif
    @include('frontend.company.tpl1.sections.main.include.divider1')
    @include('frontend.company.tpl1.sections.main.include.email')
@endsection