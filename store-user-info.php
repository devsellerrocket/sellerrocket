<?php
// Allow cross-origin requests (optional)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Read JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Check input
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'No data received']);
    exit;
}

// Database config
$host = 'localhost';
$db = 'u827204564_ipaddress';
$user = 'u827204564_ip_address';
$pass = 'Sellerrocket@1@1';

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed']));
}

// Prepare statement
$stmt = $conn->prepare("INSERT INTO user_visits 
(ip_address, user_agent, platform, browser_language, screen_resolution, referrer, current_url, page_title, hostname, pathname, query_string, hash, network_type, device_memory, save_data_mode) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param(
    "sssssssssssssss",
    $input['ip_address'],
    $input['user_agent'],
    $input['platform'],
    $input['browser_language'],
    $input['screen_resolution'],
    $input['referrer'],
    $input['current_url'],
    $input['page_title'],
    $input['hostname'],
    $input['pathname'],
    $input['query_string'],
    $input['hash'],
    $input['network_type'],
    $input['device_memory'],
    $input['save_data_mode']
);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Insert failed']);
}

$stmt->close();
$conn->close();
?>
