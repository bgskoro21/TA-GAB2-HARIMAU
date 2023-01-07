<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF-QR</title>
</head>
<body>
    <div class="row d-flex">
        <h1 style="text-align: center;">Arus Kas Keluar Masuk</h1>
        <p style="text-align: center;">Periode : {{ $waktu }}</p>
        <table width="100%" border="1" cellspacing="0" cellpadding="15">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Perincian</th>
                    <th>Pemasukkan</th>
                    <th>Pengeluaran</th>
                    <th>Saldo</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $saldo = 0;
                $pemasukkan = 0;
                $pengeluaran = 0;
                ?>
                <?php foreach($transaksi as $t): ?>
                <tr>
                    <td align="center"><?php echo $no  ?></td>
                    <td><?php echo $t['perincian'] ?></td>
                    <td>@currency($t['pemasukan'])</td>
                    <td>@currency($t['pengeluaran'])</td>
                    <td>@currency($saldo += $t['pemasukan'] - $t['pengeluaran'])</td> 
                    <?php $pemasukkan += $t['pemasukan'] ?>
                    <?php $pengeluaran += $t['pengeluaran'] ?>
                </tr>
                <?php $no++ ?>
                <?php endforeach ?>
                <tr>
                    <th colspan="2" >TOTAL</th>
                    <td>@currency($pemasukkan)</td>
                    <td>@currency($pengeluaran)</td>
                    <td>@currency($saldo)</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>