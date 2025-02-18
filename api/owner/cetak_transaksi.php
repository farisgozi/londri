<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Transaksi | Launnres</title>
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
        .page {
            page-break-after: always;
            position: relative;
        }
        .page:last-child {
            page-break-after: avoid;
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
        }
        .summary-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .summary-box {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background: #f8f9fa;
        }
        .summary-box h5 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }
        .summary-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        .status-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        .status-box {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 13px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
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
        }
    </style>
</head>
<body>
    <?php
    include "koneksi.php";
    
    // Calculate summary statistics
    $result = mysqli_query($conn, "SELECT SUM(p.harga) as total_revenue 
                                 FROM transaksi t 
                                 JOIN paket p ON t.id_paket = p.id_paket 
                                 WHERE t.dibayar = 'dibayar'");
    $total_revenue = mysqli_fetch_assoc($result)['total_revenue'] ?? 0;

    $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM transaksi");
    $total_transactions = mysqli_fetch_assoc($result)['total'];

    $status_dist = mysqli_query($conn, "SELECT status, COUNT(*) as count 
                                      FROM transaksi 
                                      GROUP BY status");
    $status_counts = [];
    while($row = mysqli_fetch_assoc($status_dist)) {
        $status_counts[$row['status']] = $row['count'];
    }

    $payment_dist = mysqli_query($conn, "SELECT dibayar, COUNT(*) as count 
                                       FROM transaksi 
                                       GROUP BY dibayar");
    $payment_counts = [];
    while($row = mysqli_fetch_assoc($payment_dist)) {
        $payment_counts[$row['dibayar']] = $row['count'];
    }

    $outlet_revenue = mysqli_query($conn, "SELECT o.nama, COUNT(*) as transactions, 
                                         SUM(p.harga) as revenue
                                         FROM transaksi t 
                                         JOIN outlet o ON t.id_outlet = o.id_outlet
                                         JOIN paket p ON t.id_paket = p.id_paket
                                         WHERE t.dibayar = 'dibayar'
                                         GROUP BY o.id_outlet");
    ?>

    <!-- Page 1: Header and Summary Statistics -->
    <div class="page">
        <div class="container">
            <div class="header-section">
                <img src="../logos.webp" alt="Logo" class="logo">
                <div class="company-name">Launnres</div>
                <div class="report-title">Laporan Transaksi Laundry</div>
                <div>Email: launnreslaundry@gmail.com</div>
            </div>

            <div class="date-section">
                <strong>Tanggal Cetak:</strong> <?php echo date('l, d-m-Y'); ?>
            </div>

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
                <table>
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
        </div>
    </div>

    <!-- Page 2: Transaction Details -->
    <div class="page">
        <div class="container">
            <div class="header-section">
                <div class="company-name">Launnres</div>
                <div class="report-title">Detail Transaksi</div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 12%">Outlet</th>
                        <th style="width: 10%">Tanggal</th>
                        <th style="width: 10%">Batas Waktu</th>
                        <th style="width: 10%">Pembayaran</th>
                        <th style="width: 10%">Tanggal Bayar</th>
                        <th style="width: 15%">Customer</th>
                        <th style="width: 18%">Paket</th>
                        <th style="width: 10%">Status</th>
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
                        <td><?=$no?></td>
                        <td><?=$data_transaksi['nama_outlet']?></td>
                        <td><?=date('d/m/Y', strtotime($data_transaksi['tgl']))?></td>
                        <td><?=date('d/m/Y', strtotime($data_transaksi['batas_waktu']))?></td>
                        <td><?=$data_transaksi['dibayar']?></td>
                        <td><?=$data_transaksi['tgl_bayar'] ? date('d/m/Y', strtotime($data_transaksi['tgl_bayar'])) : '-'?></td>
                        <td><?=$data_transaksi['nama_member']?></td>
                        <td><?=$data_transaksi['nama_paket']?></td>
                        <td><?=$data_transaksi['status']?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Page 3: Terms and Conditions -->
    <div class="page">
        <div class="container">
            <div class="header-section">
                <div class="company-name">Launnres</div>
                <div class="report-title">Syarat dan Ketentuan</div>
            </div>

            <div class="terms">
                <ol>
                    <li>Pekerjaan dilakukan sesuai jam kerja yaitu hari Senin – Sabtu dari pukul 07:00 – 19:00. Diluar jam tersebut, maka pekerjaan tidak dilakukan. Hari minggu tidak dihitung sebagai hari layanan.</li>
                    <li>Jumlah berat yang ditimbang dan dijadikan nota adalah jumlah berat yang diterima pada saat diterima baik basah maupun kering.</li>
                    <li>Bukti tagihan yang sah di dalam transaksi kami adalah melalui nota digital atau nota fisik.</li>
                    <li>Kami tidak bertanggung jawab apabila terjadi kehilangan / kerusakan pada laundry bersih yang tidak diambil selama 1 bulan di workshop kami.</li>
                    <li>Kami menggunakan bahan detergent dan parfum dengan standar laundry tanpa mengetahui jenis alergi yang anda miliki. Segala jenis penggunaan sabun atau parfum milik pribadi tidak diperkenankan untuk digunakan di laundry kami dan apabila terjadi reaksi alergi pada kulit bukan menjadi tanggung jawab FamilyLaundry.</li>
                    <li>Pengaduan harap disampaikan secara tertulis di ke email launnreslaundry@gmail.com dengan melampirkan nomor nota, video unboxing serta keluhan yang dialami.</li>
                </ol>
            </div>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
