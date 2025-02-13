<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Transaksi | LaundryApp</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        @page {
            size: landscape;
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 0;
            margin: 0;
            font-size: 12px;
        }
        .header-section {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 0;
            border-bottom: 2px solid #333;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            margin: 5px 0;
        }
        .report-title {
            font-size: 16px;
            text-transform: uppercase;
            margin: 5px 0;
        }
        .date-section {
            text-align: right;
            margin: 10px 0;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .terms {
            margin-top: 20px;
            font-size: 11px;
            page-break-inside: avoid;
        }
        .terms h4 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .terms ol {
            padding-left: 20px;
            margin: 0;
        }
        .terms li {
            margin-bottom: 5px;
        }
        /* Column widths */
        .col-no { width: 5%; }
        .col-outlet { width: 15%; }
        .col-date { width: 10%; }
        .col-deadline { width: 10%; }
        .col-payment { width: 10%; }
        .col-paydate { width: 10%; }
        .col-customer { width: 15%; }
        .col-package { width: 15%; }
        .col-status { width: 10%; }
        
        @media print {
            .table th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header-section">
        <img src="laundry.PNG" alt="Logo" class="logo">
        <div class="company-name">Family Laundry</div>
        <div class="report-title">Laporan Transaksi Laundry</div>
        <div>Email: familylaundry@gmail.com</div>
    </div>

    <div class="date-section">
        <strong>Tanggal Cetak:</strong> <?php echo date('l, d-m-Y'); ?>
    </div>

    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-outlet">Outlet</th>
                <th class="col-date">Tanggal</th>
                <th class="col-deadline">Batas Waktu</th>
                <th class="col-payment">Pembayaran</th>
                <th class="col-paydate">Tanggal Bayar</th>
                <th class="col-customer">Customer</th>
                <th class="col-package">Paket</th>
                <th class="col-status">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "koneksi.php";
            $qry_transaksi = mysqli_query($conn, "SELECT t.*, o.nama as nama_outlet, m.nama_member, p.nama_paket 
                                                FROM transaksi t 
                                                JOIN outlet o ON o.id_outlet = t.id_outlet 
                                                JOIN member m ON m.id_member = t.id_member 
                                                JOIN paket p ON p.id_paket = t.id_paket 
                                                ORDER BY t.tgl DESC");
            $no = 0;
            while($data_transaksi = mysqli_fetch_array($qry_transaksi)){
                $no++;
            ?>
            <tr>
                <td class="col-no"><?=$no?></td>
                <td class="col-outlet"><?=$data_transaksi['nama_outlet']?></td>
                <td class="col-date"><?=date('d/m/Y', strtotime($data_transaksi['tgl']))?></td>
                <td class="col-deadline"><?=date('d/m/Y', strtotime($data_transaksi['batas_waktu']))?></td>
                <td class="col-payment"><?=$data_transaksi['dibayar']?></td>
                <td class="col-paydate"><?=$data_transaksi['tgl_bayar'] ? date('d/m/Y', strtotime($data_transaksi['tgl_bayar'])) : '-'?></td>
                <td class="col-customer"><?=$data_transaksi['nama_member']?></td>
                <td class="col-package"><?=$data_transaksi['nama_paket']?></td>
                <td class="col-status"><?=$data_transaksi['status']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="terms">
        <h4>Keterangan:</h4>
        <ol>
            <li>Pekerjaan dilakukan sesuai jam kerja yaitu hari Senin – Sabtu dari pukul 07:00 – 19:00. Diluar jam tersebut, maka pekerjaan tidak dilakukan. Hari minggu tidak dihitung sebagai hari layanan.</li>
            <li>Jumlah berat yang ditimbang dan dijadikan nota adalah jumlah berat yang diterima pada saat diterima baik basah maupun kering.</li>
            <li>Bukti tagihan yang sah di dalam transaksi kami adalah melalui nota digital atau nota fisik.</li>
            <li>Kami tidak bertanggung jawab apabila terjadi kehilangan / kerusakan pada laundry bersih yang tidak diambil selama 1 bulan di workshop kami.</li>
            <li>Kami menggunakan bahan detergent dan parfum dengan standar laundry tanpa mengetahui jenis alergi yang anda miliki. Segala jenis penggunaan sabun atau parfum milik pribadi tidak diperkenankan untuk digunakan di laundry kami dan apabila terjadi reaksi alergi pada kulit bukan menjadi tanggung jawab FamilyLaundry.</li>
            <li>Pengaduan harap disampaikan secara tertulis di ke email familylaundry@gmail.com dengan melampirkan nomor nota, video unboxing serta keluhan yang dialami.</li>
        </ol>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>