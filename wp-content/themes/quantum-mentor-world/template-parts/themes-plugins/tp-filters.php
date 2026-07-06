<?php
/**
 * Themes & Plugins Archive Filters Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Current query states
$current_category = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';
$current_platform = isset( $_GET['platform'] ) ? sanitize_text_field( $_GET['platform'] ) : '';
$current_type     = isset( $_GET['type'] ) ? sanitize_text_field( $_GET['type'] ) : '';
$current_license  = isset( $_GET['license'] ) ? sanitize_text_field( $_GET['license'] ) : '';
$current_sort     = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
$search_query     = isset( $_GET['tp_search'] ) ? sanitize_text_field( $_GET['tp_search'] ) : '';

// 1. Fetch category terms of theme_plugin_category taxonomy
$categories = get_terms( array(
    'taxonomy'   => 'theme_plugin_category',
    'hide_empty' => false,
) );

// 2. Platforms
$platforms = array(
    'wordpress'   => 'WordPress',
    'woocommerce' => 'WooCommerce',
    'shopify'     => 'Shopify',
    'hostinger'   => 'Hostinger',
    'godaddy'     => 'GoDaddy',
    'blogger'     => 'Blogger',
);

// 3. Types
$types = array(
    'theme'     => 'Theme',
    'plugin'    => 'Plugin',
    'template'  => 'Template',
    'extension' => 'Extension',
    'app'       => 'App',
);

// 4. Licenses
$licenses = array(
    'free'          => 'Free',
    'open-source'   => 'Open Source',
    'gpl'           => 'GPL / Copyleft',
    'freemium'      => 'Freemium',
    'paid-official' => 'Paid Official Link',
);

$has_active_filters = ! empty( $current_category ) || ! empty( $current_platform ) || ! empty( $current_type ) || ! empty( $current_license ) || ! empty( $search_query ) || $current_sort !== 'latest';
?>

<div class="tp-filters-bar glass-card mb-8 p-4">
    <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'themes_plugins' ) ); ?>" class="filters-form" id="tp-filters-form">
        
        <!-- Persistent search query -->
        <?php if ( ! empty( $search_query ) ) : ?>
            <input type="hidden" name="tp_search" value="<?php echo esc_attr( $search_query ); ?>">
        <?php endif; ?>

        <div class="filters-grid" style="display: grid; gap: var(--space-3); grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); align-items: flex-end;">
            
            <!-- Category Filter -->
            <div class="filter-group">
                <label for="filter-cat" class="small-text" style="display: block; margin-bottom: var(--space-1); font-weight: 600; color: var(--text-muted);">
                    <?php esc_html_e( 'Category', 'quantum-mentor-world' ); ?>
                </label>
                <select name="category" id="filter-cat" class="filter-select" onchange="document.getElementById('tp-filters-form').submit();" style="width: 100%; height: 42px; border-radius: var(--radius-sm); border: 1px solid var(--border); background-color: var(--bg-primary); color: var(--text-main); padding: 0 12px; outline: none; font-size: 13px;">
                    <option value=""><?php esc_html_e( 'All Categories', 'quantum-mentor-world' ); ?></option>
                    <?php if ( ! is_wp_error( $categories ) && ! empty( $categories ) ) : ?>
                        <?php foreach ( $categories as $cat ) : ?>
                            <option value="<?php echo esc_attr( $cat->slug ); ?>" <?php selected( $current_category, $cat->slug ); ?>>
                                <?php echo esc_html( $cat->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Platform Filter -->
            <div class="filter-group">
                <label for="filter-platform" class="small-text" style="display: block; margin-bottom: var(--space-1); font-weight: 600; color: var(--text-muted);">
                    <?php esc_html_e( 'Platform', 'quantum-mentor-world' ); ?>
                </label>
                <select name="platform" id="filter-platform" class="filter-select" onchange="document.getElementById('tp-filters-form').submit();" style="width: 100%; height: 42px; border-radius: var(--radius-sm); border: 1px solid var(--border); background-color: var(--bg-primary); color: var(--text-main); padding: 0 12px; outline: none; font-size: 13px;">
                    <option value=""><?php esc_html_e( 'All Platforms', 'quantum-mentor-world' ); ?></option>
                    <?php foreach ( $platforms as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $current_platform, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Type Filter -->
            <div class="filter-group">
                <label for="filter-type" class="small-text" style="display: block; margin-bottom: var(--space-1); font-weight: 600; color: var(--text-muted);">
                    <?php esc_html_e( 'Resource Type', 'quantum-mentor-world' ); ?>
                </label>
                <select name="type" id="filter-type" class="filter-select" onchange="document.getElementById('tp-filters-form').submit();" style="width: 100%; height: 42px; border-radius: var(--radius-sm); border: 1px solid var(--border); background-color: var(--bg-primary); color: var(--text-main); padding: 0 12px; outline: none; font-size: 13px;">
                    <option value=""><?php esc_html_e( 'All Types', 'quantum-mentor-world' ); ?></option>
                    <?php foreach ( $types as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $current_type, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- License Filter -->
            <div class="filter-group">
                <label for="filter-license" class="small-text" style="display: block; margin-bottom: var(--space-1); font-weight: 600; color: var(--text-muted);">
                    <?php esc_html_e( 'License', 'quantum-mentor-world' ); ?>
                </label>
                <select name="license" id="filter-license" class="filter-select" onchange="document.getElementById('tp-filters-form').submit();" style="width: 100%; height: 42px; border-radius: var(--radius-sm); border: 1px solid var(--border); background-color: var(--bg-primary); color: var(--text-main); padding: 0 12px; outline: none; font-size: 13px;">
                    <option value=""><?php esc_html_e( 'All Licenses', 'quantum-mentor-world' ); ?></option>
                    <?php foreach ( $licenses as $slug => $label ) : ?>
                        <option value="<?php echo esc_attr( $slug ); ?>" <?php selected( $current_license, $slug ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sorting Filter -->
            <div class="filter-group">
                <label for="filter-sort" class="small-text" style="display: block; margin-bottom: var(--space-1); font-weight: 600; color: var(--text-muted);">
                    <?php esc_html_e( 'Sort By', 'quantum-mentor-world' ); ?>
                </label>
                <select name="sort" id="filter-sort" class="filter-select" onchange="document.getElementById('tp-filters-form').submit();" style="width: 100%; height: 42px; border-radius: var(--radius-sm); border: 1px solid var(--border); background-color: var(--bg-primary); color: var(--text-main); padding: 0 12px; outline: none; font-size: 13px;">
                    <option value="latest" <?php selected( $current_sort, 'latest' ); ?>><?php esc_html_e( 'Latest Releases', 'quantum-mentor-world' ); ?></option>
                    <option value="featured" <?php selected( $current_sort, 'featured' ); ?>><?php esc_html_e( 'Featured First', 'quantum-mentor-world' ); ?></option>
                    <option value="popular" <?php selected( $current_sort, 'popular' ); ?>><?php esc_html_e( 'Most Popular', 'quantum-mentor-world' ); ?></option>
                    <option value="a-z" <?php selected( $current_sort, 'a-z' ); ?>><?php esc_html_e( 'Alphabetical (A-Z)', 'quantum-mentor-world' ); ?></option>
                </select>
            </div>

            <!-- Clear Action -->
            <?php if ( $has_active_filters ) : ?>
                <div class="filter-group reset-button-group" style="display: flex;">
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'themes_plugins' ) ); ?>" class="btn btn-secondary" style="width: 100%; height: 42px; padding: 0 16px; border-radius: var(--radius-sm); font-size: 13px; min-height: auto; align-items: center; justify-content: center; gap: 8px;">
                        <span>&times;</span> <?php esc_html_e( 'Clear', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </form>
</div>
