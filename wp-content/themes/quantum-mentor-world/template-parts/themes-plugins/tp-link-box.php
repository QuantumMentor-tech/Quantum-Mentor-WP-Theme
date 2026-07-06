<?php
/**
 * Single Themes & Plugins Direct Link/CTA Box Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$post_id = get_the_ID();

// Fetch URLs from ACF
$official_url  = get_field( 'tp_official_url', $post_id );
$demo_url      = get_field( 'tp_demo_url', $post_id );
$doc_url       = get_field( 'tp_documentation_url', $post_id );
$download_url  = get_field( 'tp_download_url', $post_id );

$has_links = ! empty( $official_url ) || ! empty( $demo_url ) || ! empty( $doc_url ) || ! empty( $download_url );
?>

<div class="tp-download-box glass-card mb-8" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.95), rgba(15, 23, 42, 0.95)); border: 1px solid var(--border-hover); padding: var(--space-6); border-radius: var(--radius-md);">
    
    <div class="download-safety-header" style="display: flex; align-items: flex-start; gap: var(--space-3); margin-bottom: var(--space-4); border-bottom: 1px solid var(--border); padding-bottom: var(--space-4);">
        <span style="font-size: 24px; line-height: 1;">📂</span>
        <div>
            <h4 style="font-size: 16px; font-weight: 700; color: var(--primary); margin-bottom: 2px;">
                <?php esc_html_e( 'Official Resources', 'quantum-mentor-world' ); ?>
            </h4>
            <p class="small-text" style="color: var(--text-muted); font-size: 12px; line-height: 1.4;">
                <?php esc_html_e( 'GPL Compliant & Safety Checked', 'quantum-mentor-world' ); ?>
            </p>
        </div>
    </div>

    <?php if ( $has_links ) : ?>
        <div class="download-buttons-stack" style="display: flex; flex-direction: column; gap: var(--space-3); margin-bottom: var(--space-4);">
            
            <!-- 1. Download Link (Success Button) -->
            <?php if ( ! empty( $download_url ) ) : ?>
                <a href="<?php echo esc_url( $download_url ); ?>" class="btn btn-success" target="_blank" rel="nofollow noopener noreferrer" style="width: 100%; border-radius: var(--radius-sm); font-size: 14px; gap: 8px;">
                    <span>📥</span> <?php esc_html_e( 'Get from Official Source', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>

            <!-- 2. Demo Link (Primary Button) -->
            <?php if ( ! empty( $demo_url ) ) : ?>
                <a href="<?php echo esc_url( $demo_url ); ?>" class="btn btn-primary" target="_blank" rel="nofollow noopener noreferrer" style="width: 100%; border-radius: var(--radius-sm); font-size: 14px; gap: 8px; color: #0F172A;">
                    <span>👁️</span> <?php esc_html_e( 'View Demo', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>

            <!-- 3. Official Website Link (Secondary Button) -->
            <?php if ( ! empty( $official_url ) ) : ?>
                <a href="<?php echo esc_url( $official_url ); ?>" class="btn btn-secondary" target="_blank" rel="nofollow noopener noreferrer" style="width: 100%; border-radius: var(--radius-sm); font-size: 14px; gap: 8px;">
                    <span>🌐</span> <?php esc_html_e( 'Visit Official Website', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>

            <!-- 4. Documentation Link (Accent Button) -->
            <?php if ( ! empty( $doc_url ) ) : ?>
                <a href="<?php echo esc_url( $doc_url ); ?>" class="btn btn-accent" target="_blank" rel="nofollow noopener noreferrer" style="width: 100%; border-radius: var(--radius-sm); font-size: 14px; gap: 8px; background-color: #4b5563; border-color: #6b7280;">
                    <span>📖</span> <?php esc_html_e( 'Read Documentation', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>

        </div>
    <?php else : ?>
        <div class="no-download-links p-3 mb-4" style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.15); border-radius: var(--radius-sm); text-align: center;">
            <p class="small-text" style="color: var(--danger); font-weight: 600; font-size: 13px;">
                ⚠️ <?php esc_html_e( 'No active resource links available.', 'quantum-mentor-world' ); ?>
            </p>
        </div>
    <?php endif; ?>

    <!-- Legal Note -->
    <div class="download-disclaimer" style="font-size: 11px; line-height: 1.5; color: var(--text-muted); border-top: 1px solid var(--border); padding-top: var(--space-3); margin-top: var(--space-2);">
        <p>
            <strong><?php esc_html_e( 'GPL Compliance Notice:', 'quantum-mentor-world' ); ?></strong>
            <?php esc_html_e( 'Quantum Mentor World only lists official, GPL-compliant, open-source, free, or properly licensed resources. We do not promote nulled themes, cracked plugins, leaked files, or illegal license keys.', 'quantum-mentor-world' ); ?>
        </p>
    </div>

</div>
