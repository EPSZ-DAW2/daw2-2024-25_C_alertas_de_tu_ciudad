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
    <style>


        /* Clase para centrar la alerta y agregar márgenes */
        .custom-alert {
            margin: 0 auto 1rem auto;
            max-width: 600px;
            background-color: #e9edf1;
            border-color: #adb5bd;
        }

        /* Estilo para la etiqueta de ubicación */
        .ubicacion-label {
            display: inline-block;
            background-color: #dee3e8;
            color: #212529;
            padding: 0.2rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

    </style>
    <?php if($ciudad): ?>
        <div class="text-center mb-3">
            <p>Filtrado por: <strong><?= Html::encode($ciudad) ?></strong></p>
            <a href="<?= Url::to(['site/index', 'borrarFiltro' => 1]) ?>" class="btn btn-warning">Borrar filtros</a>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div id="alertas-container">
                <?php if (!empty($alertas)): ?>
                    <?php foreach ($alertas as $alerta): ?>
                        <div class="alert alert-info custom-alert">
                            <h5><?= Html::encode($alerta->titulo) ?></h5>
                            <p><?= Html::encode($alerta->descripcion) ?></p>
                            <div class="ubicacion-label">
                                <?= Html::encode($alerta->ubicacion->nombre ?? 'No especificada') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">No hay alertas para esta ubicación.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-4">
            <table class="table table-striped table-bordered custom-table">
                <thead>
                <tr class="custom-thead">
                    <th scope="col">Categoría</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><a href="#" class="category-link">Tráfico y Transporte</a></td>
                </tr>
                <tr>
                    <td><a href="#" class="category-link">Clima y Medio Ambiente</a></td>
                </tr>
                <tr>
                    <td><a href="#" class="category-link">Emergencias y Seguridad</a></td>
                </tr>
                <tr>
                    <td><a href="#" class="category-link">Infraestructura y Servicios</a></td>
                </tr>
                <tr>
                    <td><a href="#" class="category-link">Salud y Bienestar</a></td>
                </tr>
                <tr>
                    <td><a href="#" class="category-link">Tecnología y Comunicaciones</a></td>
                </tr>
                <tr>
                    <td><a href="#" class="category-link">Eventos y Cultura</a></td>
                </tr>
                <tr>
                    <td><a href="#" class="category-link">Economía y Sociedad</a></td>
                </tr>
                </tbody>
            </table>
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
        var filterApplied = <?= $ciudad ? 'true' : 'false' ?>;
        if (!sessionStorage.getItem("modalShown") && !filterApplied) {
            setTimeout(() => {
                const modal = new bootstrap.Modal(document.getElementById('modalUbicacion'));
                modal.show();
                sessionStorage.setItem("modalShown", "true");
            }, 1000);
        }

        const inputCiudad = document.getElementById("inputCiudad");
        const resultados = document.getElementById("listaResultados");

        inputCiudad.addEventListener("input", function() {
            let query = inputCiudad.value.trim();
            if (query.length < 2) {
                resultados.innerHTML = "";
                return;
            }
            fetch(`<?= Url::to(['site/buscar-ubicacion']) ?>&q=${encodeURIComponent(query)}`)
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

        document.getElementById("aceptarFiltro").onclick = () => {
            const ciudad = inputCiudad.value.trim();
            if (ciudad) {
                window.location.href = '<?= Url::to(['site/index']) ?>' + '&ciudad=' + encodeURIComponent(ciudad);
            } else {
                alert("Por favor, selecciona una ubicación.");
            }
        };

        document.getElementById("cancelarFiltro").onclick = () => {
            const modalEl = document.getElementById('modalUbicacion');
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) {
                modalInstance.hide();
            }
        };
    });
</script>
