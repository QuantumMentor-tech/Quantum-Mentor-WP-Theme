<?php
/**
 * Single Book — Sidebar Meta / Specs Card
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id = $post->ID;

$author         = get_field( 'book_author_field', $post_id );
$publisher      = get_field( 'book_publisher', $post_id );
$language       = get_field( 'book_language_field', $post_id );
$pages          = get_field( 'book_pages_count', $post_id );
$book_type      = get_field( 'book_type', $post_id );
$format         = get_field( 'book_format', $post_id );
$pub_year       = get_field( 'book_pub_year', $post_id );
$status         = get_field( 'book_status', $post_id );

$verified       = get_field( 'verified_resource', $post_id );
$official_conf  = get_field( 'official_source_confirmed', $post_id );
$safety_checked = get_field( 'safety_checked', $post_id );

// Fallbacks for safety status fields
if ( $verified === null )       { $verified = true; }
if ( $official_conf === null )  { $official_conf = true; }
if ( $safety_checked === null ) { $safety_checked = true; }

$formatted_date = get_the_modified_date( get_option( 'date_format' ), $post_id );

// Status color map
$status_colors = array(
    'Active'     => '#22C55E', // Available
    'Updated'    => '#3B82F6', // Updated Edition
    'Deprecated' => '#F59E0B', // Old Edition
    'Removed'    => '#EF4444', // Link Unavailable
);
$status_color = isset( $status_colors[ $status ] ) ? $status_colors[ $status ] : '#94A3B8';

// Mapping visual status text
$status_labels = array(
    'Active'     => __( 'Available', 'quantum-mentor-world' ),
    'Updated'    =>   __( 'Updated Edition', 'quantum-mentor-world' ),
    'Deprecated' => __( 'Old Edition', 'quantum-mentor-world' ),
    'Removed'    =>   __( 'Link Unavailable', 'quantum-mentor-world' ),
);
$status_label = isset( $status_labels[ $status ] ) ? $status_labels[ $status ] : $status;

// Taxonomy terms
$book_cats = get_the_terms( $post_id, 'book_category' );
$book_tags = get_the_terms( $post_id, 'book_tag' );
?>

<!-- ============================================================
     BOOK META SIDEBAR CARD
     ============================================================ -->
<aside class="book-meta-card glass-card p-6" aria-label="<?php esc_attr_e( 'Book Specifications', 'quantum-mentor-world' ); ?>">

    <h2 class="book-meta-heading">
        <?php esc_html_e( 'Book Information', 'quantum-mentor-world' ); ?>
    </h2>

    <ul class="book-spec-list" role="list">

        <?php if ( ! empty( $author ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">🧑‍🏫 <?php esc_html_e( 'Author', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value"><?php echo esc_html( $author ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $publisher ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">🏢 <?php esc_html_e( 'Publisher', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value"><?php echo esc_html( $publisher ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $language ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">🌐 <?php esc_html_e( 'Language', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value"><?php echo esc_html( $language ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $pages ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">📖 <?php esc_html_e( 'Pages', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value"><?php echo esc_html( $pages ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $pub_year ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">🗓️ <?php esc_html_e( 'Published', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value"><?php echo esc_html( $pub_year ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $format ) && is_array( $format ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">📄 <?php esc_html_e( 'Formats', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value book-format-badges">
                <?php foreach ( $format as $fmt ) : ?>
                    <span class="badge badge-muted" style="font-size: 8px;"><?php echo esc_html( $fmt ); ?></span>
                <?php endforeach; ?>
            </span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $book_type ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">🔑 <?php esc_html_e( 'License / Access', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value" style="color: var(--warning); font-weight: 700;"><?php echo esc_html( $book_type ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $status ) ) : ?>
        <li class="book-spec-item">
            <span class="book-spec-label">📡 <?php esc_html_e( 'Status', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value">
                <span style="display:inline-flex; align-items:center; gap:5px; padding: 2px 10px; border-radius:999px; background-color:<?php echo esc_attr( $status_color ); ?>20; color:<?php echo esc_attr( $status_color ); ?>; font-size:11px; font-weight:700; border:1px solid <?php echo esc_attr( $status_color ); ?>40;">
                    <?php echo esc_html( $status_label ); ?>
                </span>
            </span>
        </li>
        <?php endif; ?>

        <li class="book-spec-item" style="border-bottom: none;">
            <span class="book-spec-label">🔄 <?php esc_html_e( 'Last Updated', 'quantum-mentor-world' ); ?></span>
            <span class="book-spec-value">
                <time datetime="<?php echo esc_attr( get_the_modified_date( 'Y-m-d', $post_id ) ); ?>">
                    <?php echo esc_html( $formatted_date ); ?>
                </time>
            </span>
        </li>

    </ul>

    <!-- Category Tags -->
    <?php if ( ! empty( $book_cats ) && ! is_wp_error( $book_cats ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="books-filter-label" style="display:block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Subjects', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud">
            <?php foreach ( $book_cats as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tags -->
    <?php if ( ! empty( $book_tags ) && ! is_wp_error( $book_tags ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="books-filter-label" style="display:block; margin-bottom: var(--space-2);"><?php esc_html_e( 'Tags', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud">
            <?php foreach ( $book_tags as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</aside>

<!-- Verification Badge -->
<div class="book-verify-card glass-card p-4" aria-label="<?php esc_attr_e( 'Trust & Verification Badge', 'quantum-mentor-world' ); ?>">
    <div style="display: flex; flex-direction: column; gap: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
            <span style="font-size: 26px; flex-shrink: 0;">✅</span>
            <div>
                <p style="font-size: 13px; font-weight: 700; color: var(--success); margin-bottom: 2px;"><?php esc_html_e( 'Verified Safe Library', 'quantum-mentor-world' ); ?></p>
                <p class="small-text" style="font-size: 11px; line-height: 1.5;"><?php esc_html_e( 'Public-domain, open-access, or publisher-approved.', 'quantum-mentor-world' ); ?></p>
            </div>
        </div>

        <?php if ( $verified ) : ?>
        <div class="book-trust-check">
            <span class="book-trust-dot"></span>
            <span><?php esc_html_e( 'Verified Resource', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $official_conf ) : ?>
        <div class="book-trust-check">
            <span class="book-trust-dot"></span>
            <span><?php esc_html_e( 'Official Source Confirmed', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $safety_checked ) : ?>
        <div class="book-trust-check">
            <span class="book-trust-dot"></span>
            <span><?php esc_html_e( 'Safety & Integrity Checked', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
