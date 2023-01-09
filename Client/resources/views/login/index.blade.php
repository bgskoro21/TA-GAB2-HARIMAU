<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <title>{{ $title }}</title>
  </head>
  <body class="bg-login">
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
                <center><button type="submit" class="mt-5 px-4 py-2 btn btn-outline-dark">LOGIN</button></center>
            </form>
        </div>
    </div>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  </body>
</html>