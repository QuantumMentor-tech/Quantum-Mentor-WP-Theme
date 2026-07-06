<?php
/**
 * Tools Archive — Hero Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$total_tools = wp_count_posts( 'tools' )->publish ?? 0;
?>

<section class="tools-archive-hero" aria-label="<?php esc_attr_e( 'Tools Platform Hero', 'quantum-mentor-world' ); ?>">
    <!-- Background orbs decoration -->
    <div class="tools-hero-bg-orbs"></div>

    <div class="container container-laptop" style="position: relative; z-index: 1; text-align: center;">

        <!-- Eyebrow Badge -->
        <div style="text-align: center; margin-bottom: var(--space-4);">
            <span class="badge badge-primary" style="font-size: 11px; letter-spacing: 0.12em; padding: 6px 16px; border-color: var(--primary);">
                ⚙️ <?php esc_html_e( 'ONLINE TOOLS DIRECTORY', 'quantum-mentor-world' ); ?>
            </span>
        </div>

        <!-- H1 Page Title -->
        <h1 class="tools-hero-title">
            <?php esc_html_e( 'Tools', 'quantum-mentor-world' ); ?>
        </h1>

        <!-- Subtitle -->
        <p class="tools-hero-subtitle">
            <?php esc_html_e( 'Use helpful online tools for files, PDFs, images, videos, text, SEO, AI, and development.', 'quantum-mentor-world' ); ?>
        </p>

        <!-- Stats Pills -->
        <div class="tools-hero-stats">
            <div class="tools-stat-pill">
                <span>⚙️</span>
                <span><?php echo esc_html( $total_tools ); ?> <?php esc_html_e( 'Tools Online', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="tools-stat-pill">
                <span>🔒</span>
                <span><?php esc_html_e( 'Built-in & Safe', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="tools-stat-pill">
                <span>🛡️</span>
                <span><?php esc_html_e( 'Privacy Verified', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="tools-stat-pill">
                <span>⚡</span>
                <span><?php esc_html_e( 'Fast Browser Processing', 'quantum-mentor-world' ); ?></span>
            </div>
        </div>

        <!-- Category Quick-Links -->
        <nav class="tools-category-links" aria-label="<?php esc_attr_e( 'Quick Category Links', 'quantum-mentor-world' ); ?>">
            <?php
            $quick_cats = array(
                'file-converter' => array( 'label' => 'Converter', 'icon' => '🔄' ),
                'pdf-tools'      => array( 'label' => 'PDF Tools', 'icon' => '📄' ),
                'image-tools'    => array( 'label' => 'Image Tools', 'icon' => '🖼️' ),
                'text-tools'     => array( 'label' => 'Text Tools', 'icon' => '📝' ),
                'ai-tools'       => array( 'label' => 'AI Tools', 'icon' => '🤖' ),
                'developer-tools'=> array( 'label' => 'Dev Tools', 'icon' => '💻' ),
            );
            $archive_url = get_post_type_archive_link( 'tools' );
            foreach ( $quick_cats as $slug => $data ) :
                $active = ( isset( $_GET['category'] ) && sanitize_text_field( $_GET['category'] ) === $slug );
            ?>
            <a href="<?php echo esc_url( add_query_arg( 'category', $slug, $archive_url ) ); ?>"
               class="tools-category-pill <?php echo $active ? 'active' : ''; ?>"
               aria-label="<?php echo esc_attr( sprintf( __( 'Filter by %s', 'quantum-mentor-world' ), $data['label'] ) ); ?>">
                <span aria-hidden="true"><?php echo esc_html( $data['icon'] ); ?></span>
                <?php echo esc_html( $data['label'] ); ?>
            </a>
            <?php endforeach; ?>
        </nav>

    </div>
</section>
