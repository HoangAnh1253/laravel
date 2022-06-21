<nav class="navbar navbar-expand d-flex flex-column align-item-start" id="sidebar">
    <a href="#" class="navbar-brand text-light mb-4">
        <div class="display-5 font-weight-bold">TMA</div>
    </a>
    <ul class="navbar-nav d-flex flex-column  w-100">
        @auth
            @if (Auth::user()->is_admin)
            <li class="nav-item w-100 {{ Route::is('equipment') ? 'nav-item-active' : '' }}">
                <a href="{{ route('equipment') }}" class="nav-link text-light pl-4">Equipments</a>
            </li>
            <li class="nav-item w-100 {{ Route::is('category') ? 'nav-item-active' : '' }}">
                <a href="{{ route('category') }}" class="nav-link text-light pl-4">Categories</a>
            </li>
            <li class="nav-item w-100 {{ Route::is('user') ? 'nav-item-active' : '' }}">
                <a href="{{ route('user') }}" class="nav-link text-light pl-4">Users</a>
            </li>
            @endif
        @endauth
        <li class="nav-item w-100 {{ Route::is('myEquipments') ? 'nav-item-active' : '' }}">
            <a href="{{ route('myEquipments') }}" class="nav-link text-light pl-4">My Equipments</a>
        </li>
        <li class="nav-item w-100 {{ Route::is('info') ? 'nav-item-active' : '' }}">
            <a href="{{ route('info') }}" class="nav-link text-light pl-4">My info</a>
        </li>
        <li class="nav-item w-100">
            <a href="{{ route('logout') }}" class="nav-link text-light pl-4">Logout</a>
        </li>
    </ul>
</nav>
