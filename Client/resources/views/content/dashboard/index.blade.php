@extends('layout.main')
@section('container')
{{-- @php
    // var_dump($keuntungan)
    echo session('nama_lengkap')
@endphp --}}
<section class="mt-3 mx-3">
    <div class="row">
        <div class="col-md-4">
        {{-- <div class="card text-white bg-white mb-3">
            <div class="card-body d-flex justify-content-center text-dark flex-column">
                <h5 class="card-title">Saldo</h5>
                <h2>@currency($saldo->saldo)</h2>
                <p>{{ \Custom::format_indo(date('Y-m-d')) }}</p>
            </div>
        </div> --}}
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-white mb-3">
                <div class="card-body d-flex justify-content-center text-dark flex-column">
                    <h5 class="card-title">Pemasukkan</h5>
                    <h2>@currency($pemasukkan_bulan->Total_bulan)</h2>
                    <p>Bulan Ini</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-white mb-3">
                <div class="card-body d-flex justify-content-center text-dark flex-column">
                    <h5 class="card-title">Pengeluaran</h5>
                    <h2>@currency($pengeluaran_bulan->Total_bulan)</h2>
                    <p>Bulan Ini</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="mb-3 mx-3 p-3">
    <div class="row">
        <div class="col-md-12 bg-white p-3 radius">
            <canvas id="grafik"></canvas>
        </div>
    </div>
</section>
{{-- <section class="m-3 bg-white p-4 overflow-auto radius">
    <h4 class="mb-2">Transaksi Terakhir</h4>
    <table class="table table-bordered table-responsive border" id="table_transaksi">
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
                @php
                    $saldo = 0
                @endphp
                @foreach ($transaksi as $t)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{  \Custom::format_indo($t->waktu_transaksi) }}</td>
                    <td>{{ $t->perincian }}</td>
                    <td>@currency($t->pemasukkan)</td>
                    <td>@currency($t->pengeluaran)</td>
                    <td>@currency($saldo += $t->pemasukkan - $t->pengeluaran)</td>
                </tr>
                @endforeach
            </tbody>
        </table>
</section> --}}
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
          backgroundColor: 'black',
          borderColor: 'black',
          data: pemasukkanBulan
        }]
      };
  
      const config = {
        type: 'bar',
        data: data,
        options: {
          plugins: {
            legend: {
                labels: {
                    // This more specific font property overrides the global property
                    font: {
                        size: 16
                    },                    
                },
            },
            customCanvasBackgroundColor: {
                    color: 'black',
                },
            title: {
                display: true,
                text: 'Grafik Keuntungan',
                padding: {
                    top: 10,
                    bottom: 30
                },
                font: {
                        size: 22
                },
                align: 'start'
            }
        },
          animations: {
          tension: {
            duration: 1000,
            easing: 'linear',
            from: 1,
            to: 0,
            loop: true
          }
        }
        },
      };

      const myChart = new Chart(
        document.getElementById('grafik'),
        config
      );
</script>
@endsection