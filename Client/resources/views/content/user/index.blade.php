@extends('layout.main')
@section('container')
{{-- @php
    var_dump($users);die;
@endphp --}}
<section class="m-3 bg-dark text-white radius p-4 overflow-auto">
    <div class="row d-flex justify-content-center align-items-center mb-3">
        <div class="col-10">
            <h2>{{ $title }}</h2>
        </div>
        <div class="col-2 text-end">
            <button class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn_tambah"><i class='bx bx-plus-medical'></i></button>
        </div>
    </div>
    <table class="table table-bordered table-responsive border overflow-hidden text-white" id="table_user">
        <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Email</th>
                    <th scope="col" class="text-center">Nomor HP</th>
                    <th scope="col" class="text-center">Level</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
        </thead>
        <tbody>
            @if (isset($users->user))
            @foreach ($users->user as $user)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{  $user->nama_lengkap }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->no_hp }}</td>
                <td>{{ $user->level }}</td>
                <td class="text-center">
                    <button class="btn btn-success btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $user->email }}"><i class='bx bx-edit'></i></button>
                    <button type="submit" onclick="setDelete('{{ $user->email }}')" class="btn btn-danger btn-sm"><i class='bx bx-trash'></i></button>
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
          <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
          <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
           <form action="/user/add_data" method="post" id="form_user">   
              <input type="hidden" name="token" id="token">        
              @csrf
              <div class="form-floating mb-3">
                  <input type="text" class="form-control float-nama" placeholder="pemasukan" name="nama_lengkap" id="nama_lengkap">
                  <label for="nama_lengkap" class="text-dark">Nama Lengkap</label>
              </div>
              <div class="form-floating mb-3">
                  <input type="email" class="form-control" placeholder="email" name="email" id="email">
                  <label for="email" class="text-dark">Email</label>
              </div>
              <div class="form-floating mb-3 float-hp">
                  <input type="text" class="form-control" placeholder="no_hp" name="no_hp" id="no_hp">
                  <label for="no_hp" class="text-dark">Nomor HP</label>
              </div>
              <div class="form-floating mb-3">
                  <select class="form-select" id="floatingSelect" aria-label="Level" name="level">
                      <option value="Admin">Admin</option>
                      <option value="Bendahara">Bendahara</option>
                  </select>
                  <label for="floatingSelect" class="text-dark">Pilih Level</label>
              </div>
              <div class="form-floating mb-3 float-password">
                  <input type="password" class="form-control" placeholder="password" name="password" id="password">
                  <label for="password" class="text-dark">Password</label>
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
     function setDelete(username){
        // console.log(username);
        Swal.fire({
          title: 'Apakah kamu yakin?',
          showDenyButton: true,
          confirmButtonText: 'Delete',
          denyButtonText: `Cancel`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/user/hapus_data/'+username
          } else if (result.isDenied) {
            return false;
          }
        })
      }

    $(document).ready( function () {
        $('#table_user').DataTable();
    });

    $('.btn-edit').on('click', function(){
        $('#exampleModalLabel').html('Ubah Data User')
        $('.modal-footer button[type=submit]').html('Simpan Perubahan')
        const username = $(this).data('id')
        $('.modal-body form').attr('action','/user/edit_data/')
        $('.float-password').hide()
        $('.float-hp').hide()
        $('.float-nama').hide()

    $.ajax({
      url: '/user/dataByUsername/'+username,
      success: function(data){
          const json = JSON.parse(data)
        //   console.log(json)
        $('#email').val(json.email)
        $('#level').val(json.level)
        $('#token').val(json.email)
      }
    })
  })

  $('#btn_tambah').on('click', function(){
    $('#exampleModalLabel').html('Tambah User')
    $('.modal-footer button[type=submit]').html('Tambah Data')
    $('.modal-body form').attr('action','/user/add_data')
    $('.float-password').show()

    $('#nama_lengkap').val('')
    $('#email').val('')
    $('#no_hp').val('')
    $('#level').val('')
    $('#password').val('')
  })

    $('#form_user').validate({
            rules: {
                nama_lengkap : {
                    required: true,
                },
                username : {
                    required: true,
                    minlength: 8,
                    maxlength : 20,
                },
                email:{
                    required:true,
                    email:true
                },
                no_hp:{
                    required:true,
                    number:true
                },
                level:{
                    required:true,
                },
                password:{
                    required:true,
                    minlength:8
                },
            },
            messages:{
                nama_lengkap : {
                    required: "Nama lengkap harus diisi!",
                },
                username : {
                    required: "Username harus diisi!",
                    minlength: "Username minimal 8 karakter!",
                    maxlength: "Username maksimal 20 karakter!"
                },
                email:{
                    required:'Email harus diisi!',
                    email:'Isi dengan email valid!'
                },
                no_hp:{
                    required:'Nomor HP harus diisi!',
                    number:'Nomor HP harus berupa angka'
                },
                level:{
                    required:'Level harus dipilih!',
                },
                password:{
                    required: 'Password harus diisi!',
                    minlength:"Password minimal 8 karakter!"
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