<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Transaksi | LaundryApp</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .header-section {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 2px solid #333;
        }
        .logo {
            max-width: 140px;
            margin-bottom: 15px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .report-title {
            font-size: 20px;
            text-transform: uppercase;
            margin: 10px 0;
        }
        .date-section {
            text-align: right;
            margin: 20px 0;
        }
        .table {
            width: 100%;
            margin-bottom: 30px;
            font-size: 14px;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .terms {
            margin-top: 30px;
            font-size: 14px;
        }
        .terms h4 {
            font-size: 16px;
            font-weight: bold;
        }
        .terms ol {
            padding-left: 20px;
        }
        .terms li {
            margin-bottom: 10px;
        }
        @media print {
            .table th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
            .badge {
                border: 1px solid #333;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-section">
            <img src="laundry.PNG" alt="Logo" class="logo">
            <div class="company-name">Family Laundry</div>
            <div class="report-title">Laporan Transaksi Laundry</div>
            <div>Email: familylaundry@gmail.com</div>
        </div>

        <div class="date-section">
            <strong>Tanggal Cetak:</strong> <?php echo date('l, d-m-Y'); ?>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Outlet</th>
                        <th>Tanggal</th>
                        <th>Batas Waktu</th>
                        <th>Pembayaran</th>
                        <th>Tanggal Dibayar</th>
                        <th>Customer</th>
                        <th>Paket</th>
                        <th>Status Order</th>
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
                        <td><?=$no?></td>
                        <td><?=$data_transaksi['nama_outlet']?></td>
                        <td><?=$data_transaksi['tgl']?></td>
                        <td><?=$data_transaksi['batas_waktu']?></td>
                        <td><?=$data_transaksi['dibayar']?></td>
                        <td><?=$data_transaksi['tgl_bayar']?></td>
                        <td><?=$data_transaksi['nama_member']?></td>
                        <td><?=$data_transaksi['nama_paket']?></td>
                        <td><?=$data_transaksi['status']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

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
    </div>

    <script>
        window.print();
    </script>
</body>
</html>