@extends('admin_panel.layouts.main.main')
@section('title')
    Запись
@endsection
@section('pageheader-title')
    <a href="{{ route('content.sheet.timeline.page.index') }}"><i class="icon-arrow-left52 mr-2"></i></a>Запись
@endsection
@section('header-js')
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/extensions/jquery_ui/touch.min.js"></script>
@endsection
@section('content-area')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-right">
                        <a href="{{ route('content.sheet.timeline.line.create', $page->id) }}" type="button" class="btn btn-primary">Добавить линию</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @include('admin_panel.layouts.main.alerts')
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $page->h1 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form action="{{ route('content.sheet.timeline.page.orderrenew', $page->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="timeline timeline-left">
            <div class="timeline-container">
                <!-- Blog post -->

                    @if($lines->count() > 0)
                        <ul class="selectable-demo-list ui-sortable" id="sortable-list-basic" style="max-width: 100%">
                            @foreach($lines as $line)
                                <li class="p-2 bg-light border rounded cursor-move mt-1 ui-sortable-handle" style="">
                                    <div class="timeline-row">
                                        <div class="timeline-icon">
                                            <img src="/admin_panel/global_assets/images/placeholders/placeholder.jpg" alt="">
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header header-elements-sm-inline">
                                                        <h6 class="card-title">{{ $line->h1 }}</h6>
                                                        <div class="header-elements">
                                                            <div class="list-icons ml-3">
                                                                <div class="d-inline-flex">
                                                                    <a href="{{ route('content.sheet.timeline.line.edit', [$page->id, $line->id]) }}" class="list-icons-item">
                                                                        <i class="icon-cog3"></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="card-img-actions mb-3">
                                                                    <img src="{{ $line->img }}" alt="">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">
                                                                <blockquote class="blockquote blockquote-bordered py-2 pl-3 mb-0">
                                                                    {!! $line->content !!}
                                                                </blockquote>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="content_sheet_timeline_line_id[]" value="{{ $line->id }}">
                                </li>
                            @endforeach
                        </ul>
                    @endif

                <!-- /blog post -->

            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Сохранить порядок линий</button>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('include-footer')
    <script>
        // Setup module
        // ------------------------------

        var JqueryUiInteractions = function() {


            //
            // Setup module components
            //

            // Draggable
            var _componentUiDraggable = function() {
                if (!$().draggable) {
                    console.warn('Warning - jQuery UI components are not loaded.');
                    return;
                }

                // Basic setup
                $('.draggable-element').draggable({
                    containment: '#draggable-default-container'
                });


                //
                // Constrain movement
                //

                // Both
                $('#draggable-move-both').draggable({
                    containment: '#draggable-containment-container'
                });

                // Vertical
                $('#draggable-move-vertical').draggable({
                    containment: '#draggable-containment-container',
                    axis: 'y'
                });

                // Horizontal
                $('#draggable-move-horizontal').draggable({
                    containment: '#draggable-containment-container',
                    axis: 'x'
                });


                //
                // Revert position
                //

                // Element
                $('#draggable-revert-element').draggable({
                    containment: '#draggable-revert-container',
                    revert: true
                });

                // Clone helper
                $('#draggable-revert-clone').draggable({
                    containment: '#draggable-revert-container',
                    revert: true,
                    helper: 'clone'
                });

                // Speed
                $('#draggable-revert-speed').draggable({
                    containment: '#draggable-revert-container',
                    revert: true,
                    revertDuration: 1500
                });


                //
                // Cursors
                //

                // Move cursor
                $('#draggable-cursor-move').draggable({
                    containment: '#draggable-cursor-container',
                    cursor: 'move'
                });

                // Crosshair cursor
                $( '#draggable-cursor-crosshair' ).draggable({
                    containment: '#draggable-cursor-container',
                    cursor: 'crosshair'
                });

                // Bottom cursor
                $( '#draggable-cursor-bottom' ).draggable({
                    containment: '#draggable-cursor-container',
                    cursorAt: {
                        bottom: 0
                    }
                });


                //
                // Handles
                //

                // Text
                $( '#draggable-handle-text' ).draggable({
                    containment: '#draggable-handle-container',
                    handle: 'span'
                });

                // Icon
                $( '#draggable-handle-icon' ).draggable({
                    containment: '#draggable-handle-container',
                    handle: '.handle-icon'
                });

                // Exception
                $( '#draggable-handle-exception' ).draggable({
                    containment: '#draggable-handle-container',
                    cancel: 'span'
                });


                //
                // Events
                //

                // Define elements
                var $start_counter = $('#draggable-event-start'),
                    $drag_counter = $('#draggable-event-drag'),
                    $stop_counter = $('#draggable-event-stop'),
                    counts = [0, 0, 0];


                // Start event
                $start_counter.draggable({
                    containment: '#draggable-events-container',
                    start: function() {
                        counts[0]++;
                        updateCounterStatus( $start_counter, counts[0]);
                    }
                });

                // Drag event
                $drag_counter.draggable({
                    containment: '#draggable-events-container',
                    drag: function() {
                        counts[1]++;
                        updateCounterStatus($drag_counter, counts[1]);
                    }
                });

                // Stop event
                $stop_counter.draggable({
                    containment: '#draggable-events-container',
                    stop: function() {
                        counts[2]++;
                        updateCounterStatus($stop_counter, counts[2]);
                    }
                });

                // Update counter text
                function updateCounterStatus( $event_counter, new_count ) {
                    $( '.event-count', $event_counter ).text( new_count );
                }
            };

            // Droppable
            var _componentUiDroppable = function() {
                if (!$().draggable || !$().droppable) {
                    console.warn('Warning - jQuery UI components are not loaded.');
                    return;
                }


                //
                // Basic functionality
                //

                // Drag
                $('#droppable-basic-element').draggable({
                    containment: '#droppable-basic-container'
                });

                // Drop
                $('#droppable-basic-target').droppable({
                    drop: function(event, ui) {
                        $(this).addClass('bg-success border-success text-white').html('<span>Dropped!</span>');
                    }
                });


                //
                // Accept drop
                //

                // Drag
                $('#droppable-accept-yes, #droppable-accept-no').draggable({
                    containment: '#droppable-accept-container'
                });

                // Drop
                $('#droppable-accept-target').droppable({
                    accept: '#droppable-accept-yes',
                    drop: function(event, ui) {
                        $(this).addClass('bg-success border-success text-white').html('<span>Dropped!</span>');
                    }
                });


                //
                // Revert draggable position
                //

                // Drag (revert on drop)
                $('#droppable-revert-drop').draggable({
                    containment: '#droppable-revert-container',
                    revert: 'valid'
                });

                // Drag (revert always except drop)
                $('#droppable-revert-except').draggable({
                    containment: '#droppable-revert-container',
                    revert: 'invalid'
                });

                // Drop
                $('#droppable-revert-target').droppable({
                    drop: function(event, ui) {
                        $(this).addClass('bg-success border-success text-white').html('<span>Dropped!</span>');
                    }
                });


                //
                // Visual feedback
                //

                // Drag
                $('#droppable-visual-element').draggable({
                    containment: '#droppable-visual-container'
                });

                // Active drop
                $('#droppable-visual-target-active').droppable({
                    containment: '#droppable-visual-container',
                    accept: '#droppable-visual-element',
                    activeClass: 'bg-secondary border-secondary text-white',
                    drop: function(event, ui) {
                        $(this).addClass('bg-success border-success text-white').html('<span>Dropped!</span>');
                    }
                });

                // Hover drop
                $('#droppable-visual-target-hover').droppable({
                    containment: '#droppable-visual-container',
                    hoverClass: 'bg-primary border-primary text-white',
                    drop: function(event, ui) {
                        $(this).addClass('bg-teal border-teal text-white').html('<span>Dropped!</span>');
                    }
                });
            };

            // Resizable
            var _componentUiResizable = function() {
                if (!$().resizable) {
                    console.warn('Warning - jQuery UI components are not loaded.');
                    return;
                }

                // Basic functionality
                $('#resizable-basic-element').resizable({
                    minWidth: 50,
                    minHeight: 50
                });

                // Animated resize
                $('#resizable-animate-element').resizable({
                    minWidth: 50,
                    minHeight: 50,
                    animate: true
                });

                // Preserve aspect ratio
                $('#resizable-ratio-element').resizable({
                    minWidth: 50,
                    minHeight: 50,
                    aspectRatio: 16 / 9
                });

                // Synchronous resize
                $('#resizable-sync-element1').resizable({
                    minWidth: 50,
                    minHeight: 50,
                    alsoResize: '#resizable-sync-element2'
                });
                $('#resizable-sync-element2').resizable({
                    minWidth: 50,
                    minHeight: 50,
                    alsoResize: '#resizable-sync-element1'
                });
            };

            // Selectable
            var _componentUiSelectable = function() {
                if (!$().selectable) {
                    console.warn('Warning - jQuery UI components are not loaded.');
                    return;
                }

                // Basic functionality
                $('#selectable-basic').selectable();

                // Serialize
                $('#selectable-serialize').selectable({
                    stop: function() {
                        var result = $('#select-result').empty();
                        $('.ui-selected', this).each(function() {
                            var index = $('#selectable-serialize li').index(this);
                            result.append(' #' + (index + 1));
                        });
                    }
                });
            };

            // Sortable
            var _componentUiSortable = function() {
                if (!$().sortable) {
                    console.warn('Warning - jQuery UI components are not loaded.');
                    return;
                }

                // Basic functionality
                $('#sortable-list-basic').sortable();
                $('#sortable-list-basic').disableSelection();


                // Placeholder
                $('#sortable-list-placeholder').sortable({
                    placeholder: 'sortable-placeholder',
                    start: function(e, ui){
                        ui.placeholder.height(ui.item.outerHeight());
                    }
                });
                $('#sortable-list-placeholder').disableSelection();


                // Connected lists
                $('#sortable-list-first, #sortable-list-second').sortable({
                    connectWith: '.selectable-demo-connected'
                }).disableSelection();


                //
                // Include/exclude items
                //

                // Specify sort items
                $('#sortable-list-specify').sortable({
                    items: 'li:not(.ui-handle-excluded)'
                });

                // Exclude items
                $('#sortable-list-cancel').sortable({
                    cancel: '.ui-handle-excluded'
                });

                // Disable selections
                $('#sortable-list-specify li, #sortable-list-cancel li').disableSelection();
            };


            //
            // Return objects assigned to module
            //

            return {
                init: function() {
                    _componentUiDraggable();
                    _componentUiDroppable();
                    _componentUiResizable();
                    _componentUiSelectable();
                    _componentUiSortable();
                }
            }
        }();


        // Initialize module
        // ------------------------------

        document.addEventListener('DOMContentLoaded', function() {
            JqueryUiInteractions.init();
        });
    </script>
@endsection