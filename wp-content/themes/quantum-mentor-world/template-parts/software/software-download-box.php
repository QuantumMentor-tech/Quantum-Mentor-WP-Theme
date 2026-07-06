<?php
/**
 * Single Software Download Box Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();

// Fetch URLs
$official_url = get_field( 'software_official_url', $post_id );
$download_url = get_field( 'software_download_url', $post_id );
$github_url   = get_field( 'software_github_url', $post_id );
$safety_note  = get_field( 'software_safety_note', $post_id );

if ( empty( $safety_note ) ) {
    $safety_note = esc_html__( 'Verified 100% legal & malware-free.', 'quantum-mentor-world' );
}

$has_links = ! empty( $official_url ) || ! empty( $download_url ) || ! empty( $github_url );
?>

<div class="software-download-box glass-card mb-8" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95)); border: 1px solid var(--border-hover); padding: var(--space-6); border-radius: var(--radius-md);">
    
    <div class="download-safety-header" style="display: flex; align-items: flex-start; gap: var(--space-3); margin-bottom: var(--space-4); border-bottom: 1px solid var(--border); padding-bottom: var(--space-4);">
        <span style="font-size: 24px; line-height: 1;">🛡️</span>
        <div>
            <h4 style="font-size: 16px; font-weight: 700; color: var(--success); margin-bottom: 2px;">
                <?php esc_html_e( 'Verified Secure Download', 'quantum-mentor-world' ); ?>
            </h4>
            <p class="small-text" style="color: var(--text-muted); font-size: 12px; line-height: 1.4;">
                <?php echo esc_html( $safety_note ); ?>
            </p>
        </div>
    </div>

    <?php if ( $has_links ) : ?>
        <div class="download-buttons-stack" style="display: flex; flex-direction: column; gap: var(--space-3); margin-bottom: var(--space-4);">
            
            <!-- 1. Download URL (Primary/Success Action) -->
            <?php if ( ! empty( $download_url ) ) : ?>
                <a href="<?php echo esc_url( $download_url ); ?>" class="btn btn-success" target="_blank" rel="nofollow noopener noreferrer" style="width: 100%; border-radius: var(--radius-sm); font-size: 14px; gap: 8px;">
                    <span>📥</span> <?php esc_html_e( 'Download from Official Source', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>

            <!-- 2. Official URL (Secondary Action) -->
            <?php if ( ! empty( $official_url ) ) : ?>
                <a href="<?php echo esc_url( $official_url ); ?>" class="btn btn-secondary" target="_blank" rel="nofollow noopener noreferrer" style="width: 100%; border-radius: var(--radius-sm); font-size: 14px; gap: 8px;">
                    <span>🌐</span> <?php esc_html_e( 'Visit Official Website', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>

            <!-- 3. GitHub URL (Accent/Code Action) -->
            <?php if ( ! empty( $github_url ) ) : ?>
                <a href="<?php echo esc_url( $github_url ); ?>" class="btn btn-accent" target="_blank" rel="nofollow noopener noreferrer" style="width: 100%; border-radius: var(--radius-sm); font-size: 14px; gap: 8px; background-color: #24292e; border-color: #3f4448;">
                    <span>🐙</span> <?php esc_html_e( 'View on GitHub', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>

        </div>
    <?php else : ?>
        <div class="no-download-links p-3 mb-4" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: var(--radius-sm); text-align: center;">
            <p class="small-text" style="color: var(--danger); font-weight: 600; font-size: 13px;">
                ⚠️ <?php esc_html_e( 'No active download links available at this time.', 'quantum-mentor-world' ); ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Legal Disclaimer -->
    <div class="download-disclaimer" style="font-size: 11px; line-height: 1.5; color: var(--text-muted); border-top: 1px solid var(--border); padding-top: var(--space-3); margin-top: var(--space-2);">
        <p>
            <strong><?php esc_html_e( 'Important Notice:', 'quantum-mentor-world' ); ?></strong>
            <?php esc_html_e( 'Only download software from official or verified sources. Quantum Mentor World does not promote cracked, pirated, or unauthorized software.', 'quantum-mentor-world' ); ?>
        </p>
    </div>

</div>
