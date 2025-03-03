<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $alertas app\models\Alerta[] */
/* @var $ciudad string|null */
/* @var $ubicaciones array */

$this->title = 'Alertas de tu Ciudad';
?>
<!-- Para que funcione el mapa -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="container mt-4">
    <h1 class="text-center" style="margin: 50px;">
        <?= Html::encode($this->title) ?>
    </h1>

    <!-- Filtro por ciudad -->
    <?php if ($ciudad): ?>
        <div class="text-center mb-3">
            <p class="d-inline">Filtrado por: <strong><?= Html::encode($ciudad) ?></strong></p>
            <a href="<?= Url::to(['site/index', 'borrarFiltro' => 1]) ?>" class="btn" id="borrarFiltro">Borrar filtros</a>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Columna de alertas (8 columnas de 12) -->
        <div class="col-md-8">
            <div id="alertas-container">
                <?php if (!empty($alertas)): ?>
                    <?php foreach ($alertas as $alerta): ?>
                        <div class="alert-post">
                            <div class="post-header">
                                <div class="user-info">
                                    <img src="<?= !empty($alerta->usuario->foto) ? Html::encode($alerta->usuario->foto) : Url::to('@web/images/resources/iconuser.png') ?>" alt="Foto de perfil" class="profile-pic">
                                    <div class="user-details">
                                        <strong><?= Html::encode($alerta->usuario->nombre ?? 'Usuario Anónimo') ?></strong>
                                        <small><?= date('d M Y', strtotime($alerta->fecha_creacion)) ?></small>
                                    </div>
                                    <?php if (!empty($alerta->ubicacion->nombre)): ?>
                                        <div class="ubicacion-label"><?= Html::encode($alerta->ubicacion->nombre) ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="post-content">
                                <img src="<?= !empty($alerta->imagen) ? Html::encode($alerta->imagen) : Url::to('@web/images/resources/no-image.svg') ?>" alt="Imagen de la alerta">
                                <h5><?= Html::encode($alerta->titulo) ?></h5>
                                <p class="post-description"><?= Html::encode($alerta->descripcion) ?></p>
                            </div>
                            <div class="post-actions">
                                <button class="btn-like" onclick="this.firstElementChild.src = this.firstElementChild.src.includes('like.svg') ? '<?= Url::to('@web/images/resources/heart.svg') ?>' : '<?= Url::to('@web/images/resources/like.svg') ?>'">
                                    <img src="<?= Url::to('@web/images/resources/like.svg') ?>" alt="Me gusta">
                                </button>
                                <button class="btn-open">
                                    <img src="<?= Url::to('@web/images/resources/open.svg') ?>" alt="Abrir">
                                </button>
                                <button class="btn-comment">
                                    <img src="<?= Url::to('@web/images/resources/coment.svg') ?>" alt="Comentar">
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No hay alertas para esta ubicación.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Columna del mapa -->
        <div class="col-md-4">
            <div class="map-container">
                <div class="map-title">Mapa de Ubicaciones</div>
                <div id="map" style="height: 600px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<footer class="text-center mt-5 py-3 bg-dark text-light">
    <p>&copy; <?= date('Y') ?> Alertas de tu Ciudad. Todos los derechos reservados.</p>
</footer>

<!-- Modal para filtrar por ubicación -->
<div id="modalUbicacion" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">¿Filtrar alertas por ubicación?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" id="inputCiudad" class="form-control" placeholder="Escribe el nombre de la ubicación para filtrar las alertas...">
                <div id="listaResultados" class="list-group mt-2"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelarFiltro">Cancelar</button>
                <button type="button" class="btn" id="aceptarFiltro">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Manejo del modal de filtro por ubicación
        var inputCiudad = document.getElementById("inputCiudad");
        var listaResultados = document.getElementById("listaResultados");

        inputCiudad.addEventListener("input", function () {
            let query = inputCiudad.value.trim();
            if (query.length < 2) {
                listaResultados.innerHTML = "";
                return;
            }
            fetch("<?= Url::to(['site/buscar-ubicacion']) ?>&q=" + encodeURIComponent(query))
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
                window.location.href = "<?= Url::to(['site/index']) ?>" + "&ciudad=" + encodeURIComponent(ciudad);
            } else {
                alert("Por favor, selecciona una ubicación.");
            }
        };

        document.getElementById("cancelarFiltro").onclick = function () {
            var modalEl = document.getElementById('modalUbicacion');
            var modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
        };

        // Mostrar el modal automáticamente si no hay filtro aplicado
        var filterApplied = <?= $ciudad ? 'true' : 'false' ?>;
        if (!sessionStorage.getItem("modalShown") && !filterApplied) {
            setTimeout(() => {
                const modal = new bootstrap.Modal(document.getElementById('modalUbicacion'));
                modal.show();
                sessionStorage.setItem("modalShown", "true");
            }, 1000);
        }

        // Configuración inicial del mapa
        const map = L.map('map').setView([40.4168, -3.7038], 6); // Centrar el mapa en España

        // Añadir capa de tiles (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Obtener las ubicaciones desde PHP
        const ubicaciones = <?= json_encode($ubicaciones) ?>;

        // Crear un grupo de marcadores para gestionarlos mejor
        const markers = L.layerGroup().addTo(map);

        // Añadir marcadores al mapa
        ubicaciones.forEach(ubicacion => {
            const { latitud, longitud, nombre } = ubicacion;

            if (latitud && longitud) {
                // Crear el marcador
                const marker = L.marker([parseFloat(latitud), parseFloat(longitud)], {
                    title: nombre // Tooltip por defecto
                });

                // Crear el contenido del tooltip
                const tooltipContent = `<b>${nombre}</b>`;

                // Asignar tooltip al marcador
                marker.bindTooltip(tooltipContent, {
                    permanent: false, // No mostrar permanentemente
                    direction: 'top', // Dirección del tooltip
                    className: 'map-tooltip', // Clase CSS para el tooltip
                    opacity: 1 // Hacer el tooltip completamente visible
                });

                // Desactivar el popup al hacer clic
                marker.on('click', () => {}); // No hacer nada al hacer clic

                // Añadir el marcador al grupo
                markers.addLayer(marker);
            }
        });

        // Ajustar el zoom del mapa para que se vean todos los marcadores
        if (ubicaciones.length > 0) {
            const bounds = L.latLngBounds(ubicaciones.map(ubicacion => [
                parseFloat(ubicacion.latitud), parseFloat(ubicacion.longitud)
            ]));
            map.fitBounds(bounds);
        }
    });
</script>