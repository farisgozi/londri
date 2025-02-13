<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Transaksi | LaundryApp</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
        @page {
            size: A3 portrait;
            margin: 20mm;
        }
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }
        .header-section {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px 0;
            border-bottom: 2px solid #333;
        }
        .logo {
            max-width: 120px;
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
            font-size: 14px;
        }
        .summary-section {
            margin: 30px 0;
            page-break-inside: avoid;
        }
        .summary-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-box h5 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }
        .summary-box .value {
            font-size: 18px;
            font-weight: bold;
        }
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 20px;
        }
        .status-box {
            text-align: center;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .terms {
            margin-top: 30px;
            font-size: 13px;
            page-break-inside: avoid;
        }
        .terms h4 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .terms ol {
            padding-left: 20px;
            margin: 0;
        }
        .terms li {
            margin-bottom: 8px;
        }
        .col-no { width: 5%; }
        .col-outlet { width: 12%; }
        .col-date { width: 10%; }
        .col-deadline { width: 10%; }
        .col-payment { width: 10%; }
        .col-paydate { width: 10%; }
        .col-customer { width: 15%; }
        .col-package { width: 18%; }
        .col-status { width: 10%; }
        
        .container {
            max-width: 257mm;
            margin: 0 auto;
        }
        
        @media print {
            .table th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
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

        <?php
        // Calculate summary statistics
        include "koneksi.php";
        
        // Total Revenue
        $result = mysqli_query($conn, "SELECT SUM(p.harga) as total_revenue 
                                     FROM transaksi t 
                                     JOIN paket p ON t.id_paket = p.id_paket 
                                     WHERE t.dibayar = 'dibayar'");
        $total_revenue = mysqli_fetch_assoc($result)['total_revenue'] ?? 0;

        // Total Transactions
        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi");
        $total_transactions = mysqli_fetch_assoc($result)['total'];

        // Status Distribution
        $status_dist = mysqli_query($conn, "SELECT status, COUNT(*) as count 
                                          FROM transaksi 
                                          GROUP BY status");
        $status_counts = [];
        while($row = mysqli_fetch_assoc($status_dist)) {
            $status_counts[$row['status']] = $row['count'];
        }

        // Payment Status
        $payment_dist = mysqli_query($conn, "SELECT dibayar, COUNT(*) as count 
                                           FROM transaksi 
                                           GROUP BY dibayar");
        $payment_counts = [];
        while($row = mysqli_fetch_assoc($payment_dist)) {
            $payment_counts[$row['dibayar']] = $row['count'];
        }

        // Revenue by Outlet
        $outlet_revenue = mysqli_query($conn, "SELECT o.nama, COUNT(*) as transactions, 
                                             SUM(p.harga) as revenue
                                             FROM transaksi t 
                                             JOIN outlet o ON t.id_outlet = o.id_outlet
                                             JOIN paket p ON t.id_paket = p.id_paket
                                             WHERE t.dibayar = 'dibayar'
                                             GROUP BY o.id_outlet");
        ?>

        <div class="summary-section">
            <div class="summary-title">Rekapitulasi Statistik Penjualan</div>
            
            <div class="summary-grid">
                <div class="summary-box">
                    <h5>Total Pendapatan</h5>
                    <div class="value">Rp <?= number_format($total_revenue, 0, ',', '.') ?></div>
                </div>
                <div class="summary-box">
                    <h5>Total Transaksi</h5>
                    <div class="value"><?= number_format($total_transactions) ?></div>
                </div>
            </div>

            <div class="summary-title">Status Transaksi</div>
            <div class="status-grid">
                <div class="status-box">
                    <h5>Baru</h5>
                    <div class="value"><?= number_format($status_counts['baru'] ?? 0) ?></div>
                </div>
                <div class="status-box">
                    <h5>Proses</h5>
                    <div class="value"><?= number_format($status_counts['proses'] ?? 0) ?></div>
                </div>
                <div class="status-box">
                    <h5>Selesai</h5>
                    <div class="value"><?= number_format($status_counts['selesai'] ?? 0) ?></div>
                </div>
                <div class="status-box">
                    <h5>Diambil</h5>
                    <div class="value"><?= number_format($status_counts['diambil'] ?? 0) ?></div>
                </div>
            </div>

            <div class="summary-title">Status Pembayaran</div>
            <div class="summary-grid">
                <div class="summary-box">
                    <h5>Sudah Dibayar</h5>
                    <div class="value"><?= number_format($payment_counts['dibayar'] ?? 0) ?></div>
                </div>
                <div class="summary-box">
                    <h5>Belum Dibayar</h5>
                    <div class="value"><?= number_format($payment_counts['belum dibayar'] ?? 0) ?></div>
                </div>
            </div>

            <div class="summary-title">Pendapatan per Outlet</div>
            <table class="mb-4">
                <thead>
                    <tr>
                        <th>Outlet</th>
                        <th>Jumlah Transaksi</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($outlet_revenue)) { ?>
                    <tr>
                        <td><?= $row['nama'] ?></td>
                        <td><?= number_format($row['transactions']) ?></td>
                        <td>Rp <?= number_format($row['revenue'], 0, ',', '.') ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="summary-title">Detail Transaksi</div>
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
    </div>

    <script>
        window.print();
    </script>
</body>
</html>