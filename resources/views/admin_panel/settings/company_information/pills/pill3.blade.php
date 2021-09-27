<div class="card">
    <div class="card-header">
        <h6 class="card-title">Склады</h6>
    </div>

    <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <a href="#" id="add_filial">Добавить</a> | <a href="#" id="remove_filial">Удалить</a>
                    @if(!empty($products))
                        <div class="inputs" id="data_inputs_filial">
                            @php $i = 1 @endphp
                            @foreach($products as $product)
                                <div class="fieldfilial form-group row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-8">
                                                <input class="form-control"
                                                       type="text"
                                                       name="stoks_json[{{ $i }}][address]"
                                                       value="{{ $product['name'] }}">
                                            </div>
                                            <div class="col-4">
                                                <input class="form-control"
                                                       type="text"
                                                       name="stoks_json[{{ $i }}][worktime]"
                                                       value="{{ $product['gost'] }}">
                                            </div>
                                            <div class="col-4">
                                                <input class="form-control"
                                                       type="text"
                                                       name="stoks_json[{{ $i }}][phones]"
                                                       value="{{ $product['gost'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $i++ @endphp
                            @endforeach
                        </div>
                    @elseif(!empty($products) == false)
                        <div class="inputs_filial" id="data_inputs_filial"></div>
                    @endif
                </div>

            </div>

    </div>
</div>