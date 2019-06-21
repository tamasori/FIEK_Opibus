
     <div class="sidebar-heading">
        Általános
    </div>
    @foreach (Config::get('constants.menus.altalanos') as $menu)
        <li class="nav-item active">
            <a class="nav-link" href="{{ $menu['url'] }}">
            {!! $menu['icon'] !!}
            <span>{{ $menu['name'] }}</span></a>
        </li>
    @endforeach
    
    @if(User::find(Auth::User()->id)->AnyMenu())
    <hr class="sidebar-divider">
    <!-- Nav Item - Dashboard -->
    <div class="sidebar-heading">
        Adminisztráció
    </div>
    @endif
    @foreach (Config::get('constants.menus.administration') as $menu)
        @if(User::find(Auth::User()->id)->CanAccessMenu($menu['perm']))
            <li class="nav-item active">
                <a class="nav-link" href="{{ $menu['url'] }}">
                {!! $menu['icon'] !!}
                <span>{{ $menu['name'] }}</span></a>
            </li>
        @endif
    @endforeach

     

      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
