<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="/admin_panel/global_assets/css/icons/icomoon/styles.min.css" rel="stylesheet" type="text/css">
    <link href="/admin_panel/assets/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="/admin_panel/global_assets/js/main/jquery.min.js"></script>
    <script src="/admin_panel/global_assets/js/main/bootstrap.bundle.min.js"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="/admin_panel/global_assets/js/plugins/visualization/d3/d3.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/ui/moment/moment.min.js"></script>
    <script src="/admin_panel/global_assets/js/plugins/pickers/daterangepicker.js"></script>

    <script src="/admin_panel/assets/js/app.js"></script>

    @yield('header-js')

    <!-- /theme JS files -->

</head>

<body>
<!-- Main navbar -->
    @include('admin_panel.layouts.main.navbar')
<!-- /main navbar -->

<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
    <div class="sidebar sidebar-light sidebar-main sidebar-expand-lg">
        @include('admin_panel.layouts.main.sidebar')
    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Inner content -->
        <div class="content-inner">

            <!-- Page header -->
                @include('admin_panel.layouts.main.pageheader')
            <!-- /page header -->


            <!-- Content area -->
            <div class="content">
                @yield('content-area')
            </div>
            <!-- /content area -->


            <!-- Footer -->
            <div class="navbar navbar-expand-lg navbar-light">
                <div class="text-center d-lg-none w-100">
                    <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                        <i class="icon-unfold mr-2"></i>
                        Footer
                    </button>
                </div>

                <div class="navbar-collapse collapse" id="navbar-footer">
						<span class="navbar-text">
							&copy; 2021. <a href="#">Каталог металлопродукции</a> от <a href="#" target="_blank">Перминова Ильи</a>
						</span>
                </div>
            </div>
            <!-- /footer -->

        </div>
        <!-- /inner content -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->
@yield('include-footer')
</body>
</html>
