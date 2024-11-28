<?php
require '../controllers/function.php';
require '../databases/database.php';
checkAuth();
// At the top after checkAuth()
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data with validation
$kategori = $_POST['kategori'] ?? '';
$start_date = $_POST['start_date'] ?? date('Y-m-d');
$end_date = $_POST['end_date'] ?? date('Y-m-d');
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// Format dates for query
$formatted_start_date = date('Y-m-d', strtotime($start_date));
$formatted_end_date = date('Y-m-d', strtotime($end_date));

// Initialize variables
$query = '';
$headers = [];
$data = [];

// Only proceed if kategori is not empty
if (!empty($kategori)) {
    switch($kategori) {
        case 'Peserta':
            if($role == 'mitra') {
                $query = "SELECT DISTINCT u.first_name, u.last_name, u.username, u.email, u.phone, 
                         DATE_FORMAT(r.registration_date, '%d/%m/%Y') as registration_date
                         FROM users u 
                         JOIN registrations r ON u.user_id = r.user_id
                         JOIN workshops w ON r.workshop_id = w.workshop_id
                         WHERE u.role = 'user' AND w.mitra_id = $user_id
                         AND DATE(r.registration_date) BETWEEN '$formatted_start_date' AND '$formatted_end_date'";
            } else {
                $query = "SELECT first_name, last_name, username, email, phone, 
                         DATE_FORMAT(created_at, '%d/%m/%Y') as created_at 
                         FROM users 
                         WHERE role = 'user' 
                         AND DATE(created_at) BETWEEN '$formatted_start_date' AND '$formatted_end_date'";
            }
            $headers = ['Nama Depan', 'Nama Belakang', 'Username', 'Email', 'No. Telepon', 'Tanggal Registrasi'];
            break;
            
        case 'Mitra':
            if($role == 'admin') {
                $query = "SELECT first_name, last_name, username, email, phone, 
                         DATE_FORMAT(created_at, '%d/%m/%Y') as created_at 
                         FROM users 
                         WHERE role = 'mitra' 
                         AND DATE(created_at) BETWEEN '$formatted_start_date' AND '$formatted_end_date'";
                $headers = ['Nama Depan', 'Nama Belakang', 'Username', 'Email', 'No. Telepon', 'Tanggal Registrasi'];
            }
            break;

        case 'Keuangan':
            if($role == 'mitra') {
                $query = "SELECT 
                    r.registration_id,
                    CONCAT(u.first_name, ' ', u.last_name) as nama_peserta,
                    w.title as nama_workshop,
                    w.price as harga_workshop,
                    p.amount as jumlah_bayar,
                    p.payment_method as metode_pembayaran,
                    p.payment_status as status_pembayaran,
                    DATE_FORMAT(p.payment_date, '%d/%m/%Y') as tanggal_pembayaran,
                    r.status as status_registrasi
                    FROM registrations r
                    LEFT JOIN payments p ON r.registration_id = p.registration_id
                    LEFT JOIN users u ON r.user_id = u.user_id
                    LEFT JOIN workshops w ON r.workshop_id = w.workshop_id
                    WHERE w.mitra_id = $user_id
                    AND DATE(r.created_at) BETWEEN '$formatted_start_date' AND '$formatted_end_date'";
            } else {
                $query = "SELECT 
                    r.registration_id,
                    CONCAT(u.first_name, ' ', u.last_name) as nama_peserta,
                    w.title as nama_workshop,
                    w.price as harga_workshop,
                    p.amount as jumlah_bayar,
                    p.payment_method as metode_pembayaran,
                    p.payment_status as status_pembayaran,
                    DATE_FORMAT(p.payment_date, '%d/%m/%Y') as tanggal_pembayaran,
                    r.status as status_registrasi
                    FROM registrations r
                    LEFT JOIN payments p ON r.registration_id = p.registration_id
                    LEFT JOIN users u ON r.user_id = u.user_id
                    LEFT JOIN workshops w ON r.workshop_id = w.workshop_id
                    WHERE DATE(r.created_at) BETWEEN '$formatted_start_date' AND '$formatted_end_date'";
            }
            $headers = ['ID Registrasi', 'Nama Peserta', 'Workshop', 'Harga Workshop', 'Jumlah Bayar', 'Metode Pembayaran', 'Status Pembayaran', 'Tanggal Pembayaran', 'Status Registrasi'];
            break;
    }
}

// Execute query and format data
$data = [];
if (!empty($query)) {
    $result = $conn->query($query);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Format currency for keuangan report
        if ($kategori === 'Keuangan') {
            foreach ($data as &$row) {
                if(isset($row['harga_workshop'])) {
                    $row['harga_workshop'] = 'Rp. ' . number_format((float)$row['harga_workshop'], 0, ',', '.');
                }
                if(isset($row['jumlah_bayar'])) {
                    $row['jumlah_bayar'] = 'Rp. ' . number_format((float)$row['jumlah_bayar'], 0, ',', '.');
                }
            }
        }
    }
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan <?= ucfirst($kategori) ?></title>
    <style>
        @media print {
            @page { margin: 0.5cm; }
        }
        body { 
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo-container img {
            max-width: 200px;
            height: auto;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin: 10px 0;
        }
        table { 
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        th, td { 
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th { 
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f5f5f5;
        }
        tr:hover {
            background-color: #f0f0f0;
        }
        .header { 
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .periode { 
            margin-bottom: 15px;
            color: #666;
            font-style: italic;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="assets/img/logo-worksmart.png" alt="WorkSmart Logo">
        <div class="company-name">WorkSmart</div>
    </div>
    
    <div class="header">    
        <h2>Laporan Data <?= ucfirst($kategori) ?></h2>
        <div class="periode">
            Periode: <?= date('d/m/Y', strtotime($start_date)) ?> - <?= date('d/m/Y', strtotime($end_date)) ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <?php foreach ($headers as $header): ?>
                    <th><?= $header ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <?php foreach ($row as $cell): ?>
                        <td><?= $cell ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
