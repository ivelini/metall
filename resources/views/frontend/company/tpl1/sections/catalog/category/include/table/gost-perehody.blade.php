<table class="table">
    <thead>
    <tr>
        <td>DU1-DU2</td>
        <td>Толщина</td>
        <td>Сталь</td>
        <td>Стандарт</td>
        <td>Заказать</td>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $du1)
        @foreach($du1 as $du2)
           @foreach($du2 as $product)
                <tr>
                    <td>{{ $product->get('du1') }}-{{ $product->get('du2') }}</td>
                    <td>{{ $product->get('du1') }}х{{ $product->get('h1') }}-{{ $product->get('du2') }}х{{ $product->get('h2') }}</td>
                    <td>{{ $product->get('steel') }}</td>
                    <td>{{ $product->get('gost') }}</td>
                    <td><a href="#">Заказать</a> </td>
                </tr>
           @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>