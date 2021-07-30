@extends('admin_panel.layouts.main.main')
@section('title')
    Импорт прайс листа
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('catalog.price.upload') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <fieldset class="mb-3">
                    <div class="form-group row">
                        <div class="col-lg-3">
                            <input name="price" type="file" class="form-control-plaintext">
                        </div>
                        <div class="col col-lg-9">
                            <div class="text-left">
                                <button type="submit" class="btn btn-primary">Загрузить прайс <i class="icon-attachment ml-2"></i></button>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
            <h6 class="font-weight-semibold">Инструция по загрузке прайса</h6>
            <p class="mb-3"></p>
        </div>
@endsection