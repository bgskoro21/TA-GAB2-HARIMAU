@extends('layout.main')
@section('container')
<section class="m-3 px-3">
    <div class="row bg-dark text-white radius p-2">
        <div class="col-md-8 d-flex align-items-center">
            <h4>{{ $title }}</h4>
        </div>
        <div class="col-md-4 d-lg-flex d-sm-iniline-block justify-content-end align-items-center">
            @if (isset($transaksi->searching))
            <button class="btn  btn-dang btn-sm text-end me-1 text-white" id="btn-pdf"><i class='bx bxs-file-pdf'></i></button>
            <button class="btn  btn-suc btn-sm text-end me-1 text-white" id="btn-qr"><i class='bx bx-grid-alt' ></i></button>
            @else
            <button class="btn  btn-dang btn-sm text-end me-1 text-white" disabled><i class='bx bxs-file-pdf'></i></button>
            <button class="btn  btn-suc btn-sm text-end me-1 text-white" disabled><i class='bx bx-grid-alt' ></i></button>
            @endif
            <button class="btn btn-show-all btn-sm text-end text-white" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class='bx bx-search-alt-2' ></i></button>
        </div>
    </div>
    <div class="row bg-dark text-white rounded-bottom rounded-top p-2 overflow-auto">
        <div class="col">
            <h3 style="text-align: center;" class="mt-2">Arus Kas Keluar Masuk</h3>
            <p style="text-align: center;">Periode : {{ $waktu }}</p>
            <table width="100%" class="table table-bordered table-responsive text-white">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Perincian</th>
                        <th class="text-center">Pemasukkan</th>
                        <th class="text-center">Pengeluaran</th>
                        <th class="text-center">Saldo</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($transaksi->searching))
                    <?php 
                    $no = 1;
                    $saldo = 0;
                    $pemasukkan = 0;
                    $pengeluaran = 0;
                    ?>
                    <?php foreach($transaksi->searching as $t): ?>
                    <tr>
                        <td class="text-center"><?php echo $no  ?></td>
                        <td><?php echo $t->perincian ?></td>
                        <td>@currency($t->pemasukan)</td>
                        <td>@currency($t->pengeluaran)</td>
                        <td>@currency($saldo += $t->pemasukan - $t->pengeluaran)</td> 
                        <?php $pemasukkan += $t->pemasukan ?>
                        <?php $pengeluaran += $t->pengeluaran ?>
                    </tr>
                    <?php $no++ ?>
                    <?php endforeach ?>
                    <tr>
                        <th colspan="2" class="text-center">TOTAL</th>
                        <td>@currency($pemasukkan)</td>
                        <td>@currency($pengeluaran)</td>
                        <td>@currency($saldo)</td>
                    </tr>
                    @else
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada transaksi!</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>  
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content bg-dark text-white">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukkan</h5>
          <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form action="/laporan/umum" method="post" id="form_pemasukkan">   
            <input type="hidden" name="id" id="id">    
            @csrf    
              <div class="form-floating mb-3">
                  <input type="date" class="form-control" id="tanggal_awal" name="tanggal_awal" required>
                  <label for="tanggal_awal"  class="text-dark">Tanggal Awal</label>
              </div>
              <div class="form-floating mb-3">
                  <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" required>
                  <label for="tanggal_akhir"  class="text-dark">Tanggal Akhir</label>
              </div>
        </div>
        <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Cari</button>
          </form>
        </div>
      </div>
    </div>
</div>  
@endsection
@section('script')
<script>
    const tanggal_awal = {{ Js::from($tanggal_awal) }}
    const tanggal_akhir = {{ Js::from($tanggal_akhir) }}
    $('#btn-pdf').on('click',function(){
        location.href = '/laporan/umum/pdf?tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir
    })
    $('#btn-qr').on('click',function(){
        location.href = '/laporan/umum/qrcode?tanggal_awal='+tanggal_awal+'&tanggal_akhir='+tanggal_akhir
    })
</script>
@endsection