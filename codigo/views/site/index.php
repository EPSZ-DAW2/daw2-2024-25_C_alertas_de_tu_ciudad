<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $alertas app\models\Alerta[] */
/* @var $ciudad string|null */

$this->title = 'Alertas de tu Ciudad';
?>
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
        <!-- Aumentamos el ancho de la columna de alertas a col-md-10 -->
        <div class="col-md-10 mx-auto"> <!-- mx-auto centra la columna -->
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
                                <p class="post-description" id="desc-<?= $alerta->id ?>">
                                    <?= Html::encode($alerta->descripcion) ?>
                                </p>
                            </div>
                            <div class="post-actions">
                                <button class="btn-like" onclick="this.firstElementChild.src = this.firstElementChild.src.includes('like.svg') ? '<?= Url::to('@web/images/resources/heart.svg') ?>' : '<?= Url::to('@web/images/resources/like.svg') ?>'">
                                    <img src="<?= Url::to('@web/images/resources/like.svg') ?>" alt="Me gusta">
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

        <!-- Reducimos el ancho de la columna de categorías a col-md-2 -->
        <div class="col-md-1">
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
                <button type="button" class="btn" id="aceptarFiltro">Aceptar</button>
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