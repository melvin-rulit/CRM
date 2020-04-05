
        <nav class="navbar navbar-vertical fixed-left navbar-expand-md d-block d-sm-none" id="sidebar">
          <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-user d-none d-md-flex" id="sidebarUser">

              <a href="#sidebarModalActivity" class="navbar-user-link" data-toggle="modal">
                <span class="icon">
                  <i class="fe fe-bell"></i>
                </span>
              </a>

              <!-- Dropup -->
              <div class="dropup">
                <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="avatar avatar-xl avatar-online">
                    <img src="http://83.220.172.19/images/photo_LI.jpg
                    " class="avatar-img rounded-circle" alt="...">
                  </div>
                </a>
              </div>

              <!-- Icon -->
              <a href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();" class="navbar-user-link" data-toggle="modal">
              <span class="icon">
                <i class="fe fe-log-out"></i>
              </span>
            </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

            </div>

            <hr>


            <div class="navbar-user d-md-none">
              <div class="dropdown">
                <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="avatar avatar-sm avatar-online">
                    <img src="https://dashkit.goodthemes.co/assets/img/avatars/profiles/avatar-1.jpg" class="avatar-img rounded-circle" alt="...">
                  </div>
                </a>


<!--                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
                  <a href="profile-posts.html" class="dropdown-item">Profile</a>
                  <a href="settings.html" class="dropdown-item">Settings</a>
                  <hr class="dropdown-divider">
                  <a href="sign-in.html" class="dropdown-item">Logout</a>
                </div> -->

              </div>
            </div>


              <a href="{{ route('logout') }}" onclick="event.preventDefault();
              document.getElementById('logout-form').submit();" class="navbar-user-link" data-toggle="modal">
<button class="ml-4 btn btn-primary btn-sm">{{ trans('global.logout') }}</button>
            </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>


            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidebarCollapse">
                  <div class="text-center">
                        <h2 class="card-title">
                          @if (Auth::id())
                          {{ Auth::user()->name }} {{ Auth::user()->surname }}
                          @endif
                      </h2>
                 </div>
             <hr class="navbar-divider my-3">

              <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                  <a class="nav-link" href="/promoter">
                    <i class="fe fe-git-branch"></i>{{ trans('cruds.promoter.menu_instruktion') }}
                  </a>
                </li>  
                <li class="nav-item">
                  <a class="nav-link" href="/promoter">
                    <i class="fe fe-git-branch"></i>{{ trans('cruds.promoter.menu_rating') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/promoter">
                    <i class="fe fe-git-branch"></i>{{ trans('cruds.promoter.menu_chart') }}
                  </a>
              </ul>

              <hr class="navbar-divider my-3">

              <ul class="navbar-nav mb-md-4">
                <li class="nav-item">
                  <a class="nav-link" href="/promoter">
                    <i class="fe fe-settings"></i>{{ trans('cruds.promoter.menu_settings') }}
                  </a>
                </li>
              </ul>
              <div class="mt-auto"></div>
            </div> 
          </div>
        </nav>
      




        <nav class="navbar navbar-vertical navbar-vertical-sm fixed-left navbar-expand-md " id="sidebarSmall">
          <div class="container-fluid">
          </div>
        </nav>
      
    
    
      <nav class="navbar navbar-expand-lg " id="topnav">
        <div class="container">

<!--           <form class="form-inline mr-4 d-none d-lg-flex">
            <div class="input-group input-group-rounded input-group-merge" data-toggle="lists" data-options='{"valueNames": ["name"]}'>
              <input type="search" class="form-control form-control-prepended  dropdown-toggle search" data-toggle="dropdown" placeholder="Поиск" aria-label="Search">
              <div class="input-group-prepend">
                <div class="input-group-text">
                  <i class="fe fe-search"></i>
                </div>
              </div>
            </div>
          </form> -->



<!--           <div class="navbar-user">
            <div class="dropdown mr-4 d-none d-lg-flex">
              <a href="#" class="navbar-user-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon active">
                  <i class="fe fe-bell"></i>
                </span>
              </a>

              <div class="dropdown-menu dropdown-menu-right dropdown-menu-card">
                <div class="card-header">
                  <div class="row align-items-center">
                    <div class="col">
                

                      <h5 class="card-header-title">
                        Уведомления
                      </h5>

                    </div>
                    <div class="col-auto">
                

                      <a href="#!" class="small">
                        Посмотреть все
                      </a>

                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <div class="list-group list-group-flush my-n3">
                    <a class="list-group-item text-reset px-0" href="#!">
              
                      <div class="row">
                        <div class="col-auto">
                    
                          <div class="avatar avatar-sm">
                            <img src="https://dashkit.goodthemes.co/assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">
                          </div>

                        </div>
                        <div class="col ml-n2">
                          <div class="small">
                            <strong>Dianna Smiley</strong> shared your post with Ab Hadley, Adolfo Hess, and 3 others.
                          </div>
                          <small class="text-muted">
                            2m ago
                          </small>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div> -->


<!--           <div class="collapse navbar-collapse mr-auto order-lg-first" id="navbar">
          </div> -->
        </div>
      </nav>
