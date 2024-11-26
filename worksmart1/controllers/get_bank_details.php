<?php
header('Content-Type: application/json');
require_once '../databases/database.php';

$bank_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($bank_id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid bank ID']);
    exit;
}

try {
    $query = "SELECT bank_name, account_name, account_number, swift_code 
              FROM banks 
              WHERE bank_id = ? AND is_active = 1";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $bank_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'name' => $row['bank_name'],
            'account_name' => $row['account_name'],
            'account_number' => $row['account_number'],
            'swift_code' => $row['swift_code'] ?? '-'
        ]);
        exit;
    }

    http_response_code(404);
    echo json_encode(['error' => 'Bank not found']);
    exit;
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch bank details']);
    exit;
}
