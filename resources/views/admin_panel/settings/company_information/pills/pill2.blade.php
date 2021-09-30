<div class="card">
    <div class="card-header">
        <h6 class="card-title">Склады</h6>
    </div>

    <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <a href="#" id="add">Добавить</a> | <a href="#" id="remove">Удалить</a>
                    @if(!empty($storages))
                        <div class="inputs" id="data_inputs">
                            @php $i = 1 @endphp
                            @foreach($storages as $storage)
                                <div class="field form-group row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <input class="form-control"
                                                       type="text"
                                                       name="storages_json[{{ $i }}][address]"
                                                       value="{{ $storage['address'] }}">
                                            </div>
                                            <div class="col-2">
                                                <input class="form-control"
                                                       type="text"
                                                       name="storages_json[{{ $i }}][worktime]"
                                                       value="{{ $storage['worktime'] }}">
                                            </div>
                                            <div class="col-4">
                                                <input class="form-control"
                                                       type="text"
                                                       name="storages_json[{{ $i }}][phones]"
                                                       value="{{ $storage['phones'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $i++ @endphp
                            @endforeach
                        </div>
                    @elseif(!empty($products) == false)
                        <div class="inputs" id="data_inputs"></div>
                    @endif
                </div>

            </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-floppy-disk ml-2"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>