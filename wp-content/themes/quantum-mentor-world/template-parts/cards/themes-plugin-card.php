<?php
/**
 * Themes & Plugins Directory Card Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();

// Fetch ACF custom fields
$platform     = get_field( 'tp_platform', $post_id ); // select
$type         = get_field( 'tp_type', $post_id ); // select/radio
$license      = get_field( 'tp_license', $post_id ); // text
$version      = get_field( 'tp_version', $post_id ); // text
$last_updated = get_field( 'tp_last_updated', $post_id );
if ( empty( $last_updated ) ) {
    $last_updated = get_the_modified_date( 'Y-m-d', $post_id );
}
$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $last_updated ) );

$is_verified = get_field( 'admin_verified', $post_id );
if ( $is_verified === null ) {
    $is_verified = true;
}
?>

<article class="glass-card card-themes-plugins transition-all" style="height: 100%; display: flex; flex-direction: column; padding: 0;">
    
    <!-- Verified Badge -->
    <?php if ( $is_verified ) : ?>
        <div class="card-badge" style="top: var(--space-3); right: var(--space-3);">
            <span class="badge badge-success" style="font-size: 9px; padding: 3px 8px;"><?php esc_html_e( 'Verified Safe', 'quantum-mentor-world' ); ?></span>
        </div>
    <?php endif; ?>

    <!-- Card Featured Thumbnail Cover (16:9 Aspect Ratio) -->
    <div class="resource-cover-wrapper" style="aspect-ratio: 16/9; width: 100%; background-color: var(--bg-primary); overflow: hidden; position: relative; border-bottom: 1px solid var(--border);">
        <?php if ( has_post_thumbnail( $post_id ) ) : ?>
            <?php echo get_the_post_thumbnail( $post_id, 'medium_large', array(
                'style'   => 'width: 100%; height: 100%; object-fit: cover; transition: transform var(--transition-speed) var(--transition-timing);',
                'class'   => 'resource-cover-img',
                'loading' => 'lazy',
                'alt'     => esc_attr( get_the_title() )
            ) ); ?>
        <?php else : ?>
            <!-- Fallback design with typography overlay -->
            <div class="fallback-cover-wrapper" style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(0, 212, 255, 0.05), rgba(124, 58, 237, 0.05)); font-size: 40px; color: var(--primary);">
                <span>🎨</span>
                <span class="small-text" style="font-size: 10px; margin-top: 6px; font-weight: 700; text-transform: uppercase; color: var(--text-muted);"><?php echo esc_html( $platform ? $platform : 'Web Resource' ); ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Content Area -->
    <div class="card-content" style="padding: var(--space-5) var(--space-5) var(--space-6) var(--space-5); display: flex; flex-direction: column; flex: 1;">
        
        <!-- Platform and Type badge line -->
        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: var(--space-2);">
            <?php if ( ! empty( $platform ) ) : ?>
                <span class="badge badge-secondary" style="font-size: 8px; padding: 2px 6px; text-transform: uppercase;"><?php echo esc_html( $platform ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $type ) ) : ?>
                <span class="badge badge-primary" style="font-size: 8px; padding: 2px 6px; text-transform: uppercase;"><?php echo esc_html( $type ); ?></span>
            <?php endif; ?>
        </div>

        <!-- Title -->
        <h3 class="card-title" style="margin-bottom: var(--space-2); font-size: 17px; line-height: 1.3;">
            <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none; transition: color var(--transition-speed);">
                <?php the_title(); ?>
            </a>
        </h3>

        <!-- Excerpt -->
        <p class="small-text line-clamp-2" style="font-size: 13px; line-height: 1.5; color: var(--text-muted); margin-bottom: var(--space-4); flex: 1;">
            <?php 
            $excerpt = get_the_excerpt();
            if ( empty( $excerpt ) ) {
                $excerpt = wp_strip_all_tags( get_the_content() );
            }
            echo esc_html( wp_trim_words( $excerpt, 15, '...' ) ); 
            ?>
        </p>

        <!-- Version & License Row -->
        <div class="card-meta-spec-row" style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: var(--space-3); margin-bottom: var(--space-4); font-size: 12px; color: var(--text-muted);">
            <div>
                <?php if ( ! empty( $license ) ) : ?>
                    <span class="badge badge-muted" style="font-size: 9px; padding: 2px 6px; text-transform: uppercase;"><?php echo esc_html( $license ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $version ) ) : ?>
                    <span style="font-size: 11px; margin-left: var(--space-2);"><?php echo esc_html( $version ); ?></span>
                <?php endif; ?>
            </div>
            <span style="font-size: 10px;"><?php echo esc_html( $formatted_date ); ?></span>
        </div>

        <!-- Button -->
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="width: 100%; padding: 8px 12px; min-height: auto; font-size: 13px; border-radius: var(--radius-sm);">
            <?php esc_html_e( 'View Details', 'quantum-mentor-world' ); ?>
        </a>

    </div>

</article>
