<table class="table">
    <thead>
    <tr>
        <td>Название</td>
        @if (gettype(strripos($products->first()->first()->get('name'), 'Фланец')) == 'integer')
            <td>Даление</td>
        @elseif(true)
            <td>Размер</td>
        @endif
        <td>Сталь</td>
        <td>Стандарт</td>
        <td>Заказать</td>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $du)
            @foreach($du as $product)
                <tr>
                    @if ($loop->first)
                        <td rowspan="{{ $du->count() }}" style="vertical-align : middle;text-align:center;">
                            <a href="{{ route('frontend.company.catalog.category.standard.du', $product->get('filter')) }}">
                                {{ $product->get('name') }}
                            </a>
                        </td>
                    @endif
                    @if (gettype(strripos($products->first()->first()->get('name'), 'Фланец')) == 'integer')
                            <td>{{ $product->get('davlenie') }}</td>
                    @elseif(true)
                            <td>{{ $product->get('razmer') }}</td>
                    @endif
                    <td>{{ $product->get('steel') }}</td>
                    <td>{{ $product->get('gost') }}</td>
                    <td><a href="#">Заказать</a> </td>
                </tr>
            @endforeach
    @endforeach
    </tbody>
</table>