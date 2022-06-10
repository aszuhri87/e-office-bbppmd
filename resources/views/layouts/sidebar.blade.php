<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow border-right ml-1 mt-1"  data-scroll-to-active="true" style="border-radius: 20px;">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="#">
                <span class="brand-logo">
                         <img src="{{asset('/logo.png')}}" alt="" style="width:90%; height:75%; padding-left:10%" >
                </span>
                        {{-- <img src="{{asset('app-assets/images/logo.png')}}" alt="" style="width:auto; height:80%" > --}}
                    <h2 class="brand-text text-bppm"  style="padding-right">SITA SUTRO</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse" id="side-toggle"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content" >
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">



            @hasrole('superadmin|admin')
            <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/admin/dashboard"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
            </li>
        {{-- @endhasrole --}}
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="database"></i><span class="menu-title text-truncate" data-i18n="Menu Levels">Master Data</span></a>
                <ul class="menu-content">
                    <li class="nav-item @if (Request::is('admin/unit')) active @endif"><a class="d-flex align-items-center" href="/admin/unit"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Unit</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/wish')) active @endif"><a class="d-flex align-items-center" href="/admin/wish"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Second Level">Mengharapkan</span></a>
                    </li>
                    <li class="nav-item @if (Request::is('admin/position')) active @endif"><a class="d-flex align-items-center" href="/admin/position"  data-toggle="tooltip" data-bs-placement="right" title="posisi"><i data-feather="circle"></i><span class="menu-item text-truncate">Posisi</span></a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item nav-pill-success @if (Request::is('admin/input-letter')) active @endif"><a class="d-flex align-items-center" href="/admin/input-letter"  ><i data-feather="file-plus"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Input Surat</span></a>
            </li>
            <li class=" nav-item nav-pill-success @if (Request::is('admin/letter')) active @endif"><a class="d-flex align-items-center" href="/admin/letter"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Disposisi Surat</span></a>
            </li>
            <li class=" nav-item nav-pill-success @if (Request::is('admin/verification')) active @endif"><a class="d-flex align-items-center" href="/admin/verification"><i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Status Disposisi</span></a>
            </li>
            {{-- <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/admin/done"><i data-feather="check-circle"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Selesai</span></a>
            </li> --}}
            @endhasrole

            @hasrole('chief')
            <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/chief/dashboard"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
            </li>
            {{-- @endhasrole --}}
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item nav-pill-success @if (Request::is('chief/letter-chief')) active @endif"><a class="d-flex align-items-center" href="/chief/letter-chief"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Disposisi Surat</span></a>
            </li>
            <li class=" nav-item nav-pill-success @if (Request::is('chief/verification')) active @endif"><a class="d-flex align-items-center" href="/chief/verification"><i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Status Disposisi</span></a>
            </li>
            {{-- <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/chief/done"><i data-feather="check-circle"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Selesai</span></a>
            </li> --}}
            @endhasrole

            @hasrole('chief_of_division|chief_of_sub_division|coordinator|personil')
            <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/chief_div/dashboard"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span></a>
            </li>
            {{-- @endhasrole --}}
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item nav-pill-success @if (Request::is('chief_div/letter-chief_div')) active @endif"><a class="d-flex align-items-center" href="/chief_div/letter-chief_div"><i data-feather="file-text"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Disposisi Surat</span></a>
            </li>
            <li class=" nav-item nav-pill-success @if (Request::is('chief_div/verification')) active @endif"><a class="d-flex align-items-center" href="/chief_div/verification"><i data-feather="list"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Status Disposisi</span></a>
            </li>
            {{-- <li class=" nav-item nav-pill-success"><a class="d-flex align-items-center" href="/chief_div/done"><i data-feather="check-circle"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Selesai</span></a>
            </li> --}}
            @endhasrole



            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Akun &amp; Data</span><i data-feather="more-horizontal"></i>
          {{-- @role('super admin') --}}
          @hasrole('superadmin')
            <li class=" nav-item @if (Request::is('admin/manage-user')) active @endif"><a class="d-flex align-items-center" href="/admin/manage-user"><i data-feather="user-plus"></i><span class="menu-title text-truncate" data-i18n="Documentation">Manajemen User</span></a>
            </li>
            {{-- <li class=" nav-item"><a class="d-flex align-items-center" href="/admin/profile"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Documentation">Profile</span></a>
            </li> --}}
            @endhasrole
            {{-- @endrole --}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="{{ route('logout') }}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><i data-feather="log-out"></i><span class="menu-title text-truncate" data-i18n="Raise Support">Logout</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->


