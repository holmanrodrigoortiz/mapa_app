# Mapa Interactivo con Google Maps API

Este proyecto es una aplicación web interactiva que integra la API JavaScript de Google Maps para mostrar mapas interactivos, buscar lugares, añadir marcadores y gestionar ubicaciones.

## Características

- **Visualización de mapas**: Muestra un mapa centrado en coordenadas específicas
- **Búsqueda de lugares**: Busca lugares usando la API de Places de Google
- **Marcadores interactivos**: Añade marcadores haciendo clic en el mapa
- **Geolocalización**: Obtén tu ubicación actual
- **Gestión de ubicaciones**: Guarda, visualiza y elimina ubicaciones personalizadas
- **Interfaz responsiva**: Diseño adaptable a diferentes dispositivos

## Estructura del proyecto

```
mapa_app/
├── index.php          # Página principal
├── config.php         # Configuración (API key)
├── .env.example       # Ejemplo de variables de entorno
├── locations.json     # Almacenamiento de ubicaciones
├── css/
│   └── style.css      # Estilos CSS
├── js/
│   └── map.js         # Funcionalidad JavaScript
├── save_location.php  # Endpoint para guardar ubicaciones
├── get_locations.php  # Endpoint para obtener ubicaciones
└── delete_location.php # Endpoint para eliminar ubicaciones
```

## Instalación y configuración

1. **Clona o descarga** los archivos del proyecto en tu servidor web (XAMPP, WAMP, etc.)

2. **Obtén una API Key de Google Maps**:
   - Ve a [Google Cloud Console](https://console.cloud.google.com/)
   - Crea un nuevo proyecto o selecciona uno existente
   - Habilita las siguientes APIs:
     - Maps JavaScript API
     - Places API
   - Crea una API Key con restricciones apropiadas
   - Copia la API Key

3. **Configura la API Key** (elige una opción):
   
   **Opción A - Directo en config.php:**
   - Abre `config.php`
   - Reemplaza `'TU_API_KEY_AQUI'` con tu API Key real en la línea:
     ```php
     $apiKey = getenv('GOOGLE_MAPS_API_KEY') ?: 'TU_API_KEY_AQUI';
     ```
   
   **Opción B - Archivo .env (recomendado):**
   - Copia `.env.example` como `.env`
   - Edita `.env` y añade tu API Key:
     ```
     GOOGLE_MAPS_API_KEY=TU_CLAVE_REAL_AQUI
     ```
   - El archivo `.env` se carga automáticamente

4. **Ejecuta el proyecto**:
   - Asegúrate de que tu servidor web esté ejecutándose
   - Abre tu navegador y ve a `http://localhost/mapa_app/`

## Uso

- **Buscar lugares**: Escribe en el campo de búsqueda y selecciona un lugar
- **Ir a coordenadas**: Ingresa latitud y longitud en el formulario y haz clic en "Actualizar Mapa"
- **Añadir marcadores**: Haz clic en cualquier lugar del mapa para añadir un marcador
- **Mi ubicación**: Haz clic en "Mi Ubicación" para centrar el mapa en tu posición actual
- **Gestionar ubicaciones**: Las ubicaciones guardadas aparecen en la lista inferior

## Tecnologías utilizadas

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **APIs**: Google Maps JavaScript API, Google Places API
- **Almacenamiento**: JSON (para simplicidad; en producción usar base de datos)

## Notas de seguridad

- Nunca expongas tu API Key en código público
- Usa variables de entorno para la API Key en producción
- Implementa validación y sanitización de datos del usuario
- Considera usar HTTPS en producción

## Próximas mejoras

- Integración con base de datos (MySQL, PostgreSQL)
- Autenticación de usuarios
- Rutas y direcciones
- Filtros de búsqueda avanzados
- Exportación de datos

## Licencia

Este proyecto es de código abierto. Siéntete libre de modificarlo y adaptarlo a tus necesidades.