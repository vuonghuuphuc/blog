<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
    <button class="btn btn-light mr-2" id="menu-toggle">
        <i class="fa fa-chevron-right"></i>
        Menu
    </button>

    <a href="{{ url('') }}" class="btn btn-dark" target="_blank">
        <i class="fa fa-home"></i>
        {{ config('app.name', 'Laravel') }}
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link text-light dropdown-toggle" href="#" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="fa fa-user"></i>
                    {{ auth()->user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a href="{{ url('/password') }}" class="dropdown-item">
                        <i class="fa fa-key"></i>
                        {{ __('Change Password') }}
                    </a>
                    <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>