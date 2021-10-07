@extends('admin_panel.layouts.main.main')
@section('title')
    Общие настройки
@endsection
@section('pageheader-title')
    <a href=""><i class="icon-arrow-left52 mr-2"></i></a>Общие настройки
@endsection
@section('header-js')

@endsection
@section('content-area')
    <form action="{{ route('settings.companyInformation.generalUpdate') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Общие настройки</h6>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Название сайта</label>
                            <input
                                    name="site_name"
                                    type="text"
                                    class="form-control"
                                    required
                                    value="{{ old('site_name', $page->site_name) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Краткое описание</label>
                            <input
                                    name="site_description"
                                    type="text"
                                    class="form-control"
                                    required
                                    value="{{ old('site_description', $page->site_description) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Адрес сайта (URL)</label>
                            <input
                                    name="domain"
                                    type="text"
                                    class="form-control"
                                    required
                                    value="{{ old('domain', $page->domain) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Email для получения сообщений</label>
                            <input
                                    name="site_email"
                                    type="text"
                                    class="form-control"
                                    required
                                    value="{{ old('site_email', $page->site_email) }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Телефон</label>
                            <input
                                    name="site_phone"
                                    type="text"
                                    class="form-control"
                                    required
                                    value="{{ old('site_phone', $page->site_phone) }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6 text-right">
                            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-floppy-disk ml-2"></i></button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>


@endsection
@section('include-footer')

@endsection