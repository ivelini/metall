<div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static">
    <div class="d-flex flex-1 d-lg-none">
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
            <i class="icon-paragraph-justify3"></i>
        </button>

        <button data-target="#navbar-search" type="button" class="navbar-toggler" data-toggle="collapse">
            <i class="icon-search4"></i>
        </button>
    </div>

    <div class="navbar-brand text-center text-lg-left">
        <a href="{{ asset('dashboard')}}" class="d-inline-block">
            <img src="{{ asset('admin_panel/global_assets/images/logo_light.png') }}" class="d-none d-sm-block" alt="">
            <img src="{{ asset('admin_panel/global_assets/images/logo_icon_light.png') }}" class="d-sm-none" alt="">
        </a>
    </div>

    @if(Auth::user())
        @include('admin_panel.layouts.main.navbarForUser')
    @elseif(Auth::user() == null)
        @include('admin_panel.layouts.main.navbarForGuest')
    @endif
</div>