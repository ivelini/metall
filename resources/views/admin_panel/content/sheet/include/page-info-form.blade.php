                <fieldset class="mb-3">

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input name="h1"
                                   class="form-control"
                                   placeholder="Название записи"
                                   value="{{ old('h1', $page->get('h1')) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                                        <textarea name="content"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control"
                                                  id="summernote">{{ old('content', $page->get('content')) }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="card-img-actions m-1">
                                <img class="card-img img-fluid" src="{{ $page->get('img') }}" alt="">
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
                    <legend class="text-uppercase font-size-sm font-weight-bold border-bottom">SEO</legend>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input name="title"
                                   class="form-control"
                                   placeholder="Title"
                                   value="{{ old('title', $page->get('title')) }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input name="slug"
                                   class="form-control"
                                   placeholder="Ярлык"
                                   value="{{ old('slug', $page->get('slug')) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                                        <textarea name="description"
                                                  placeholder="Описание"
                                                  rows="5"
                                                  cols="3"
                                                  class="form-control">{{ old('description', $page->get('description')) }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-lg-12">
                            <input name="keywords"
                                   class="form-control"
                                   placeholder="keywords"
                                   value="{{ old('keywords', $page->get('keywords')) }}">
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