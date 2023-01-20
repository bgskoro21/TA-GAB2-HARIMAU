@extends('layout.main')
@section('container')
{{-- @php
    var_dump($presentase);die;
    // echo session('nama_lengkap')
@endphp --}}
<section class="mt-3 mx-3">
  <div class="row">
    <div class="col-md-8">
        <section>
          <div class="row">
              <!-- Sales Card -->
              <div class="col mb-2">
                <div class="card info-card sales-card bg-dark text-white p-2">
                  <div class="card-body">
                    <div class="row">
                        <div class="col-8">
                            <h6 class="card-title">Saldo <span id="saldo_filter">| Today</span></h6>
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
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center p-2" style="background-color: rgb(174, 212, 212)">
                        <i class='bx bx-cart fs-1 text-success' ></i>
                      </div>
                      <div class="ps-3">
                        <h2 id="saldo">@currency($saldo->saldo)</h2>
                        @if (isset($presentase_saldo->presentase))
                        @if ($presentase_saldo->presentase >= 0)
                        <span class="text-success small pt-1 fw-bold" id="presentase_saldo">{{ number_format($presentase_saldo->presentase,2,'.','') }}%</span> 
                        <span class="small pt-2 ps-1 text-white" id="ket_saldo">increase</span>
                        @else 
                        <span class="text-danger small pt-1 fw-bold" id="presentase_saldo">{{ number_format($presentase_saldo->presentase,2,'.','') }}%</span> 
                        <span class="small pt-2 ps-1 text-white" id="ket_saldo">decrease</span>
                        @endif
                        @else
                        @if ($saldo->saldo != 0)
                        <span class="text-success small pt-1 fw-bold" id="presentase_saldo">100.00%</span> <span class="small pt-2 ps-1 text-white" id="ket_saldo">increase</span>
                        @else
                        <span class="text-success small pt-1 fw-bold" id="presentase_saldo">0%</span> <span class="small pt-2 ps-1 text-white" id="ket_saldo">increase</span>
                        @endif
                        @endif
                      </div>
                    </div>
                  </div>
  
                </div>
              </div>
            </div><!-- End Sales Card -->

          <div class="row">
                      <div class="col-xxl-6 col-md-6 mb-2">
                          <div class="card info-card sales-card bg-dark text-white p-2">
                            <div class="card-body">
                              <div class="row">
                                  <div class="col-8">
                                      <h6 class="card-title">Masuk <span id="masuk_filter">| Today</span></h6>
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
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center p-2" style="background-color: rgb(219, 210, 168)">
                                  <i class='bx bx-dollar fs-1' style="color: rgb(179, 143, 28)" ></i>
                                </div>
                                <div class="ps-3">
                                  <h2 id="pemasukkan">@currency($pemasukkan_hari->pemasukan)</h3>
                                  @if (isset($presentase_pendapatan->presentase))
                                  @if ($presentase_pendapatan->presentase > 0)
                                  <span class="text-success small pt-1 fw-bold" id="presentase_pemasukkan">{{ number_format($presentase_pendapatan->presentase,2,'.','') }}%</span>
                                  <span class="small pt-2 ps-1 text-white" id="ket_pemasukkan">increase</span>
                                  @else
                                  <span class="text-danger small pt-1 fw-bold" id="presentase_pemasukkan">{{ number_format($presentase_pendapatan->presentase,2,'.','') }}%</span>
                                  <span class="small pt-2 ps-1 text-white" id="ket_pemasukkan">decrease</span>
                                  @endif
                                  @else
                                  @if ($pemasukkan_hari->pemasukan != 0)
                                  <span class="text-success small pt-1 fw-bold" id="presentase_saldo">100.00%</span> <span class="small pt-2 ps-1 text-white" id="ket_saldo">increase</span>
                                  @else
                                  <span class="text-success small pt-1 fw-bold" id="presentase_saldo">0%</span> <span class="small pt-2 ps-1 text-white" id="ket_saldo">increase</span>
                                  @endif
                                  @endif
                                </div>
                              </div>
                            </div>
            
                          </div>
                        </div><!-- End Sales Card -->

                      <div class="col-xxl-6 col-md-6 mb-2">
                          <div class="card info-card sales-card bg-dark text-white p-2">
                            <div class="card-body">
                              <div class="row">
                                  <div class="col-8">
                                      <h6 class="card-title">Keluar <span id="keluar_filter">| Today</span></h6>
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
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center p-2" style="background-color: rgb(233, 186, 186)">
                                  <i class='bx bx-minus fs-1 text-danger'></i>
                                </div>
                                <div class="ps-3">
                                  <h2 id="pengeluaran">@currency($pengeluaran->pengeluaran)</h2>
                                  @if (isset($presentase_pengeluaran->presentase))
                                    @if ($presentase_pengeluaran->presentase < 0)
                                    <span class="text-danger small pt-1 fw-bold" id="presentase_pengeluaran">{{ number_format($presentase_pengeluaran->presentase,2,'.','') }}%</span> 
                                    <span class="small pt-2 ps-1 text-white" id="ket_pengeluaran">decrease</span>
                                    @else
                                    <span class="text-success small pt-1 fw-bold" id="presentase_pengeluaran">{{ number_format($presentase_pengeluaran->presentase,2,'.','') }}%</span> 
                                    <span class="small pt-2 ps-1 text-white" id="ket_pengeluaran">increase</span>
                                    @endif
                                  @else
                                  @if ($pengeluaran->pengeluaran != 0)
                                  <span class="text-success small pt-1 fw-bold" id="presentase_saldo">100.00%</span> <span class="small pt-2 ps-1 text-white" id="ket_saldo">increase</span>
                                  @else
                                  <span class="text-success small pt-1 fw-bold" id="presentase_saldo">0%</span> <span class="small pt-2 ps-1 text-white" id="ket_saldo">increase</span>
                                  @endif
                                  @endif
                                </div>
                              </div>
                            </div>
            
                          </div>
                        </div><!-- End Sales Card -->
          </div>
      </section>
      <section class="p-3 mb-2">
          <div class="row">
              <div class="col-md-12 bg-dark p-3 radius">
                  <canvas id="grafik" style="width: 100%;"></canvas>
              </div>
          </div>
      </section>
    </div>
    <div class="col-md-4">
      <div class="row d-flex flex-column">
        {{-- QRCode Hari ini --}}
        <div class="col mb-2">
          <div class="card text-white bg-dark">
            <div class="card-header">
              <span class="d-block">QR Code | This Day</span>
              <span class="text-muted">{{ \Custom::format_indo(date('Y-m-d')) }}</span>
            </div>
            <div class="card-body">
              @if ($waktu != null)
              <div class="d-flex justify-content-center align-items-center">
              <img src="{{ asset('storage/qr-code/harian/img-'.$waktu.'.png') }}" alt="" width="200">
            </div>  
              @else
              <div class="d-flex justify-content-center align-items-center">
                <span>Belum ada transaksi hari ini</span>
              </div>
              @endif
            </div>
          </div>
        </div>
        {{-- Pemasukkan Terakhir --}}
        <div class="col mb-2">
          <ul class="list-group">
                <li class="list-group-item bg-dark text-white">
                  <div class="row">
                    <div class="col-8 d-flex align-items-center">
                      Pemasukkan Terbaru
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                      <a class="btn btn-sm btn-show-all btn-tambah" href="/pemasukkan/tambahdata"><i class='bx bx-plus-circle text-white fs-5'></i></a>
                    </div>
                </li>
                @if ($pemasukkan->pendapatan)
                @foreach (array_slice(array_reverse($pemasukkan->pendapatan),0,3) as $p)
                <li class="list-group-item bg-dark text-white">
              <div class="row">
                <div class="col-2 d-flex align-items-center">
                  <div class="bg-white rounded-circle p-1">
                    <img src="{{ $p->profile_picture }}" alt="Foto" class="img-fluid rounded-circle" style="width:30px; height:e0px;">
                  </div>
                </div>
                <div class="col-6 d-flex flex-column justify-content-center">
                  <span style="font-size: 14px;">{{ $p->perincian }}</span>
                  <span style="font-size:14px;" class="text-muted">{{ \Custom::format_indo($p->waktu_transaksi) }}</span>
                </div>
                <div class="col-4 d-flex align-items-center">
                  <span>@currency($p->pemasukan)</span>
                </div>
              </div>
            @endforeach
            @else
              <div class="d-flex bg-dark text-white align-items-center justify-content-center p-2">
                <span>Belum ada transaksi!</span>
              </div>
            @endif
          </li>
          @if ($pemasukkan->pendapatan)
          <li class="list-group-item bg-dark text-white">
            <div class="d-flex align-items-center justify-content-center">
              <a class="btn text-center w-100 btn-show-all text-white btn-semua" href="/pemasukkan">Lihat semua</a>
            </div>
          </li>
          @endif
          </ul>
        </div>
        {{-- Pengeluaran Terakhir --}}
        <div class="col mb-2">
          <ul class="list-group">
                <li class="list-group-item bg-dark text-white">
                  <div class="row">
                    <div class="col-8 d-flex align-items-center">
                      Pengeluaran Terbaru
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                      <a class="btn btn-sm btn-show-all btn-tambah" href="/pengeluaran/tambahdata"><i class='bx bx-plus-circle fs-5 text-white'></i></a>
                    </div>
                </li>
                @if ($pengeluaran_h->pengeluaran)
                @foreach (array_slice(array_reverse($pengeluaran_h->pengeluaran),0,3) as $p)
                <li class="list-group-item bg-dark text-white">
              <div class="row">
                <div class="col-2 d-flex align-items-center">
                  <div class="bg-white rounded-circle p-1">
                    <img src="{{ $p->profile_picture }}" alt="Foto" class="img-fluid rounded-circle" style="width:30px; height:e0px;">
                  </div>
                </div>
                <div class="col-6 d-flex flex-column justify-content-center">
                  <span style="font-size: 14px;">{{ $p->perincian }}</span>
                  <span style="font-size:14px;" class="text-muted">{{ \Custom::format_indo($p->waktu_transaksi) }}</span>
                </div>
                <div class="col-4 d-flex align-items-center">
                  <span>@currency($p->pengeluaran)</span>
                </div>
              </div>
            @endforeach
            @else
              <div class="d-flex bg-dark text-white align-items-center justify-content-center p-2">
                <span>Belum ada transaksi!</span>
              </div>
              @endif
          </li>
          @if (isset($pengeluaran_h->pengeluaran))
          <li class="list-group-item bg-dark text-white">
            <div class="d-flex align-items-center justify-content-center">
              <a class="btn text-white text-center w-100 btn-show-all btn-semua" href="/pengeluaran">Lihat semua</a>
            </div>
          </li>
          @endif
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="mx-3 mb-3 bg-dark p-4 overflow-auto radius text-white">
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
          // console.log(result.presentase)
          if(result.saldo.hasOwnProperty('result')){
            location.href = '/expToken'
          }
          $('#saldo_filter').html('| '+result.title)

          if(result.saldo.saldo == null){
            $('#saldo').html('Rp. 0')
            $('#presentase_saldo').html('0%')
            $('#ket_saldo').text('increase')
          }else{
            $('#saldo').html(formatRupiah(result.saldo.saldo, 'Rp. '))
          }

          if(result.presentase.hasOwnProperty('presentase')){
            if(result.presentase.presentase >= 0){
              if($('#presentase_saldo').hasClass('text-danger')){
                $('#presentase_saldo').removeClass('text-danger')
                $('#presentase_saldo').addClass('text-success')
                $('#ket_saldo').text('increase')
              }
            }else{
              if($('#presentase_saldo').hasClass('text-success')){
                $('#presentase_saldo').removeClass('text-success')
                $('#presentase_saldo').addClass('text-danger')
                $('#ket_saldo').text('decrease')
              }
            }
            $('#presentase_saldo').html(result.presentase.presentase.toFixed(2)+'%')
          }else{
            if($('#presentase_pemasukkan').hasClass('text-danger')){
              $('#presentase_pemasukkan').removeClass('text-danger')
              $('#presentase_pemasukkan').addClass('text-success')
              $('#ket_pemasukkan').text('increase')
            }
              $('#presentase_pengeluaran').html('100.00%')
              $('#presentase_pengeluaran').html('0%')
              $('#ket_pengeluaran').text('increase')
          }
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
            $('#presentase_pemasukkan').html('0%')
            $('#ket_pemasukkan').text('increase')
          }else{
            $('#pemasukkan').html(formatRupiah(result.pemasukkan.pemasukan, 'Rp. '))
          }

          if(result.presentase.hasOwnProperty('presentase')){
            if(result.presentase.presentase >= 0){
              if($('#presentase_pemasukkan').hasClass('text-danger')){
                $('#presentase_pemasukkan').removeClass('text-danger')
                $('#presentase_pemasukkan').addClass('text-success')
                $('#ket_pemasukkan').text('increase')
              }
            }else{
              if($('#presentase_pemasukkan').hasClass('text-success')){
                $('#presentase_pemasukkan').removeClass('text-success')
                $('#presentase_pemasukkan').addClass('text-danger')
                $('#ket_pemasukkan').text('decrease')
              }
            }
            $('#presentase_pemasukkan').html(result.presentase.presentase.toFixed(2)+'%')
          }else{
            if($('#presentase_pemasukkan').hasClass('text-danger')){
              $('#presentase_pemasukkan').removeClass('text-danger')
              $('#presentase_pemasukkan').addClass('text-success')
              $('#ket_pemasukkan').text('increase')
            }
              $('#presentase_pemasukkan').html('100.00%')
              $('#ket_pemasukkan').text('increase')
          }
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
          }else{
            $('#pengeluaran').html(formatRupiah(result.pengeluaran.pengeluaran, 'Rp. '))
          }

          if(result.presentase.hasOwnProperty('presentase')){
            if(result.presentase.presentase >= 0){
              if($('#presentase_pengeluaran').hasClass('text-danger')){
                $('#presentase_pengeluaran').removeClass('text-danger')
                $('#presentase_pengeluaran').addClass('text-success')
                $('#ket_pengeluaran').text('increase')
              }
            }else{
              if($('#presentase_pengeluaran').hasClass('text-success')){
                $('#presentase_pengeluaran').removeClass('text-success')
                $('#presentase_pengeluaran').addClass('text-danger')
                $('#ket_pengeluaran').text('decrease')
              }
            }
            $('#presentase_pengeluaran').html(result.presentase.presentase.toFixed(2)+'%')
          }else{
            if($('#presentase_pengeluaran').hasClass('text-danger')){
              $('#presentase_pengeluaran').removeClass('text-danger')
              $('#presentase_pengeluaran').addClass('text-success')
              $('#ket_pengeluaran').text('increase')
            }
              $('#presentase_pengeluaran').html('100.00%')
              $('#ket_pengeluaran').text('increase')
          }
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