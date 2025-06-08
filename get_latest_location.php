<?php
$host = 'localhost';
$db = 'location_tracker';
$user = '';
$pass = '';

header('Content-Type: application/json');

$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$result = $mysqli->query("SELECT latitude, longitude, recorded_at FROM locations ORDER BY recorded_at DESC LIMIT 1");
if ($row = $result->fetch_assoc()) {
    echo json_encode([
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude'],
        'timestamp' => $row['recorded_at']
    ]);
} else {
    echo json_encode(['error' => 'No data found']);
}

$mysqli->close();
?>