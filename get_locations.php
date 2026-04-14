<?php
// get_locations.php - Obtener ubicaciones guardadas

header('Content-Type: application/json');

require_once 'config.php';

$locations = json_decode(file_get_contents('locations.json'), true);

echo json_encode($locations);
?>