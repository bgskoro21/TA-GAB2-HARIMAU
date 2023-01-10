@extends('login.index');
@section('container-login')
      {{-- {{ session('username') }} --}}
      <div class="row d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="col-4 bg-white shadow-sm" style="padding: 50px; border-radius:10px;">
            <h5 class="text-center mb-2">Ganti Password Kamu</h5>
            <p class="text-center">{{ session('reset_password') }}</p>
            @php
                echo session('loginError')
            @endphp
            <form action="/resetpassword" method="post" class="mt-3" id="form_password">
                @csrf
                <div class="form-floating mb-3">
                    <input type="password" name="password1" class="form-control" id="password1" placeholder="Password" autofocus>
                    <label for="password">Masukkan Password Baru</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password2" class="form-control" id="password2" placeholder="Password">
                    <label for="password">Ulangi Password Baru</label>
                </div>
                <center><button type="submit" class="px-4 py-2 btn btn-outline-dark mt-4">Forgot Password</button></center>
            </form>
        </div>
    </div>
@endsection
@section('script-auth')
<script>
$('#form_password').validate({
    rules: {
        password1 : {
            minlength: 8,
        },
        password2:{
          minlength: 8,
          equalTo : '#password1'
        }
    },
    messages:{
        password1 : {
            minlength: 'Password minimal 8 karakter!',
        },
        password2:{
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