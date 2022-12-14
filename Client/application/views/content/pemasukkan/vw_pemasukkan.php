<section class="m-4">
    <h1>Daftar Pemasukkan</h1>
    <button type="button" class="btn btn-primary mb-3 btn-tambah" data-bs-toggle="modal" data-bs-target="#exampleModal">
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
    <table class="table table-bordered table-responsive" id="table_pemasukkan">
        <thead>
                <tr>
                    <th scope="col" class="text-center">No</th>
                    <th scope="col" class="text-center">Nama</th>
                    <th scope="col" class="text-center">Waktu</th>
                    <th scope="col" class="text-center">Perincian</th>
                    <th scope="col" class="text-center">Pemasukkan</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
        </thead>
        <tbody>
                <?php $no=1 ?>
                <?php foreach($pemasukkan as $p): ?>
                <tr>
                    <td class="text-center"><?php echo $no ?></td>
                    <td><?= $p['nama_lengkap'] ?></td>
                    <td><?= $p['waktu_transaksi'] ?></td>
                    <td><?= $p['perincian'] ?></td>
                    <td><?= $p['pemasukan'] ?></td>    
                    <td>
                        <button class="btn btn-success btn-sm btn-edit" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="<?= $p['id'] ?>"><i class='bx bx-edit'></i></button>
                        <button class="btn btn-danger btn-sm" onclick="return handleDelete(<?=$p['id']?>)"><i class='bx bx-trash'></i></button>
                    </td>   
                </tr>
                <?php $no++ ?>
                <?php endforeach ?>
        </tbody>
    </table>
</section>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukkan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <form action="<?= base_url('pemasukkan/add_pemasukkan') ?>" method="post" id="form_pemasukkan">           
            <div class="form-floating mb-3">
                <input type="date" class="form-control" id="input_waktu" placeholder="Waktu Transaksi" name="waktu_transaksi">
                <label for="input_waktu">Waktu Transaksi</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" placeholder="pemasukan" name="pemasukkan" id="input_pemasukkan">
                <label for="input_pemasukkan">Pemasukkan</label>
            </div>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" placeholder="perincian" name="perincian" id="input_perincian">
                <label for="input_perincian">Perincian</label>
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
        $('#table_pemasukkan').DataTable();
    });

    $('.btn-edit').on('click', function(){
    $('#exampleModalLabel').html('Ubah Pemasukkan')
    $('.modal-footer button[type=submit]').html('Simpan Perubahan')
    const id = $(this).data('id')
    $('.modal-body form').attr('action','<?= base_url('/pemasukkan/edit_pemasukkan') ?>/'+id)

    $.ajax({
      url: '<?= base_url('pemasukkan/getPemasukkanById') ?>/'+id,
      success: function(data){
        // console.log(data)
        const json = JSON.parse(data)
        console.log(json);
        $('#input_pemasukkan').val(json.pemasukan)
        $('#input_perincian').val(json.perincian)
        const waktu_transaksi = json.waktu_transaksi.split(" ")
        console.log(waktu_transaksi)
        $('#input_waktu').val(waktu_transaksi[0])
      }
    })
  })

  $('.btn-tambah').on('click', function(){
    $('#exampleModalLabel').html('Tambah Pemasukkan')
    $('.modal-footer button[type=submit]').html('Tambah Data')
    $('.modal-body form').attr('action','<?= base_url('pemasukkan/add_pemasukkan') ?>')

    $('#input_pemasukkan').val('')
    $('#input_perincian').val('')
    $('#input_waktu').val('')
  })

    $('#form_pemasukkan').validate({
            rules: {
                waktu_transaksi : {
                    required: true,
                },
                pemasukan : {
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
                pemasukan : {
                    number : 'Pemasukkan Harus Angka!',
                    required: 'Pemasukkan Harus Diisi!'
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
            location.href='<?php echo base_url('pemasukkan');?>'
    }

    function setDelete(id){
            const data = {
                "idnya" : id,
            }
            fetch('<?= site_url("pemasukkan/setDelete") ?>', {
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