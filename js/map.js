// map.js - Funcionalidad JavaScript para Google Maps

let map;
let markers = [];
let searchBox;
let currentInfoWindow = null;

function initMap() {
    // Obtenemos las coordenadas procesadas por PHP
    const location = new google.maps.LatLng(window.mapLat, window.mapLng);

    // Creamos la instancia del mapa
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: window.mapZoom,
        center: location,
        mapId: "DEMO_MAP_ID",
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: true
    });

    // Añadimos un marcador inicial
    addMarker(location, "Ubicación Seleccionada");

    // Inicializar Places API para búsqueda
    initSearchBox();

    // Evento para añadir marcador al hacer clic en el mapa
    map.addListener('click', function(event) {
        addMarker(event.latLng, 'Marcador añadido');
    });

    // Cargar marcadores guardados
    loadSavedLocations();
}

function initSearchBox() {
    // Crear el input de búsqueda
    const input = document.getElementById('search-input');
    searchBox = new google.maps.places.SearchBox(input);

    // Sesgar los resultados de SearchBox hacia la vista actual del mapa
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });

    // Escuchar los cambios en el input de búsqueda
    searchBox.addListener('places_changed', function() {
        const places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Limpiar marcadores anteriores
        clearMarkers();

        // Para cada lugar, obtener el icono, nombre y ubicación
        const bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
            if (!place.geometry) {
                console.log("Lugar retornado no contiene geometría");
                return;
            }

            // Crear un marcador para cada lugar
            addMarker(place.geometry.location, place.name);

            if (place.geometry.viewport) {
                bounds.union(place.geometry.viewport);
            } else {
                bounds.extend(place.geometry.location);
            }
        });
        map.fitBounds(bounds);
    });
}

function addMarker(position, title) {
    const marker = new google.maps.Marker({
        position: position,
        map: map,
        title: title,
        animation: google.maps.Animation.DROP
    });

    // Crear InfoWindow
    const infoWindow = new google.maps.InfoWindow({
        content: `<div><strong>${title}</strong><br>Lat: ${position.lat().toFixed(6)}<br>Lng: ${position.lng().toFixed(6)}</div>`
    });

    marker.addListener('click', function() {
        if (currentInfoWindow) {
            currentInfoWindow.close();
        }
        infoWindow.open(map, marker);
        currentInfoWindow = infoWindow;
    });

    markers.push(marker);
}

function clearMarkers() {
    markers.forEach(marker => marker.setMap(null));
    markers = [];
}

function saveLocation(lat, lng, name) {
    // Enviar datos al servidor para guardar
    fetch('save_location.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ lat: lat, lng: lng, name: name })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadSavedLocations();
        } else {
            alert('Error al guardar la ubicación');
        }
    })
    .catch(error => console.error('Error:', error));
}

function loadSavedLocations() {
    fetch('get_locations.php')
    .then(response => response.json())
    .then(data => {
        displayLocations(data);
    })
    .catch(error => console.error('Error:', error));
}

function displayLocations(locations) {
    const list = document.getElementById('locations-list');
    list.innerHTML = '';

    locations.forEach(location => {
        const item = document.createElement('div');
        item.className = 'location-item';

        item.innerHTML = `
            <div class="location-info">
                <strong>${location.name}</strong><br>
                Lat: ${location.lat}, Lng: ${location.lng}
            </div>
            <button class="delete-btn" onclick="deleteLocation(${location.id})">Eliminar</button>
        `;

        list.appendChild(item);
    });
}

function deleteLocation(id) {
    fetch('delete_location.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadSavedLocations();
        } else {
            alert('Error al eliminar la ubicación');
        }
    })
    .catch(error => console.error('Error:', error));
}

function getCurrentLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            map.setCenter(pos);
            map.setZoom(15);
            addMarker(pos, 'Tu ubicación actual');
        }, function() {
            alert('Error: La geolocalización falló.');
        });
    } else {
        alert('Error: Tu navegador no soporta geolocalización.');
    }
}

function clearAllMarkers() {
    clearMarkers();
    // Recargar marcadores guardados
    loadSavedLocations();
}

// Hacer funciones globales para usar en HTML
window.initMap = initMap;
window.getCurrentLocation = getCurrentLocation;
window.clearAllMarkers = clearAllMarkers;