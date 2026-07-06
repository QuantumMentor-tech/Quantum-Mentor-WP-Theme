<?php
/**
 * Category Explorer Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$categories = array(
    array(
        'title' => __( 'Software', 'quantum-mentor-world' ),
        'desc'  => __( 'Discover Windows, Mac, Linux, Android, and iPhone resources.', 'quantum-mentor-world' ),
        'icon'  => '💻',
        'url'   => home_url( '/software/' ),
        'color' => 'var(--primary)',
    ),
    array(
        'title' => __( 'Themes & Plugins', 'quantum-mentor-world' ),
        'desc'  => __( 'Explore legal templates and plugins for WordPress, WooCommerce, and Shopify.', 'quantum-mentor-world' ),
        'icon'  => '🔌',
        'url'   => home_url( '/themes-plugins/' ),
        'color' => 'var(--secondary)',
    ),
    array(
        'title' => __( 'Games', 'quantum-mentor-world' ),
        'desc'  => __( 'Discover free, open-source, and legally allowed educational games.', 'quantum-mentor-world' ),
        'icon'  => '🎮',
        'url'   => home_url( '/games/' ),
        'color' => 'var(--success)',
    ),
    array(
        'title' => __( 'Tech News', 'quantum-mentor-world' ),
        'desc'  => __( 'Read up-to-date AI alerts, tech developments, and global software news.', 'quantum-mentor-world' ),
        'icon'  => '📰',
        'url'   => home_url( '/news/' ),
        'color' => 'var(--text-muted)',
    ),
    array(
        'title' => __( 'Online Tools', 'quantum-mentor-world' ),
        'desc'  => __( 'Web-based converters, calculators, AI sandboxes, and developer tools.', 'quantum-mentor-world' ),
        'icon'  => '⚙',
        'url'   => home_url( '/tools/' ),
        'color' => 'var(--success)',
    ),
    array(
        'title' => __( 'Books & Guides', 'quantum-mentor-world' ),
        'desc'  => __( 'Download legal public-domain ebooks, learning guides, and tutorials.', 'quantum-mentor-world' ),
        'icon'  => '📚',
        'url'   => home_url( '/books/' ),
        'color' => 'var(--warning)',
    ),
    array(
        'title' => __( 'Watch Media', 'quantum-mentor-world' ),
        'desc'  => __( 'Embedded educational courses, anime, courses, and movies.', 'quantum-mentor-world' ),
        'icon'  => '🎬',
        'url'   => home_url( '/watch/' ),
        'color' => 'var(--secondary)',
    ),
    array(
        'title' => __( 'GitHub Repos', 'quantum-mentor-world' ),
        'desc'  => __( 'Explore verified open-source repositories and development scripts.', 'quantum-mentor-world' ),
        'icon'  => '🐙',
        'url'   => home_url( '/github-repos/' ),
        'color' => 'var(--primary)',
    ),
);
?>

<section id="category-explorer" class="py-16" style="border-bottom: 1px solid var(--border);">
    <div class="container container-desktop">
        
        <div style="margin-bottom: var(--space-8);">
            <h2 class="section-title">
                <?php esc_html_e( 'Browse Directory Categories', 'quantum-mentor-world' ); ?>
            </h2>
            <p class="small-text" style="max-width: 600px; margin-top: -12px;">
                <?php esc_html_e( 'Find legally compliant files, resources, and tech content curated and verified by our editors.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <div class="grid grid-cols-12 grid-cols-mobile-1 grid-cols-tablet-6 grid-desktop-4" style="gap: var(--space-6);">
            <?php foreach ( $categories as $cat ) : ?>
                <a href="<?php echo esc_url( $cat['url'] ); ?>" class="glass-card card-category col-span-3 md:col-span-3 lg:col-span-3 transition-all" style="border-bottom: 3px solid <?php echo esc_attr( $cat['color'] ); ?>;">
                    <div class="category-icon" style="color: <?php echo esc_attr( $cat['color'] ); ?>;">
                        <?php echo esc_html( $cat['icon'] ); ?>
                    </div>
                    <h3 class="card-title" style="margin-bottom: var(--space-2); font-size: 18px; color: var(--text-main);">
                        <?php echo esc_html( $cat['title'] ); ?>
                    </h3>
                    <p class="small-text" style="font-size: 13px; line-height: 1.5; color: var(--text-muted);">
                        <?php echo esc_html( $cat['desc'] ); ?>
                    </p>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>
