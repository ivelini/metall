@if($categoriesSidebar->count() > 0)
    <div class="widget">
        <div class="categories">
            <ul class="list list-border angle-double-right">
                @foreach($categoriesSidebar as $category)
                    <li><a href="{{ route('frontend.company.catalog.category.parent', $category->get('slug')) }}">{{ $category->get('category_name') }}</a></li>
                    @if($category->get('children')->count() > 0)
                        <ul class="list list-border angle-double-right">
                            @foreach($category->get('children') as $child)
                                <li><a href="{{ route('frontend.company.catalog.product.category', [$category->get('slug'), $child->get('slug')]) }}">{{ $child->get('category_name') }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
@endif
{{--1-2--}}