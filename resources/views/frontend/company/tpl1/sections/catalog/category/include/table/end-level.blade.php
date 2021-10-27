<table class="table">
    <thead>
    <tr>
        <td>Название</td>
        <td>Размер</td>
        <td>Сталь</td>
        <td>Стандарт</td>
        <td>Заказать</td>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
                <tr>
                    <td>{{ $product->get('name2') }}</td>
                    <td>{{ $product->get('razmer') }}</td>
                    <td>{{ $product->get('steel') }}</td>
                    <td>{{ $product->get('gost') }}</td>
                    <td><a href="#">Заказать</a> </td>
                </tr>
    @endforeach
    </tbody>
</table>