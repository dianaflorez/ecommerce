<?php

/** @var yii\web\View $this */
/** @var string $content */

//use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

use rce\material\Assets;
if (class_exists('rce\material\Assets')) {
   rce\material\Assets::register($this); 
}

if (class_exists('backend\assets\AppAsset')) {
   backend\assets\AppAsset::register($this);
} else {
   app\assets\AppAsset::register($this);
}
$bundle = Assets::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/ricar2ce/yii2-material-theme/assets');

//AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);

rce\material\Assets::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/ricar2ce/yii2-material-theme/assets');
 
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
<?php

?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-blue fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            // ['label' => 'Home', 'url' => ['/site/index']],
            // ['label' => 'About', 'url' => ['/site/about']],
            // ['label' => 'Contact', 'url' => ['/site/contact']],

            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item-blue">'
                    . Html::beginForm(['/site/logout'])
                    . Html::submitButton(
                        'Logout (' . Yii::$app->user->identity->username . ')',
                        ['class' => 'nav-link btn btn-link logout']
                    )
                    . Html::endForm()
                    . '</li>'
        ]
    ]);
    NavBar::end();
    ?>

    <?php
    // Muestra el banner solo en la página de inicio
    if (Yii::$app->controller->id === 'product' && Yii::$app->controller->action->id === 'products') {
        echo $this->render('//layouts/_banner');
    }
    ?>
</header>
<br>
<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <!-- <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?> -->
            <br>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <!-- Cart BUTTON FIXED -->
    <?php
                    $cartCount = 0;
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $item) {
                            $cartCount += $item['item_quantity'];
                        }
                    }
                    ?>
    <div class="cart-floating-wrapper">
        <?= Html::a(
            '<i class="material-icons">shopping_cart</i>',
            ['/invoice/cart'],
            ['class' => 'btn btn-warning btn-fab btn-fab-lg btn-round btn-cart-flotante']
        ) ?>

        <?php if ($cartCount > 0): ?>
            <span class="cart-badge"><?= $cartCount ?></span>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; IdearTICs <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
