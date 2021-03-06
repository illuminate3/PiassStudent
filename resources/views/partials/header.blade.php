<header class="main-header">
        <a href="{{Url()}}" class="logo"> 
        <img src="{!! Url() !!}/assets/dist/img/logo.gif" width="22%" >
        <b>{!! $company !!} </b> </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
              <!-- Notifications: style can be found in dropdown.less -->
              
              <!-- Tasks: style can be found in dropdown.less -->
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <span class="hidden-xs"><i class="fa fa-circle text-success user-image"></i> {{ Sentry::getUser()->first_name }}  {{ Sentry::getUser()->last_name }} </span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                
                  <!-- Menu Body -->
                  
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="{{ route('sentinel.profile.show') }}" class="btn btn-success btn-flat">Profile</a>
                    
                    </div>
                    <div class="pull-right">
                      <a class="btn btn-danger btn-flat" href="{{ route('sentinel.logout') }}">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>