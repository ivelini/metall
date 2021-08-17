@extends('admin_panel.layouts.main.main')
@section('title')
    Каталог продукции - Отводы
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>

@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            @if ($listProducts->count() > 0)
                @switch($productName)
                    @case('Отводы')
                        @include('admin_panel.catalog.product.table.otvody')
                        @break
                    @case('Переходы')
                        @include('admin_panel.catalog.product.table.perehody')
                        @break
                    @default

                    @break
                @endswitch
            @endif
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
                                width: 100,
                                targets: [ 5 ]
                            }],
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