<div class="bg-dark" id="sidebar-wrapper">
    <div class="sidebar-heading text-center" style="background: black; height: 52px; border-bottom: 1px solid rgba(0, 0, 0, 0.125)">
        <a class="text-light" href="{{ adminUrl('/dashboard') }}">
            Admin Control Panel
        </a>
    </div>
    <div class="list-group list-group-flush">
        {{-- <a href="{{ adminUrl('/dashboard') }}" class="list-group-item list-group-item-action {{ request()->is(config('site.admin_routes_prefix') . '/dashboard*') ? 'active' : 'bg-light' }}">
            <i class="fa fa-tachometer-alt"></i>
            Dashboard
        </a> --}}
        
        

        <a href="{{ adminUrl('/posts') }}" class="list-group-item list-group-item-action {{ request()->is(config('site.admin_routes_prefix') . '/posts*') ? 'bg-light text-dark' : 'bg-dark text-light' }}">
            <i class="fa fa-newspaper"></i>
            Posts
        </a>

        @if (auth()->user()->can('view', \App\User::class))
        <a href="{{ adminUrl('/users') }}" class="list-group-item list-group-item-action {{ request()->is(config('site.admin_routes_prefix') . '/users*') ? 'bg-light text-dark' : 'bg-dark text-light' }}">
            <i class="fa fa-users"></i>
            Users
        </a>
        @endif

        {{-- <a href="{{ adminUrl('/settings') }}" class="list-group-item list-group-item-action {{ request()->is(config('site.admin_routes_prefix') . '/settings*') ? 'active' : 'bg-light' }}">
            <i class="fa fa-cogs"></i>
            Settings
        </a> --}}
    </div>
</div>