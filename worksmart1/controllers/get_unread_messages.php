<?php
require 'function.php';
checkAuth();

$user_id = $_SESSION['user_id'];
$unread_data = getUnreadMessages($user_id);
echo json_encode($unread_data);
