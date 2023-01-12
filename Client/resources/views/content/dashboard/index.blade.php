@extends('layout.main')
@section('container')
{{-- @php
    // var_dump($keuntungan)
    echo session('nama_lengkap')
@endphp --}}
<section class="mt-3 mx-3">
    <div class="row">
                   <!-- Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card bg-dark text-white">
                      <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title">Saldo <span id="saldo_filter">| Today</span></h5>
                            </div>
                            <div class="col-4">
                                <div class="filter d-flex justify-content-end">
                                    <a class="text-white" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded'></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                      <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                      </li>
                                      <li><button class="dropdown-item btn-today" onclick="return getSaldo(event)">Today</button></li>
                                      <li><button class="dropdown-item btn-month" onclick="return getSaldo(event)">This Month</button></li>
                                      <li><button class="dropdown-item btn-year" onclick="return getSaldo(event)">This Year</button></li>
                                    </ul>
                                  </div>
                            </div>
                        </div>
      
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center p-2" style="background-color: rgb(187, 190, 190)">
                            <i class='bx bx-cart fs-1' ></i>
                          </div>
                          <div class="ps-3">
                            <h3 id="saldo">@currency($saldo->saldo)</h3>
                            <span class="text-success small pt-1 fw-bold">12%</span> <span class="small pt-2 ps-1 text-white">increase</span>
                          </div>
                        </div>
                      </div>
      
                    </div>
                </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card bg-dark text-white">
                      <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title">Masuk <span id="masuk_filter">| Today</span></h5>
                            </div>
                            <div class="col-4">
                                <div class="filter d-flex justify-content-end">
                                    <a class="text-white" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded'></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                      <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                      </li>
                                      <li><button class="dropdown-item" onclick="return getPemasukkan(event)">Today</button></li>
                                      <li><button class="dropdown-item" onclick="return getPemasukkan(event)">This Month</button></li>
                                      <li><button class="dropdown-item" onclick="return getPemasukkan(event)">This Year</button></li>
                                    </ul>
                                  </div>
                            </div>
                        </div>
      
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center p-2" style="background-color: rgb(187, 190, 190)">
                            <i class='bx bx-dollar fs-1' ></i>
                          </div>
                          <div class="ps-3">
                            <h3 id="pemasukkan">@currency($pemasukkan_hari->pemasukan)</h3>
                            <span class="text-success small pt-1 fw-bold">12%</span> <span class="small pt-2 ps-1 text-white">increase</span>
                          </div>
                        </div>
                      </div>
      
                    </div>
                  </div><!-- End Sales Card -->
                <div class="col-xxl-4 col-md-4">
                    <div class="card info-card sales-card bg-dark text-white">
                      <div class="card-body">
                        <div class="row">
                            <div class="col-8">
                                <h5 class="card-title">Keluar <span id="keluar_filter">| Today</span></h5>
                            </div>
                            <div class="col-4">
                                <div class="filter d-flex justify-content-end">
                                    <a class="text-white" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded'></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                      <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                      </li>
                                      <li><button class="dropdown-item" onclick="return getPengeluaran(event)">Today</button></li>
                                      <li><button class="dropdown-item" onclick="return getPengeluaran(event)">This Month</button></li>
                                      <li><button class="dropdown-item" onclick="return getPengeluaran(event)">This Year</button></li>
                                    </ul>
                                  </div>
                            </div>
                        </div>
      
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center p-2" style="background-color: rgb(187, 190, 190)">
                            <i class='bx bx-cart fs-1' ></i>
                          </div>
                          <div class="ps-3">
                            <h3 id="pengeluaran">@currency($pengeluaran->pengeluaran)</h3>
                            <span class="text-success small pt-1 fw-bold">12%</span> <span class="small pt-2 ps-1 text-white">increase</span>
                          </div>
                        </div>
                      </div>
      
                    </div>
                  </div><!-- End Sales Card -->
    </div>
</section>
<section class="mx-3 p-3">
    <div class="row">
        <div class="col-md-12 bg-dark p-3 radius">
            <canvas id="grafik"></canvas>
        </div>
    </div>
