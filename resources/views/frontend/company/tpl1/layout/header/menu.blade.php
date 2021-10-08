<nav id="menuzord" class="menuzord red">
    <ul class="menuzord-menu">
        <li class="home"><a href="/"><i class="fa fa-home font-28"></i></a></li>
        @if($header_menu)
            @foreach($header_menu as $menu)
                <li class="{{ $menu['class'] }}"><a href="{{ $menu['link'] }}" title="">{{ $menu['label'] }}</a>
                    @if( $menu['child'] )
                        <ul class="dropdown">
                            @foreach( $menu['child'] as $child )
                                <li class="{{ $child['class'] }}"><a href="{{ $child['link'] }}" title="">{{ $child['label'] }}</a></li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        @endif
        <li class="active pull-right"><a href="tel:+{{ $headerValues->get('sitePhone') }}" class="font-20 line-height-1"><i class="pe-7s-call mr-10 font-28"></i>
                {{ $headerValues->get('sitePhone') }}</a></li>
    </ul>
</nav>
