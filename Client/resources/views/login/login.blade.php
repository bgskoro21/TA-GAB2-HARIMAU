@extends('login.index')
@section('container-login')
     {{-- {{ session('username') }} --}}
     <div class="row d-flex justify-content-center align-items-center" style="height: 100vh">
        <div class="col-4 bg-white shadow-sm" style="padding: 50px; border-radius:10px;">
            <h1 class="text-center mb-4">LOGIN</h1>
            @php
                echo session('loginError')
            @endphp
            <form action="/login" method="post">
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
                <div class="form-floating">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Password">
                    @error('password')
                    <div class="invalid-feedback">
                      {{ $message }}
                     </div>
                    @enderror
                    <label for="password">Password</label>
                </div>
                <center><button type="submit" class="mt-5 px-4 py-2 btn btn-outline-dark mb-4">LOGIN</button></center>
            </form>
            <center><a href="/forgotpassword" class="text-center text-decoration-none" style="font-size: 12px;">Forgot Password?</a></center>
        </div>
    </div>
@endsection