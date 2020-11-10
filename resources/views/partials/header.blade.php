<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#">
                <i class="fa fa-bars"></i>
            </a>

        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="label label-primary">
                        {{ count(session('cart')) }}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('logout') }}">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
            </li>
        </ul>

    </nav>
</div>
