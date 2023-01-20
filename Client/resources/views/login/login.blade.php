@extends('login.index')
@section('container-login')
     {{-- {{ session('username') }} --}}
<div class="row" style="height: 100vh">
    <div class="col-md-5 px-4 d-flex flex-column justify-content-center align-items-center bg-white">
        <div class="row">
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <img src="../../img/eyzel.png" alt="Logo" class="img-fluid" width="80">
                <h5 class=" mt-3">Selamat Datang Kembali!</h5>
                <p>Anda sangat kami rindukan.</p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                @php
                echo session('loginError')
                @endphp
                <form action="/login" method="post">
                    @csrf
                    <div class="mb-3 mt-2">
                      <label for="exampleInputEmail1" class="form-label ">Email address</label>
                      <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Masukkan Email Anda"  id="email" name="email" value="{{ old('email') }}" autofocus >
                      @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                       </div>
                      @enderror
                      <div class="form-text">Kami tidak akan menyebarkan email anda.</div>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label ">Password</label>
                      <input type="password" class="form-control @error('email') is-invalid @enderror" name="password" id="exampleInputPassword1" placeholder="Masukkan Password Anda">
                      @error('email')
                      <div class="invalid-feedback">
                        {{ $message }}
                       </div>
                      @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 btn btn-dark mb-4 w-100">Login</button>
                  </form>
            </div>
        </div>
        <a href="/forgotpassword" class="text-end text-decoration-none" style="font-size: 12px;">Forgot Password?</a>
    </div>
    <div class="col-md-7 d-md-block d-none bg-warning p-0">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active bg-white" aria-current="true" aria-label="Slide 1"></button>
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2" class="bg-white"></button>
              <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3" class="bg-white"></button>
            </div>
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="10000">
                <img src="https://images.unsplash.com/photo-1563917570459-6394376cc5d5?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" style="height: 100vh" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="text-white">EyzelKas</h5>
                  <p class="text-white">Catat transaksi anda dengan bantuan EyzelKas.</p>
                </div>
              </div>
              <div class="carousel-item" data-bs-interval="2000">
                <img src="https://images.unsplash.com/photo-1630861412395-62bb8fd671ea?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" style="height: 100vh" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="text-white">Eyzel</h5>
                  <p class="text-white">Menyediakan makanan dan minuman yang menggugah selera anda.</p>
                </div>
              </div>
              <div class="carousel-item">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80" style="height: 100vh" class="d-block w-100 img-fluid" alt="...">
                <div class="carousel-caption d-none d-md-block">
                  <h5 class="text-white">Statistik</h5>
                  <p class="text-white">Dapatkan statistik penjualan mu di EyzelKas</p>
                </div>
              </div>
            </div>
          </div>
    </div>
  </div>
@endsection