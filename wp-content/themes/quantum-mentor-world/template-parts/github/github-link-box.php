<?php
/**
 * Single GitHub Repo — Outbound Link Actions Card
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id  = $post->ID;
$git_url  = get_field( 'repo_github_url', $post_id );
$doc_url  = get_field( 'repo_doc_url', $post_id );
$owner    = get_field( 'repo_owner_name', $post_id );
?>

<div class="glass-card p-6" style="margin-bottom: var(--space-8); border-color: rgba(124, 58, 237, 0.2); background: rgba(124, 58, 237, 0.01);">

    <div style="display: flex; gap: var(--space-4); flex-wrap: wrap; margin-bottom: var(--space-5);">
        <!-- 1. View on GitHub Button -->
        <?php if ( ! empty( $git_url ) ) : ?>
        <a href="<?php echo esc_url( $git_url ); ?>" 
           target="_blank" 
           rel="nofollow noopener noreferrer" 
           class="btn btn-primary" 
           style="flex: 1; min-width: 180px; font-size: 14px; gap: 8px;">
            <span>🐙</span> <?php esc_html_e( 'View on GitHub', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>

        <!-- 2. Read Documentation Button -->
        <?php if ( ! empty( $doc_url ) ) : ?>
        <a href="<?php echo esc_url( $doc_url ); ?>" 
           target="_blank" 
           rel="nofollow noopener noreferrer" 
           class="btn btn-secondary" 
           style="flex: 1; min-width: 180px; font-size: 14px; gap: 8px;">
            <span>📖</span> <?php esc_html_e( 'Read Documentation', 'quantum-mentor-world' ); ?>
        </a>
        <?php endif; ?>
    </div>

    <!-- Safety Warning Notes -->
    <div class="tools-safety-note-wrap" style="display: flex; flex-direction: column; gap: var(--space-3); border-top: 1px solid var(--border); padding-top: var(--space-4); font-size: 12px; line-height: 1.5; color: var(--text-muted);">
        <p style="margin: 0;">
            <strong style="color: var(--warning);"><?php esc_html_e( 'Notice:', 'quantum-mentor-world' ); ?></strong>
            <?php esc_html_e( 'You are leaving Quantum Mentor World and opening an external repository link. Always review the target repository\'s safety, licensing, and code profile.', 'quantum-mentor-world' ); ?>
        </p>
        <p style="margin: 0; font-style: italic;">
            <?php esc_html_e( 'Quantum Mentor World only indexes legal, verified, open-source, or properly licensed GitHub repositories.', 'quantum-mentor-world' ); ?>
        </p>
    </div>

</div>
