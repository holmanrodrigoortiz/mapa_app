<?php
// save_location.php - Guardar ubicación en JSON

header('Content-Type: application/json');

require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['lat']) || !isset($data['lng']) || !isset($data['name'])) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

$locations = json_decode(file_get_contents('locations.json'), true);

$newLocation = [
    'id' => time(), // Usar timestamp como ID simple
    'lat' => floatval($data['lat']),
    'lng' => floatval($data['lng']),
    'name' => htmlspecialchars($data['name'])
];

$locations[] = $newLocation;

file_put_contents('locations.json', json_encode($locations, JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);
?>