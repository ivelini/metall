<table class="table datatable-column-search-inputs">
    <thead>
    <tr>
        <th>Размер</th>
        <th>Стенка</th>
        <th>Сталь</th>
        <th>Стандарт</th>
        <th>Стоимость</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listProducts as $product)
        <tr>
            <td><span data-popup="popover" data-placement="top" data-content="{{ $product->fullName }}"><i class="icon-play3 ml-2"></i>
                    <span style="display: none">{{ $product->fullName }}</span></span> {{ $product->du }}</td>
            <td>{{ $product->h }}</td>
            <td>{{ $product->steel }}</td>
            <td>{{ $product->standard }}</td>
            <td>{{ $product->price }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>