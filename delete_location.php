<?php
// delete_location.php - Eliminar ubicación

header('Content-Type: application/json');

require_once 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$locations = json_decode(file_get_contents('locations.json'), true);

$locations = array_filter($locations, function($location) use ($data) {
    return $location['id'] != $data['id'];
});

file_put_contents('locations.json', json_encode(array_values($locations), JSON_PRETTY_PRINT));

echo json_encode(['success' => true]);
?>