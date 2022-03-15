<section class="bg-silver-light">
    <div class="container">
        <div class="section-content text-center">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-uppercase line-bottom-double-line-centered text-theme-colored mt-0">Каталог продукции</h2>
                </div>
            </div>
            <div class="row mt-40">
                @foreach($catalog as $category)
                    <div class="col-sm-6 col-md-4 maxwidth500 mb-sm-40">
                        <a href="{{ route('frontend.company.catalog.category.parent', $category->get('slug')) }}">
                            <div class="project">
                                <div class="thumb">
                                    <img class="img-fullwidth" src="{{ $category->get('img') }}" alt="">
                                    <div class="hover-link">
                                        <i class="fa pe-7s-folder"></i>
                                    </div>
                                </div>
                                <h3 class="text-theme-colored">{{ $category->get('category_name') }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>