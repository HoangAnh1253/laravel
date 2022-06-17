<nav class="navbar navbar-expand d-flex flex-column align-item-start" id="sidebar">
    <a href="#" class="navbar-brand text-light mb-4">
        <div class="display-5 font-weight-bold">ADMIN</div>
    </a>
    <ul class="navbar-nav d-flex flex-column  w-100">
        <li class="nav-item w-100 {{ Route::is('equipment') ? 'nav-item-active' : '' }}">
            <a href="{{ route('equipment') }}" class="nav-link text-light pl-4">Equipments</a>
        </li>
        <li class="nav-item w-100 {{ Route::is('user') ? 'nav-item-active' : '' }}">
            <a href="{{ route('user') }}" class="nav-link text-light pl-4">Users</a>
        </li>
        <li class="nav-item w-100 {{ Route::is('info') ? 'nav-item-active' : '' }}">
            <a href="{{ route('info') }}" class="nav-link text-light pl-4">My info</a>
        </li>
        <li class="nav-item w-100">
            <a href="{{ route('logout') }}" class="nav-link text-light pl-4">Logout</a>
        </li>
    </ul>
</nav>
