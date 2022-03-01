@extends('admin_panel.layouts.main.main')
@section('title')
    Разделитель
@endsection
@section('pageheader-title')
    Редактирование разделителя
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">
@endsection
@section('content-area')
    <div class="row">
        <div class="col-lg-12">
            <div class="card-group-control card-group-control-right">
                <div class="card">
                    <div class="card-body">
                        <form action=" {{ route('content.sheet.main.divider.update', $divider->get('id')) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <fieldset class="mb-3">

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="h1"
                                               class="form-control"
                                               placeholder="Заголовок разделителя"
                                               value="{{ old('h1', $divider->get('h1')) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input name="description"
                                               placeholder="Описание разделителя"
                                               class="form-control"
                                               value="{{ old('description', $divider->get('description')) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <div class="card-img-actions m-1">
                                            <img class="card-img img-fluid" src="{{ $divider->get('img') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input type="file"
                                               name="img">
                                    </div>
                                </div>

                            </fieldset>
                            <fieldset>
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-primary">Соханить <i class="icon-floppy-disk ml-2"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('include-footer')

@endsection