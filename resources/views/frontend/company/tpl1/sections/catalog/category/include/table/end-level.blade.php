<table class="table">
    <thead>
    <tr>
        <td>Название</td>
        @if (gettype(strripos($products->first()->get('name'), 'Фланец')) == 'integer')
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
    @foreach($products as $product)
                <tr>
                    <td>{{ $product->get('name2') }}</td>
                    @if (gettype(strripos($products->first()->get('name'), 'Фланец')) == 'integer')
                        <td>{{ $product->get('davlenie') }}</td>
                    @elseif(true)
                        <td>{{ $product->get('razmer') }}</td>
                    @endif
                    <td>{{ $product->get('steel') }}</td>
                    <td>{{ $product->get('gost') }}</td>
                    <td><a href="#">Заказать</a> </td>
                </tr>
    @endforeach
    </tbody>
</table>