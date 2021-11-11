@extends('admin_panel.layouts.main.main')
@section('title')
    Главная страница
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Главная страница
@endsection
@section('header-js')

@endsection
@section('content-area')
    <form action="{{ route('content.sheet.main.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="card">
            <div class="card-body">
                <fieldset class="mb-3">
                    <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">SEO</legend>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Title</label>
                        <div class="col-lg-10">
                            <input name="title"
                                   type="text"
                                   class="form-control"
                                   value="{{ old('title', $mainPage->get('title')) }}">
                    </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">h1</label>
                        <div class="col-lg-10">
                            <input name="h1"
                                   type="text"
                                   class="form-control"
                                   value="{{ old('h1', $mainPage->get('h1')) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">Description</label>
                        <div class="col-lg-10">
                            <input name="description"
                                   type="text"
                                   class="form-control"
                                   value="{{ old('description', $mainPage->get('description')) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-2">keywords</label>
                        <div class="col-lg-10">
                            <input name="keywords"
                                   type="text"
                                   class="form-control"
                                   value="{{ old('keywords', $mainPage->get('keywords')) }}">
                        </div>
                    </div>
                </fieldset>
                    <fieldset class="mb-3">
                        <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Параметры полей</legend>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Наша команда</label>
                            <div class="col-lg-10">
                                    @if ($workerCategories->count() > 0)
                                        <select class="form-control" name="worker_category_id">
                                            @foreach($workerCategories as $workerCategory)
                                                <option value="{{ $workerCategory->get('id') }}"
                                                    @if ($workerCategory->get('id') == $mainPage->get('worker_category_id'))
                                                        selected
                                                    @endif
                                                >{{ $workerCategory->get('h1') }}</option>
                                            @endforeach
                                        </select>
                                    @else
                                    <label class="col-form-label col-lg-12">
                                       <a href="{{ route('content.sheet.worker.index') }}">Добавить сотрудников</a></label>
                                    @endif
                            </div>
                        </div>
                    </fieldset>
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Обновить <i class="icon-paperplane ml-2"></i></button>
                    </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')

@endsection