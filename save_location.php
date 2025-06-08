<?php
// MySQL connection settings
$host = 'localhost';
$db = 'location_tracker';
$user = '';
$pass = '';

header('Content-Type: application/json');

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data['latitude']) || !isset($data['longitude'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Connect to MySQL
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$lat = $data['latitude'];
$lon = $data['longitude'];

$stmt = $mysqli->prepare("INSERT INTO locations (latitude, longitude) VALUES (?, ?)");
$stmt->bind_param("dd", $lat, $lon);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'timestamp' => date('Y-m-d H:i:s')]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Insert failed']);
}

$stmt->close();
$mysqli->close();
?>