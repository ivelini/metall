@extends('admin_panel.layouts.main.main')
@section('title')
    Карточка компании
@endsection
@section('pageheader-title')
    <a href=""><i class="icon-arrow-left52 mr-2"></i></a>Подразделения
@endsection
@section('header-js')
    <script>
        $(document).ready(function(){
            var i = $('#data_inputs .form-control').length;
            if (i == 0) {
                i = 1;
            }
            else {
                i = i / 2 + 1;
            }
            $('#add').click(function() {
                $('<div class="field form-group row"><div class="col-lg-12"><div class="form-group row"><div class="col-6"><input class="form-control" type="text" name="stocks_json[' + i + '][address]" value="" placeholder="Адрес"></div><div class="col-2"><input class="form-control" type="text" name="stocks_json[' + i + '][worktime]" value="" placeholder="Время работы"></div><div class="col-4"><input class="form-control" type="text" name="stocks_json[' + i + '][phones]" value="" placeholder="Телефоны"></div></div></div></div>').fadeIn('slow').appendTo('.inputs');
                i++;
            });

            $('#remove').click(function() {
                if(i > 1) {
                    $('.field:last').remove();
                    i--;
                }
            });

            var j = $('#data_inputs_filial .form-control').length;
            if (j == 0) {
                j = 1;
            }
            else {
                j = j / 2 + 1;
            }
            $('#add_filial').click(function() {
                $('<div class="field_filial form-group row"><div class="col-lg-12"><div class="form-group row"><div class="col-6"><input class="form-control" type="text" name="filial_json[' + j + '][address]" value="" placeholder="Адрес"></div><div class="col-2"><input class="form-control" type="text" name="filial_json[' + j + '][worktime]" value="" placeholder="Время работы"></div><div class="col-4"><input class="form-control" type="text" name="filial_json[' + j + '][phones]" value="" placeholder="Телефоны"></div></div></div></div>').fadeIn('slow').appendTo('.inputs_filial');
                j++;
            });

            $('#remove_filial').click(function() {
                if(j > 1) {
                    $('.field_filial:last').remove();
                    j--;
                }
            });
        });
    </script>

@endsection
@section('content-area')
<div class="card">
    <div class="card-body">
        <ul class="nav nav-pills">
            <li class="nav-item"><a href="#basic-pill1" class="nav-link active" data-toggle="tab">Осноная информация</a></li>
            <li class="nav-item"><a href="#basic-pill2" class="nav-link" data-toggle="tab">Склады</a></li>
            <li class="nav-item"><a href="#basic-pill3" class="nav-link" data-toggle="tab">Филиалы</a></li>
        </ul>
    </div>
</div>

    <form action="{{ route('settings.companyInformation.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="tab-content">
            <div class="tab-pane fade active show" id="basic-pill1">
                @include('admin_panel.settings.company_information.pills.pill1')
            </div>

            <div class="tab-pane fade" id="basic-pill2">
                @include('admin_panel.settings.company_information.pills.pill2')
            </div>
            <div class="tab-pane fade" id="basic-pill3">
                @include('admin_panel.settings.company_information.pills.pill3')
            </div>
        </div>
    </form>

@endsection
@section('include-footer')

@endsection