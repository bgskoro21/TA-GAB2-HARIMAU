@extends('layout.main')
@section('container')
    <section class="m-3">
        <div class="row">
        <div class="col-lg-12">
            <div class="card bg-dark radius p-3">
                <h3 class="text-white ms-3">Tambah Data Pengeluaran</h3>
                <div class="card-body">
                    <form id="form-item" method="post">
                        @csrf
                        <table class="table table-sm table-borderless text-white" id="table-kas">
                            <thead>
                                <tr>
                                    <th>Waktu Transaksi</th>
                                    <th>Perincian</th>
                                    <th>Pengeluaran</th>
                                </tr>
                            </thead>
                            <tbody id="body-kas">
                                <tr>
                                    <td>
                                        <input name="waktu_transaksi[]" class="form-control" type="date" required>
                                    </td>
                                    <td>
                                        <input name="perincian[]" class="form-control" type="text" placeholder="Masukkan Perincian">
                                    </td>
                                    <td>
                                        <input name="pengeluaran[]" class="form-control money" type="number" placeholder="Masukkan Jumlah">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                    <button class="btn btn-sm btn-show-all text-white" type="button" id="add-transaksi">
                        <i class='bx bx-plus-medical'></i> Tambah Form
                    </button>
                    <div class="text-end">
                        <button class="btn btn-suc text-white" id="save" type="button"><i class="fa fa-floppy-o"></i> Simpan</button>
                        <a href="" class="btn btn-dang text-white"><i class="fa fa-arrow-left"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
@section('script')
<script>
    $('#add-transaksi').on('click', function(e){
        var maxTr = 10;
        var count = document.getElementById("table-kas").getElementsByTagName("tr").length;
            if(count <= maxTr){
                e.preventDefault();
                var images = `
                <tr>
                    <td>
                        <input name="waktu_transaksi[]" class="form-control" type="date" required>
                    </td>
                    <td>
                        <input name="perincian[]" class="form-control" type="text" placeholder="Masukkan Perincian">
                    </td>
                    <td>
                        <input name="pengeluaran[]" class="form-control money" type="number" data-kas="masuk" placeholder="Masukkan Jumlah">
                    </td>
                    <td class="align-middle text-center">
                        <button type="button" class="btn-danger btn-sm delete" onclick="return this.parentNode.parentNode.remove()"><i class='bx bx-trash'></i></button>
                    </td>
                </tr>
                `;
                $('#body-kas').append(images);
            }else {
                toastr.error("Maksimal 10 item !!")
                return false;
            }
        });

        $('#save').on('click', function(e){
            e.preventDefault();
            var dataString = $("#form-item ").serialize();
            // console.log(dataString);
            $.ajax({
                type:'POST',
                url: `/pengeluaran/add_data`,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: dataString,
                success: function(data)
                {
                    const json = JSON.parse(data)
                    console.log(json)
                    if(json.hasOwnProperty('status')){
                        location.href='/flash?status='+json.status+'&messages='+json.messages+"&route=pengeluaran"
                    }else {
                        location.href='/expToken'
                    }
                }
            });
        });
</script>
@endsection
