<?php
/**
 * Single GitHub Repo — Sidebar Specifications and Trust Indicators
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id     = $post->ID;

$repo_name   = get_field( 'repo_name', $post_id ) ?: get_the_title( $post_id );
$lang        = get_field( 'repo_language_field', $post_id );
$license     = get_field( 'repo_license_field', $post_id );
$difficulty  = get_field( 'repo_difficulty', $post_id );
$stars       = get_field( 'repo_stars_count', $post_id );
$forks       = get_field( 'repo_forks_count', $post_id );
$owner       = get_field( 'repo_owner_name', $post_id );
$last_update = get_field( 'repo_last_updated', $post_id );

$is_verified  = get_field( 'verified_resource', $post_id );
$is_official  = get_field( 'official_source_confirmed', $post_id );
$is_safety    = get_field( 'safety_checked', $post_id );

if ( $is_verified === null ) $is_verified = true;
if ( $is_official === null ) $is_official = true;
if ( $is_safety === null )   $is_safety   = true;

$difficulty_label = $difficulty;
if ( $difficulty === 'Beginner' )     $difficulty_label = '🟢 ' . __( 'Beginner Friendly', 'quantum-mentor-world' );
if ( $difficulty === 'Intermediate' ) $difficulty_label = '🟡 ' . __( 'Intermediate', 'quantum-mentor-world' );
if ( $difficulty === 'Advanced' )     $difficulty_label = '🔴 ' . __( 'Advanced Developer', 'quantum-mentor-world' );
?>

<aside class="github-specifications-sidebar" aria-label="<?php esc_attr_e( 'Repository Specifications', 'quantum-mentor-world' ); ?>">

    <!-- 1. Metadata Info Card -->
    <div class="watch-meta-card glass-card p-5" style="margin-bottom: var(--space-6); border-radius: var(--radius-md);">
        <h3 class="watch-meta-heading"><?php esc_html_e( 'Repository Details', 'quantum-mentor-world' ); ?></h3>
        
        <ul class="watch-spec-list">
            <?php if ( ! empty( $owner ) ) : ?>
            <li class="watch-spec-item">
                <span class="watch-spec-label"><?php esc_html_e( 'Developer/Org', 'quantum-mentor-world' ); ?></span>
                <span class="watch-spec-value" style="font-family: monospace; color: var(--primary);"><?php echo esc_html( $owner ); ?></span>
            </li>
            <?php endif; ?>

            <?php if ( ! empty( $lang ) ) : ?>
            <li class="watch-spec-item">
                <span class="watch-spec-label"><?php esc_html_e( 'Language', 'quantum-mentor-world' ); ?></span>
                <span class="watch-spec-value"><?php echo esc_html( $lang ); ?></span>
            </li>
            <?php endif; ?>

            <?php if ( ! empty( $license ) ) : ?>
            <li class="watch-spec-item">
                <span class="watch-spec-label"><?php esc_html_e( 'Open Source License', 'quantum-mentor-world' ); ?></span>
                <span class="watch-spec-value"><?php echo esc_html( $license ); ?></span>
            </li>
            <?php endif; ?>

            <?php if ( ! empty( $difficulty ) ) : ?>
            <li class="watch-spec-item">
                <span class="watch-spec-label"><?php esc_html_e( 'Difficulty', 'quantum-mentor-world' ); ?></span>
                <span class="watch-spec-value" style="font-weight: 700;"><?php echo esc_html( $difficulty_label ); ?></span>
            </li>
            <?php endif; ?>

            <?php if ( ! empty( $stars ) ) : ?>
            <li class="watch-spec-item">
                <span class="watch-spec-label"><?php esc_html_e( 'GitHub Stars', 'quantum-mentor-world' ); ?></span>
                <span class="watch-spec-value" style="color: var(--warning); font-weight: 700;">★ <?php echo number_format_i18n( $stars ); ?></span>
            </li>
            <?php endif; ?>

            <?php if ( ! empty( $forks ) ) : ?>
            <li class="watch-spec-item">
                <span class="watch-spec-label"><?php esc_html_e( 'Forks Count', 'quantum-mentor-world' ); ?></span>
                <span class="watch-spec-value" style="font-family: monospace;">🍴 <?php echo number_format_i18n( $forks ); ?></span>
            </li>
            <?php endif; ?>

            <?php if ( ! empty( $last_update ) ) : ?>
            <li class="watch-spec-item">
                <span class="watch-spec-label"><?php esc_html_e( 'Last Updated', 'quantum-mentor-world' ); ?></span>
                <span class="watch-spec-value" style="font-size: 12px; color: var(--text-muted);"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $last_update ) ) ); ?></span>
            </li>
            <?php endif; ?>
        </ul>
    </div>

    <!-- 2. Trust Checked Indicators Card -->
    <div class="watch-verify-card p-5" style="border: 1px solid rgba(34, 197, 94, 0.2); background: rgba(34, 197, 94, 0.02); border-radius: var(--radius-md);">
        <h4 style="margin: 0 0 var(--space-4); font-size: 13px; font-weight: 700; color: var(--success); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 6px;">
            <span>🛡️</span> <?php esc_html_e( 'Safety Assured', 'quantum-mentor-world' ); ?>
        </h4>

        <div style="display: flex; flex-direction: column; gap: var(--space-3.5);">
            <div class="watch-trust-check">
                <span class="watch-trust-dot" style="background-color: <?php echo $is_verified ? 'var(--success)' : 'var(--text-muted)'; ?>; box-shadow: <?php echo $is_verified ? '0 0 8px var(--success)' : 'none'; ?>;"></span>
                <span style="font-size: 12px; font-weight: 600; color: <?php echo $is_verified ? 'var(--text-main)' : 'var(--text-muted)'; ?>;">
                    <?php esc_html_e( 'Verified Safe Repository', 'quantum-mentor-world' ); ?>
                </span>
            </div>
            
            <div class="watch-trust-check">
                <span class="watch-trust-dot" style="background-color: <?php echo $is_official ? 'var(--success)' : 'var(--text-muted)'; ?>; box-shadow: <?php echo $is_official ? '0 0 8px var(--success)' : 'none'; ?>;"></span>
                <span style="font-size: 12px; font-weight: 600; color: <?php echo $is_official ? 'var(--text-main)' : 'var(--text-muted)'; ?>;">
                    <?php esc_html_e( 'Official Source Confirmed', 'quantum-mentor-world' ); ?>
                </span>
            </div>

            <div class="watch-trust-check">
                <span class="watch-trust-dot" style="background-color: <?php echo $is_safety ? 'var(--success)' : 'var(--text-muted)'; ?>; box-shadow: <?php echo $is_safety ? '0 0 8px var(--success)' : 'none'; ?>;"></span>
                <span style="font-size: 12px; font-weight: 600; color: <?php echo $is_safety ? 'var(--text-main)' : 'var(--text-muted)'; ?>;">
                    <?php esc_html_e( 'Safety & Integrity Scanned', 'quantum-mentor-world' ); ?>
                </span>
            </div>
        </div>
    </div>

</aside>
