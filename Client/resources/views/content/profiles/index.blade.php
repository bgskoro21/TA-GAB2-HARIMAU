@extends('layout.main')
@section('container')
<section class="section profile mt-3 mx-3 mb-5">
    <div class="row">
      <div class="col-xl-4">

        <div class="card bg-dark text-white">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <img src="{{ $current_user->profile_picture }}" alt="Profile" class="rounded-circle img-fluid mb-2 profile-picture">
            <h4>{{ $current_user->nama_lengkap }}</h4>
            <p>{{ $current_user->level }}</p>
          </div>
        </div>

      </div>

      <div class="col-xl-8">

        <div class="card bg-dark text-white">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>

            </ul>
            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <h5 class="card-title">About</h5>
                <p class="small fst-italic">{{ $current_user->about }}</p>

                <h5 class="card-title">Profile Details</h5>

                <div class="row my-2">
                  <div class="col-lg-3 col-md-4 text-muted">Nama Lengkap</div>
                  <div class="col-lg-9 col-md-8">{{ $current_user->nama_lengkap }}</div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-3 col-md-4 text-muted">Email</div>
                  <div class="col-lg-9 col-md-8">{{ $current_user->email }}</div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-3 col-md-4 text-muted">Nomor HP</div>
                  <div class="col-lg-9 col-md-8">{{ $current_user->no_hp }}</div>
                </div>

                <div class="row mb-2">
                  <div class="col-lg-3 col-md-4 text-muted">Level</div>
                  <div class="col-lg-9 col-md-8">{{ $current_user->level }}</div>
                </div>
              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                <!-- Profile Edit Form -->
                <form action="/profile/edit_profile" method="post" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" value="{{ $current_user->email }}" name="token">
                  <div class="row mb-3">
                    <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                    <div class="col-md-8 col-lg-9">
                      <img src="{{ $current_user->profile_picture }}" alt="Profile" width="100" id="preview_photo">
                      <div class="pt-2">
                        <div class="input-file">
                          <input type="file" name="profile_picture" id="photo" class="d-none">
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" onclick="return getFile()"><i class="bx bx-upload"></i></button>
                        @if (explode('/',$current_user->profile_picture)[7] != 'default.png')
                        <button type="button" class="btn btn-danger btn-sm" onclick="return deleteProfilePicture('{{ $current_user->email }}')" title="Remove my profile image" id="btn_hapus"><i class="bx bx-trash"></i></button>
                        @endif
                      </div>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="nama_lengkap" type="text" class="form-control" id="fullName" value="{{ $current_user->nama_lengkap }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="no_hp" class="col-md-4 col-lg-3 col-form-label">Nomor HP</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="no_hp" type="text" class="form-control" id="no_hp" value="{{ $current_user->no_hp }}">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="about" class="col-md-4 col-lg-3 col-form-label">About</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="about" class="form-control" id="about" style="height: 100px">{{ $current_user->about }}</textarea>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                  </div>
                </form><!-- End Profile Edit Form -->

              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form id="form_password" method="post" action="/profile/change_password">
                  @csrf
                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection
@section('script')
<script>

function deleteProfilePicture(email){
      Swal.fire({
        title: 'Apakah kamu ingin menghapus foto profile?',
        showDenyButton: true,
        confirmButtonText: 'Ya',
        denyButtonText: `Tidak`,
      }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          // console.log(email)
          location.href = '/deletephoto?token='+email
        } else if (result.isDenied) {
          return false;
        }
      })
    }

    function getFile(){
        document.getElementById("photo").click();
    }

    $(document).ready(function (e) {
  
    
  $('#photo').change(function(){
            
    let reader = new FileReader();
    $('#btn_hapus').show()
    reader.onload = (e) => { 

      $('#preview_photo').attr('src', e.target.result); 
    }

    reader.readAsDataURL(this.files[0]); 
  
  });
  
  });
  $('#form_password').validate({
            rules: {
                password : {
                    required: true,
                },
                newpassword : {
                    minlength: 8,
                },
                renewpassword:{
                  minlength: 8,
                  equalTo : '#newPassword'
                }
            },
            messages:{
              password : {
                    required: 'Current password harus diisi!',
                },
                newpassword : {
                    minlength: 'Password minimal 8 karakter!',
                },
                renewpassword:{
                  minlength: 'Password minimal 8 karakter!',
                  equalTo : 'Konfirmasi password tidak cocok!'
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
