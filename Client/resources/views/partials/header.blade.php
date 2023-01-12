<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <i class="bx bx-menu fs-2 text-white" style="cursor: pointer"></i>
      <div class="{{ Request::is('profile*') ? 'bg-dark' : '' }} p-1">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown"> 
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                 @if (!is_null(session('profile_picture')))
                 <img src="{{ session('profile_picture') }}" alt="Profile" class="rounded-circle img-fluid" width="30">
                 @else
                 <img src="https://www.pngplay.com/wp-content/uploads/12/User-Avatar-Profile-Clip-Art-Transparent-File.png" alt="Profile" class="rounded-circle img-fluid" width="30">
                 @endif
                  <span class="d-none d-md-block dropdown-toggle ps-2 {{ Request::is('profile*') ? 'text-white' : '' }}">{{ session('nama_lengkap') }}</span> 
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" style="">
                    <li class="dropdown-header text-center">
                        <h6>{{ session('nama_lengkap') }}</h6>
                        <span>{{ session('level') }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li> 
                        <a class="dropdown-item d-flex align-items-center" href="/profile">
                        <i class='bx bxs-user'></i><span class="ms-2">My Profile</span> </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li> 
                        <a class="dropdown-item d-flex align-items-center" href="/logout">
                            <i class='bx bx-log-out-circle'></i>
                            <span class="ms-2">Sign Out</span> 
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
      </div>
    </div>
  </nav>