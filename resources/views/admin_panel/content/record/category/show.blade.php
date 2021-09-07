@extends('admin_panel.layouts.main.main')
@section('title')
    Рубика "{{ $category->title }}"
@endsection
@section('pageheader-title')
    <a href="{{ Redirect::back()->getTargetUrl() }}"><i class="icon-arrow-left52 mr-2"></i></a>Рубика "{{ $category->h1 }}"
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


                            <a href="{{ route('content.records.record.create') }}" type="button" class="btn btn-primary">Добавить запись</a>
                        </div>

                </div>
            </div>
            @include('admin_panel.layouts.main.alerts')
                <table class="table datatable-column-search-inputs">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Категория</th>
                        <th>Дата публикации</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($records as $record)
                        <tr @if($record->is_published == 0) class="not-active" @endif>
                            <td><a href="{{ route('content.records.record.edit', $record->id) }}">{{ $record->h1 }}</a></td>
                            <td><a href="{{ route('content.records.category.show', $category->id) }}">{{ $category->h1 }}</a></td>
                            <td>{{ $record->created_at }}</td>
                            <td>
                                <form action="{{ route('content.records.record.destroy', $record->id) }}" method="POST">
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