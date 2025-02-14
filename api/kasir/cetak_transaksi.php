<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Transaksi | LaundryApp</title>
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            padding-left: 140px;
        }

        .logo {
            width: 120px;
            position: absolute;
            left: 0;
            top: 0;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .company-info {
            font-size: 14px;
            color: #666;
            margin: 5px 0;
        }

        .divider {
            border: none;
            border-top: 2px solid #000;
            margin: 20px 0;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }

        table th {
            background-color: #f5f5f5;
        }

        .customer-info td:first-child {
            width: 200px;
            font-weight: bold;
            color: #666;
        }

        .transaction-table th {
            background-color: #f8f9fa;
        }

        .date {
            text-align: right;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }

        .terms {
            margin-top: 30px;
        }

        .terms h4 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .terms ol {
            margin: 0;
            padding-left: 20px;
            font-size: 12px;
            color: #666;
        }

        .terms li {
            margin-bottom: 5px;
        }

        @media print {
            body {
                padding: 0;
                margin: 20px;
            }
            
            .divider {
                border-top: 1px solid #000;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="../logos.webp" alt="Logo" class="logo">
        <h1 class="company-name">LAPORAN TRANSAKSI LAUNDRY</h1>
        <p class="company-info">Family Laundry</p>
        <p class="company-info">Email: familylaundry@gmail.com</p>
    </div>

    <hr class="divider">

    <h3 class="section-title">Informasi Pelanggan</h3>
    <table class="customer-info">
        <?php
        include "koneksi.php";
        $sql = 'SELECT * FROM transaksi 
                JOIN detail_transaksi ON detail_transaksi.id_transaksi=transaksi.id_transaksi 
                JOIN member ON member.id_member = transaksi.id_member 
                JOIN outlet ON outlet.id_outlet = transaksi.id_outlet 
                WHERE transaksi.id_transaksi = ' . $_GET['id_transaksi'];
        $result = mysqli_query($conn, $sql);
        $data_detail_transaksi = mysqli_fetch_assoc($result);
        ?>
        <tr>
            <td>No Transaksi</td>
            <td><?=$data_detail_transaksi['id_transaksi']?></td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td><?=$data_detail_transaksi['nama_member']?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?=$data_detail_transaksi['alamat']?></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td><?=$data_detail_transaksi['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'?></td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td><?=$data_detail_transaksi['tlp']?></td>
        </tr>
        <tr>
            <td>Nama Outlet</td>
            <td><?=$data_detail_transaksi['nama']?></td>
        </tr>
        <tr>
            <td>Status Pembayaran</td>
            <td><?=ucfirst($data_detail_transaksi['dibayar'])?></td>
        </tr>
        <tr>
            <td>Status Order</td>
            <td><?=ucfirst($data_detail_transaksi['status'])?></td>
        </tr>
        <tr>
            <td>Tanggal Diambil</td>
            <td><?=date('d/m/Y', strtotime($data_detail_transaksi['batas_waktu']))?></td>
        </tr>
    </table>

    <div class="date">
        <?php echo date('l, d F Y'); ?>
    </div>

    <h3 class="section-title">Detail Transaksi</h3>
    <table class="transaction-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Order</th>
                <th>Tanggal Bayar</th>
                <th>Paket Laundry</th>
                <th>Berat</th>
                <th>Harga/Kg</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $qry_pembayaran = mysqli_query($conn, "SELECT * FROM transaksi 
                                                  JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id_transaksi 
                                                  JOIN paket ON paket.id_paket = transaksi.id_paket 
                                                  WHERE transaksi.id_transaksi = " . $_GET['id_transaksi']);
            $no = 0;
            $total_all = 0;
            while($data_pembayaran = mysqli_fetch_array($qry_pembayaran)){
                $harga = $data_pembayaran['harga'];
                $qty = $data_pembayaran['qty'];
                $total = $harga * $qty;
                $total_all += $total;
                $no++;
            ?>
            <tr>
                <td><?=$no?></td>
                <td><?=date('d/m/Y', strtotime($data_pembayaran['tgl']))?></td>
                <td><?=$data_pembayaran['tgl_bayar'] ? date('d/m/Y', strtotime($data_pembayaran['tgl_bayar'])) : '-'?></td>
                <td><?=$data_pembayaran['nama_paket']?></td>
                <td><?=$data_pembayaran['qty']?> kg</td>
                <td>Rp <?=number_format($data_pembayaran['harga'], 0, ',', '.')?></td>
                <td>Rp <?=number_format($total, 0, ',', '.')?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="6" style="text-align: right; font-weight: bold;">Total:</td>
                <td style="font-weight: bold;">Rp <?=number_format($total_all, 0, ',', '.')?></td>
            </tr>
        </tbody>
    </table>

    <div class="terms">
        <h4>Keterangan:</h4>
        <ol>
            <li>Pekerjaan dilakukan sesuai jam kerja yaitu hari Senin – Sabtu dari pukul 07:00 – 19:00. Diluar jam tersebut, maka pekerjaan tidak dilakukan. Hari minggu tidak dihitung sebagai hari layanan.</li>
            <li>Jumlah berat yang ditimbang dan dijadikan nota adalah jumlah berat yang diterima pada saat diterima baik basah maupun kering.</li>
            <li>Bukti tagihan yang sah di dalam transaksi kami adalah melalui nota digital atau nota fisik.</li>
            <li>Kami tidak bertanggung jawab apabila terjadi kehilangan / kerusakan pada laundry bersih yang tidak diambil selama 1 bulan di workshop kami.</li>
            <li>Kami menggunakan bahan detergent dan parfum dengan standar laundry tanpa mengetahui jenis alergi yang anda miliki. Segala jenis penggunaan sabun atau parfum milik pribadi tidak diperkenankan untuk digunakan di laundry kami dan apabila terjadi reaksi alergi pada kulit bukan menjadi tanggung jawab Family Laundry.</li>
            <li>Pengaduan harap disampaikan secara tertulis di ke email familylaundry@gmail.com dengan melampirkan nomor nota, video unboxing serta keluhan yang dialami.</li>
        </ol>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>