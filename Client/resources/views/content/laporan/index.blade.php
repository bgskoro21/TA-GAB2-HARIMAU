@extends('layout.main')
@section('container')
<section class="m-3 bg-dark text-white radius p-4 overflow-auto">
    <h2 class="mb-3">{{ $title }}</h2>
    <table class="table table-bordered table-responsive border overflow-hidden text-white" id="table_waktu">
        <thead>
                <tr>
                    <th scope="col" class="text-center" style="width: 10%">No</th>
                    <th scope="col" class="text-center">Waktu</th>
                    <th scope="col" class="text-center">Laporan</th>
                </tr>
        </thead>
        @if (request('waktu') == 'harian')
        <tbody>
                @if (isset($waktu))
                @foreach ($waktu as $p)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{  \Custom::format_indo($p->waktu_transaksi) }}</td>
                    <td class="text-center">
                        <a href="/laporan/pdf?tanggal={{ $p->waktu_transaksi }}" class="btn btn-dang btn-sm text-white">PDF</a>
                        <a href="/laporan/qrcode?tanggal={{ $p->waktu_transaksi }}" class="btn btn-suc btn-sm text-white">QR</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        @else
        <tbody>
            @if (isset($waktu[0]))
            @foreach ($waktu as $p)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{  $p->bulan }}</td>
                <td class="text-center">
                    <a href="/laporan/pdf?bulan={{ $p->bulan }}" class="btn btn-dang text-white btn-sm">PDF</a>
                    <a href="/laporan/qrcode?bulan={{ $p->bulan }}" class="btn btn-suc text-white btn-sm">QR</a>
                </td>
            </tr>
            @endforeach
            @endif
            </tbody>
        </table>
        @endif
</section>
@endsection
@section('script')
<script>
        $(document).ready( function () {
        $('#table_waktu').DataTable();
    });
</script>
@endsection
