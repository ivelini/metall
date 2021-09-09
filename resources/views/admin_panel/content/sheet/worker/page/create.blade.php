@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить запись
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить сотрудника
@endsection
@section('header-js')

@endsection
@section('content-area')
    <form action="{{ route('content.sheet.worker.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        @include('admin_panel.layouts.main.alerts')
                            <fieldset class="mb-3">
                                <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Сотрудник</legend>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="name" class="form-control" placeholder="ФИО" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="position" class="form-control" placeholder="Должность" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="phone" class="form-control" placeholder="Телефон" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="email" class="form-control" placeholder="Почта" required>
                                    </div>
                                </div>
                            </fieldset>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Фото</legend>

                            <div class="card-img-actions m-1">
                                <img class="card-img img-fluid" src="/admin_panel/global_assets/images/placeholders/placeholder.jpg" alt="">
                                <div class="card-img-actions-overlay card-img">
                                    <input name="img" type="file" class="form-control-plaintext" style="width: 65px">
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <fieldset class="mb-3">
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Подразделение</legend>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <select name="content_sheet_worker_category_id" class="form-control">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Добавить <i class="icon-floppy-disk ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')

@endsection