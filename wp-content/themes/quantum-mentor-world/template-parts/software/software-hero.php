<?php
/**
 * Software Archive Hero Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$search_query = isset( $_GET['software_search'] ) ? sanitize_text_field( $_GET['software_search'] ) : '';
?>

<section class="software-hero py-12 mb-8 relative overflow-hidden">
    <!-- Decorative background glow -->
    <div class="hero-glow-glow" style="position: absolute; top: -50px; left: 50%; transform: translateX(-50%); width: 300px; height: 300px; background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, rgba(0,0,0,0) 70%); pointer-events: none; z-index: 0;"></div>

    <div class="container container-laptop relative" style="z-index: 1; text-align: center;">
        <!-- Breadcrumbs -->
        <nav class="breadcrumbs mb-4" aria-label="Breadcrumb" style="display: inline-flex; justify-content: center; font-size: 13px; color: var(--text-muted);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary);"><?php esc_html_e( 'Software', 'quantum-mentor-world' ); ?></span>
        </nav>

        <h1 class="hero-title mb-4">
            <?php esc_html_e( 'Software Directory', 'quantum-mentor-world' ); ?>
        </h1>
        <p class="body-text text-muted mb-8" style="max-width: 600px; margin-left: auto; margin-right: auto; color: var(--text-muted);">
            <?php esc_html_e( 'Discover legal software, AI apps, utilities, developer tools, and productivity resources for every platform.', 'quantum-mentor-world' ); ?>
        </p>

        <!-- Search Bar -->
        <div class="software-search-wrapper" style="max-width: 580px; margin: 0 auto;">
            <form role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'software' ) ); ?>" class="software-search-form" style="position: relative; display: flex; align-items: center;">
                
                <!-- Carry filters in query params when searching if they exist -->
                <?php if ( ! empty( $_GET['category'] ) ) : ?>
                    <input type="hidden" name="category" value="<?php echo esc_attr( $_GET['category'] ); ?>">
                <?php endif; ?>
                <?php if ( ! empty( $_GET['platform'] ) ) : ?>
                    <input type="hidden" name="platform" value="<?php echo esc_attr( $_GET['platform'] ); ?>">
                <?php endif; ?>
                <?php if ( ! empty( $_GET['license'] ) ) : ?>
                    <input type="hidden" name="license" value="<?php echo esc_attr( $_GET['license'] ); ?>">
                <?php endif; ?>
                <?php if ( ! empty( $_GET['sort'] ) ) : ?>
                    <input type="hidden" name="sort" value="<?php echo esc_attr( $_GET['sort'] ); ?>">
                <?php endif; ?>

                <div style="position: relative; width: 100%;">
                    <span style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-size: 16px; color: var(--text-muted); pointer-events: none;">🔍</span>
                    <input type="search" name="software_search" class="software-search-input" value="<?php echo esc_attr( $search_query ); ?>" placeholder="<?php esc_attr_e( 'Search safe software...', 'quantum-mentor-world' ); ?>" style="width: 100%; height: 50px; padding: 10px 50px 10px 48px; font-size: 15px; border-radius: 25px; border: 1px solid var(--border); background-color: var(--card-bg); color: var(--text-main); backdrop-filter: var(--glass-blur); outline: none; transition: border-color var(--transition-speed) var(--transition-timing);">
                    <?php if ( ! empty( $search_query ) ) : ?>
                        <a href="<?php echo esc_url( get_post_type_archive_link( 'software' ) ); ?>" style="position: absolute; right: 100px; top: 50%; transform: translateY(-50%); font-size: 18px; color: var(--text-muted); text-decoration: none;" title="<?php esc_attr_e( 'Clear Search', 'quantum-mentor-world' ); ?>">&times;</a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="btn btn-primary" style="position: absolute; right: 4px; height: 42px; padding: 0 20px; border-radius: 21px; min-height: auto; font-size: 13px;">
                    <?php esc_html_e( 'Search', 'quantum-mentor-world' ); ?>
                </button>
            </form>
        </div>
    </div>
</section>
