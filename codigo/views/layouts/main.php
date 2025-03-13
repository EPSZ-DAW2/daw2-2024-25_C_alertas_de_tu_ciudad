<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

// Meta etiquetas de seguridad y SEO
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerCsrfMetaTags();
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

// Definir URL de inicio según el parámetro "ciudad"
$homeUrl = Yii::$app->request->get('ciudad')
    ? Url::to(['site/index', 'ciudad' => Yii::$app->request->get('ciudad')])
    : Yii::$app->homeUrl;

// Obtener el rol del usuario autenticado o asignar "guest"
$role = Yii::$app->user->isGuest ? 'guest' : Yii::$app->user->identity->role;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' =>
            Html::img('@web/images/resources/inicio.svg', [
                'alt' => 'Inicio',
                'style' => 'height:50px;'
            ]) . '<span class="ms-2">' . Html::encode(Yii::$app->name) . '</span>',
        'brandUrl' => $homeUrl,
        'options' => ['class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    // Menú izquierdo (según el rol)
    $menuItems = [['label' => 'Búsqueda', 'url' => ['/site/busqueda']]];

    if (in_array($role, ['moderator', 'admin', 'sysadmin'])) {
        $menuItems[] = ['label' => 'Incidencias', 'url' => ['/site/incidencias']];
    }
    if (in_array($role, ['admin', 'sysadmin'])) {
        $menuItems[] = ['label' => 'Áreas', 'url' => ['/site/areas']];
    }
    if ($role === 'sysadmin') {
        $menuItems[] = ['label' => 'Alertas', 'url' => ['/site/alertas']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto'],
        'items' => $menuItems,
    ]);

    // Menú derecho (visible para todos)
    $menuItemsRight = [
        ['label' => 'Contacto', 'url' => ['/site/contact']],
        ['label' => 'Sobre Nosotros', 'url' => ['/site/about']]
    ];

    if (Yii::$app->user->isGuest) {
        $menuItemsRight[] = ['label' => 'Iniciar Sesión', 'url' => ['/site/login']];
    } else {
        // Botón de cierre de sesión con el nombre del usuario
        $menuItemsRight[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'nav-item'])
            . Html::submitButton(
                'Cerrar Sesión (' . Html::encode(Yii::$app->user->identity->username) . ')',
                ['class' => 'nav-link btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';

        // Imagen de perfil
        $menuItemsRight[] = '<li class="nav-item d-flex align-items-center ms-2">'
            . '<a href="' . Url::to(['/user/profile']) . '" class="d-flex align-items-center justify-content-center rounded-circle overflow-hidden" '
            . 'style="width: 35px; height: 35px; background-color: #fff;">'
            . '<img src="' . Yii::$app->user->identity->getProfileImage() . '" '
            . 'alt="Perfil" class="rounded-circle" '
            . 'style="width: 100%; height: 100%; object-fit: cover;">'
            . '</a>'
            . '</li>';
    }

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
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted row text-center">
            <p>&copy; <?= date('Y') ?> Alertas de tu Ciudad. Todos los derechos reservados.</p>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
