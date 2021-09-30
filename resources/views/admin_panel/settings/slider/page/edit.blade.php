@extends('admin_panel.layouts.main.main')
@section('title')
    Редактирование слайдера
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Редактирование слайдера
@endsection
@section('header-js')

@endsection
@section('content-area')
    <form action="{{ route('settings.slider.update', $page->id) }}" method="POST" enctype="multipart/form-data">
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
                                               placeholder="Название слайдера"
                                               value="{{ old('h1', $page->h1) }}"
                                                required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="description"
                                                  placeholder="Описание"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control">{{ old('description', $page->description) }}</textarea>
                                    </div>
                                </div>
                            </fieldset>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="custom-control custom-control-right custom-switch text-right mb-2">
                            <input type="checkbox" name="is_published" class="custom-control-input" id="sc_rs_c"
                                   @if ($page->is_published == 1) checked @endif>
                            <label class="custom-control-label" for="sc_rs_c">Опубликованна</label>
                        </div>
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