@extends('admin_panel.layouts.main.main')
@section('title')
    Добавить сертификат
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Добавить сертификат
@endsection
@section('header-js')


@endsection
@section('content-area')
    <form action="{{ route('content.sheet.certificate.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        @include('admin_panel.layouts.main.alerts')
                            <fieldset class="mb-3">
                                <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Cертификат</legend>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="h1"
                                               class="form-control"
                                               placeholder="Название сертификата"
                                               value="{{ old('name', $certificate->h1) }}"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea name="description"
                                                  class="form-control"
                                                  placeholder="Описание сертификата">{{ old('content', $certificate->description) }}</textarea>
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
                            <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">Изображение</legend>

                            <div class="card-img-actions m-1">
                                <img class="card-img img-fluid" src="@if(empty($certificate->image->img))
                                                                        /admin_panel/global_assets/images/placeholders/placeholder.jpg
                                                                    @else
                                                                        {{ $certificate->image->img}}
                                                                    @endif" alt="">
                                <div class="card-img-actions-overlay card-img">
                                    <input name="img" type="file" class="form-control-plaintext" style="width: 65px">
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
                            <button type="submit" class="btn btn-primary">Обновить <i class="icon-floppy-disk ml-2"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')

@endsection