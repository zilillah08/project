<?php
require '../controllers/function.php';
checkAuth();

$data = json_decode(file_get_contents('php://input'), true);
$sender_id = $_SESSION['user_id'];
$receiver_id = $data['receiver_id'] ?? null;
$message = $data['message'] ?? null;

$response = ['success' => false];

if ($receiver_id && $message) {
    $success = sendMessage($sender_id, $receiver_id, $message);
    $response['success'] = $success;
}

echo json_encode($response);
