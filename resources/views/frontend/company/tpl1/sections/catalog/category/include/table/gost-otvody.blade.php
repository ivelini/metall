<table class="table">
    <thead>
    <tr>
        <td>DU</td>
        <td>Угол гиба</td>
        <td>Размер</td>
        <td>Сталь</td>
        <td>Стандарт</td>
        <td>Заказать</td>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $du)
        @foreach($du as $ugolGiba)
            @foreach($ugolGiba as $product)
                <tr>
                    <td style="vertical-align : middle;text-align:center;"><a href="{{ route('frontend.company.catalog.category.standard.du', $product->get('filter')) }}">Отводы {{ $product->get('du') }}</a></td>
                    <td style="vertical-align : middle;text-align:center;">{{ $product->get('ugol_giba') }}</td>
                    <td>{{ $product->get('du') }}х{{ $product->get('h') }}</td>
                    <td>{{ $product->get('steel') }}</td>
                    <td>{{ $product->get('gost') }}</td>
                    <td><a href="#">Заказать</a> </td>
                </tr>
            @endforeach
        @endforeach
    @endforeach
    </tbody>
</table>