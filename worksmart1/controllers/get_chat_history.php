<?php
require '../controllers/function.php';
checkAuth();

$receiver_id = $_GET['receiver_id'] ?? null;
$sender_id = $_SESSION['user_id'];

if ($receiver_id) {
    markMessagesAsRead($receiver_id, $sender_id);
    $messages = getChatHistory($sender_id, $receiver_id);
    echo json_encode($messages);
}
