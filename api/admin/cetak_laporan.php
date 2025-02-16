<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Transaksi | Launnres</title>
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

        .date {
            text-align: right;
            margin: 20px 0;
            font-size: 14px;
            color: #666;
        }

        .summary {
            margin-top: 20px;
            text-align: right;
        }

        .summary table {
            width: auto;
            margin-left: auto;
        }

        .summary td {
            padding: 5px 15px;
        }

        .summary .total {
            font-weight: bold;
            font-size: 16px;
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
        <p class="company-info">Launnres</p>
        <p class="company-info">Email: familylaundry@gmail.com</p>
    </div>

    <hr class="divider">

    <div class="date">
        <?php echo date('l, d F Y'); ?>
    </div>

    <h3 class="section-title">Daftar Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Outlet</th>
                <th>Paket</th>
                <th>Qty</th>
                <th>Harga/Kg</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "koneksi.php";
            $qry_transaksi = mysqli_query($conn, 
                "SELECT t.*, m.nama_member, o.nama as outlet_nama, p.nama_paket, p.harga, dt.qty 
                FROM transaksi t 
                JOIN member m ON t.id_member = m.id_member 
                JOIN outlet o ON t.id_outlet = o.id_outlet 
                JOIN paket p ON t.id_paket = p.id_paket 
                JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi 
                ORDER BY t.tgl DESC"
            );
            $no = 1;
            $total_all = 0;
            while($data = mysqli_fetch_array($qry_transaksi)){
                $total = $data['harga'] * $data['qty'];
                $total_all += $total;
            ?>
            <tr>
                <td><?=$no++?></td>
                <td>#<?=$data['id_transaksi']?></td>
                <td><?=date('d/m/Y', strtotime($data['tgl']))?></td>
                <td><?=$data['nama_member']?></td>
                <td><?=$data['outlet_nama']?></td>
                <td><?=$data['nama_paket']?></td>
                <td><?=$data['qty']?> kg</td>
                <td>Rp <?=number_format($data['harga'], 0, ',', '.')?></td>
                <td>Rp <?=number_format($total, 0, ',', '.')?></td>
                <td><?=ucfirst($data['status'])?></td>
                <td><?=ucfirst($data['dibayar'])?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr class="total">
                <td>Total Pendapatan:</td>
                <td>Rp <?=number_format($total_all, 0, ',', '.')?></td>
            </tr>
        </table>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>