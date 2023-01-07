<div class="sidebar">
    <div class="logo-details">
        <img src="https://cdn.freebiesupply.com/logos/large/2x/codeigniter-logo-png-transparent.png" alt="Eyzel" width="50" >
        <span class="logo_name">EyzelKas</span>
    </div>
    <ul class="nav-links">
        <li class="{{ Request::is('/') ? 'aktif' : '' }}">
            <a href="/">
                <i class="bx bx-grid-alt"></i>
                <span class="name_link">Beranda</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="name_link" href="/">Beranda</a></li>
            </ul>
        </li>
        {{-- @if (session('level') == 'Admin') --}}
        <li class="{{ Request::is('user*') ? 'aktif' : '' }}">
            <a href="/user">
                <i class='bx bx-user'></i>
                <span class="name_link">Daftar User</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="name_link" href="/user">Daftar User</a></li>
            </ul>
        </li>
        {{-- @endif --}}
        <li class= "{{Request::is('pemasukkan*') || Request::is('pengeluaran*')  ? 'aktif' : '' }}">
            <div class="iocn-link">
                <a href="#">
                    <i class='bx bx-book-bookmark'></i>
                    <span class="name_link">Transaksi</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a href="/pemasukkan">Kas Masuk</a></li>
                <li><a href="/pengeluaran">Kas Keluar</a></li>
            </ul>
        </li>
        @if (Request::is('laporan*') || Request::is('laporanbulanan*'))
        <li class= "aktif">
        @else
        <li>
        @endif
            <div class="iocn-link">
                <a href="#">
                    <i class="bx bx-collection"></i>
                    <span class="name_link">Laporan Kas</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a href="/laporan?waktu=harian">Laporan Harian</a></li>
                <li><a href="/laporan?waktu=bulanan">Laporan Bulanan</a></li>
            </ul>
        </li>
        <li>
            <div class="d-flex justify-content-evenly profile-details">
                <div class="col-md-3">
                    <div class="profile-content">
                        <img src="{{ session('profile_picture') }}" alt="Profile" class="img-fluid img-thumbnail rounded-circle">
                    </div>
                </div>
                <div class="col-md-6 ms-1">
                    <div class="name-job">
                        <div class="profile_name">{{ session('nama_lengkap') }}</div>
                        <div class="job">{{ session('level') }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <button onclick="setLogout()" type="submit"><i class="bx bx-log-out fs-3"></i></button>
                </div>
            </div>
        </li>
    </ul>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script>
    function setLogout(){
        Swal.fire({
          title: 'Apakah kamu ingin logout?',
          showDenyButton: true,
          confirmButtonText: 'Ya',
          denyButtonText: `Tidak`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/logout'
          } else if (result.isDenied) {
            return false;
          }
        })
      }
</script>
