@php
    $activeView = request()->segment(1); 
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src="AdminLTE-3.2.0/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><strong>Growspital</strong></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="AdminLTE-3.2.0/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a class="d-block">{{auth()->user()->name}}</a>
        </div>
    </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item {{ ($activeView == 'dashboard') ? 'menu-open' : '' }}">
            <a href="/dashboard" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>

          @if (auth()->user()->hasRole('pasien'))
          <li class="nav-item {{ ($activeView == 'riwayat') ? 'menu-open' : '' }}">
            <a href="/riwayat" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Medical Records
              </p>
            </a>
          </li>
          @endif

          @if(auth()->user()->hasRole('admin'))
              <li class="nav-item {{ ($activeView == 'user-list') ? 'menu-open' : '' }}">
                <a href="/user-list" class="nav-link">
                  <i class="nav-icon fas fa-table"></i>
                  <p>
                    User List
                  </p>
                </a>
              </li>
          @endif

          @if (auth()->user()->hasRole('apoteker'))
          <li class="nav-item {{ ($activeView == 'obat-list') ? 'menu-open' : '' }}">
            <a href="/obat-list" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Medicine List
              </p>
            </a>
          </li>
          @endif

          @if (auth()->user()->hasRole('dokter'))
          <li class="nav-item {{ ($activeView == 'pasien-list') ? 'menu-open' : '' }}">
            <a href="/pasien-list" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Patient List
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item {{ ($activeView == 'user-profile') ? 'menu-open' : '' }}">
            <a href="/user-profile" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
              </p>
            </a>
          </li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p :href="route('logout')" onclick="event.preventDefault();
                this.closest('form').submit();">
                    {{ __('Log Out') }}
                </p>
                </a>
            </form>
          </li>
      </nav>
    </div>
  </aside>