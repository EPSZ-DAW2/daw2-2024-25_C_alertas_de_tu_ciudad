<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Alertas de tu Ciudad';
?>
<div class="container mt-4">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-8">
            <div id="alertas-container">
                <p class="text-center">Cargando alertas...</p>
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

<!-- Modal de Ubicación -->
<div id="modalUbicacion" class="modal fade" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Filtrar alertas por ubicación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Quieres ver alertas solo de una ciudad específica?</p>
                <input type="text" id="inputCiudad" class="form-control" placeholder="Escribe tu ciudad..." list="ciudadesList">
                <datalist id="ciudadesList"></datalist>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelarFiltro">Cancelar</button>
                <button type="button" class="btn btn-primary" id="aceptarFiltro">Aceptar</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Modal Script -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            let modal = new bootstrap.Modal(document.getElementById('modalUbicacion'));
            modal.show();
        }, 5000);

        // Obtener lista de ciudades de España desde API externa
        fetch('https://raw.githubusercontent.com/IagoLast/pselect/master/data/ES/cities.json')
            .then(response => response.json())
            .then(data => {
                let ciudadList = document.getElementById("ciudadesList");
                data.forEach(ciudad => {
                    let option = document.createElement("option");
                    option.value = ciudad;
                    ciudadList.appendChild(option);
                });
            });

        document.getElementById("aceptarFiltro").addEventListener("click", function() {
            let ciudadSeleccionada = document.getElementById("inputCiudad").value;
            if (ciudadSeleccionada) {
                window.location.href = '<?= Url::to(['site/index']) ?>' + '?ciudad=' + encodeURIComponent(ciudadSeleccionada);
            } else {
                alert("Por favor, selecciona una ciudad.");
            }
        });

        document.getElementById("cancelarFiltro").addEventListener("click", function() {
            window.close(); // Cierra la pestaña
        });
    });
</script>
