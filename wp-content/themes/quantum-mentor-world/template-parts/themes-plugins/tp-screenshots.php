<?php
/**
 * Single Themes & Plugins Screenshots Gallery Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();
$screenshots = get_field( 'tp_screenshots', $post_id ); // Array of attachment IDs

if ( empty( $screenshots ) ) {
    return; // Hide section if empty
}
?>

<section class="tp-screenshots-section mb-8" style="border-top: 1px solid var(--border); padding-top: var(--space-6);">
    <h3 class="section-title mb-4" style="font-size: 22px;"><?php esc_html_e( 'Screenshots & Demo Previews', 'quantum-mentor-world' ); ?></h3>
    
    <div class="screenshots-grid" style="display: grid; gap: var(--space-4); grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));">
        <?php foreach ( $screenshots as $image_id ) : 
            $full_url = wp_get_attachment_image_url( $image_id, 'full' );
            $alt_text = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
            if ( empty( $alt_text ) ) {
                $alt_text = get_the_title() . ' screenshot';
            }
        ?>
            <div class="screenshot-item glass-card" style="padding: 6px; overflow: hidden; cursor: pointer; border-radius: var(--radius-sm); aspect-ratio: 16/10;">
                <a href="<?php echo esc_url( $full_url ); ?>" class="lightbox-trigger" data-lightbox="tp-gallery" style="display: block; width: 100%; height: 100%;" title="<?php esc_attr_e( 'Click to zoom', 'quantum-mentor-world' ); ?>">
                    <?php echo wp_get_attachment_image( $image_id, 'medium', false, array(
                        'style'   => 'width: 100%; height: 100%; object-fit: cover; border-radius: 4px; display: block; transition: transform 0.3s;',
                        'class'   => 'screenshot-thumb',
                        'loading' => 'lazy',
                        'alt'     => esc_attr( $alt_text )
                    ) ); ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
