<?php
/**
 * Carousel Block Template
 *
 * Expects ACF fields defined in block registration:
 * - slides (repeater): image (array), caption (text), link (array)
 * - autoplay (bool)
 * - delay (int, ms)
 * - pagination (bool)
 * - navigation (bool)
 * - loop (bool)
 *
 * This template outputs data attributes for JS initialization.
 * Attach a slider library (e.g., Swiper/Flickity) to `.cfce-carousel`
 * and read dataset options.
 *
 * @package Community_First_Construction_Essentials
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$block_id   = isset( $block['id'] ) ? $block['id'] : uniqid('cfce-carousel-');
$align      = isset( $block['align'] ) && $block['align'] ? 'align' . $block['align'] : '';

$slides     = get_field( 'slides' ) ?: [];
$autoplay   = (bool) get_field( 'autoplay' );
$delay      = (int) ( get_field( 'delay' ) ?: 5000 );
$pagination = (bool) get_field( 'pagination' );
$navigation = (bool) get_field( 'navigation' );
$loop       = (bool) get_field( 'loop' );
$height     = (int) ( get_field( 'height' ) ?: 0 );

// Editor preview fallback
if ( empty( $slides ) && is_admin() ) : ?>
    <div class="cfce-carousel notice" style="padding:12px;border:1px solid #ccd0d4;background:#fff;">
        <p style="margin:0;"><?php esc_html_e( 'Add slides to the Carousel block.', 'community-first-construction-essentials' ); ?></p>
    </div>
    <?php return; endif; ?>

<div id="<?php echo esc_attr( $block_id ); ?>"
     class="cfce-carousel <?php echo esc_attr( $align ); ?> swiper"
     <?php echo $height ? 'style="height:' . esc_attr( $height ) . 'px"' : ''; ?>
     data-autoplay="<?php echo $autoplay ? 'true' : 'false'; ?>"
     data-delay="<?php echo esc_attr( $delay ); ?>"
     data-pagination="<?php echo $pagination ? 'true' : 'false'; ?>"
     data-navigation="<?php echo $navigation ? 'true' : 'false'; ?>"
     data-loop="<?php echo $loop ? 'true' : 'false'; ?>">

    <div class="cfce-carousel__track swiper-wrapper">
        <?php foreach ( $slides as $slide ) :
            $image   = isset( $slide['image'] ) ? $slide['image'] : null;
            $caption = isset( $slide['caption'] ) ? $slide['caption'] : '';
            $link    = isset( $slide['link'] ) && is_array( $slide['link'] ) ? $slide['link'] : null;

            if ( ! $image ) {
                continue;
            }

            $img_html = wp_get_attachment_image( $image['ID'], 'large', false, [ 'class' => 'cfce-carousel__image' ] );
        ?>
            <div class="cfce-carousel__slide swiper-slide">
                <?php if ( $link && ! empty( $link['url'] ) ) : ?>
                    <a class="cfce-carousel__link" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo ! empty( $link['target'] ) ? esc_attr( $link['target'] ) : '_self'; ?>" rel="noopener">
                        <?php echo $img_html; ?>
                    </a>
                <?php else : ?>
                    <?php echo $img_html; ?>
                <?php endif; ?>

                <?php if ( $caption ) : ?>
                    <div class="cfce-carousel__caption"><?php echo esc_html( $caption ); ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ( $pagination ) : ?>
        <div class="cfce-carousel__pagination swiper-pagination" aria-hidden="true"></div>
    <?php endif; ?>

    <?php if ( $navigation ) : ?>
        <button class="cfce-carousel__prev swiper-button-prev" type="button" aria-label="Previous slide"></button>
        <button class="cfce-carousel__next swiper-button-next" type="button" aria-label="Next slide"></button>
    <?php endif; ?>
</div>