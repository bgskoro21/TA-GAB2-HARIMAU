<section class="m-4">
    <h1>Daftar Pengeluaran</h1>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
    TAMBAH DATA
    </button>
    <?php if($this->session->flashdata('success')): ?>
    <div class="row">
        <div class="col-md-6">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $this->session->flashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <?php endif ?>
    <table class="table table-bordered table-responsive" id="table_pengeluaran">
        <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Waktu</th>
                    <th scope="col" class="text-center">Perincian</th>
                    <th scope="col" class="text-center">Pengeluaran</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
        </thead>
        <tbody>
                <?php $no=1; ?>
                <?php foreach($pengeluaran as $p): ?>
                <tr>
                    <td class="text-center"><?= $no;  ?></td>
                    <td><?= $p['nama_lengkap'] ?></td>
                    <td><?= $p['waktu_transaksi'] ?></td>
                    <td><?= $p['perincian'] ?></td>
                    <td><?= $p['pengeluaran'] ?></td>    
                    <td class="text-center">
                        <button class="btn btn-success btn-sm"><i class='bx bx-edit'></i></button>
                        <button class="btn btn-danger btn-sm" onclick="return handleDelete(<?= $p['id'] ?>)"><i class='bx bx-trash'></i></button>
                    </td>   
                </tr>
                <?php $no++; ?>
                <?php endforeach; ?>
        </tbody>
    </table>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengeluaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form action="<?= base_url('pengeluaran/add_pengeluaran') ?>" method="post" id="form_pengeluaran">           
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="floatingInput" placeholder="Waktu Transaksi" name="waktu_transaksi">
                <label for="floatingInput">Waktu Transaksi</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="floatingInput" placeholder="pengeluaran" name="pengeluaran">
                <label for="floatingInput">Pengeluaran</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="perincian" name="perincian">
                <label for="floatingInput">Perincian</label>
            </div>
      </div>
      <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>
    $(document).ready( function () {
        $('#table_pengeluaran').DataTable();
    });

    $('#form_pengeluaran').validate({
            rules: {
                waktu_transaksi : {
                    required: true,
                },
                pengeluaran : {
                    number : true,
                    required: true
                },
                perincian:{
                    required:true
                }
            },
            messages:{
                waktu_transaksi : {
                    required: 'Waktu Transaksi Harus Diisi!',
                },
                pengeluaran : {
                    number : 'Pengeluaran Harus Angka!',
                    required: 'Pengeluaran Harus Diisi!'
                },
                perincian:{
                    required:'Perincian Harus Diisi!'
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

    function handleDelete(id){
        var conf = confirm('Apakah anda yakin ingin menghapus data ini?');
        if(conf == true){
            // console.log(id)
            setDelete(id)
        }
    }

    function setRefresh(){
            location.href='<?php echo base_url('pengeluaran');?>'
    }

    function setDelete(id){
            const data = {
                "idnya" : id,
            }
            fetch('<?= site_url("pengeluaran/setDelete") ?>', {
                method : "POST",
                headers : {
                    "Content-type" : "application/json"
                },
                body : JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                setRefresh()
                alert(result.statusnya)
            })
        }

</script>
