<?php
/**
 * Software Card Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();
$platforms = get_field( 'software_platform', $post_id ); // Array of choices (Windows, Mac, Linux, Android, iPhone)
$license = get_field( 'software_license', $post_id );
$version = get_field( 'software_version', $post_id );
$last_updated = get_field( 'software_last_updated', $post_id );
if ( empty( $last_updated ) ) {
    $last_updated = get_the_modified_date( 'Y-m-d', $post_id );
}
$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $last_updated ) );

$is_verified = get_field( 'admin_verified', $post_id );
if ( $is_verified === null ) {
    $is_verified = true;
}
?>

<article class="glass-card card-software transition-all" style="height: 100%; display: flex; flex-direction: column;">
    
    <!-- Verified Badge -->
    <?php if ( $is_verified ) : ?>
        <div class="card-badge">
            <span class="badge badge-success" style="font-size: 9px; padding: 3px 8px;"><?php esc_html_e( 'Verified Safe', 'quantum-mentor-world' ); ?></span>
        </div>
    <?php endif; ?>

    <!-- Icon/Thumbnail & Platform indicators -->
    <div class="card-top-header" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--space-4); gap: var(--space-3);">
        <div class="software-card-image" style="flex-shrink: 0; width: 52px; height: 52px; border-radius: var(--radius-sm); border: 1px solid var(--border); background-color: var(--bg-primary); overflow: hidden; display: flex; align-items: center; justify-content: center;">
            <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                <?php echo get_the_post_thumbnail( $post_id, 'thumbnail', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'lazy', 'alt' => esc_attr( get_the_title() ) ) ); ?>
            <?php else : ?>
                <div class="fallback-software-icon" style="font-size: 24px; color: var(--primary);">💻</div>
            <?php endif; ?>
        </div>
        
        <!-- Platforms indicators dot layout -->
        <div class="platform-tag" title="<?php esc_attr_e( 'Supported Platforms', 'quantum-mentor-world' ); ?>" style="display: inline-flex; gap: 4px; flex-wrap: wrap; justify-content: flex-end; max-width: 120px; margin-top: 4px;">
            <?php 
            $all_platform_options = array(
                'Windows' => 'W', 
                'Mac'     => 'M', 
                'Linux'   => 'L', 
                'Android' => 'A', 
                'iPhone'  => 'I'
            );
            foreach ( $all_platform_options as $key => $short ) :
                $is_supported = ! empty( $platforms ) && in_array( $key, $platforms );
                $dot_color = $is_supported ? 'var(--primary)' : 'rgba(255,255,255,0.1)';
                $text_color = $is_supported ? '#0F172A' : 'var(--text-muted)';
                $title_label = ($key === 'Mac') ? 'macOS' : (($key === 'iPhone') ? 'iPhone / iOS' : $key);
            ?>
            <span class="platform-indicator-dot <?php echo $is_supported ? 'active' : ''; ?>" style="display: inline-flex; align-items: center; justify-content: center; width: 18px; height: 18px; border-radius: 50%; font-size: 8px; font-weight: 700; background-color: <?php echo esc_attr( $dot_color ); ?>; color: <?php echo esc_attr( $text_color ); ?>; transition: all 0.3s;" title="<?php echo esc_attr( $title_label ); ?>">
                <?php echo esc_html( $short ); ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Meta update date -->
    <div class="card-meta-date" style="font-size: 11px; color: var(--text-muted); margin-bottom: var(--space-2);">
        <span><?php esc_html_e( 'Updated:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $formatted_date ); ?></span>
    </div>

    <!-- Title -->
    <h3 class="card-title" style="margin-bottom: var(--space-2); font-size: 18px;">
        <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none; transition: color var(--transition-speed);">
            <?php the_title(); ?>
        </a>
    </h3>

    <!-- Version & License Spec badges -->
    <div class="card-badges-container" style="display: flex; gap: 6px; margin-bottom: var(--space-4); flex-wrap: wrap;">
        <?php if ( ! empty( $version ) ) : ?>
            <span class="badge badge-muted" style="font-size: 9px; padding: 2px 8px;"><?php echo esc_html( $version ); ?></span>
        <?php endif; ?>
        <?php if ( ! empty( $license ) ) : ?>
            <span class="badge badge-primary" style="font-size: 9px; padding: 2px 8px;"><?php echo esc_html( $license ); ?></span>
        <?php endif; ?>
    </div>

    <!-- Excerpt description -->
    <p class="small-text line-clamp-2" style="font-size: 13px; line-height: 1.6; color: var(--text-muted); margin-bottom: var(--space-6); flex: 1;">
        <?php 
        $excerpt = get_the_excerpt();
        if ( empty( $excerpt ) ) {
            $excerpt = wp_strip_all_tags( get_the_content() );
        }
        echo esc_html( wp_trim_words( $excerpt, 16, '...' ) ); 
        ?>
    </p>

    <!-- Download/View Permalinks -->
    <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="width: 100%; padding: 8px 12px; min-height: auto; font-size: 13px; border-radius: var(--radius-sm);">
            <?php esc_html_e( 'View Details', 'quantum-mentor-world' ); ?>
        </a>
    </div>

</article>
