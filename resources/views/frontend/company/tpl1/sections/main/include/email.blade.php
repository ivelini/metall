<section>
    <div class="container">
        <div class="section-title text-center">
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <h3 class="text-uppercase line-bottom-double-line-centered mt-0">Отправьте заявку <span class="text-theme-colored2">и узнайте актуальные цены</span> на продукцию</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="tab-content bg-silver-light">
                    <div class="tab-pane fade p-15 active in" id="login-tab">
                        <form action="{{ route('frontend.company.action.send.request') }}" class="clearfix" method="POST" enctype="multipart/form-data">
                            @method('PUTCH')
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="form_username_email">Имя</label>
                                    <input name="send_name" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="form_password">Телефон</label>
                                    <input name="send_phone" class="form-control" type="text">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="form_password">Email</label>
                                    <input name="send_email" class="form-control" type="email">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="form_password">Комментарий</label>
                                    <textarea name="send_desc" class="form-control" type="text"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="form_username_email">Заявка / Реквизиты</label>
                                    <input name="send_file" class="form-control" type="file">
                                </div>
                            </div>
                            <div class="form-group pull-right mt-10">
                                <button type="submit" class="btn btn-dark btn-sm">Отправить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>