<?php
/**
 * Carrusel estilo "Carnavales" - Yii2
 * Vista parcial: views/site/_carousel.php (o donde prefieras)
 *
 * Uso desde otro view:
 *   echo $this->render('_carousel', ['slides' => $slides]);
 *
 * Estructura esperada de $slides (array):
 * [
 *   [
 *     'title'      => 'Carnavales',
 *     'text'       => 'El Carnaval de negros y blancos...',
 *     'buttonText' => 'LEER MÁS...',
 *     'buttonUrl'  => '/carnavales',
 *     'mainImage'  => '/images/carnaval-main.png',   // imagen grande (diamante)
 *     'thumbs'     => [                               // hasta 3 miniaturas
 *         '/images/thumb1.png',
 *         '/images/thumb2.png',
 *         '/images/thumb3.png',
 *     ],
 *     'accentColor'=> '#9B27AF',  // opcional, color del botón/acento
 *   ],
 * ]
 */

use yii\helpers\Html;
use yii\helpers\Url;

// Registrar assets
$this->registerCssFile('@web/css/carousel-custom.css');
$this->registerJsFile('@web/js/carousel-custom.js', ['depends' => [\yii\web\JqueryAsset::class]]);
?>

<section class="custom-carousel" id="customCarousel" aria-label="Carrusel de secciones">

    <div class="carousel-track-wrapper">
        <div class="carousel-track" id="carouselTrack">

            <?php foreach ($slides as $index => $slide):
                $accent = $slide['accentColor'] ?? '#9B27AF';
                $isActive = $index === 0 ? 'active' : '';
            ?>
            <div class="carousel-slide <?= $isActive ?>"
                 data-index="<?= $index ?>"
                 style="--accent: <?= Html::encode($accent) ?>">

                <!-- ── Lado izquierdo: texto ── -->
                <div class="slide-content">
                    <h2 class="slide-title"><?= Html::encode($slide['title']) ?></h2>
                    <p class="slide-text"><?= Html::encode($slide['text']) ?></p>
                    <?= Html::a(
                        Html::encode($slide['buttonText'] ?? 'LEER MÁS...'),
                        Url::to($slide['buttonUrl'] ?? '#'),
                        ['class' => 'slide-btn']
                    ) ?>
                </div>

                <!-- ── Lado derecho: imágenes en diamante ── -->
                <div class="slide-images">

                    <!-- Imagen principal grande -->
                    <div class="diamond diamond--main">
                        <div class="diamond-inner">
                            <?= Html::img(
                                $slide['mainImage'],
                                ['alt' => Html::encode($slide['title']), 'loading' => 'lazy']
                            ) ?>
                        </div>
                    </div>

                    <!-- Miniaturas -->
                    <?php foreach (array_slice($slide['thumbs'] ?? [], 0, 3) as $ti => $thumb): ?>
                    <div class="diamond diamond--thumb diamond--thumb-<?= $ti + 1 ?>">
                        <div class="diamond-inner">
                            <?= Html::img($thumb, ['alt' => '', 'loading' => 'lazy']) ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                </div><!-- /slide-images -->

            </div><!-- /carousel-slide -->
            <?php endforeach; ?>

        </div><!-- /carousel-track -->
    </div><!-- /carousel-track-wrapper -->

    <!-- Flechas de navegación -->
    <button class="carousel-arrow carousel-arrow--prev" aria-label="Anterior">&#10094;</button>
    <button class="carousel-arrow carousel-arrow--next" aria-label="Siguiente">&#10095;</button>

    <!-- Indicadores / dots -->
    <?php if (count($slides) > 1): ?>
    <div class="carousel-dots" aria-label="Indicadores de diapositiva">
        <?php foreach ($slides as $i => $_): ?>
        <button class="carousel-dot <?= $i === 0 ? 'active' : '' ?>"
                data-goto="<?= $i ?>"
                aria-label="Ir a diapositiva <?= $i + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</section>
