<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#">
                <i class="fa fa-bars"></i>
            </a>

        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown">
                <a class="dropdown-toggle count-info" href="{{ url('/orders/cart/preview') }}">
                    <i class="fa fa-shopping-cart"></i>
                    <span class="label label-primary">
                        @php
                            $carts = session('cart');
                            if(!$carts) {
                                echo 0;
                            }
                            else {
                                $qty = 0;
                                foreach ($carts as $key => $value) {
                                    $qty += $value['total_quantity'];
                                }

                                echo $qty;
                            }
                        @endphp
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
