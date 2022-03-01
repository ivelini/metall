@extends('admin_panel.layouts.main.main')
@section('title')
    Все разделители
@endsection
@section('pageheader-title')
    Все разделители
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">

                        <div class="text-right">
                            @if($dividers->count() < 2)
                                <a href="{{ route('content.sheet.main.divider.create') }}" type="button" class="btn btn-primary">Добавить разделитель</a>
                            @endif
                        </div>

                </div>
            </div>
            @include('admin_panel.layouts.main.alerts')
                <table class="table datatable-column-search-inputs">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($dividers as $divider)
                        <tr>
                            <td><a href="{{ route('content.sheet.main.divider.edit', $divider->get('id')) }}">{{ $divider->get('h1') }}</a></td>
                            <td>{{ $divider->get('description') }}</td>
                            <td>
                                <form action="{{ route('content.sheet.main.divider.destroy', $divider->get('id')) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <div class="text-right">
                                        <button type="submit" class="btn"> <i class="icon-bin"></i></button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
@section('include-footer')
    <script>

        var DatatableAPI = function() {

            // Basic Datatable examples
            var _componentDatatableAPI = function() {
                if (!$().DataTable) {
                    console.warn('Warning - datatables.min.js is not loaded.');
                    return;
                }

                // Setting datatable defaults
                $.extend( $.fn.dataTable.defaults, {
                    autoWidth: false,
                    columnDefs: [{
                        orderable: false,
                        width: 100
                    }],
                    order: [[2, 'desc']],
                    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
                    language: {
                        search: '<span>Фильтр:</span> _INPUT_',
                        searchPlaceholder: 'Поиск ...',
                        lengthMenu: '<span>Число строк:</span> _MENU_',
                        paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
                    }
                });

                // Apply custom style to select
                $.extend( $.fn.dataTableExt.oStdClasses, {
                    "sLengthSelect": "custom-select"
                });

                // Individual column searching with text inputs
                $('.datatable-column-search-inputs tfoot td').each(function () {
                    var title = $('.datatable-column-search-inputs thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" class="form-control input-sm" />');
                });
                var table = $('.datatable-column-search-inputs').DataTable();
                table.columns().every( function () {
                    var that = this;
                    $('input', this.footer()).on('keyup change', function () {
                        that.search(this.value).draw();
                    });
                });
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentDatatableAPI();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            DatatableAPI.init();
        });

    </script>
@endsection