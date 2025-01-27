@extends('admin_panel.layouts.main.main')
@section('title')
    Страница стандартов
@endsection
@section('pageheader-title')
    Страница стандартов
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.js"></script>
    <link href="/admin_panel/global_assets/js/plugins/editors/summernote/summernote.min.css" rel="stylesheet">
@endsection
@section('content-area')
    <div class="row">
        <div class="col-lg-12">
            <div class="card-group-control card-group-control-right">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">
                            <a class="text-body collapsed" data-toggle="collapse" href="#collapsible-control-right-group2" aria-expanded="false">Контент</a>
                        </h6>
                    </div>

                    <div id="collapsible-control-right-group2" class="collapse" style="">
                        <div class="card-body">
                            <form action="{{ route('content.sheet.info-update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input name="sheet_name"
                                       value="page_standards"
                                       hidden>
                                @include('admin_panel.content.sheet.include.page-info-form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">

                        <div class="text-right">
                            <a href="{{ route('content.sheet.standard.create') }}" type="button" class="btn btn-primary">Добавить стандарт</a>
                        </div>

                </div>
            </div>
            @include('admin_panel.layouts.main.alerts')
                <table class="table datatable-column-search-inputs">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Скачать</th>
                        <th>Удалить</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($standards as $standardt)
                        <tr>
                            <td><a href="{{ route('content.sheet.standard.edit', $standardt->id) }}">{{ $standardt->h1 }}</a></td>
                            <td>{{ $standardt->description }}</td>
                            <td><a href="{{ $standardt->file }}"><i class="icon-upload"></i></a></td>
                            <td>
                                <form action="{{ route('content.sheet.standard.destroy', $standardt->id) }}" method="POST">
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