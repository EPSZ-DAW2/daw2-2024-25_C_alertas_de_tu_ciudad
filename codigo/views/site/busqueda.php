<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
use app\models\Etiqueta;
use app\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $alertas app\models\Alerta[] */
/* @var $ciudad string|null */
/* @var $ubicaciones array */

$this->title = 'Búsqueda Avanzada de Alertas';
$this->registerCssFile('@web/css/site.css?v=' . time());
?>

<div class="container mt-4">
    <h1 class="text-center" style="margin: 50px;">
        <?= Html::encode($this->title) ?>
    </h1>

    <div class="card p-3 mb-4">
        <form method="get" action="<?= Url::to(['site/index']) ?>" id="searchForm">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" name="titulo" class="form-control" placeholder="Título">
                </div>
                <div class="col-md-3">
                    <input type="text" name="descripcion" class="form-control" placeholder="Descripción">
                </div>
                <div class="col-md-3">
                    <?php
                    $categorias = ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre');
                    ?>
                    <select name="id_categoria" class="form-control">
                        <option value="">Categoría</option>
                        <?php foreach($categorias as $id => $nombre): ?>
                            <option value="<?= $id ?>"><?= Html::encode($nombre) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <?php
                    $etiquetas = ArrayHelper::map(Etiqueta::find()->all(), 'id', 'nombre');
                    ?>
                    <select name="id_etiqueta" class="form-control">
                        <option value="">Etiqueta</option>
                        <?php foreach($etiquetas as $id => $nombre): ?>
                            <option value="<?= $id ?>"><?= Html::encode($nombre) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-3 autocomplete-container">
                    <input type="text" id="inputContinente" name="continente" class="form-control" placeholder="Continente">
                    <div id="sugerenciasContinente" class="list-group sugerencias-autocomplete"></div>
                </div>
                <div class="col-md-3 autocomplete-container">
                    <input type="text" id="inputPais" name="pais" class="form-control" placeholder="País">
                    <div id="sugerenciasPais" class="list-group sugerencias-autocomplete"></div>
                </div>
                <div class="col-md-3 autocomplete-container">
                    <input type="text" id="inputComunidad" name="comunidad" class="form-control" placeholder="Comunidad Autónoma">
                    <div id="sugerenciasComunidad" class="list-group sugerencias-autocomplete"></div>
                </div>
                <div class="col-md-3 autocomplete-container">
                    <input type="text" id="inputProvincia" name="provincia" class="form-control" placeholder="Provincia">
                    <div id="sugerenciasProvincia" class="list-group sugerencias-autocomplete"></div>
                </div>
                <div class="col-md-3 autocomplete-container">
                    <input type="text" id="inputLocalidad" name="localidad" class="form-control" placeholder="Localidad">
                    <div id="sugerenciasLocalidad" class="list-group sugerencias-autocomplete"></div>
                </div>
                <div class="col-md-3 autocomplete-container">
                    <input type="text" id="inputBarrio" name="barrio" class="form-control" placeholder="Barrio">
                    <div id="sugerenciasBarrio" class="list-group sugerencias-autocomplete"></div>
                </div>

                <div class="col-md-3 autocomplete-container">
                    <div class="input-with-icon">
                        <input type="text" name="fecha_desde" id="fecha-desde" class="form-control" placeholder="Fecha Desde">
                        <i class="fas fa-calendar-alt input-icon"></i>
                    </div>
                </div>
                <div class="col-md-3 autocomplete-container">
                    <div class="input-with-icon">
                        <input type="text" name="fecha_hasta" id="fecha-hasta" class="form-control" placeholder="Fecha Hasta">
                        <i class="fas fa-calendar-alt input-icon"></i>
                    </div>
                </div>
            </div>

            <div class="mt-3 text-center">
                <button type="button" class="btn btn-custom" id="openMap">Búsqueda por Mapa</button>
                <button type="submit" class="btn btn-custom" id="btnBusqueda">Búsqueda Avanzada</button>
                <button type="button" class="btn btn-custom delete" id="limpiarFiltros">Limpiar Filtros</button>
            </div>
        </form>
    </div>

    <div class="col-md-15" id="map-container" style="display: none;">
        <div class="map-container">
            <div class="map-title">Mapa de Ubicaciones</div>
            <div id="map" style="height: 600px; width: 100%;"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    //Configuración de fechas
    $('#fecha-desde, #fecha-hasta').inputmask('99/99/9999');

    const fechaDesdePicker = flatpickr("#fecha-desde", {
        dateFormat: "d/m/Y",
        locale: "es",
        allowInput: true,
        maxDate: new Date(),
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                fechaHastaPicker.set('minDate', selectedDates[0]);
            } else {
                fechaHastaPicker.set('minDate', null);
            }
        }
    });

    const fechaHastaPicker = flatpickr("#fecha-hasta", {
        dateFormat: "d/m/Y",
        locale: "es",
        allowInput: true,
        maxDate: new Date(),
        onChange: function(selectedDates) {
            if (selectedDates.length > 0) {
                fechaDesdePicker.set('maxDate', selectedDates[0]);
            } else {
                fechaDesdePicker.set('maxDate', new Date());
            }
        }
    });

    //Configuración del mapa
    var mapContainer = document.getElementById("map-container");
    var openMap = document.getElementById("openMap");
    var map;

    const niveles = [
        { id: 'Continente', ub_code: 1, input: 'inputContinente', sugerencias: 'sugerenciasContinente', paramName: 'continente' },
        { id: 'Pais', ub_code: 2, input: 'inputPais', sugerencias: 'sugerenciasPais', paramName: 'pais' },
        { id: 'Comunidad', ub_code: 3, input: 'inputComunidad', sugerencias: 'sugerenciasComunidad', paramName: 'comunidad' },
        { id: 'Provincia', ub_code: 4, input: 'inputProvincia', sugerencias: 'sugerenciasProvincia', paramName: 'provincia' },
        { id: 'Localidad', ub_code: 6, input: 'inputLocalidad', sugerencias: 'sugerenciasLocalidad', paramName: 'localidad' },
        { id: 'Barrio', ub_code: 7, input: 'inputBarrio', sugerencias: 'sugerenciasBarrio', paramName: 'barrio' }
    ];

    const ubicaciones = <?= json_encode(Ubicacion::find()->asArray()->all()) ?>;

    niveles.forEach((nivel) => {
        const inputElement = document.getElementById(nivel.input);
        const sugerenciasElement = document.getElementById(nivel.sugerencias);

        inputElement.addEventListener("input", function() {
            const query = this.value.trim().toLowerCase();
            sugerenciasElement.innerHTML = '';

            if (query.length < 2) {
                sugerenciasElement.style.display = 'none';
                return;
            }

            let ubicacionesFiltradas = ubicaciones.filter(u => u.ub_code === nivel.ub_code);
            const resultados = ubicacionesFiltradas.filter(ubicacion =>
                ubicacion.nombre.toLowerCase().includes(query)
            );

            if (resultados.length > 0) {
                resultados.forEach(ubicacion => {
                    const item = document.createElement("a");
                    item.classList.add("list-group-item", "list-group-item-action");
                    item.textContent = ubicacion.nombre;
                    item.href = "#";
                    item.addEventListener("click", function(e) {
                        e.preventDefault();
                        inputElement.value = ubicacion.nombre;
                        sugerenciasElement.style.display = 'none';
                    });
                    sugerenciasElement.appendChild(item);
                });
                sugerenciasElement.style.display = 'block';
            } else {
                const item = document.createElement("div");
                item.classList.add("list-group-item");
                item.textContent = "No se encontraron resultados";
                sugerenciasElement.appendChild(item);
                sugerenciasElement.style.display = 'block';
            }
        });
    });

    document.addEventListener("click", function(e) {
        niveles.forEach(nivel => {
            const inputElement = document.getElementById(nivel.input);
            const sugerenciasElement = document.getElementById(nivel.sugerencias);

            if (e.target !== inputElement && !inputElement.contains(e.target)) {
                sugerenciasElement.style.display = 'none';
            }
        });
    });

    openMap.onclick = function (e) {
        e.preventDefault();
        mapContainer.style.display = "block";

        if (!map) {
            initMap();
        }

        setTimeout(() => {
            if (map) {
                map.invalidateSize();
                if (ubicaciones && ubicaciones.length > 0) {
                    const bounds = L.latLngBounds(
                        ubicaciones
                            .filter(ubicacion => ubicacion.latitud && ubicacion.longitud)
                            .map(ubicacion => [
                                parseFloat(ubicacion.latitud),
                                parseFloat(ubicacion.longitud)
                            ])
                    );
                    map.fitBounds(bounds);
                } else {
                    map.setView([40.4168, -3.7038], 6);
                }
            }
        }, 100);
    };

    function initMap() {
        map = L.map('map').setView([40.4168, -3.7038], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const ubicacionesMapa = <?= json_encode($ubicaciones) ?>;
        const markers = L.layerGroup().addTo(map);

        if (ubicacionesMapa && ubicacionesMapa.length > 0) {
            ubicacionesMapa.forEach(ubicacion => {
                const { latitud, longitud, nombre } = ubicacion;
                if (latitud && longitud) {
                    try {
                        const lat = parseFloat(latitud);
                        const lng = parseFloat(longitud);

                        if (!isNaN(lat) && !isNaN(lng)) {
                            const marker = L.marker([lat, lng], {
                                title: nombre
                            });

                            marker.bindTooltip(`<b>${nombre}</b>`, {
                                permanent: false,
                                direction: 'top'
                            });

                            marker.on('click', function() {
                                const url = new URL("<?= Url::to(['site/index']) ?>", window.location.origin);
                                url.searchParams.set('ciudad', nombre);
                                window.location.href = url.toString();
                            });

                            markers.addLayer(marker);
                        }
                    } catch (e) {
                        console.error("Error con ubicación:", ubicacion, e);
                    }
                }
            });

            const bounds = L.latLngBounds(
                ubicacionesMapa
                    .filter(ubicacion => ubicacion.latitud && ubicacion.longitud)
                    .map(ubicacion => [
                        parseFloat(ubicacion.latitud),
                        parseFloat(ubicacion.longitud)
                    ])
            );
            map.fitBounds(bounds);
        }
    }

    // Formulario de búsqueda
    const searchForm = document.getElementById('searchForm');
    const btnBusqueda = document.getElementById('btnBusqueda');

    btnBusqueda.addEventListener('click', function(e) {
        e.preventDefault();

        // Construir URL con parámetros
        const formData = new FormData(searchForm);
        const params = new URLSearchParams();

        // Agregar solo los parámetros con valor
        for (const [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }

        // Eliminar parámetros vacíos que podrían estar en la URL actual
        const url = new URL("<?= Url::to(['site/index']) ?>", window.location.origin);
        url.search = params.toString();

        // Redirigir con los nuevos parámetros
        window.location.href = url.toString();
    });

    // Limpiar filtros
    document.getElementById('limpiarFiltros').addEventListener('click', function() {
        // Redirigir a la misma URL sin parámetros de búsqueda
        const url = new URL(window.location.href);
        url.search = '';
        window.location.href = url.toString();
    });

    // Rellenar campos del formulario con los parámetros existentes
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.toString()) {
        urlParams.forEach((value, key) => {
            const input = searchForm.querySelector(`[name="${key}"]`);
            if (input) {
                input.value = value;

                // Manejo especial para fechas
                if (key === 'fecha_desde' && value) {
                    fechaDesdePicker.setDate(value, true);
                }
                if (key === 'fecha_hasta' && value) {
                    fechaHastaPicker.setDate(value, true);
                }
            }
        });
    }
});
</script>