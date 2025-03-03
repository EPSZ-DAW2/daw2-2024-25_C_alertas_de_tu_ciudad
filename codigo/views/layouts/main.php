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

// Registra meta etiquetas comunes y de seguridad
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no'
], 'viewport');
$this->registerCsrfMetaTags();

// Registra meta etiquetas SEO
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->params['meta_description'] ?? 'Portal Web sobre la Publicación y Gestión de Alertas, Avisos, Sucesos, Eventos que ocurren en tu Ciudad o cercanías'
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->params['meta_keywords'] ?? 'alertas, ciudad, eventos, incidencias'
]);

// Registra el favicon usando un SVG
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/svg+xml',
    'href' => Yii::getAlias('@web/images/resources/inicio.svg')
]);

// Registra etiquetas Open Graph (opcional, para compartir en redes sociales)
$this->registerMetaTag(['property' => 'og:title', 'content' => Html::encode($this->title)]);
$this->registerMetaTag(['property' => 'og:description', 'content' => Html::encode($this->params['meta_description'] ?? 'Descripción predeterminada de la página')]);
$this->registerMetaTag(['property' => 'og:type', 'content' => 'website']);
$this->registerMetaTag(['property' => 'og:url', 'content' => Yii::$app->request->absoluteUrl]);
$this->registerMetaTag(['property' => 'og:image', 'content' => Yii::getAlias('@web/path/to/og-image.jpg')]);

// Obtener el parámetro "ciudad" (si existe) y definir el URL de inicio en consecuencia
$ciudad = Yii::$app->request->get('ciudad');
$homeUrl = $ciudad ? Url::to(['site/index', 'ciudad' => $ciudad]) : Yii::$app->homeUrl;

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
                'alt' => 'inicio icon',
                'style' => 'height:50px;'
            ]) .
            '<span style="margin-left:20px;">' . Html::encode(Yii::$app->name) . '</span>',
        'brandUrl' => $homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);

    // Left menu items
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            ['label' => 'Búsqueda', 'url' => ['/site/busqueda']],
            ['label' => 'Incidencias', 'url' => ['/site/incidencias']],
            ['label' => 'Áreas', 'url' => ['/site/areas']],
            ['label' => 'Alertas', 'url' => ['/site/alertas']],
        ],
    ]);

    // Right menu items
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => array_merge(
            [
                ['label' => 'Contacto', 'url' => ['/site/contact']],
                ['label' => 'Sobre Nosotros', 'url' => ['/site/about']]
            ],
            Yii::$app->user->isGuest
                ? [['label' => 'Iniciar Sesión', 'url' => ['/site/login']]]
                : [
                ['label' => 'Perfil', 'url' => ['/site/perfil']],
                ['label' => 'Cerrar Sesión', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
            ]
        ),
    ]);

    NavBar::end();
    ?>
</header>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
