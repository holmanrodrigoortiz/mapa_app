<?php
require_once 'config.php';

// Valores por defecto
$lat = DEFAULT_LAT;
$lng = DEFAULT_LNG;
$zoom = DEFAULT_ZOOM;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputLat = filter_input(INPUT_POST, 'latitud', FILTER_VALIDATE_FLOAT);
    $inputLng = filter_input(INPUT_POST, 'longitud', FILTER_VALIDATE_FLOAT);

    if ($inputLat !== false && $inputLng !== false) {
        $lat = $inputLat;
        $lng = $inputLng;
        $zoom = 15;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visor de Mapas Interactivo - PHP & Google Maps API</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Mapa Interactivo con Google Maps</h1>

        <div class="search-container">
            <input id="search-input" type="text" placeholder="Buscar lugares...">
        </div>

        <form method="POST" action="" class="form-group">
            <input type="text" name="latitud" placeholder="Latitud (ej: 4.609)" value="<?php echo $lat; ?>" required>
            <input type="text" name="longitud" placeholder="Longitud (ej: -74.081)" value="<?php echo $lng; ?>" required>
            <button type="submit">Actualizar Mapa</button>
        </form>

        <div class="controls">
            <button class="control-btn" onclick="getCurrentLocation()">Mi Ubicación</button>
            <button class="control-btn" onclick="clearAllMarkers()">Limpiar Marcadores</button>
        </div>

        <div id="map"></div>

        <div id="locations-list">
            <!-- Las ubicaciones guardadas se cargarán aquí -->
        </div>
    </div>

    <script async src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&libraries=places&callback=initMap"></script>
    <script>
        // Variables globales para PHP
        window.mapLat = <?php echo $lat; ?>;
        window.mapLng = <?php echo $lng; ?>;
        window.mapZoom = <?php echo $zoom; ?>;
    </script>
    <script src="js/map.js"></script>
</body>
</html>