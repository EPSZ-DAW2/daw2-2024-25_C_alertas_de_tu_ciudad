<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $alertas app\models\Alerta[] */
/* @var $ciudad string|null */
/* @var $ubicaciones array */

$this->title = 'Búsqueda de Alertas';
?>
<!-- Para que funcione el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>


<div class="container mt-4">
    <h1 class="text-center" style="margin: 50px;">
        <?= Html::encode($this->title) ?>
    </h1>

    <!-- Filtro por ubicación en la parte superior -->
    <div class="card p-3 mb-4 text-center">
        <h5>Filtrar alertas por ubicación global</h5>
        <input type="text" id="inputCiudad" class="form-control" placeholder="Escribe el nombre de la ubicación...">
        <div id="listaResultados" class="list-group mt-2"></div>
        <div class="mt-2 text-center">
            <button class="btn" id="aceptarFiltro">Buscar</button>
            <button class="btn" id="openMap">Búsqueda por mapa</button>
        </div>
    </div>
    <div class="col-md-15" id="map-container" style="display: none;">
        <div class="map-container">
                <div class="map-title">Mapa de Ubicaciones</div>
                <div id="map" style="height: 600px; width: 100%;"></div>
            </div>
        </div>
    </div>
<footer class="text-center mt-5 py-3 bg-dark text-light">
    <p>&copy; <?= date('Y') ?> Búsqueda de Alertas. Todos los derechos reservados.</p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var inputCiudad = document.getElementById("inputCiudad");
        var listaResultados = document.getElementById("listaResultados");
        var mapContainer = document.getElementById("map-container");
        var openMap = document.getElementById("openMap");


        inputCiudad.addEventListener("input", function () {
            let query = inputCiudad.value.trim();
            if (query.length < 2) {
                listaResultados.innerHTML = "";
                return;
            }
            fetch("<?= Url::to(['site/buscar-ubicacion']) ?>?q=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    listaResultados.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(item => {
                            let div = document.createElement("a");
                            div.classList.add("list-group-item", "list-group-item-action");
                            div.innerHTML = `<div>${item.nombre}</div><small style="color:#6c757d;">${item.padre}</small>`;
                            div.href = "#";
                            div.addEventListener("click", function (e) {
                                e.preventDefault();
                                inputCiudad.value = item.nombre;
                                listaResultados.innerHTML = "";
                            });
                            listaResultados.appendChild(div);
                        });
                    } else {
                        listaResultados.innerHTML = '<p class="list-group-item">No encontrado.</p>';
                    }
                });
        });

        document.getElementById("aceptarFiltro").onclick = function () {
            var ciudad = inputCiudad.value.trim();
            if (ciudad) {
                window.location.href = "<?= Url::to(['site/index']) ?>?ciudad=" + encodeURIComponent(ciudad);
            } else {
                alert("Por favor, selecciona una ubicación.");
            }
        };

        openMap.onclick = function () {
            mapContainer.style.display = "block";
            map.invalidateSize(); //porque no se carga bien a veces
        };


        // Configuración del mapa
        const map = L.map('map').setView([40.4168, -3.7038], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const ubicaciones = <?= json_encode($ubicaciones) ?>;
        const markers = L.layerGroup().addTo(map);

        ubicaciones.forEach(ubicacion => {
            const { latitud, longitud, nombre } = ubicacion;
            if (latitud && longitud) {
                const marker = L.marker([parseFloat(latitud), parseFloat(longitud)], {
                    title: nombre
                });

                marker.bindTooltip(`<b>${nombre}</b>`, { permanent: false, direction: 'top' });

                marker.on('click', function () {
                    // Simular que el usuario ha escrito en el input y ha hecho clic en "Buscar"
                    inputCiudad.value = nombre;
                    document.getElementById("aceptarFiltro").click();
                });

                markers.addLayer(marker);
            }
        });

        if (ubicaciones.length > 0) {
            const bounds = L.latLngBounds(ubicaciones.map(ubicacion => [parseFloat(ubicacion.latitud), parseFloat(ubicacion.longitud)]));
            map.fitBounds(bounds);
        }
    });
</script>