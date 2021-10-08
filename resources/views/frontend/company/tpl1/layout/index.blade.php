<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    @include('frontend.company.tpl1.layout.head')
</head>
<body class="">
    <div id="wrapper" class="clearfix">
        <!-- Header -->
            @widget('Frontend\Layout\HeaderWidget')
        <!-- Start main-content -->
        <div class="main-content">
            @yield('main-content')
        </div>
        <!-- Footer -->
        @widget('Frontend.Layout.FooterWidget')
        <a class="scrollToTop" href="#"><i class="fa fa-angle-up"></i></a>
    </div>
    @include('frontend.company.tpl1.layout.footer-scripts')
</body>
</html>