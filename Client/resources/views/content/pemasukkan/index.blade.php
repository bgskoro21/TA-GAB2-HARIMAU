@extends('layout.main')
@section('container')
{{-- @php
    var_dump(session('profile_picture'))
@endphp --}}
<section class="mt-3 mb-4 mx-3 bg-dark text-white radius p-4 overflow-auto">
    <div class="row d-flex justify-content-center align-items-center mb-3">
        <div class="col-md-8">
            <h2>{{ $title }}</h2>
        </div>
        <div class="col-md-4 text-end">
            <button class="btn btn-dang text-white btn-sm delete_all"><i class='bx bx-trash'></i> Hapus Diseleksi</button>
            <a href="/pemasukkan/tambahdata"><button class="btn btn-show-all btn-sm text-white"><i class='bx bx-plus-medical'></i> Tambah Data</button></a>
        </div>
    </div>
    <table class="table table-bordered table-responsive border overflow-hidden text-white" id="table_pemasukkan">
        <thead>
                <tr>
                    <th scope="col" class="text-center check" data-orderable="false"><input type="checkbox" id="master"></th>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Waktu</th>
                    <th scope="col" class="text-center">Perincian</th>
                    <th scope="col" class="text-center">Pemasukkan</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
        </thead>
        <tbody id="body_data">
            @if (isset($pemasukkan->pendapatan))
            @foreach ($pemasukkan->pendapatan as $p)
            <tr id="tr_{{ $p->id }}">
                <td class="text-center">
                    @if ($p->user_id == session('id'))
                    <input type="checkbox" class="sub_chk" data-id="{{$p->id}}">
                    @endif
                </td>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{  $p->email }}</td>
                <td>{{  \Custom::format_indo($p->waktu_transaksi) }}</td>
                <td>{{ $p->perincian }}</td>
                <td>@currency($p->pemasukan)</td>
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
           <form action="/pemasukkan/add_data" method="post" id="form_pemasukkan">   
            <input type="hidden" name="id" id="id">    
            @csrf    
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="input_waktu" placeholder="Waktu Transaksi" name="waktu_transaksi">
                        <label for="input_waktu"  class="text-dark">Waktu Transaksi</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" placeholder="pemasukan" name="pemasukkan" id="input_pemasukkan">
                        <label for="input_pemasukkan" class="text-dark">Pemasukkan</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" placeholder="perincian" name="perincian" id="input_perincian">
                            <label for="input_perincian" class="text-dark">Perincian</label>
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
    function setDelete(id){
        Swal.fire({
          title: 'Apakah kamu yakin?',
          showDenyButton: true,
          confirmButtonText: 'Delete',
          denyButtonText: `Cancel`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/pemasukkan/hapus_data/'+id
          } else if (result.isDenied) {
            return false;
          }
        })
      }

    $(document).ready( function () {
        $('#table_pemasukkan').DataTable();
        $('.check').data('orderable',false)

        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });

        $('.delete_all').on('click', function(e) {

        var allVals = [];  
        $(".sub_chk:checked").each(function() {  
            allVals.push($(this).attr('data-id'));
        }); 

        if(allVals.length <=0) {  
                alert("Please select row.");  
        }else{
            Swal.fire({
            title: 'Apakah kamu ingin menghapus data yang diseleksi?',
            showDenyButton: true,
            confirmButtonText: 'Ya',
            denyButtonText: `Tidak`,
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                var join_selected_values = allVals.join(",");
                $.ajax({
                        url: '/pemasukkan/deleteSelected',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                            const json = JSON.parse(data)
                            if (json.hasOwnProperty('result')) {
                                location.href='/expToken'
                            } else {
                                location.href='/flash?messages='+json.message+'&status='+json.status
                            }
                        },
                        error: function (data) {
                            alert(json.responseText);
                        }
                    });
            } else if (result.isDenied) {
                return false;
            }
            })  
        }
    })
    });

    $('.btn-edit').on('click', function(){
    $('#exampleModalLabel').html('Ubah Pemasukkan')
    $('.modal-footer button[type=submit]').html('Simpan Perubahan')
    const id = $(this).data('id')
    $('.modal-body form').attr('action','/pemasukkan/edit_data/')

    $.ajax({
      url: '/pemasukkan/getPemasukkanById/'+id,
      success: function(data){
        const json = JSON.parse(data)
        $('#id').val(id)
        $('#input_pemasukkan').val(json.pemasukan)
        $('#input_perincian').val(json.perincian)
        $('#input_waktu').val(json.waktu_transaksi)
      }
    })
  })

    $('#form_pemasukkan').validate({
            rules: {
                waktu_transaksi : {
                    required: true,
                },
                pemasukan : {
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
                pemasukan : {
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