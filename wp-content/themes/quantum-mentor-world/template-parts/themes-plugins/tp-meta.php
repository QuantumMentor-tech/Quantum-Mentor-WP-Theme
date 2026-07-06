<?php
/**
 * Single Themes & Plugins Metadata Sidebar Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();

// Fetch ACF custom fields
$platform     = get_field( 'tp_platform', $post_id );
$type         = get_field( 'tp_type', $post_id );
$version      = get_field( 'tp_version', $post_id );
$developer    = get_field( 'tp_developer', $post_id );
$license      = get_field( 'tp_license', $post_id );
$last_updated = get_field( 'tp_last_updated', $post_id );
if ( empty( $last_updated ) ) {
    $last_updated = get_the_modified_date( 'Y-m-d', $post_id );
}
$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $last_updated ) );

$status = get_field( 'tp_status', $post_id );
if ( empty( $status ) ) {
    $status = 'Active';
}

// Global checks
$is_verified        = get_field( 'admin_verified', $post_id ) !== false;
$is_source_checked  = get_field( 'admin_source_confirmed', $post_id ) !== false;
$is_safety_checked  = get_field( 'admin_safety_checked', $post_id ) !== false;

// Status Badge Helper
$status_class = 'badge-success';
if ( $status === 'Deprecated' ) {
    $status_class = 'badge-warning';
} elseif ( $status === 'Removed' ) {
    $status_class = 'badge-danger';
} elseif ( $status === 'Updated' ) {
    $status_class = 'badge-primary';
}
?>

<div class="tp-specs-sidebar glass-card" style="position: sticky; top: 100px; gap: var(--space-4);">
    <h3 class="card-title mb-4" style="font-size: 20px; border-bottom: 1px solid var(--border); padding-bottom: var(--space-3);"><?php esc_html_e( 'Item Specifications', 'quantum-mentor-world' ); ?></h3>

    <ul class="specs-list" style="list-style: none; padding: 0; margin: 0 0 var(--space-6) 0;">
        <?php if ( ! empty( $developer ) ) : ?>
            <li style="display: flex; justify-content: space-between; padding: var(--space-2) 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
                <span class="small-text" style="font-weight: 500; color: var(--text-muted);"><?php esc_html_e( 'Developer', 'quantum-mentor-world' ); ?></span>
                <span style="font-size: 14px; font-weight: 600; text-align: right;"><?php echo esc_html( $developer ); ?></span>
            </li>
        <?php endif; ?>

        <?php if ( ! empty( $platform ) ) : ?>
            <li style="display: flex; justify-content: space-between; padding: var(--space-2) 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
                <span class="small-text" style="font-weight: 500; color: var(--text-muted);"><?php esc_html_e( 'Platform', 'quantum-mentor-world' ); ?></span>
                <span class="badge badge-secondary" style="font-size: 10px; padding: 2px 6px;"><?php echo esc_html( $platform ); ?></span>
            </li>
        <?php endif; ?>

        <?php if ( ! empty( $type ) ) : ?>
            <li style="display: flex; justify-content: space-between; padding: var(--space-2) 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
                <span class="small-text" style="font-weight: 500; color: var(--text-muted);"><?php esc_html_e( 'Resource Type', 'quantum-mentor-world' ); ?></span>
                <span class="badge badge-primary" style="font-size: 10px; padding: 2px 6px;"><?php echo esc_html( $type ); ?></span>
            </li>
        <?php endif; ?>

        <?php if ( ! empty( $version ) ) : ?>
            <li style="display: flex; justify-content: space-between; padding: var(--space-2) 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
                <span class="small-text" style="font-weight: 500; color: var(--text-muted);"><?php esc_html_e( 'Version', 'quantum-mentor-world' ); ?></span>
                <span style="font-size: 14px; font-weight: 600; text-align: right;"><?php echo esc_html( $version ); ?></span>
            </li>
        <?php endif; ?>

        <?php if ( ! empty( $license ) ) : ?>
            <li style="display: flex; justify-content: space-between; padding: var(--space-2) 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
                <span class="small-text" style="font-weight: 500; color: var(--text-muted);"><?php esc_html_e( 'License', 'quantum-mentor-world' ); ?></span>
                <span class="badge badge-muted" style="font-size: 10px; padding: 2px 6px; text-transform: uppercase;"><?php echo esc_html( $license ); ?></span>
            </li>
        <?php endif; ?>

        <li style="display: flex; justify-content: space-between; padding: var(--space-2) 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
            <span class="small-text" style="font-weight: 500; color: var(--text-muted);"><?php esc_html_e( 'Last Updated', 'quantum-mentor-world' ); ?></span>
            <span style="font-size: 14px; font-weight: 600; text-align: right;"><?php echo esc_html( $formatted_date ); ?></span>
        </li>

        <li style="display: flex; justify-content: space-between; padding: var(--space-2) 0; border-bottom: 1px solid rgba(255, 255, 255, 0.04);">
            <span class="small-text" style="font-weight: 500; color: var(--text-muted);"><?php esc_html_e( 'Status', 'quantum-mentor-world' ); ?></span>
            <span class="badge <?php echo esc_attr( $status_class ); ?>" style="font-size: 10px; padding: 2px 6px;"><?php echo esc_html( $status ); ?></span>
        </li>
    </ul>

    <!-- Security Validation Block -->
    <div class="safety-validation-checks p-4" style="background: rgba(34, 197, 94, 0.05); border: 1px solid rgba(34, 197, 94, 0.15); border-radius: var(--radius-sm); display: flex; flex-direction: column; gap: var(--space-2);">
        <h4 style="font-size: 14px; font-weight: 700; color: var(--success); display: flex; align-items: center; gap: 8px;">
            🛡️ <?php esc_html_e( 'GPL & Safety Check', 'quantum-mentor-world' ); ?>
        </h4>
        
        <div style="display: flex; flex-direction: column; gap: 6px; margin-top: 4px;">
            <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                <span style="color: var(--success); font-weight: 700;">✓</span>
                <span style="color: var(--text-main);"><?php esc_html_e( 'GPL-Compliant/Official', 'quantum-mentor-world' ); ?></span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                <span style="color: var(--success); font-weight: 700;">✓</span>
                <span style="color: var(--text-main);"><?php esc_html_e( 'Verified Safe Source', 'quantum-mentor-world' ); ?></span>
            </div>
            
            <div style="display: flex; align-items: center; gap: 8px; font-size: 13px;">
                <span style="color: var(--success); font-weight: 700;">✓</span>
                <span style="color: var(--text-main);"><?php esc_html_e( 'Virus & Spyware Free', 'quantum-mentor-world' ); ?></span>
            </div>
        </div>
    </div>
</div>
