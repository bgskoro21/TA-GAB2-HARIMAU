@extends('layout.main')
@section('container')
    <section class="m-3 bg-dark radius p-4 text-white">
        <div class="row">
            <div class="col-md-8">
                <h1 class="mb-3">Daftar Hutang</h1>
            </div>
            <div class="col-md-4 d-flex justify-content-end align-items-center">
                <button class="btn btn-show-all text-white btn-sm btn-tambah" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class='bx bx-plus-circle fs-5'></i></button>
            </div>
        </div>
        <table class="table table-bordered table-responsive border overflow-hidden text-white" id="table_pemasukkan">
            <thead>
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col" class="text-center">Kode Hutang</th>
                        <th scope="col" class="text-center">Nama</th>
                        <th scope="col" class="text-center">Perincian</th>
                        <th scope="col" class="text-center">Tanggal Hutang</th>
                        <th scope="col" class="text-center">Jatuh Tempo</th>
                        <th scope="col" class="text-center">Total Hutang</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
            </thead>
            <tbody id="body_data">
                @if (isset($hutang->hutang))
                @foreach ($hutang->hutang as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{  $p->kode_hutang }}</td>
                    <td>{{  $p->nama_pelanggan }}</td>
                    <td>{{  $p->perincian }}</td>
                    <td>{{  \Custom::format_indo($p->tgl_transaksi) }}</td>
                    <td>{{  \Custom::format_indo($p->tgl_tempo) }}</td>
                    <td>@currency($p->total_hutang)</td>
                    <td class="fw-bold">
                        @if ($p->status != 'Lunas')
                        <button class="btn btn-show-all text-white btn-sm" onclick="setUpdate('{{ $p->kode_hutang }}')">Lunaskan</button>
                        @else
                        <span class="text-success text-center">{{ $p->status }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($p->user_id == session('id'))
                        <button class="btn btn-suc text-white btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $p->id }}"><i class='bx bx-edit'></i></button>
                        <button type="submit" onclick="setDelete({{ $p->id }})" class="btn btn-dang text-white btn-sm"><i class='bx bx-trash'></i></button>
                        @else
                        <i class="text-muted">Forbidden</i>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </section>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content bg-dark text-white">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukkan</h5>
              <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <form action="/hutang" method="post" id="form_hutang">   
                <input type="hidden" name="id" id="id">    
                @csrf    
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="kode_hutang" name="kode_hutang" id="input_kode_hutang">
                    <label for="input_kode_hutang" class="text-dark">Kode Hutang</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="nama_pelanggan" name="nama_pelanggan" id="input_nama_pelanggan">
                    <label for="input_nama_pelanggan" class="text-dark">Nama Pelanggan</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="no_hp" name="no_hp" id="input_no_hp">
                    <label for="input_no_hp" class="text-dark">Nomor Handphone</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" placeholder="total_hutang" name="total_hutang" id="input_total_hutang">
                    <label for="input_total_hutang" class="text-dark">Total Hutang</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="perincian" name="perincian" id="input_perincian">
                    <label for="input_perincian" class="text-dark">Perincian</label>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="tgl_transaksi" placeholder="Tanggal Hutang" name="tgl_transaksi">
                            <label for="tgl_transaksi"  class="text-dark">Tanggal Hutang</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="tgl_tempo" placeholder="Waktu Transaksi" name="tgl_tempo">
                            <label for="tgl_tempo"  class="text-dark">Jatuh Tempo</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </form>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready( function () {
        $('#table_pemasukkan').DataTable();})

        function setDelete(id){
        Swal.fire({
          title: 'Apakah kamu yakin?',
          showDenyButton: true,
          confirmButtonText: 'Delete',
          denyButtonText: `Cancel`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/hutang/hapus_data/'+id
          } else if (result.isDenied) {
            return false;
          }
        })
      }

      function setUpdate(kode){
        Swal.fire({
          title: 'Apakah kamu yakin melunaskan hutang ini?',
          showDenyButton: true,
          confirmButtonText: 'Yakin',
          denyButtonText: `Tidak`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/hutang/lunas/'+kode
            // console.log(kode)
          } else if (result.isDenied) {
            return false;
          }
        })
      }

      $('.btn-edit').on('click', function(){
        $('#exampleModalLabel').html('Ubah Data Hutang')
        $('.modal-footer button[type=submit]').html('Simpan Perubahan')
        const id = $(this).data('id')
        $('.modal-body form').attr('action','/hutang/edit_data')

        $.ajax({
        url: '/hutang/'+id,
        success: function(data){
            const json = JSON.parse(data)
            $('#id').val(json.kode_hutang)
            $('#input_nama_pelanggan').val(json.nama_pelanggan)
            $('#input_kode_hutang').val(json.kode_hutang)
            $('#input_total_hutang').val(json.total_hutang)
            $('#tgl_transaksi').val(json.tgl_transaksi)
            $('#tgl_tempo').val(json.tgl_tempo)
            $('#input_perincian').val(json.perincian)
            $('#input_no_hp').val(json.no_hp)
        }
        })
    })

    $('.btn-tambah').on('click', function(){
        $('#exampleModalLabel').html('Tambah Data Hutang')
        $('.modal-footer button[type=submit]').html('Simpan')
        $('.modal-body form').attr('action','/hutang')

        $('#id').val('')
        $('#input_nama_pelanggan').val('')
        $('#input_kode_hutang').val('HT')
        $('#input_total_hutang').val('')
        $('#input_perincian').val('')
        $('#input_no_hp').val('')
        $('#tgl_transaksi').val('')
        $('#tgl_tempo').val('')
    })


        $('#form_hutang').validate({
            rules: {
                nama_pelanggan : {
                    required : true
                },
                total_hutang:{
                    required:true,
                    number:true
                },
                no_hp:{
                    required:true,
                    number:true
                },
                perincian:{
                    required:true,
                },
                tgl_transaksi:{
                    required:true
                },
                tgl_tempo:{
                    required:true
                }
            },
            messages:{
                nama_pelanggan : {
                    required : 'Nama Pelanggan Harus Diisi!'
                },
                total_hutang:{
                    required:'Total Hutang Harus Diisi!',
                    number:'Total Hutang Harus Berupa Angka!'
                },
                tgl_transaksi:{
                    required:'Tanggal Hutang Harus Diisi!'
                },
                tgl_tempo:{
                    required:'Tanggal Tempo Harus Diisi!'
                }
            },
            errorElement: "div",
                errorPlacement: function ( error, element ) {
                    error.addClass( "invalid-feedback" );
                    error.insertAfter( element );
                },
            highlight: function(element) {
                $(element).removeClass('is-valid').addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            }
    })
    </script>
@endsection