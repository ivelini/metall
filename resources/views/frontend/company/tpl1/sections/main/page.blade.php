@extends('frontend.company.tpl1.layout.index')

@section('main-content')
    @if(!empty($slider) && $slider->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.header-slider')
    @endif
    @if($services->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.service')
    @endif
    @if($dividers->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.divider0')
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
    @if(!empty($workers) && $workers->count() > 0)
        @include('frontend.company.tpl1.sections.main.include.managers')
    @endif
    @if(!empty($dividers->get(1)))
        @include('frontend.company.tpl1.sections.main.include.divider1')
    @endif
    @include('frontend.company.tpl1.sections.main.include.email')
@endsection