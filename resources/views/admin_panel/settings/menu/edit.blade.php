
@extends('admin_panel.layouts.main.main')
@section('title')
    Настройка меню
@endsection
@section('pageheader-title')
    <a href=""><i class="icon-arrow-left52 mr-2"></i></a>Настройка меню
@endsection
@section('header-js')

@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    {!! Menu::render() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('include-footer')
    {!! Menu::scripts() !!}
@endsection