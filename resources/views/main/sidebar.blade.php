<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link text-center" style=" padding: 8px;">
      <span class="brand-image img-circle elevation-3"  style="font-size: 34px;line-height: 0px; padding: 0px; font-weight: 600;"><i class="fas fa-users"></i></span>
      <span class="brand-text font-weight-bold">SYSTRA BPP</span>

      {{-- <span class="font-weight-dark" style="font-size: 24px;line-height: 0px; padding: 0px; font-weight: 600;">SYSTRA </span> --}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="#" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        @include('vms.main.sidebar-menu')
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>