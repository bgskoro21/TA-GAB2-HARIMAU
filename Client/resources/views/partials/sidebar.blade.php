<div class="sidebar close">
    <div class="logo-details">
        <img src="../../img/eyzel.png" alt="Eyzel" width="50" >
        <span class="logo_name" style="flex: 1">EyzelKas</span>
        <i class='bx bx-arrow-back bg-white d-lg-none text-dark fs-3 btn-tutup'></i>
    </div>
    <ul class="nav-links">
        <li class="{{ Request::is('/') ? 'aktif' : '' }}">
            <div class="iocn-link">
                <a href="/">
                    <i class="bx bx-grid-alt"></i>
                    <span class="name_link">Beranda</span>
                </a>
            </div>
            <ul class="sub-menu">
                <li><a class="name_link" href="/">Beranda</a></li>
            </ul>
        </li>
        @if (session('level') == 'Admin')
        <li class="{{ Request::is('user*') ? 'aktif' : '' }}">
            <div class="iocn-link">
                <a href="/user">
                    <i class='bx bx-user'></i>
                    <span class="name_link">Daftar User</span>
                </a>
            </div>
            <ul class="sub-menu">
                <li><a class="name_link" href="/user">Daftar User</a></li>
            </ul>
        </li>
        @endif
        <li class= "{{Request::is('hutang*') ? 'aktif' : '' }}">
            <div class="iocn-link">
                <a href="/hutang">
                    <i class='bx bx-archive-out'></i>
                    <span class="name_link">Hutang Piutang</span>
                </a>
            </div>
            <ul class="sub-menu">
                <li><a href="/hutang">Hutang Piutang</a></li>
            </ul>
        </li>
        <li class= "{{Request::is('pemasukkan*') || Request::is('pengeluaran*')  ? 'aktif' : '' }}">
            <div class="iocn-link">
                <a href="/pemasukkan">
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
        <li class= "{{Request::is('laporan*') ? 'aktif' : '' }}">
            <div class="iocn-link">
                <a href="/laporan/umum">
                    <i class="bx bx-collection"></i>
                    <span class="name_link">Laporan Kas</span>
                </a>
                <i class="bx bxs-chevron-down arrow"></i>
            </div>
            <ul class="sub-menu">
                <li><a href="/laporan/umum">Laporan Kas Umum</a></li>
                <li><a href="/laporan?waktu=harian">Laporan Harian</a></li>
                <li><a href="/laporan?waktu=bulanan">Laporan Bulanan</a></li>
            </ul>
        </li>
        <li>
            <div class="profile-details">
                    <div class="profile-content">
                        <img src="{{ session('profile_picture') }}" alt="Profile" class="img-fluid img-thumbnail rounded-circle">
                    </div>
                    <div class="name-job">
                        <div class="profile_name">{{ session('nama_lengkap') }}</div>
                        <div class="job">{{ session('level') }}</div>
                    </div>
                    <button onclick="setLogout('{{ session('email') }}')" type="submit"><i class="bx bx-log-out fs-3"></i></button>
                </div>
        </li>
    </ul>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script>
    function setLogout(email){
        Swal.fire({
          title: 'Apakah kamu ingin logout?',
          showDenyButton: true,
          confirmButtonText: 'Ya',
          denyButtonText: `Tidak`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/logout?email='+email
          } else if (result.isDenied) {
            return false;
          }
        })
      }
</script>
