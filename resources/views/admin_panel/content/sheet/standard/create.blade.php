@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить стандарт
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить стандарт
@endsection
@section('header-js')

@endsection
@section('content-area')
    <form action="{{ route('content.sheet.standard.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        @include('admin_panel.layouts.main.alerts')
                            <fieldset class="mb-3">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="h1"
                                               class="form-control"
                                               placeholder="Название стандарта"
                                                required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="description"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control"
                                                  required>{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-10">
                                        <input name="file"
                                                type="file"
                                               class="form-control-plaintext"
                                               required>
                                    </div>
                                </div>
                            </fieldset>
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