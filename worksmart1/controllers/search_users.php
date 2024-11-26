<?php
require 'function.php';
checkAuth();

$search_term = $_GET['term'] ?? '';
$results = searchUsers($search_term);
echo json_encode($results);
