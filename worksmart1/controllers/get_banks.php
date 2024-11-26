<?php
header('Content-Type: application/json');
require_once '../databases/database.php';

if (!$conn) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$query = "SELECT bank_id, bank_name FROM banks WHERE is_active = 1";
$result = $conn->query($query);

$banks = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $banks[] = [
            'id' => $row['bank_id'],
            'name' => $row['bank_name']
        ];
    }
    echo json_encode($banks);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed']);
}
