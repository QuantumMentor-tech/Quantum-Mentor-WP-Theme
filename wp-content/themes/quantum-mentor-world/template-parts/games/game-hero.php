<?php
/**
 * Games Archive — Hero Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Count totals for display
$total_games = wp_count_posts( 'games' )->publish ?? 0;
?>

<!-- ============================================================
     GAMES ARCHIVE HERO
     ============================================================ -->
<section class="games-archive-hero" aria-label="<?php esc_attr_e( 'Games Directory Hero', 'quantum-mentor-world' ); ?>">

    <!-- Background orbs -->
    <div class="hero-bg-orbs"></div>

    <div class="container container-laptop" style="position: relative; z-index: 1;">

        <!-- Eyebrow badge -->
        <div style="text-align: center; margin-bottom: var(--space-4);">
            <span class="badge badge-secondary" style="font-size: 11px; letter-spacing: 0.12em; padding: 6px 16px;">
                🎮 <?php esc_html_e( 'LEGAL GAMES DIRECTORY', 'quantum-mentor-world' ); ?>
            </span>
        </div>

        <!-- Main heading -->
        <h1 class="games-hero-title" style="text-align: center;">
            <?php esc_html_e( 'Games', 'quantum-mentor-world' ); ?>
        </h1>

        <!-- Subtitle -->
        <p class="games-hero-subtitle">
            <?php esc_html_e( 'Discover legal, free, open-source, educational, browser, mobile, and PC games from trusted and official sources. Zero piracy — only verified, licensed resources.', 'quantum-mentor-world' ); ?>
        </p>

        <!-- Stat pills row -->
        <div class="games-hero-stats">
            <div class="games-stat-pill">
                <span class="games-stat-icon">🎮</span>
                <span><?php echo esc_html( $total_games ); ?> <?php esc_html_e( 'Games Listed', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="games-stat-pill">
                <span class="games-stat-icon">✅</span>
                <span><?php esc_html_e( 'Verified Legal Only', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="games-stat-pill">
                <span class="games-stat-icon">🛡️</span>
                <span><?php esc_html_e( 'Zero Piracy Policy', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="games-stat-pill">
                <span class="games-stat-icon">🌍</span>
                <span><?php esc_html_e( 'PC · Mobile · Browser', 'quantum-mentor-world' ); ?></span>
            </div>
        </div>

        <!-- Platform quick-links -->
        <nav class="games-platform-links" aria-label="<?php esc_attr_e( 'Quick Platform Filter Links', 'quantum-mentor-world' ); ?>">
            <?php
            $quick_platforms = array(
                'windows' => array( 'label' => 'Windows', 'icon' => '🪟' ),
                'mac'     => array( 'label' => 'Mac',     'icon' => '🍎' ),
                'linux'   => array( 'label' => 'Linux',   'icon' => '🐧' ),
                'android' => array( 'label' => 'Android', 'icon' => '🤖' ),
                'iphone'  => array( 'label' => 'iPhone',  'icon' => '📱' ),
                'browser' => array( 'label' => 'Browser', 'icon' => '🌐' ),
            );
            $archive_url = get_post_type_archive_link( 'games' );
            foreach ( $quick_platforms as $slug => $data ) :
                $active = ( isset( $_GET['platform'] ) && sanitize_text_field( $_GET['platform'] ) === $slug );
            ?>
            <a href="<?php echo esc_url( add_query_arg( 'platform', $slug, $archive_url ) ); ?>"
               class="games-platform-pill <?php echo $active ? 'active' : ''; ?>"
               aria-label="<?php echo esc_attr( sprintf( __( 'Filter by %s', 'quantum-mentor-world' ), $data['label'] ) ); ?>">
                <span aria-hidden="true"><?php echo esc_html( $data['icon'] ); ?></span>
                <?php echo esc_html( $data['label'] ); ?>
            </a>
            <?php endforeach; ?>
        </nav>

    </div>
</section>
