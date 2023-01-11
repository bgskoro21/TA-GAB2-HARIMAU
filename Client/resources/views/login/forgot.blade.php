@extends('login.index');
@section('container-login')
      {{-- {{ session('username') }} --}}
      <div class="row d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="col-4 bg-white shadow-sm d-flex flex-column justify-content-center" style="padding: 50px; border-radius:10px;">
            <h3 class="text-center mb-4">FORGOT PASSWORD</h3>
            @php
                echo session('loginError')
            @endphp
            <form action="/forgotpassword" method="post">
                @csrf
                <div class="form-floating mb-4">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Psername" value="{{ old('email') }}" autofocus>
                    @error('email')
                    <div class="invalid-feedback">
                      {{ $message }}
                     </div>
                    @enderror
                    <label for="email">Email</label>
                </div>
                <center><button type="submit" class="px-4 py-2 btn btn-outline-dark mb-4">Reset Password</button></center>
            </form>
        </div>
    </div>
@endsection