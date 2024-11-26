<?php
require '../controllers/function.php';
checkAuth();

if(isset($_GET['payment_id'])) {
    $payment_id = $_GET['payment_id'];
    $payment = getPaymentData($_SESSION['user_id']);
    // Get specific payment data
    $payment_data = array_filter($payment, function($p) use ($payment_id) {
        return $p['payment_id'] == $payment_id;
    });
    $payment_data = reset($payment_data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #<?= $payment_data['payment_id'] ?> - WorkSmart</title>
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 2px solid #ddd;
            border-radius: 10px;
            background: #fff;
        }
        
        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #5271ff;
        }
        
        .logo {
            width: 150px;
        }
        
        .invoice-title {
            text-align: right;
            color: #5271ff;
        }
        
        .invoice-details {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        
        .workshop-details {
            margin: 20px 0;
            padding: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .payment-info {
            margin-top: 20px;
            text-align: right;
        }
        
        .total-amount {
            font-size: 24px;
            color: #5271ff;
            font-weight: bold;
        }
        
        .payment-status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            color: white;
            font-weight: bold;
        }
        
        .status-successful {
            background: #28a745;
        }
        
        .status-failed {
            background: #dc3545;
        }
        
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
        }
        
        .qr-code {
            text-align: center;
            margin: 20px 0;
        }
        
        .print-button {
            background: #5271ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 20px 0;
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <img src="assets/img/logo-worksmart.png" alt="WorkSmart Logo" class="logo">
            <div class="invoice-title">
                <h1>INVOICE</h1>
                <h3>#<?= $payment_data['payment_id'] ?></h3>
            </div>
        </div>

        <div class="invoice-details">
            <table width="100%">
                <tr>
                    <td width="50%">
                        <strong>Tanggal Pembayaran:</strong><br>
                        <?= date('d F Y H:i', strtotime($payment_data['payment_date'])) ?>
                    </td>
                    <td width="50%" style="text-align: right;">
                        <strong>Status Pembayaran:</strong><br>
                        <span class="payment-status status-<?= $payment_data['payment_status'] ?>">
                            <?= ucfirst($payment_data['payment_status']) ?>
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="workshop-details">
            <h3>Detail Workshop</h3>
            <table width="100%">
                <tr>
                    <td width="30%"><strong>Nama Workshop</strong></td>
                    <td>: <?= $payment_data['workshop_title'] ?></td>
                </tr>
                <tr>
                    <td><strong>Penyelenggara</strong></td>
                    <td>: <?= $payment_data['mitra_name'] ?></td>
                </tr>
                <tr>
                    <td><strong>Lokasi</strong></td>
                    <td>: <?= $payment_data['location'] ?></td>
                </tr>
                <tr>
                    <td><strong>Tanggal</strong></td>
                    <td>: <?= date('d F Y', strtotime($payment_data['start_date'])) ?></td>
                </tr>
            </table>
        </div>

        <div class="payment-info">
            <table width="100%">
                <tr>
                    <td width="60%"></td>
                    <td width="20%"><strong>Total Pembayaran</strong></td>
                    <td width="20%" class="total-amount">Rp <?= number_format($payment_data['amount'], 0, ',', '.') ?></td>
                </tr>
            </table>
        </div>

        <div class="qr-code">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=INVOICE-<?= $payment_data['payment_id'] ?>" alt="QR Code">
        </div>

        <div class="footer">
            <p>Terima kasih telah menggunakan layanan WorkSmart</p>
            <p>Untuk informasi lebih lanjut hubungi support@worksmart.id</p>
        </div>
    </div>
</body>
</html>
