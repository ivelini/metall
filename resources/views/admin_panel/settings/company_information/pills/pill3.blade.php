<div class="card">
    <div class="card-header">
        <h6 class="card-title">Филиалы</h6>
    </div>

    <div class="card-body">
            <div class="form-group row">
                <div class="col-lg-12">
                    <a href="#" id="add_agency">Добавить</a> | <a href="#" id="remove_agency">Удалить</a>
                    @if(!empty($agencys))
                        <div class="inputs_agency" id="data_inputs_agency">
                            @php $i = 1 @endphp
                            @foreach($agencys as $agency)
                                <div class="field_agency form-group row">
                                    <div class="col-12">
                                        <div class="form-group row">
                                            <div class="col-6">
                                                <input class="form-control"
                                                       type="text"
                                                       name="agency_json[{{ $i }}][address]"
                                                       value="{{ $agency['address'] }}">
                                            </div>
                                            <div class="col-2">
                                                <input class="form-control"
                                                       type="text"
                                                       name="agency_json[{{ $i }}][worktime]"
                                                       value="{{ $agency['worktime'] }}">
                                            </div>
                                            <div class="col-4">
                                                <input class="form-control"
                                                       type="text"
                                                       name="agency_json[{{ $i }}][phones]"
                                                       value="{{ $agency['phones'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php $i++ @endphp
                            @endforeach
                        </div>
                    @elseif(!empty($products) == false)
                        <div class="inputs_agency" id="data_inputs_agency"></div>
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