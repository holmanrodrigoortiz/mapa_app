<?php
// config.php - Archivo de configuración para Google Maps API
//
// INSTRUCCIONES PARA OBTENER Y CONFIGURAR LA API KEY:
//
// 1. Ve a https://console.cloud.google.com/
// 2. Crea un nuevo proyecto o selecciona uno existente
// 3. Habilita las siguientes APIs:
//    - Maps JavaScript API
//    - Places API
// 4. Ve a "Credenciales" > "Crear credenciales" > "Clave de API"
// 5. Copia la clave generada
// 6. Restringe la clave para mayor seguridad:
//    - Aplicaciones web
//    - Sitios web: http://localhost, http://localhost:8080, etc.
// 7. Reemplaza 'TU_API_KEY_AQUI' con tu clave real abajo
//
// IMPORTANTE: Nunca subas tu API key a repositorios públicos!

// Cargar variables de entorno desde .env si existe
if (file_exists(__DIR__ . '/.env')) {
    $envLines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// API Key de Google Maps
// Primero intenta obtener de variable de entorno, si no existe usa el valor por defecto
$apiKey = getenv('GOOGLE_MAPS_API_KEY') ?: 'TU_API_KEY_AQUI';
define('GOOGLE_MAPS_API_KEY', $apiKey);

// Otras configuraciones
define('DEFAULT_LAT', 4.6097);  // Latitud por defecto (Bogotá, Colombia)
define('DEFAULT_LNG', -74.0817); // Longitud por defecto
define('DEFAULT_ZOOM', 12);     // Zoom por defecto
?>