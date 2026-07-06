<?php
/**
 * Books Archive — Hero Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Count published books for display
$total_books = wp_count_posts( 'books' )->publish ?? 0;
?>

<!-- ============================================================
     BOOKS ARCHIVE HERO
     ============================================================ -->
<section class="books-archive-hero" aria-label="<?php esc_attr_e( 'Books Library Hero', 'quantum-mentor-world' ); ?>">

    <!-- Background orbs -->
    <div class="books-hero-bg-orbs"></div>

    <div class="container container-laptop" style="position: relative; z-index: 1;">

        <!-- Eyebrow badge -->
        <div style="text-align: center; margin-bottom: var(--space-4);">
            <span class="badge badge-warning" style="font-size: 11px; letter-spacing: 0.12em; padding: 6px 16px;">
                📚 <?php esc_html_e( 'LEGAL DIGITAL LIBRARY', 'quantum-mentor-world' ); ?>
            </span>
        </div>

        <!-- Main heading -->
        <h1 class="books-hero-title" style="text-align: center;">
            <?php esc_html_e( 'E-Books & Guides', 'quantum-mentor-world' ); ?>
        </h1>

        <!-- Subtitle -->
        <p class="books-hero-subtitle">
            <?php esc_html_e( 'Discover legal, free, public-domain, and open-access books, programming manuals, freelancing guides, and academic texts. Completely safe downloads and official reader links.', 'quantum-mentor-world' ); ?>
        </p>

        <!-- Stat pills row -->
        <div class="books-hero-stats">
            <div class="books-stat-pill">
                <span class="books-stat-icon">📖</span>
                <span><?php echo esc_html( $total_books ); ?> <?php esc_html_e( 'Books Cataloged', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="books-stat-pill">
                <span class="books-stat-icon">📜</span>
                <span><?php esc_html_e( 'Public Domain & CC', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="books-stat-pill">
                <span class="books-stat-icon">🛡️</span>
                <span><?php esc_html_e( 'Verified Safe Sources', 'quantum-mentor-world' ); ?></span>
            </div>
            <div class="books-stat-pill">
                <span class="books-stat-icon">📄</span>
                <span><?php esc_html_e( 'PDF · EPUB · Online', 'quantum-mentor-world' ); ?></span>
            </div>
        </div>

        <!-- Category quick-links -->
        <nav class="books-category-links" aria-label="<?php esc_attr_e( 'Quick Category Filter Links', 'quantum-mentor-world' ); ?>">
            <?php
            $quick_categories = array(
                'programming' => array( 'label' => 'Programming', 'icon' => '💻' ),
                'ai'          => array( 'label' => 'AI',          'icon' => '🤖' ),
                'business'    => array( 'label' => 'Business',    'icon' => '📈' ),
                'freelancing' => array( 'label' => 'Freelancing', 'icon' => '✍️' ),
                'science'     => array( 'label' => 'Science',     'icon' => '🔬' ),
                'novels'      => array( 'label' => 'Novels',      'icon' => '📚' ),
            );
            $archive_url = get_post_type_archive_link( 'books' );
            foreach ( $quick_categories as $slug => $data ) :
                $active = ( isset( $_GET['category'] ) && sanitize_text_field( $_GET['category'] ) === $slug );
            ?>
            <a href="<?php echo esc_url( add_query_arg( 'category', $slug, $archive_url ) ); ?>"
               class="books-category-pill <?php echo $active ? 'active' : ''; ?>"
               aria-label="<?php echo esc_attr( sprintf( __( 'Filter by %s', 'quantum-mentor-world' ), $data['label'] ) ); ?>">
                <span aria-hidden="true"><?php echo esc_html( $data['icon'] ); ?></span>
                <?php echo esc_html( $data['label'] ); ?>
            </a>
            <?php endforeach; ?>
        </nav>

    </div>
</section>
