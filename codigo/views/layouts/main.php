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
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
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

// Registra el favicon
$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => Yii::getAlias('@web/images/resources/favicon.png')
]);

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

    // Menú izquierdo
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto'],
        'items' => [
            ['label' => 'Búsqueda', 'url' => ['/site/busqueda']],
            ['label' => 'Incidencias', 'url' => ['/site/incidencias']],
            ['label' => 'Áreas', 'url' => ['/site/areas']],
            ['label' => 'Alertas', 'url' => ['/site/alertas']],
        ],
    ]);

    // Campo de búsqueda en la barra de navegación
    echo Html::beginForm(['/site/search'], 'get', ['class' => 'd-flex']);
    echo Html::textInput('search', '', ['class' => 'form-control me-2', 'placeholder' => 'Buscar...']);
    echo Html::submitButton('Buscar', ['class' => 'btn btn-outline-light']);
    echo Html::endForm();

    // Menú derecho
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
                '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Cerrar Sesión (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
            ]
        ),
    ]);

    if (!Yii::$app->user->isGuest) {
        echo '<div class="ms-auto d-flex align-items-center">';
        echo '<a href="' . Url::to(['/user/profile']) . '" class="btn btn-light rounded-circle d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; text-decoration: none; font-size: 12px; font-weight: bold;">'
            . Html::encode(Yii::$app->user->identity->username)
            . '</a>';
        echo '</div>';
    }

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

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
