<?php

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

// Registra los assets para la vista
AppAsset::register($this);

// Meta etiquetas de seguridad y SEO
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerCsrfMetaTags();  // Para protección CSRF
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->params['meta_description'] ?? 'Portal Web sobre la Publicación y Gestión de Alertas, Avisos, Sucesos, Eventos que ocurren en tu Ciudad o cercanías'
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->params['meta_keywords'] ?? 'alertas, ciudad, eventos, incidencias'
]);
// Favicon
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => Url::to('@web/images/resources/favicon.svg', true)
]);

// URL de inicio, dependiendo del parámetro "ciudad" en la URL
$homeUrl = Yii::$app->request->get('ciudad')
    ? Url::to(['site/index', 'ciudad' => Yii::$app->request->get('ciudad')])
    : Yii::$app->homeUrl;

// Obtener el rol del usuario (o asignar "guest" si no está autenticado)
$role = Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->role;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <!-- Carga FontAwesome para los iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    // Configuración del navbar
    NavBar::begin([
        'brandLabel' =>
            Html::img('@web/images/resources/inicio.svg', [
                'alt' => 'Inicio',
                'style' => 'height:50px;'
            ]) . '<span class="ms-2">' . Html::encode(Yii::$app->name) . '</span>',
        'brandUrl' => $homeUrl,  // URL de inicio, considerando el parámetro "ciudad"
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    // Menú izquierdo basado en el rol del usuario
    $menuItems = [];
    if (in_array($role, ['moderator', 'admin', 'sysadmin'])) {
        // Para moderadores, admins o sysadmins, mostrar opciones adicionales
        $menuItems[] = ['label' => 'Ubicaciones', 'url' => ['/ubicacion/index']];
        $menuItems[] = ['label' => 'Imágenes', 'url' => ['/imagen/index']];
        $menuItems[] = ['label' => 'Usuarios', 'url' => ['/usuarios/index']];
        $menuItems[] = ['label' => 'Alertas', 'url' => ['/alertasCreados/index']];
        $menuItems[] = ['label' => 'Incidencias', 'url' => ['/incidencia/index']];
        $menuItems[] = ['label' => 'Categorías', 'url' => ['/categoria/index']];
        $menuItems[] = ['label' => 'Etiquetas', 'url' => ['/etiqueta/index']];
        $menuItems[] = ['label' => 'Comentarios', 'url' => ['/cometarios/index']];
    } elseif (in_array($role, ['user', 'guest'])) {
        // Para usuarios o invitados, mostrar opciones básicas
        $menuItems[] = ['label' => 'Búsqueda', 'url' => ['/site/busqueda']];
        $menuItems[] = ['label' => 'Categorías', 'url' => ['/site/categorias']];
        $menuItems[] = ['label' => 'Etiquetas', 'url' => ['/site/etiquetas']];
    }

    // Renderizar el menú izquierdo
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto'],
        'items' => $menuItems,
    ]);

    // Menú derecho para todos los usuarios (contacto, sobre nosotros)
    $menuItemsRight = [
        ['label' => 'Contacto', 'url' => ['/site/contact']],
        ['label' => 'Sobre Nosotros', 'url' => ['/site/about']]
    ];

    // Si el usuario no ha iniciado sesión, ofrecer opción de login
    if (Yii::$app->user->isGuest) {
        $menuItemsRight[] = ['label' => 'Iniciar Sesión', 'url' => ['/site/login']];
        $menuItemsRight[] = ['label' => 'Registrarse', 'url' => ['/site/registrar']];
    } else {
        // Si está autenticado, mostrar opción de logout y nombre de usuario
        $menuItemsRight[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'nav-item'])
            . Html::submitButton(
                'Cerrar Sesión (' . Html::encode(Yii::$app->user->identity->username) . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';

        // Mostrar imagen de perfil del usuario autenticado
        $menuItemsRight[] = '<li class="nav-item d-flex align-items-center ms-2">'
            . '<a href="' . Url::to(['/user/profile']) . '" class="d-flex align-items-center justify-content-center rounded-circle overflow-hidden" '
            . 'style="width: 35px; height: 35px; background-color: #fff;">'
            . '<img src="' . Yii::$app->user->identity->getProfileImage() . '" '
            . 'alt="Perfil" class="rounded-circle" '
            . 'style="width: 100%; height: 100%; object-fit: cover;">'
            . '</a>'
            . '</li>';
    }

    // Renderizar el menú derecho
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto d-flex align-items-center'],
        'items' => $menuItemsRight,
        'encodeLabels' => false
    ]);

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?= Alert::widget() ?>  <!-- Mostrar alertas -->
        <?= $content ?>  <!-- Aquí se renderiza el contenido principal de la vista -->
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container text-center">
        <p class="text-muted">&copy; <?= date('Y') ?> Alertas de tu Ciudad. Todos los derechos reservados.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
