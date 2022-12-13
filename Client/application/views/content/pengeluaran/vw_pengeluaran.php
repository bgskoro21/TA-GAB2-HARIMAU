<section class="m-4">
    <h1>Daftar Pengeluaran</h1>
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
                <?php foreach($pengeluaran as $p): ?>
                <?php $no = 1 ?>
                <tr>
                    <td class="text-center"><?php echo $no ?></td>
                    <td><?= $p['nama_lengkap'] ?></td>
                    <td><?= $p['waktu_transaksi'] ?></td>
                    <td><?= $p['perincian'] ?></td>
                    <td><?= $p['pengeluaran'] ?></td>    
                    <td>
                        <button class="btn btn-success btn-sm"><i class='bx bx-edit'></i></button>
                        <button class="btn btn-danger btn-sm"><i class='bx bx-trash'></i></button>
                    </td>   
                </tr>
        </tbody>
        <?php $no++ ?>
        <?php endforeach ?>
    </table>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script>
    $(document).ready( function () {
        $('#table_pengeluaran').DataTable();
    });
</script>