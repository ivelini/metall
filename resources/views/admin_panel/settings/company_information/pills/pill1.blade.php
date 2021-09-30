<div class="card">
    <div class="card-header">
        <h6 class="card-title">Осноная информация</h6>
    </div>

    <div class="card-body">
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <label>Полное наименование</label>
                        <input
                                name="full_name"
                                type="text"
                                class="form-control"
                                required
                                value="{{ old('full_name', $page->full_name) }}">
                    </div>
                    <div class="col-lg-6">
                        <label>Сокращенное наименование</label>
                        <input
                                name="slim_name"
                                type="text"
                                class="form-control"
                                required
                                value="{{ old('slim_name', $page->slim_name) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        <label>Индекс</label>
                        <input name="index"
                               type="text"
                               class="form-control"
                               required
                               value="{{ old('index', $page->index) }}">
                    </div>
                    <div class="col-lg-4">
                        <label>Область</label>
                        <input name="oreal"
                               type="text"
                               class="form-control"
                               value="{{ old('oreal', $page->oreal) }}">
                    </div>
                    <div class="col-lg-4">
                        <label>Город</label>
                        <input name="sity"
                               type="text"
                               class="form-control"
                               required
                               value="{{ old('sity', $page->sity) }}">
                    </div>
                </div>
            </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label>Адрес</label>
                    <input name="address"
                           type="text"
                           class="form-control"
                           required
                           value="{{ old('address', $page->address) }}">
                </div>
            </div>
        </div>



            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <label>Телефон</label>
                        <input name="phone"
                               type="text"
                               class="form-control"
                               required
                               value="{{ old('phone', $page->phone) }}">
                    </div>
                    <div class="col-lg-6">
                        <label>Email</label>
                        <input name="email"
                               type="text"
                               class="form-control"
                               readonly
                               value="{{ old('email', $page->email) }}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4">
                        <label>Логотип</label>
                        <div class="custom-file">
                            <input name="img"
                                   type="file"
                                   class="form-control">
                            <a href="">
                                Логотип
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Реквизиты</label>
                        <div class="custom-file">
                            <input name="requisites"
                                   type="file"
                                   class="form-control">
                            <a href="">
                                Реквизиты
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <label>Прайс продукции</label>
                        <div class="custom-file">
                            <input name="price"
                                   type="file"
                                   class="form-control">
                            <a href="">
                                Прайс
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <div class="form-group">
            <div class="row">
                <div class="col-lg-12">
                    <label>Код Google/Yandex карты</label>
                        <input name="map"
                               type="text"
                               class="form-control"
                               value="{{ old('map', $page->map) }}">
                </div>
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