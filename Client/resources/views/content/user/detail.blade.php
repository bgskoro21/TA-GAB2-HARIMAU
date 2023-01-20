@extends('layout.main')
@section('container')
<section class="section profile m-3">
    <div class="row">
      <div class="col-xl-4">
        <div class="card bg-dark text-white">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            @if (!is_null($current_user->profile_picture))
            <img src="{{ $current_user->profile_picture }}" alt="Profile" class="rounded-circle img-fluid mb-2 profile-picture">
            @else
            <img src="https://www.pngplay.com/wp-content/uploads/12/User-Avatar-Profile-Clip-Art-Transparent-File.png" alt="Profile" class="rounded-circle img-fluid mb-2" width="150">    
            @endif
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

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>
@endsection