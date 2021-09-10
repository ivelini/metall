@extends('admin_panel.layouts.main.main')
@section('title')
    Редактирование запись
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Редактирование сотрудника
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">

@endsection
@section('content-area')
    <form action="{{ route('content.sheet.worker.update', $worker->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        @include('admin_panel.layouts.main.alerts')
                            <fieldset class="mb-3">
                                <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Сотрудник</legend>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="name"
                                               class="form-control"
                                               placeholder="ФИО"
                                               value="{{ old('name', $worker->name) }}"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="position"
                                               class="form-control"
                                               placeholder="Должность"
                                               value="{{ old('position', $worker->position) }}"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="phone"
                                               class="form-control"
                                               placeholder="Телефон"
                                               value="{{ old('phone', $worker->phone) }}"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="email"
                                               class="form-control"
                                               placeholder="Почта"
                                               value="{{ old('email', $worker->email) }}"
                                               required>
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
                                <img class="card-img img-fluid" src="@if(empty($worker->img))
                                                                            /admin_panel/global_assets/images/placeholders/placeholder.jpg
                                                                        @else
                                                                            {{ $worker->img}}
                                                                        @endif" alt="">
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
                                            <option value="{{ $category->id }}"
                                                    @if($category->id == $worker->category_id)
                                                    selected="selected"
                                                    @endif
                                            >{{ $category->h1 }}</option>
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
                            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-floppy-disk ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{ route('content.sheet.worker.destroy', $worker->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-right">
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')
            <script>
                $(document).ready(function() {
                    $('#summernote').summernote();
                });
            </script>

@endsection