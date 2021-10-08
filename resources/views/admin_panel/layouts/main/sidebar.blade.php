    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-section">
            <div class="sidebar-user-material">
                <div class="sidebar-section-body">
                    <div class="d-flex">
                        <div class="flex-1"></div>
                        <a href="#" class="flex-1 text-center"><img src="/admin_panel/global_assets/images/placeholders/placeholder.jpg" class="img-fluid rounded-circle shadow-sm" width="80" height="80" alt=""></a>
                        <div class="flex-1 text-right">
                            <button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                                <i class="icon-transmission"></i>
                            </button>

                            <button type="button" class="btn btn-outline-light border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                                <i class="icon-cross2"></i>
                            </button>
                        </div>
                    </div>

                    <div class="text-center">
                        <h6 class="mb-0 text-white text-shadow-dark mt-3">Victoria Baker</h6>
                        <span class="font-size-sm text-white text-shadow-dark">Santa Ana, CA</span>
                    </div>
                </div>

            </div>


        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="icon-home4"></i>
                        <span>Главная</span>
                    </a>
                </li>
                <!-- Main -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs mt-1">Каталог</div> <i class="icon-menu" title="Main"></i></li>

                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Каталог</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="{{ route('catalog.price.create') }}" class="nav-link"><i class="icon-attachment2"></i> Импорт прайс листа</a></li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-database4"></i>  Каталог продукции</a>
                            <ul class="nav nav-group-sub">
                                @widget('Sidebar\ListProductWidget')
                            </ul>
                        </li>
                        <li class="nav-item"><a href="{{ route('catalog.product.category.index') }}" class="nav-link"><i class="icon-list"></i> Категории</a></li>
                    </ul>
                </li>
                <!-- /main -->

                <!-- Страницы и записи -->
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs mt-1">Страницы и записи</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-pencil7"></i> <span>Записи</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="{{ route('content.records.record.create') }}" class="nav-link"><i class="icon-circle-small"></i> Добавить запись</a></li>
                        <li class="nav-item"><a href="{{ route('content.records.record.index') }}" class="nav-link"><i class="icon-circle-small"></i> Все записи</a></li>
                       <li class="nav-item"><a href="{{ route('content.records.category.index') }}" class="nav-link"><i class="icon-circle-small"></i> Рубрики</a></li>
                    </ul>
                </li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-files-empty"></i> <span>Страницы</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="{{ route('content.sheet.worker.index') }}" class="nav-link"><i class="icon-users4"></i> Персонал</a></li>
                        <li class="nav-item"><a href="{{ route('content.sheet.certificate.index') }}" class="nav-link"><i class="icon-certificate"></i> Сертификаты</a></li>
                        <li class="nav-item"><a href="{{ route('content.sheet.timeline.page.index') }}" class="nav-link"><i class="icon-stairs"></i> Timeline</a></li>
                        <li class="nav-item"><a href="{{ route('content.sheet.standard.index') }}" class="nav-link"><i class="icon-file-pdf"></i> Стандарты</a></li>
                        <li class="nav-item"><a href="{{ route('content.sheet.shipment.index') }}" class="nav-link"><i class="icon-truck"></i> Отгрузки</a></li>
                    </ul>
                </li>
                <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs mt-1">Настройки</div> <i class="icon-menu" title="Main"></i></li>
                <li class="nav-item nav-item-submenu">
                    <a href="#" class="nav-link"><i class="icon-brush"></i> <span>Внешний вид</span></a>

                    <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                        <li class="nav-item"><a href="{{ route('settings.companyInformation.generalEdit') }}" class="nav-link"><i class="icon-sphere"></i> Общие</a></li>
                        <li class="nav-item"><a href="{{ route('settings.menu.edit') }}" class="nav-link"><i class="icon-menu2"></i> Меню</a></li>
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-insert-template"></i> <span>Шаблон</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                                <li class="nav-item"><a href="{{ route('content.records.record.create') }}" class="nav-link"><i class="icon-circle-small"></i> Выбор шаблона</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="nav-item"><a href="{{ route('settings.companyInformation.edit') }}" class="nav-link"><i class="icon-profile"></i> Карточка компании</a></li>
                <li class="nav-item"><a href="{{ route('settings.slider.index') }}" class="nav-link"><i class="icon-stack-picture"></i> Слайдер</a></li>

                <!-- /page kits -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->