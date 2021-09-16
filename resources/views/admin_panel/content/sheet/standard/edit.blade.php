@extends('admin_panel.layouts.main.main')
@section('title')
    Изменить стандарт
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Изменить стандарт
@endsection
@section('header-js')

@endsection
@section('content-area')
    <form action="{{ route('content.sheet.standard.update', $standard->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
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
                                               value="{{ old('h1', $standard->h1) }}"
                                                required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="description"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control"
                                                  required>{{ old('description', $standard->description) }}</textarea>
                                    </div>
                                </div>
                                    <div class="form-group row">
                                        <div class="col-lg-10">
                                            <a href="{{ $standard->file }}" target="_blank">Ссылка на файл</a>
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    <div class="col-lg-10">
                                        <input name="file"
                                                type="file"
                                               class="form-control-plaintext">
                                    </div>
                                </div>
                            </fieldset>
                        <div class="text-right">
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