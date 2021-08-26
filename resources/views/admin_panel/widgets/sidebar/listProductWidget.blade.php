@foreach($productsName as $prouct)
        @switch($prouct)
                @case('otvody')
                        <li class="nav-item"><a href="{{ route('catalog.product.otvody.index') }}" class="nav-link">
                                <i class="icon-database-insert"></i> Отводы</a>
                        </li>
                        @break
                @case('perehody')
                        <li class="nav-item"><a href="{{ route('catalog.product.perehody.index') }}" class="nav-link">
                                <i class="icon-database-insert"></i> Переходы</a>
                        </li>
                        @break
                @case('troiniki')
                        <li class="nav-item"><a href="{{ route('catalog.product.troiniki.index') }}" class="nav-link">
                                <i class="icon-database-insert"></i> Тройники</a>
                        </li>
                        @break
                @case('dnisha')
                        <li class="nav-item"><a href="{{ route('catalog.product.dnisha.index') }}" class="nav-link">
                                <i class="icon-database-insert"></i> Днища</a>
                        </li>
                        @break
                @case('NULL')
                        <li class="nav-item"><a href="{{ route('catalog.price.create') }}" class="nav-link">
                                        <i class="icon-database-insert"></i> Загрузите прайс</a>
                        </li>
                        @break
                @default

                        @break
        @endswitch
@endforeach