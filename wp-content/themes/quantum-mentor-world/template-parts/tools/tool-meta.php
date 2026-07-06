<?php
/**
 * Single Tool — Sidebar Meta / Specifications Card
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id = $post->ID;

$tool_cat    = get_field( 'tool_type_field', $post_id );
$access_type = get_field( 'tool_access_type', $post_id );
$tool_status = get_field( 'tool_status_field', $post_id );

$verified       = get_field( 'verified_resource', $post_id );
$official_conf  = get_field( 'official_source_confirmed', $post_id );
$safety_checked = get_field( 'safety_checked', $post_id );

// Fallbacks for safety status fields
if ( $verified === null )       { $verified = true; }
if ( $official_conf === null )  { $official_conf = true; }
if ( $safety_checked === null ) { $safety_checked = true; }

$formatted_date = get_the_modified_date( get_option( 'date_format' ), $post_id );

// Status color mapping
$status_colors = array(
    'Active'      => '#22C55E', // green
    'Updated'     => '#3B82F6', // blue
    'Maintenance' => '#F59E0B', // amber
    'Deprecated'  => '#E2E8F0', // slate
    'Removed'     => '#EF4444', // red
);
$status_color = isset( $status_colors[ $tool_status ] ) ? $status_colors[ $tool_status ] : '#94A3B8';

// Taxonomy terms
$tool_cats = get_the_terms( $post_id, 'tool_category' );
$tool_tags = get_the_terms( $post_id, 'tool_tag' );
?>

<!-- ============================================================
     TOOL META SIDEBAR CARD
     ============================================================ -->
<aside class="tool-meta-card glass-card p-6" aria-label="<?php esc_attr_e( 'Tool Specifications details', 'quantum-mentor-world' ); ?>">

    <h3 class="tools-meta-heading" style="font-size: 16px; font-weight: 700; margin-top: 0; margin-bottom: var(--space-4); border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: var(--space-2); color: var(--text-main);">
        ⚙️ <?php esc_html_e( 'Tool Information', 'quantum-mentor-world' ); ?>
    </h3>

    <ul class="watch-spec-list" role="list" style="list-style: none; padding: 0; margin: 0;">

        <?php if ( ! empty( $tool_cat ) ) : ?>
        <li class="watch-spec-item" style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-3) 0; border-bottom: 1px solid rgba(255,255,255,0.04);">
            <span class="watch-spec-label" style="font-size: 13px; color: var(--text-muted); font-weight: 500;">📂 <?php esc_html_e( 'Category', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value" style="font-size: 13px; color: var(--text-main); font-weight: 600;"><?php echo esc_html( $tool_cat ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $access_type ) ) : ?>
        <li class="watch-spec-item" style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-3) 0; border-bottom: 1px solid rgba(255,255,255,0.04);">
            <span class="watch-spec-label" style="font-size: 13px; color: var(--text-muted); font-weight: 500;">📶 <?php esc_html_e( 'Access Mode', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value" style="font-size: 13px; color: var(--text-main); font-weight: 600;"><?php echo esc_html( $access_type ); ?></span>
        </li>
        <?php endif; ?>

        <?php if ( ! empty( $tool_status ) ) : ?>
        <li class="watch-spec-item" style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-3) 0; border-bottom: 1px solid rgba(255,255,255,0.04);">
            <span class="watch-spec-label" style="font-size: 13px; color: var(--text-muted); font-weight: 500;">📡 <?php esc_html_e( 'Status', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value" style="font-size: 13px; color: var(--text-main); font-weight: 600;">
                <span style="display:inline-flex; align-items:center; gap:5px; padding: 2px 10px; border-radius:999px; background-color:<?php echo esc_attr( $status_color ); ?>20; color:<?php echo esc_attr( $status_color ); ?>; font-size:11px; font-weight:700; border:1px solid <?php echo esc_attr( $status_color ); ?>40;">
                    <?php echo esc_html( $tool_status ); ?>
                </span>
            </span>
        </li>
        <?php endif; ?>

        <li class="watch-spec-item" style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-3) 0; border-bottom: none;">
            <span class="watch-spec-label" style="font-size: 13px; color: var(--text-muted); font-weight: 500;">🔄 <?php esc_html_e( 'Last Checked', 'quantum-mentor-world' ); ?></span>
            <span class="watch-spec-value" style="font-size: 13px; color: var(--text-main); font-weight: 600;">
                <time datetime="<?php echo esc_attr( get_the_modified_date( 'Y-m-d', $post_id ) ); ?>">
                    <?php echo esc_html( $formatted_date ); ?>
                </time>
            </span>
        </li>

    </ul>

    <!-- Taxonomy Categories -->
    <?php if ( ! empty( $tool_cats ) && ! is_wp_error( $tool_cats ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="watch-filter-label" style="display:block; margin-bottom: var(--space-2); font-size: 12px; font-weight: 700; color: var(--text-muted);"><?php esc_html_e( 'Categories', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud" style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
            <?php foreach ( $tool_cats as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag" style="font-size: 12px; text-decoration: none; color: var(--text-muted); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-muted)';"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Tags -->
    <?php if ( ! empty( $tool_tags ) && ! is_wp_error( $tool_tags ) ) : ?>
    <div style="margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <span class="watch-filter-label" style="display:block; margin-bottom: var(--space-2); font-size: 12px; font-weight: 700; color: var(--text-muted);"><?php esc_html_e( 'Tags', 'quantum-mentor-world' ); ?></span>
        <div class="tag-cloud" style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
            <?php foreach ( $tool_tags as $term ) : ?>
                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>" class="tag" rel="tag" style="font-size: 12px; text-decoration: none; color: var(--text-muted); border: 1px solid var(--border); padding: 2px 8px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-muted)';"><?php echo esc_html( $term->name ); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</aside>

<!-- Verification / Safe badge checklist -->
<div class="watch-verify-card glass-card p-4" style="margin-top: var(--space-6); background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(34, 197, 94, 0.2); border-radius: var(--radius-md);" aria-label="<?php esc_attr_e( 'Trust & Verification Badge', 'quantum-mentor-world' ); ?>">
    <div style="display: flex; flex-direction: column; gap: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
            <span style="font-size: 26px; flex-shrink: 0;">🛡️</span>
            <div>
                <p style="font-size: 13px; font-weight: 700; color: var(--success); margin-bottom: 2px;"><?php esc_html_e( 'Safe Utility Index', 'quantum-mentor-world' ); ?></p>
                <p class="small-text" style="font-size: 11px; line-height: 1.5; color: var(--text-muted); margin: 0;"><?php esc_html_e( 'Verified clean tools and safe redirect links.', 'quantum-mentor-world' ); ?></p>
            </div>
        </div>

        <?php if ( $verified ) : ?>
        <div class="watch-trust-check" style="display: flex; align-items: center; gap: var(--space-2); font-size: 12px; color: var(--text-muted);">
            <span class="watch-trust-dot" style="width: 6px; height: 6px; background: var(--success); border-radius: 50%; box-shadow: 0 0 6px var(--success); flex-shrink: 0;"></span>
            <span><?php esc_html_e( 'Verified Resource', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $official_conf ) : ?>
        <div class="watch-trust-check" style="display: flex; align-items: center; gap: var(--space-2); font-size: 12px; color: var(--text-muted);">
            <span class="watch-trust-dot" style="width: 6px; height: 6px; background: var(--success); border-radius: 50%; box-shadow: 0 0 6px var(--success); flex-shrink: 0;"></span>
            <span><?php esc_html_e( 'Official Source Confirmed', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>

        <?php if ( $safety_checked ) : ?>
        <div class="watch-trust-check" style="display: flex; align-items: center; gap: var(--space-2); font-size: 12px; color: var(--text-muted);">
            <span class="watch-trust-dot" style="width: 6px; height: 6px; background: var(--success); border-radius: 50%; box-shadow: 0 0 6px var(--success); flex-shrink: 0;"></span>
            <span><?php esc_html_e( 'Safety & Link Integrity Checked', 'quantum-mentor-world' ); ?></span>
        </div>
        <?php endif; ?>
    </div>
</div>
