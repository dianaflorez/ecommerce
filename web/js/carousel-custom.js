/**
 * carousel-custom.js
 * Lógica del carrusel para Yii2
 * Ubicar en: web/js/carousel-custom.js
 * Depende de jQuery (yii\web\JqueryAsset)
 */
(function ($) {
    'use strict';

    $(function () {
        var $carousel  = $('#customCarousel');
        if (!$carousel.length) return;

        var $track     = $carousel.find('#carouselTrack');
        var $slides    = $track.find('.carousel-slide');
        var $dots      = $carousel.find('.carousel-dot');
        var total      = $slides.length;
        var current    = 0;
        var autoTimer  = null;
        var AUTO_DELAY = 5000;   // ms entre slides automáticos
        var isAnimating = false;

        /* ── Ir a un slide ── */
        function goTo(index, dir) {
            if (isAnimating || index === current) return;
            isAnimating = true;

            var prev = current;
            current  = (index + total) % total;

            // Mover el track
            $track.css('transform', 'translateX(-' + (current * 100) + '%)');

            // Actualizar clases activas
            $slides.removeClass('active');
            $slides.eq(current).addClass('active');

            $dots.removeClass('active');
            $dots.eq(current).addClass('active');

            // Actualizar color de acento en flechas/dots según el slide activo
            var accent = $slides.eq(current).css('--accent') ||
                         $slides.eq(current)[0].style.getPropertyValue('--accent') ||
                         '#9B27AF';
            $carousel.find('.carousel-dot').css('border-color', accent);
            $carousel.find('.carousel-dot.active').css('background', accent);

            // Re-trigger animaciones del contenido
            var $activeContent = $slides.eq(current).find('.slide-content, .slide-images');
            $activeContent.css('animation', 'none');
            // forzar reflow
            $activeContent[0] && $activeContent[0].offsetHeight; // jshint ignore:line
            $activeContent.css('animation', '');

            setTimeout(function () { isAnimating = false; }, 600);
        }

        /* ── Navegación con flechas ── */
        $carousel.on('click', '.carousel-arrow--prev', function () {
            resetAuto();
            goTo(current - 1);
        });

        $carousel.on('click', '.carousel-arrow--next', function () {
            resetAuto();
            goTo(current + 1);
        });

        /* ── Dots ── */
        $carousel.on('click', '.carousel-dot', function () {
            resetAuto();
            goTo(parseInt($(this).data('goto'), 10));
        });

        /* ── Swipe táctil ── */
        var touchStartX = 0;
        $carousel[0].addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].clientX;
        }, { passive: true });

        $carousel[0].addEventListener('touchend', function (e) {
            var dx = e.changedTouches[0].clientX - touchStartX;
            if (Math.abs(dx) > 50) {
                resetAuto();
                goTo(dx < 0 ? current + 1 : current - 1);
            }
        }, { passive: true });

        /* ── Autoplay ── */
        function startAuto() {
            autoTimer = setInterval(function () {
                goTo(current + 1);
            }, AUTO_DELAY);
        }

        function resetAuto() {
            clearInterval(autoTimer);
            startAuto();
        }

        /* ── Teclado ── */
        $(document).on('keydown', function (e) {
            if (e.key === 'ArrowLeft')  { resetAuto(); goTo(current - 1); }
            if (e.key === 'ArrowRight') { resetAuto(); goTo(current + 1); }
        });

        /* ── Pausar al pasar el mouse ── */
        $carousel.on('mouseenter', function () { clearInterval(autoTimer); });
        $carousel.on('mouseleave', startAuto);

        /* ── Inicializar ── */
        if (total > 1) startAuto();
    });

}(jQuery));
