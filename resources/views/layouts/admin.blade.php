@extends('layouts.core')

@section('app')

<div class="d-flex" id="wrapper">
    
    @component('components.admin.sidebar')
    @endcomponent

    <div id="page-content-wrapper">

        @component('components.admin.nav')
        @endcomponent

        <div class="p-3">
            @yield('content')    
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
$("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
});
</script>
@endpush

@push('layoutStyles')
<style>
body{
    background: url('{{ asset("images/bg.png") }}') repeat;
}
/*!
* Start Bootstrap - Simple Sidebar (https://startbootstrap.com/template-overviews/simple-sidebar)
* Copyright 2013-2019 Start Bootstrap
* Licensed under MIT (https://github.com/BlackrockDigital/startbootstrap-simple-sidebar/blob/master/LICENSE)
*/
body {
    overflow-x: hidden;
}

#sidebar-wrapper {
    min-height: 100vh;
    margin-left: -15rem;
    -webkit-transition: margin .25s ease-out;
    -moz-transition: margin .25s ease-out;
    -o-transition: margin .25s ease-out;
    transition: margin .25s ease-out;
}

#sidebar-wrapper .sidebar-heading {
    padding: 0.875rem 1.25rem;
    font-size: 1.2rem;
}

#sidebar-wrapper .list-group {
    width: 15rem;
}

#page-content-wrapper {
    min-width: 100vw;
}

#wrapper.toggled #sidebar-wrapper {
    margin-left: 0;
}

#sidebar-wrapper .list-group-item{
    border: unset;
    border-radius: 0.25rem;
    margin-bottom: 5px;
}


#sidebar-wrapper .list-group{
    padding: 5px;
    
}

@media (min-width: 768px) {
    #sidebar-wrapper {
        margin-left: 0;
    }

    #page-content-wrapper {
        min-width: 0;
        width: 100%;
    }

    #wrapper.toggled #sidebar-wrapper {
        margin-left: -15rem;
    }
}
</style>
@endpush