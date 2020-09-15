
        <nav class="navbar navbar-vertical fixed-left navbar-expand-md " id="sidebar">
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
                    <img src="http://62.109.26.106//images/photo_LI.jpg
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

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="sidebarIcon">
                  <a href="profile-posts.html" class="dropdown-item">Profile</a>
                  <a href="settings.html" class="dropdown-item">Settings</a>
                  <hr class="dropdown-divider">
                  <a href="sign-in.html" class="dropdown-item">Logout</a>
                </div>

              </div>
            </div>



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
              <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                  <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      <span class="fe fe-search"></span>
                    </div>
                  </div>
                </div>
              </form>

              <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                  <a class="nav-link" href="/">
                    <i class="fe fe-git-branch"></i>{{ trans('cruds.menu.home') }}
                  </a>
                </li>
                <li class="nav-item">
                      @can('user_management_access')
                                        @can('role_access')
                                            <li class="nav-item">
                                                <a href="{{ route("admin.useraccess.index") }}" class="nav-link">
                                                    <i class="fe fe-git-branch">

                                                    </i>
                                                    {{ trans('cruds.menu.roleaccess') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('permission_access')
                                            <li class="nav-item">
                                              <a class="nav-link" href="/permissions">
                                                <i class="fe fe-database"></i> {{ trans('cruds.menu.permissions') }}
                                              </a>
                                            </li>
                                        @endcan
                                        @can('role_access')
                                            <li class="nav-item">
                                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                                    <i class="fe fe-git-branch">

                                                    </i>
                                                    {{ trans('cruds.menu.roles') }}
                                                </a>
                                            </li>
                                        @endcan
                                        @can('user_access')
                                            <li class="nav-item">
                                                <a href="/users" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                                    <i class="fe fe-user">

                                                    </i>
                                                    {{ trans('cruds.menu.users') }}
                                                </a>
                                            </li>
                                        @endcan
                                </li>
                            @endcan

                <li class="nav-item">
                  <a class="nav-link" href="/">
                    <i class="fe fe-git-branch"></i> {{ trans('cruds.menu.reports') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/">
                    <i class="fe fe-dollar-sign"></i> {{ trans('cruds.menu.kassa') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/">
                    <i class="fe fe-git-branch"></i> Склад
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/">
                    <i class="fe fe-book-open"></i>  {{ trans('cruds.menu.notifications') }} <span class="badge badge-primary ml-auto">12</span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="fe fe-star"></i> {{ trans('cruds.menu.tasks') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/base">
                    <i class="fe fe-database"></i> {{ trans('cruds.menu.base') }}
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/journal">
                    <i class="fe fe-database"></i> Журнал
                  </a>
                </li>
<!--                 @can('school_class_access')
                <li class="nav-item">
                  <a class="nav-link" href="{{ route("admin.school-classes.index") }}">
                    <i class="fe fe-user"></i> {{ trans('cruds.schoolClass.title') }}
                  </a>
                </li>
                @endcan
                @can('lesson_access')
                <li class="nav-item">
                  <a class="nav-link" href="{{ route("admin.lessons.index") }}">
                    <i class="fe fe-user"></i> {{ trans('cruds.lesson.title') }}
                  </a>
                </li>
                @endcan -->
<!--                 <li class="nav-item">
                  <a class="nav-link" href="{{ route("admin.calendar.index") }}">
                    <i class="fe fe-user"></i> {{ trans('cruds.menu.calendar') }}
                  </a>
                </li> -->
              </ul>

              <hr class="navbar-divider my-3">

              <h6 class="navbar-heading">
                Служебные
              </h6>

              <ul class="navbar-nav mb-md-4">
                @can('personal_settings')
                <li class="nav-item">
                  <a class="nav-link" href="{{ route("admin.settings.index") }}">
                    <i class="fe fe-settings"></i> {{ trans('cruds.menu.settings') }}
                  </a>
                </li>
                @endcan
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <i class="fe fe-clipboard"></i> {{ trans('cruds.menu.guide') }}
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

{{--          <form class="form-inline mr-4 d-none d-lg-flex">--}}
{{--            <div class="input-group input-group-rounded input-group-merge" data-toggle="lists" data-options='{"valueNames": ["name"]}'>--}}
{{--              <input type="search" class="form-control form-control-prepended  dropdown-toggle search" data-toggle="dropdown" placeholder="Поиск" aria-label="Search">--}}
{{--              <div class="input-group-prepend">--}}
{{--                <div class="input-group-text">--}}
{{--                  <i class="fe fe-search"></i>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </form>--}}



{{--          <div class="navbar-user">--}}
{{--            <div class="dropdown mr-4 d-none d-lg-flex">--}}
{{--              <a href="#" class="navbar-user-link" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
{{--                <span class="icon active">--}}
{{--                  <i class="fe fe-bell"></i>--}}
{{--                </span>--}}
{{--              </a>--}}

{{--              <div class="dropdown-menu dropdown-menu-right dropdown-menu-card">--}}
{{--                <div class="card-header">--}}
{{--                  <div class="row align-items-center">--}}
{{--                    <div class="col">--}}

{{--                      <!-- Title -->--}}
{{--                      <h5 class="card-header-title">--}}
{{--                        Уведомления--}}
{{--                      </h5>--}}

{{--                    </div>--}}
{{--                    <div class="col-auto">--}}


{{--                      <a href="#!" class="small">--}}
{{--                        Посмотреть все--}}
{{--                      </a>--}}

{{--                    </div>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--                <div class="card-body">--}}
{{--                  <div class="list-group list-group-flush my-n3">--}}
{{--                    <a class="list-group-item text-reset px-0" href="#!">--}}

{{--                      <div class="row">--}}
{{--                        <div class="col-auto">--}}

{{--                          <div class="avatar avatar-sm">--}}
{{--                            <img src="https://dashkit.goodthemes.co/assets/img/avatars/profiles/avatar-1.jpg" alt="..." class="avatar-img rounded-circle">--}}
{{--                          </div>--}}

{{--                        </div>--}}
{{--                        <div class="col ml-n2">--}}
{{--                          <div class="small">--}}
{{--                            <strong>Dianna Smiley</strong> shared your post with Ab Hadley, Adolfo Hess, and 3 others.--}}
{{--                          </div>--}}
{{--                          <small class="text-muted">--}}
{{--                            2m ago--}}
{{--                          </small>--}}
{{--                        </div>--}}
{{--                      </div>--}}
{{--                    </a>--}}
{{--                  </div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}


          <div class="collapse navbar-collapse mr-auto order-lg-first" id="navbar">
          </div>
        </div>
      </nav>
