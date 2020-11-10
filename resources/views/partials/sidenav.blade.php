<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <img alt="image" class="rounded-circle" src="{{ asset('template/img/default-user.png')}}" style="width: 48px; height: 48px;" />
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ $user->name }}</span>
                        <span class="text-muted text-xs block">{{$user->roles[0]->name}} <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>


            <li {!! $title == 'dashboard' ? "class='active'" : "" !!}>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-th-large"></i>
                    <span class="nav-label">Dashboards</span>
                </a>
            </li>

            @if($user->roles[0]->name == 'admin')
            <li {!! $title == 'kategori' ? "class='active'" : "" !!}>
                <a href="{{ url('categories') }}">
                    <i class="fa fa-database"></i>
                    <span class="nav-label">Master Kategori</span>
                </a>
            </li>

            <li {!! $title == 'produk' ? "class='active'" : "" !!}>
                <a href="{{ url('products') }}">
                    <i class="fa fa-product-hunt"></i>
                    <span class="nav-label">Master Produk</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-bar-chart-o"></i>
                    <span class="nav-label">Pengaturan</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li><a href="">Manajemen Roles</a></li>
                    <li><a href="">Manajemen Permission</a></li>
                </ul>
            </li>

            <li>
                <a href="layouts.html">
                    <i class="fa fa-text-o"></i>
                    <span class="nav-label">Laporan</span>
                </a>
            </li>

            @else
            <li {!! $title == 'produk' ? "class='active'" : "" !!}>
                <a href="{{ url('list/details_product') }}">
                    <i class="fa fa-product-hunt"></i>
                    <span class="nav-label">Produk</span>
                </a>
            </li>

            <li {!! $title == 'produk' ? "class='active'" : "" !!}>
                <a href="{{ url('list/details_product') }}">
                    <i class="fa fa-cart-plus"></i>
                    <span class="nav-label">Keranjang Belanja</span>
                </a>
            </li>
            @endif



        </ul>

    </div>
</nav>
