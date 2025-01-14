<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alertas de la Ciudad - My Application</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <h2 class="text-center">Últimas Alertas de la Ciudad</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">⚠ Accidente de Tráfico - Centro de la Ciudad</h5>
                    <p class="mb-1">Se ha producido un accidente de tráfico, se recomienda desviar la ruta.</p>
                    <small>Publicado hace 2 horas</small>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">🌧 Alerta Meteorológica - Lluvias Intensas</h5>
                    <p class="mb-1">Alerta de lluvias intensas, se espera que continúe hasta las 22:00 horas.</p>
                    <small>Publicado hace 3 horas</small>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <h5 class="mb-1">🚨 Incidente de Seguridad - Robo</h5>
                    <p class="mb-1">La policía está investigando un caso de robo, por favor tenga precaución.</p>
                    <small>Publicado hace 5 horas</small>
                </a>
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

            <h4 class="mt-4">Mapa de Alertas</h4>
            <div id="map" style="height: 200px; background-color: #eee;"></div>
        </div>
    </div>
</div>

<footer class="text-center mt-5 py-3 bg-dark text-light">
    <p>&copy; 2025 My Application. Todos los derechos reservados.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

