<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $alertas app\models\Alerta[] */
/* @var $ciudad string|null */
/* @var $ubicaciones array */

$this->title = 'Búsqueda de Alertas';
?>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="container mt-4">
    <h1 class="text-center mb-4"><?= Html::encode($this->title) ?></h1>

    <div class="card p-4 mb-4">
        <h5 class="text-center mb-4">Filtrar alertas por ubicación</h5>
        <div class="row g-3">
            <div class="col-md-2 position-relative">
                <input type="text" class="form-control hierarchy-input"
                       data-level="1"
                       placeholder="Continente"
                       data-parent-level="0">
                <div class="autocomplete-list"></div>
            </div>
            <div class="col-md-2 position-relative">
                <input type="text" class="form-control hierarchy-input"
                       data-level="2"
                       placeholder="País"
                       data-parent-level="1">
                <div class="autocomplete-list"></div>
            </div>
            <div class="col-md-2 position-relative">
                <input type="text" class="form-control hierarchy-input"
                       data-level="3"
                       placeholder="Región"
                       data-parent-level="2">
                <div class="autocomplete-list"></div>
            </div>
            <div class="col-md-2 position-relative">
                <input type="text" class="form-control hierarchy-input"
                       data-level="4"
                       placeholder="Provincia"
                       data-parent-level="3">
                <div class="autocomplete-list"></div>
            </div>
            <div class="col-md-2 position-relative">
                <input type="text" class="form-control hierarchy-input"
                       data-level="6"
                       placeholder="Ciudad"
                       data-parent-level="4">
                <div class="autocomplete-list"></div>
            </div>
            <div class="col-md-2 position-relative">
                <input type="text" class="form-control hierarchy-input"
                       data-level="7"
                       placeholder="Barrio"
                       data-parent-level="6">
                <div class="autocomplete-list"></div>
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary" id="aceptarFiltro">Buscar</button>
            <button class="btn btn-secondary" id="openMap">Búsqueda por mapa</button>
        </div>
    </div>

    <div id="map-container" class="d-none">
        <div id="map" style="height: 600px; width: 100%;"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const inputs = document.querySelectorAll('.hierarchy-input');
    let selectedValues = {};
    let map = null;

    // Inicializar estados de los inputs
    inputs.forEach(input => {
        const level = input.dataset.level;
        // Deshabilitar todos los inputs excepto el primer nivel
        if (parseInt(level) > 1) input.disabled = true;
    });

    // Función para resetear niveles dependientes
    const resetDependentLevels = (currentLevel) => {
        inputs.forEach(input => {
            const level = parseInt(input.dataset.level);
            if (level > currentLevel) {
                input.value = '';
                input.disabled = true;
                delete selectedValues[level];
            }
        });
    };

    // Autocompletado jerárquico
    inputs.forEach(input => {
        // Manejar el enfoque en el input
        input.addEventListener('focus', function() {
            const currentLevel = parseInt(this.dataset.level);
            resetDependentLevels(currentLevel);
        });

        // Manejar la entrada de texto
        input.addEventListener('input', function() {
            const level = this.dataset.level;
            const parentLevel = this.dataset.parentLevel;
            const parentId = selectedValues[parentLevel] || null;

            // Limpiar si hay menos de 2 caracteres
            if (this.value.length < 2) {
                this.nextElementSibling.innerHTML = '';
                return;
            }

            // Fetch de sugerencias
            fetch(`<?= Url::to(['site/buscar-ubicacion']) ?>?q=${encodeURIComponent(this.value)}&level=${level}&parent=${parentId}`)
                .then(res => res.json())
                .then(data => {
                    const list = this.nextElementSibling;
                    list.innerHTML = data.map(item => `
                        <div class="autocomplete-item" data-id="${item.id}" data-name="${item.nombre}">
                            <div>${item.nombre}</div>
                            ${item.padre ? `<small>${item.padre}</small>` : ''}
                        </div>
                    `).join('');

                    // Manejar clic en sugerencia
                    list.querySelectorAll('.autocomplete-item').forEach(item => {
                        item.addEventListener('click', () => {
                            this.value = item.dataset.name;
                            selectedValues[level] = item.dataset.id;
                            list.innerHTML = '';

                            // Habilitar siguiente nivel
                            const nextLevel = parseInt(level) + 1;
                            const nextInput = document.querySelector(`[data-level="${nextLevel}"]`);
                            if (nextInput) nextInput.disabled = false;

                            // Resetear niveles inferiores
                            resetDependentLevels(parseInt(level));
                        });
                    });
                });
        });

        // Limpiar selección si se borra el input
        input.addEventListener('change', function() {
            if (this.value === '') {
                const level = this.dataset.level;
                delete selectedValues[level];
                resetDependentLevels(parseInt(level));
            }
        });
    });

    // Mapa (sin cambios)
    function initMap() {
        if (!map) {
            map = L.map('map').setView([40.4168, -3.7038], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

            <?php foreach ($ubicaciones as $ubicacion): ?>
                <?php if ($ubicacion['latitud'] && $ubicacion['longitud']): ?>
                    L.marker([<?= $ubicacion['latitud'] ?>, <?= $ubicacion['longitud'] ?>], {
                        title: "<?= addslashes($ubicacion['nombre']) ?>"
                    })
                    .bindTooltip("<?= addslashes($ubicacion['nombre']) ?>", { permanent: false, direction: 'top' })
                    .addTo(map)
                    .on('click', function() {
                        window.location.href = "<?= Url::to(['site/index']) ?>?ciudad=<?= urlencode($ubicacion['nombre']) ?>";
                    });
                <?php endif; ?>
            <?php endforeach; ?>
        }
    }

    // Botones (sin cambios)
    document.getElementById('aceptarFiltro').addEventListener('click', function() {
        const params = new URLSearchParams();
        Object.entries(selectedValues).forEach(([level, id]) => {
            params.append(`level_${level}`, id);
        });
        window.location.href = `<?= Url::to(['site/index']) ?>?${params.toString()}`;
    });

    document.getElementById('openMap').addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('map-container').classList.remove('d-none');
        initMap();
        setTimeout(() => map.invalidateSize(), 100);
    });
});
</script>