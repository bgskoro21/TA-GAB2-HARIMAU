@extends('layout.main')
@section('container')
<section class="m-3 bg-dark text-white radius p-4 overflow-auto">
    <div class="row">
        <div class="col-10">
            <h2 class="mb-4">{{ $title }}</h2>
        </div>
        <div class="col-2 text-end">
            @if ($laporan == 'harian')
            <a href="{{ asset('storage/qr-code/'.$laporan.'/img-'.$waktu.'.png') }}" class="btn btn-success btn-sm" download="{{ 'Harian - '.$waktu }}"><i class='bx bxs-download'></i></a>
            @elseif($laporan == 'bulanan')
            <a href="{{ asset('storage/qr-code/'.$laporan.'/img-'.$waktu.'.png') }}" class="btn btn-success btn-sm" download="{{ 'Bulanan - '.$waktu }}"><i class='bx bxs-download'></i></a>
            @else
            <a href="{{ asset('storage/qr-code/'.$laporan.'/img-'.$waktu.'.png') }}" class="btn btn-success btn-sm" download="{{ 'Umum - '.$waktu }}"><i class='bx bxs-download'></i></a>
            @endif
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <img src="{{ asset('storage/qr-code/'.$laporan.'/img-'.$waktu.'.png') }}" alt="">
    </div>
    <p class="text-center fs-4">{{ $waktu }}</p>
</section>

@endsection