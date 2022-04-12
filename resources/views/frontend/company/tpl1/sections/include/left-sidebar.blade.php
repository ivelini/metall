@if($categoriesSidebar->count() > 0)
    <div class="widget">
        <div class="categories">
            <ul class="list list-border angle-double-right">
{{--                @foreach($categoriesSidebar as $category)--}}
{{--                    <li><a href="{{ route('frontend.company.catalog.category.parent', $category->get('slug')) }}">{{ $category->get('category_name') }}</a></li>--}}
{{--                    @if($category->get('children')->count() > 0)--}}
{{--                        <ul class="list list-border angle-double-right">--}}
{{--                            @foreach($category->get('children') as $child)--}}
{{--                                <li><a href="{{ route('frontend.company.catalog.product.category', [$category->get('slug'), $child->get('slug')]) }}">{{ $child->get('category_name') }}</a></li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    @endif--}}
{{--                @endforeach--}}
            </ul>
            <div class="panel-group toggle accordion-stylished-left-border accordion-icon-filled accordion-no-border accordion-icon-left">
                @foreach($categoriesSidebar as $category)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <a class="collapsed" data-toggle="collapse" href="#{{ $category->get('slug') }}" aria-expanded="false">
                                    <span class="open-sub"></span>{{ $category->get('category_name') }}
                                </a>
                            </div>
                        </div>
                        <div id="{{ $category->get('slug') }}" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                            <div class="panel-body">
                                @if($category->get('children')->count() > 0)
                                    <ul class="list list-border angle-double-right">
                                        @foreach($category->get('children') as $child)
                                            <li><a href="{{ route('frontend.company.catalog.product.category', [$category->get('slug'), $child->get('slug')]) }}">{{ $child->get('category_name') }}</a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif