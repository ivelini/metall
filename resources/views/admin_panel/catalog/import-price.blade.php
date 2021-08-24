@extends('admin_panel.layouts.main.main')
@section('title')
    Импорт прайс листа
@endsection
@section('pageheader-title')
    Импорт прайс листа
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <form method="post" action="{{ route('catalog.price.upload') }}" enctype="multipart/form-data">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                    </div>
                @endif
                @if (session('success'))
                    <div class="alert alert-info">
                        {{ session()->get('success') }}
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
            <p class="mb-3">
                <div>['Отводы']   =   ['du*', 'h*', 'steel*', 'standard*', 'ugol_giba', 'ed_izm', 'price']</div>
                <div>['Переходы'] =   ['du1*', 'h1*', 'du2*', 'h2*', 'model','steel*', 'standard*', 'ed_izm', 'price']</div>
                <div>['Тройники'] =   ['du1*', 'h1*', 'du2*', 'h2*', 'steel*', 'standard*', 'ed_izm', 'price']</div>
                <div>['Фланцы']   =   ['du', 'davlenie*', 'steel*', 'standard*', 'price']</div>
                <div>['Днища']    =   ['du*', 'h*', 'steel*', 'standard*', 'price']</div>
            </p>
        </div>
@endsection