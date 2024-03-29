@extends('layout.main')
@section('container')
{{-- @php
    var_dump($users);die;
@endphp --}}
<section class="m-3">
    <div class="row p-2 d-flex justify-content-center">
        <div class="col-md-12 bg-white radius p-0">
            <ul class="list-group list-group-flush radius">
                <li class="list-group-item title d-md-flex d-block bg-dark">
                    <div class="col-md-4 mb-2 col-sm-12 d-flex align-items-center">
                        <span class="text-white fs-3">Daftar User</span>
                    </div>
                    <div class="col-md-4 mb-2 col-sm-12 d-flex justify-content-center">
                        <input type="text" id="keyword" class="form-control me-2 input-search text-white" placeholder="Search by Name or Role" style="border-radius: 30px">
                    </div>
                    <div class="col-md-4 mb-2 col-sm-12 d-block d-md-flex justify-content-end align-items-center">
                        <button class="btn btn-sm btn-show-all text-white" data-bs-toggle="modal" data-bs-target="#exampleModal" id="btn_tambah"><i class='bx bx-plus-medical'></i> Tambah Data</button>
                    </div>
                </li>
                <div class="user-container">
                @foreach ($users->user as $user)
                <li class="list-group-item list-user bg-dark">
                    <div class="row d-flex">
                        <div class="col-2 d-flex align-items-center d-none d-md-block">
                            @if ($user->profile_picture != null)
                            <img src="{{ $user->profile_picture }}" class="img-fluid rounded-circle" alt="Profile Picture" style="width: 80px; height:80px;">
                            @else
                            <img src="https://www.pngplay.com/wp-content/uploads/12/User-Avatar-Profile-Clip-Art-Transparent-File.png" class="img-fluid rounded-circle" alt="Profile Picture" style="width: 80px; height:80px;">
                            @endif
                        </div>
                        <div class="col-md-8 col-sm-10 d-flex flex-column p-0 justify-content-center">
                            <p class="card-title text-white fw-bold">{{ $user->nama_lengkap }}</p>
                            <p class="card-text text-white">{{ $user->level }}</p>
                        </div>
                        <div
                         class="col-md-2 col-sm-2 d-flex align-items-center justify-content-end">
                            <a href="/user/detailuser?email={{ $user->email }}"><button class="btn btn-show-all btn-tambah text-white btn-sm btn-detail me-1"><i class="bx bxs-user-detail"></i></button></a>
                            <button class="btn btn-suc btn-sm btn-edit me-1" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $user->email }}"><i class='bx bx-edit text-white'></i></button>
                            <button type="submit" onclick="setDelete('{{ $user->email }}')" class="btn btn-dang btn-sm text-white"><i class='bx bx-trash'></i></button>
                        </div>
                    </div>
                </li>
                @endforeach
            </div>
            </ul>
        </div>
    </div>
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
     function setDelete(email){
        // console.log(username);
        Swal.fire({
          title: 'Apakah kamu yakin menghapus user ini? Data transaksi user ini juga akan hilang',
          showDenyButton: true,
          confirmButtonText: 'Delete',
          denyButtonText: `Cancel`,
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
          if (result.isConfirmed) {
            location.href = '/user/hapus_data/'+email
          } else if (result.isDenied) {
            return false;
          }
        })
      }

      $('#keyword').on('keyup',function(){
        keyword = $('#keyword').val()
        $.ajax({
            url: '/user/filteruser?keyword='+keyword,
            success: function(data){
                console.log(data);
               $('.user-container').html(data)
            }
        })
      })

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
          if(json.hasOwnProperty('result')){
            location.href='/expToken'
          }
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
    $('.float-password').show()
    $('.float-hp').show()
    $('.float-nama').show()
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