<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
         with font-awesome or any other icon font library -->
    {{-- <li class="nav-item has-treeview menu-open">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Starter Pages
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Active Page</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Inactive Page</p>
          </a>
        </li>
      </ul>
    </li> --}}
    <li class="nav-item">
      <a href="{{route('ethics.index')}}" class="nav-link {{active_class(explode('/',request()->path())[0]=='ethics')}}">
        <i class="nav-icon fas fa-check"></i>
        <p>
            Ethics & Compliance
        </p>
      </a>
    </li>

    @if($pending>0)
      <li class="nav-item">
        <a href="{{route('ethics.pending')}}" class="nav-link ">
          <i class="nav-icon fas fa-tasks"></i>
          <p>
          Pending Approval <span class="badge badge-primary">{{$pending}}</span>
            
          </p>
        </a>
      </li>
    @endif 
    
    <li class="nav-item">
      <a href="{{route('ethics.blacklist.index')}}" class="nav-link ">
        <i class="nav-icon fas fa-times"></i>
        <p>
            Blacklist Partner
          
        </p>
      </a>
    </li>

    <li class="nav-item">
      <a href="{{route('ethics.renewal.index')}}"  class="nav-link ">
        <i class="nav-icon fas fa-history"></i>
        <p>
            Renewal Dues
        </p>
      </a>
    </li>
    
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>
          Reports
          <i class="right fas fa-angle-right"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>E&C Monthly Report</p>
          </a>
        </li>
        <li class="nav-item">
        <a href="{{route('report.index')}}" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Due Diligence tracker</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>Due Diligence Report</p>
          </a>
        </li>
      </ul>
    </li>

  </ul>