@extends('layout.main')
@section('container')
{{-- @php
    var_dump($pemasukkan)
@endphp --}}
<section class="m-3 bg-white radius p-4 overflow-auto">
    <div class="row d-flex justify-content-center align-items-center mb-3">
        <div class="col-10">
            <h2>{{ $title }}</h2>
        </div>
        <div class="col-2 text-end">
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn_tambah"><i class='bx bx-plus-medical'></i></button>
        </div>
    </div>
    <table class="table table-bordered table-responsive border overflow-hidden" id="table_pemasukkan">
        <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Waktu</th>
                    <th scope="col" class="text-center">Perincian</th>
                    <th scope="col" class="text-center">Pengeluaran</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
        </thead>
        <tbody>
            @if (isset($pengeluaran->pengeluaran))
            @foreach ($pengeluaran->pengeluaran as $p)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{  $p->nama_lengkap }}</td>
                <td>{{  \Custom::format_indo($p->waktu_transaksi) }}</td>
                <td>{{ $p->perincian }}</td>
                <td>@currency($p->pengeluaran)</td>
                <td class="text-center">
                    {{-- @if ($p->user_id == session('id')) --}}
                    <button class="btn btn-success btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $p->id }}"><i class='bx bx-edit'></i></button>
                    <button type="submit" onclick="setDelete({{ $p->id }})" class="btn btn-danger btn-sm"><i class='bx bx-trash'></i></button>
                    {{-- @else
                    <i class="text-muted">Forbidden</i>
                    @endif --}}
                </td>
            </tr>
            @endforeach          
            @endif
        </tbody>
    </table>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukkan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form action="/pengeluaran/add_data" method="post" id="form_pemasukkan">   
            <input type="hidden" name="id" id="id">    
            @csrf    
              <div class="form-floating mb-3">
                  <input type="date" class="form-control" id="input_waktu" placeholder="Waktu Transaksi" name="waktu_transaksi">
                  <label for="input_waktu">Waktu Transaksi</label>
              </div>
              <div class="form-floating mb-3">
                  <input type="number" class="form-control" placeholder="pengeluaran" name="pengeluaran" id="input_pengeluaran">
                  <label for="input_pengeluaran">Pengeluaran</label>
              </div>
              <div class="form-floating mb-3">
                  <input type="text" class="form-control" placeholder="perincian" name="perincian" id="input_perincian">
                  <label for="input_perincian">Perincian</label>
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
        function setDelete(id){
        console.log(id);
        Swal.fire({
          title: 'Apakah kamu yakin?',
          showDenyButton: true,
          confirmButtonText: 'Delete',
          denyButtonText: `Cancel`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/pengeluaran/hapus_data/'+id
          } else if (result.isDenied) {
            return false;
          }
        })
      }

    $(document).ready( function () {
        $('#table_pemasukkan').DataTable();
    });

    $('.btn-edit').on('click', function(){
    $('#exampleModalLabel').html('Ubah Pengeluaran')
    $('.modal-footer button[type=submit]').html('Simpan Perubahan')
    const id = $(this).data('id')
    $('.modal-body form').attr('action','/pengeluaran/edit_data/')

    $.ajax({
      url: '/pengeluaran/getPengeluaranById/'+id,
      success: function(data){
        // console.log(data)
        const json = JSON.parse(data)
        // console.log(json)
        $('#id').val(id)
        $('#input_pengeluaran').val(json.pengeluaran)
        $('#input_perincian').val(json.perincian)
        $('#input_waktu').val(json.waktu_transaksi)
      }
    })
  })

  $('#btn_tambah').on('click', function(){
    $('#exampleModalLabel').html('Tambah Pemasukkan')
    $('.modal-footer button[type=submit]').html('Tambah Data')
    $('.modal-body form').attr('action','/pengeluaran/add_data')
    
    $('#id').val('')
    $('#input_pengeluaran').val('')
    $('#input_perincian').val('')
    $('#input_waktu').val('')
  })

    $('#form_pemasukkan').validate({
            rules: {
                waktu_transaksi : {
                    required: true,
                },
                pengeluaran : {
                    number : true,
                    required: true
                },
                perincian:{
                    required:true
                }
            },
            messages:{
                waktu_transaksi : {
                    required: 'Waktu Transaksi Harus Diisi!',
                },
                pengeluaran : {
                    number : 'Pemasukkan Harus Angka!',
                    required: 'Pemasukkan Harus Diisi!'
                },
                perincian:{
                    required:'Perincian Harus Diisi!'
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