</section>
<section class="mb-3 mx-3 bg-dark p-4 overflow-auto radius text-white">
    <h4 class="mb-2">Transaksi Terakhir</h4>
    <table class="table table-bordered table-responsive border text-white" id="table_transaksi">
            <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Waktu</th>
                        <th scope="col" class="text-center">Perincian</th>
                        <th scope="col" class="text-center">Pemasukkan</th>
                        <th scope="col" class="text-center">Pengeluaran</th>
                        <th scope="col" class="text-center">Saldo</th>
                    </tr>
            </thead>
            <tbody>
              @if ($transaksi != 0)
                @php
                    $saldo = 0
                @endphp
                @foreach ($transaksi as $t)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{  \Custom::format_indo($t->waktu_transaksi) }}</td>
                    <td>{{ $t->perincian }}</td>
                    <td>@currency($t->pemasukan)</td>
                    <td>@currency($t->pengeluaran)</td>
                    <td>@currency($saldo += $t->pemasukan - $t->pengeluaran)</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
@section('script')
<script type="text/javascript">
      $(document).ready( function () {
        $('#table_transaksi').DataTable();
    });
      let dataPemasukkan = {{ Js::from($keuntungan) }} ;
      let dataBulan = {{ Js::from($bulan) }};
    //   console.log(dataPemasukkan);
      const pemasukkanBulan = [];
      const bulan = [];
      for (var i in dataBulan) {
        bulan.push(dataBulan[i].bulan);
      }
      for (var i in dataPemasukkan) {
        pemasukkanBulan.push(dataPemasukkan[i].Keuntungan);
      }

      const data = {
        labels: bulan,
        datasets: [{
          label: 'Keuntungan Perbulan',
          backgroundColor: 'white',
          borderColor: 'white',
          color: 'white',
          data: pemasukkanBulan
        }]
      };
  
      const config = {
        type: 'line',
        data: data,
        options: {
          plugins: {
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    font: {
                        size: 16
                    },
                    color : 'white'                    
                },
            },
            title: {
                display: true,
                text: 'Grafik Keuntungan',
                padding: {
                    top: 10,
                    bottom: 30
                },
                font: {
                        size: 22,
                },
                color : 'white',
                align: 'start'
            },
        },
        },
      };

      const myChart = new Chart(
        document.getElementById('grafik'),
        config
      );

      function getSaldo(e){
        keyword = $(e.target).text()
        fetch('/getSaldo?keyword='+keyword)
        .then(response => response.json())
        .then(result => {
          if(result.saldo.hasOwnProperty('result')){
            location.href = '/expToken'
          }
          $('#saldo_filter').html('| '+result.title)
          if(result.saldo.saldo == null){
            $('#saldo').html('Rp. 0')
          }
          $('#saldo').html(formatRupiah(result.saldo.saldo, 'Rp. '))
        });
      }

      function getPemasukkan(e){
        keyword = $(e.target).text()
        fetch('/getPemasukkan?keyword='+keyword)
        .then(response => response.json())
        .then(result => {
          if(result.pemasukkan.hasOwnProperty('result')){
            location.href = '/expToken'
          }
          // console.log(result.pemasukkan)
          $('#masuk_filter').html('| '+result.title)
          if(result.pemasukkan.pemasukan == null){
            $('#pemasukkan').html('Rp. 0')
          }
          $('#pemasukkan').html(formatRupiah(result.pemasukkan.pemasukan, 'Rp. '))
        });
      }

      function getPengeluaran(e){
        keyword = $(e.target).text()
        // console.log(keyword)
        fetch('/getPengeluaran?keyword='+keyword)
        .then(response => response.json())
        .then(result => {
          if(result.pengeluaran.hasOwnProperty('result')){
            location.href = '/expToken'
          }
          // console.log(result.pengeluaran)
          $('#keluar_filter').html('| '+result.title)
          if(result.pengeluaran.pengeluaran == null){
            $('#pengeluaran').html('Rp. 0')
          }
          $('#pengeluaran').html(formatRupiah(result.pengeluaran.pengeluaran, 'Rp. '))
        });
      }

      	/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
		}
</script>
@endsection