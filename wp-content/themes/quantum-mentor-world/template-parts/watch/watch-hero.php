<?php
/**
 * Watch Archive — Hero Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Count published watch entries
$total_videos = wp_count_posts( 'watch' )->publish ?? 0;
?>

<!-- ============================================================
     WATCH ARCHIVE HERO
     ============================================================ -->
<section class="watch-archive-hero" aria-label="<?php esc_attr_e( 'Watch Platform Hero', 'quantum-mentor-world' ); ?>">

    <!-- Background orbs -->
    <div class="watch-hero-bg-orbs"></div>

    <div class="container container-laptop" style="position: relative; z-index: 1;">

        <!-- Eyebrow badge -->
        <div style="text-align: center; margin-bottom: var(--space-4);">
            <span class="badge badge-primary" style="font-size: 11px; letter-spacing: 0.12em; padding: 6px 16px;">
                🎬 <?php esc_html_e( 'LEGAL EMBED VIDEO PLATFORM', 'quantum-mentor-world' ); ?>
            </span>
        </div>

        <!-- Main heading -->
        <h1 class="watch-hero-title" style="text-align: center;">
            <?php esc_html_e( 'Watch', 'quantum-mentor-world' ); ?>
        </h1>

        <!-- Subtitle -->
        <p class="watch-hero-subtitle" style="text-align: center; max-width: 800px; margin: 0 auto var(--space-6); color: var(--text-muted); line-height: 1.6;">
            <?php esc_html_e( 'Watch legal educational content, courses, tutorials, documentaries, and creator-approved videos from trusted platforms.', 'quantum-mentor-world' ); ?>
        </p>

        <!-- Stat pills row -->
        <div class="watch-hero-stats">
            <div class="watch-stat-pill">
                <span class="watch-stat-icon">🎬</span>
                <span><?php echo esc_html( $total_videos ); ?> <?php esc_html_e( 'Videos Index', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="watch-stat-pill">
                <span class="watch-stat-icon">🎓</span>
                <span><?php esc_html_e( 'Educational & Public', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="watch-stat-pill">
                <span class="watch-stat-icon">🛡️</span>
                <span><?php esc_html_e( 'Zero Piracy Checked', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="watch-stat-pill">
                <span class="watch-stat-icon">📺</span>
                <span><?php esc_html_e( 'Official Servers Only', 'quantum-mentor-world' ); ?></span>
            </div>
        </div>

        <!-- Quick-links by Content Type -->
        <nav class="watch-category-links" aria-label="<?php esc_attr_e( 'Quick Content Type Links', 'quantum-mentor-world' ); ?>">
            <?php
            $quick_types = array(
                'course'      => array( 'label' => 'Courses',       'icon' => '🎓' ),
                'tutorial'    => array( 'label' => 'Tutorials',     'icon' => '📚' ),
                'documentary' => array( 'label' => 'Documentaries', 'icon' => '📽️' ),
                'movie'       => array( 'label' => 'Movies',        'icon' => '🎬' ),
                'anime'       => array( 'label' => 'Anime',         'icon' => '🎌' ),
                'donghua'     => array( 'label' => 'Donghua',       'icon' => '🐉' ),
            );
            $archive_url = get_post_type_archive_link( 'watch' );
            foreach ( $quick_types as $slug => $data ) :
                $active = ( isset( $_GET['type'] ) && sanitize_text_field( $_GET['type'] ) === $slug );
            ?>
            <a href="<?php echo esc_url( add_query_arg( 'type', $slug, $archive_url ) ); ?>"
               class="watch-category-pill <?php echo $active ? 'active' : ''; ?>"
               aria-label="<?php echo esc_attr( sprintf( __( 'Filter by %s', 'quantum-mentor-world' ), $data['label'] ) ); ?>">
                <span aria-hidden="true"><?php echo esc_html( $data['icon'] ); ?></span>
                <?php echo esc_html( $data['label'] ); ?>
            </a>
            <?php endforeach; ?>
        </nav>

    </div>
</section>
