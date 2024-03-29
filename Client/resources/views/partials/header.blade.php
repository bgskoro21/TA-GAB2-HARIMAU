<nav class="navbar navbar-expand-lg navbar-dark navbar-header">
    <div class="container-fluid">
      <i class="bx bx-menu fs-2 text-white" style="cursor: pointer"></i>
      <div>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown"> 
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                 <img src="{{ session('profile_picture') }}" alt="Profile" class="rounded-circle img-fluid" width="30">
                  <span class="d-none d-md-block dropdown-toggle ps-2">{{ session('nama_lengkap') }}</span> 
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
                        <a class="dropdown-item d-flex align-items-center" href="/logout?email={{ session('email') }}">
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