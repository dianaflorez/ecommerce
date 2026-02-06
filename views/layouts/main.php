<?php
use yii\helpers\Html;
use rce\material\widgets\Noti;
use rce\material\Assets;
use yii\dependencies;
use yii\helpers\Url;

//Register class
if (class_exists('rce\material\Assets')) {
    rce\material\Assets::register($this); 
}

if (Yii::$app->controller->action->id === 'login' || Yii::$app->controller->action->id === 'register') {
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} elseif ((Yii::$app->controller->action->id === 'create' && Yii::$app->controller->id === 'contrato') ||
          (Yii::$app->controller->action->id === 'update' && Yii::$app->controller->id === 'contrato')) {
    echo $this->render(
        'main-sin-header',
        ['content' => $content]
    );
} else {

if (class_exists('backend\assets\AppAsset')) {
    backend\assets\AppAsset::register($this);
} else {
    app\assets\AppAsset::register($this);
}
$bundle = Assets::register($this);
$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/ricar2ce/yii2-material-theme/assets');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <!-- <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css"> -->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    

    <?php $this->head() ?>
</head>
	<!-- <body class="sidebar-mini"> -->
    <!-- When the page is loaded, the loader becomes hidden -->
    <!-- <body onload="$('#loader').hide();" class="sidebar-mini"> -->
    <body class="sidebar-mini">

    <!-- <div id="loader"><img src="<?= Url::to('@web/images/loading.gif') ?>" alt="Loading"/></div> -->


		<?php $this->beginBody() ?>
		  <div class="wrapper ">
		    <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset ]
        ) ?>
		    <div class="main-panel">
		    	<?= $this->render('header.php') ?>
			    <div class="content">
                
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
                        <?= Noti::widget() ?>
            			<?= $content ?>
			    	</div>
			    </div>
		    </div>
		  </div>
		<?php $this->endBody() ?>
        <script type="text/javascript">

            $(document).ready(function(){

                //When clicking on a button, it shows the loader

                $('.btn-loading').on('click', function(){

                $('#loader').show();

                });

            });

        </script>

       


            
        </div>
	</body>
</html>
<?php $this->endPage() ?>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5eb8a3d88ee2956d739fdb4f/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
<?php } ?>
