<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $alertas app\models\Alerta[] */
/* @var $ciudad string|null */

$this->title = 'Alertas de tu Ciudad';
?>
<div class="container mt-4">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <?php if($ciudad): ?>
        <div class="text-center mb-3">
            <p>Filtrado por: <strong><?= Html::encode($ciudad) ?></strong></p>
            <a href="<?= \yii\helpers\Url::to(['site/index', 'borrarFiltro' => 1]) ?>" class="btn btn-warning">Borrar filtros</a>

        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div id="alertas-container">
                <?php if (!empty($alertas)): ?>
                    <?php foreach ($alertas as $alerta): ?>
                        <div class="alert alert-info">
                            <h5><?= Html::encode($alerta->titulo) ?></h5>
                            <p><?= Html::encode($alerta->descripcion) ?></p>
                            <small>Ubicación: <?= Html::encode($alerta->ubicacion->nombre ?? 'No especificada') ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No hay alertas para esta ubicación.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <h4>Categorías de Alertas</h4>
            <ul class="list-group">
                <li class="list-group-item"><a href="#">Tráfico</a></li>
                <li class="list-group-item"><a href="#">Clima</a></li>
                <li class="list-group-item"><a href="#">Seguridad</a></li>
                <li class="list-group-item"><a href="#">Eventos de Emergencia</a></li>
            </ul>
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
                <button type="button" class="btn btn-primary" id="aceptarFiltro">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para autocomplete, control del modal y redirección -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Variable que indica si se ha aplicado un filtro (según parámetro recibido en PHP)
        var filterApplied = <?= $ciudad ? 'true' : 'false' ?>;

        // Mostrar el modal sólo si aún no se ha mostrado en la sesión y no hay filtro aplicado
        if (!sessionStorage.getItem("modalShown") && !filterApplied) {
            setTimeout(() => {
                const modal = new bootstrap.Modal(document.getElementById('modalUbicacion'));
                modal.show();
                sessionStorage.setItem("modalShown", "true");
            }, 1000);
        }

        const inputCiudad = document.getElementById("inputCiudad");
        const resultados = document.getElementById("listaResultados");

        // Autocompletar ubicaciones dinámicamente
        inputCiudad.addEventListener("input", function() {
            let query = inputCiudad.value.trim();
            if (query.length < 2) {
                resultados.innerHTML = "";
                return;
            }
            fetch(`<?= yii\helpers\Url::to(['site/buscar-ubicacion']) ?>&q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(data => {
                    resultados.innerHTML = "";
                    if (data.length > 0) {
                        data.forEach(item => {
                            let div = document.createElement("a");
                            div.classList.add("list-group-item", "list-group-item-action");
                            div.innerHTML = `
                            <div>${item.nombre}</div>
                            <small style="color:#6c757d;">${item.padre}</small>
                        `;
                            div.href = "#";
                            div.addEventListener("click", (e) => {
                                e.preventDefault();
                                inputCiudad.value = item.nombre;
                                resultados.innerHTML = "";
                            });
                            resultados.appendChild(div);
                        });
                    } else {
                        resultados.innerHTML = '<p class="list-group-item">No encontrado.</p>';
                    }
                });
        });

        // Al aceptar, redirige a la página de inicio con el filtro de ubicación
        document.getElementById("aceptarFiltro").onclick = () => {
            const ciudad = inputCiudad.value.trim();
            if (ciudad) {
                // Se usa "&ciudad=" ya que la URL base ya incluye ?r=site/index
                window.location.href = '<?= Url::to(['site/index']) ?>' + '&ciudad=' + encodeURIComponent(ciudad);
            } else {
                alert("Por favor, selecciona una ubicación.");
            }
        };

        // Al cancelar, cierra el modal
        document.getElementById("cancelarFiltro").onclick = () => {
            const modalEl = document.getElementById('modalUbicacion');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
        };
    });
</script>
