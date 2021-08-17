<table class="table datatable-column-search-inputs">
    <thead>
    <tr>
        <th>Размер</th>
        <th>Стенка</th>
        <th>Угол гиба</th>
        <th>Сталь</th>
        <th>Стандарт</th>
        <th>Ед. изм.</th>
        <th>Стоимость</th>
    </tr>
    </thead>
    <tbody>
    @foreach($listProducts as $product)
        <tr>
            <td><span data-popup="popover" data-placement="top" data-content="{{ $product->fullName }}"><i class="icon-play3 ml-2"></i>
                    <span style="display: none">{{ $product->fullName }}</span></span> {{ $product->du }}</td>
            <td>{{ $product->h }}</td>
            <td>{{ $product->ugol_giba }}</td>
            <td>{{ $product->steel }}</td>
            <td>{{ $product->standard }}</td>
            <td>{{ $product->ed_izm }}</td>
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
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>