<?php
/**
 * Ejemplo de uso del carrusel en views/site/index.php
 * (o cualquier vista de tu aplicación Yii2)
 */

use yii\helpers\Url;

$this->title = 'Inicio';

// ── Definir los slides ──────────────────────────────────────────────────────
// Puedes obtener estos datos desde la base de datos, un modelo ActiveRecord,
// o un array estático como el que se muestra aquí.

$slides = [
    [
        'title'       => 'Impulso Regional',
        'text'        => 'Emprendedores y Productores de Nariño, unidos para impulsar el desarrollo'
                      . 'económico y social de la región a través de la innovación, la colaboración y el compromiso con la comunidad.  '
                      . '  Creciendo Juntos...',
        'buttonText'  => 'LEER MÁS...',
        'buttonUrl'   => Url::to(['/empresarios/index']),
        'mainImage'   => Yii::$app->request->baseUrl . '/images/empresarios/main.png',
        'thumbs'      => [
            Yii::$app->request->baseUrl . '/images/empresarios/thumb1.png',
            Yii::$app->request->baseUrl . '/images/empresarios/thumb2.png',
            Yii::$app->request->baseUrl . '/images/empresarios/thumb3.jpg',
        ],
        'accentColor' => '#9B27AF',
    ],
    [
        'title'       => 'Carnavales',
        'text'        => 'El Carnaval de negros y blancos es una expresión de la '
                       . 'diversidad cultural de Pasto y del país, el cual se '
                       . 'manifiesta a través de comparsas...',
        'buttonText'  => 'LEER MÁS...',
        'buttonUrl'   => Url::to(['/carnavales/index']),
        'mainImage'   => Yii::$app->request->baseUrl . '/images/carnavales/main.png',
        'thumbs'      => [
            Yii::$app->request->baseUrl . '/images/carnavales/thumb1.png',
            Yii::$app->request->baseUrl . '/images/carnavales/thumb2.png',
            Yii::$app->request->baseUrl . '/images/carnavales/thumb3.jpg',
        ],
        'accentColor' => '#9B27AF',
    ],
    [
        'title'       => 'Gastronomía',
        'text'        => 'Descubre los sabores únicos de la región de Nariño, '
                       . 'una cocina que mezcla tradición indígena con influencias '
                       . 'de todo el país...',
        'buttonText'  => 'DESCUBRIR',
        'buttonUrl'   => Url::to(['/gastronomia/index']),
        'mainImage'   => Yii::$app->request->baseUrl . '/images/gastronomia/main.png',
        'thumbs'      => [
            Yii::$app->request->baseUrl . '/images/gastronomia/thumb1.png',
            Yii::$app->request->baseUrl . '/images/gastronomia/thumb2.png',
            Yii::$app->request->baseUrl . '/images/gastronomia/thumb3.jpg',
        ],
        'accentColor' => '#E65100',
    ],
    [
        'title'       => 'Artesanías',
        'text'        => 'Las artesanías de Pasto son reconocidas mundialmente, '
                       . 'destacándose el barniz de Pasto y las tallas en madera '
                       . 'que preservan siglos de tradición...',
        'buttonText'  => 'VER MÁS',
        'buttonUrl'   => Url::to(['/artesanias/index']),
        'mainImage'   => Yii::$app->request->baseUrl . '/images/artesanias/main.png',
        'thumbs'      => [
            Yii::$app->request->baseUrl . '/images/artesanias/thumb1.png',
            Yii::$app->request->baseUrl . '/images/artesanias/thumb2.png',
        ],
        'accentColor' => '#2E7D32',
    ],
];
?>

<?= $this->render('_carousel', ['slides' => $slides]) ?>

<!-- Resto del contenido de tu página -->
