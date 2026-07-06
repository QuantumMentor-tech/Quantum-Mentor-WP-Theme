<?php
/**
 * Single Tool — External & Download Actions Box
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id = $post->ID;

$access_type = get_field( 'tool_access_type', $post_id );
$tool_url    = get_field( 'tool_url', $post_id );
$download_url = get_field( 'tool_download_url', $post_id );
?>

<div class="tool-action-box-container">
    
    <!-- Case 1: External Tool -->
    <?php if ( $access_type === 'External Tool' && ! empty( $tool_url ) ) : ?>
        <div class="glass-card p-6" style="border: 1px solid var(--primary); background: rgba(0, 212, 255, 0.03); box-shadow: 0 0 20px rgba(0, 212, 255, 0.05); border-radius: var(--radius-md);">
            <h3 class="card-title mb-4" style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-top: 0;"><?php esc_html_e( 'Launch External Tool', 'quantum-mentor-world' ); ?></h3>
            
            <a href="<?php echo esc_url( $tool_url ); ?>" 
               class="btn btn-primary" 
               target="_blank" 
               rel="nofollow noopener noreferrer" 
               style="width: 100%; justify-content: center; height: 46px; font-size: 14px; margin-bottom: var(--space-4);">
                🚀 <?php esc_html_e( 'Open External Tool', 'quantum-mentor-world' ); ?>
            </a>
            
            <div style="display: flex; gap: var(--space-3); align-items: flex-start; padding: var(--space-3) var(--space-4); background: rgba(30, 41, 59, 0.6); border-radius: var(--radius-sm); border: 1px solid var(--border);">
                <span style="font-size: 18px; line-height: 1; flex-shrink: 0; margin-top: 2px;">⚠️</span>
                <p class="small-text" style="font-size: 12px; line-height: 1.5; color: var(--text-muted); margin: 0;">
                    <strong><?php esc_html_e( 'Notice:', 'quantum-mentor-world' ); ?></strong>
                    <?php esc_html_e( 'You are leaving Quantum Mentor World and opening an external tool. Always review the external site’s privacy and safety policies.', 'quantum-mentor-world' ); ?>
                </p>
            </div>
        </div>

    <!-- Case 2: Downloadable Tool -->
    <?php elseif ( $access_type === 'Downloadable Tool' ) : ?>
        <div class="glass-card p-6" style="border: 1px solid var(--success); background: rgba(34, 197, 94, 0.03); box-shadow: 0 0 20px rgba(34, 197, 94, 0.05); border-radius: var(--radius-md);">
            <h3 class="card-title mb-4" style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-top: 0;"><?php esc_html_e( 'Download Resource', 'quantum-mentor-world' ); ?></h3>
            
            <?php 
            $dl_target = ! empty( $download_url ) ? $download_url : $tool_url;
            if ( ! empty( $dl_target ) ) : 
            ?>
                <a href="<?php echo esc_url( $dl_target ); ?>" 
                   class="btn btn-primary" 
                   target="_blank" 
                   rel="nofollow noopener noreferrer" 
                   style="width: 100%; justify-content: center; height: 46px; font-size: 14px; margin-bottom: var(--space-4); background-color: var(--success); border-color: var(--success); color: #ffffff;"
                   onmouseover="this.style.filter='brightness(1.1)';"
                   onmouseout="this.style.filter='none';">
                    📥 <?php esc_html_e( 'Download from Official Source', 'quantum-mentor-world' ); ?>
                </a>
            <?php endif; ?>
            
            <div style="display: flex; gap: var(--space-3); align-items: flex-start; padding: var(--space-3) var(--space-4); background: rgba(30, 41, 59, 0.6); border-radius: var(--radius-sm); border: 1px solid var(--border);">
                <span style="font-size: 18px; line-height: 1; flex-shrink: 0; margin-top: 2px;">🛡️</span>
                <p class="small-text" style="font-size: 12px; line-height: 1.5; color: var(--text-muted); margin: 0;">
                    <strong><?php esc_html_e( 'Compliance Policy:', 'quantum-mentor-world' ); ?></strong>
                    <?php esc_html_e( 'Quantum Mentor World only lists legal, official, open-source, freeware, or properly licensed tools.', 'quantum-mentor-world' ); ?>
                </p>
            </div>
        </div>

    <!-- Case 3: Browser Extension -->
    <?php elseif ( $access_type === 'Browser Extension' && ! empty( $tool_url ) ) : ?>
        <div class="glass-card p-6" style="border: 1px solid var(--warning); background: rgba(245, 158, 11, 0.03); box-shadow: 0 0 20px rgba(245, 158, 11, 0.05); border-radius: var(--radius-md);">
            <h3 class="card-title mb-4" style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-top: 0;"><?php esc_html_e( 'Install Browser Extension', 'quantum-mentor-world' ); ?></h3>
            
            <a href="<?php echo esc_url( $tool_url ); ?>" 
               class="btn btn-primary" 
               target="_blank" 
               rel="nofollow noopener noreferrer" 
               style="width: 100%; justify-content: center; height: 46px; font-size: 14px; margin-bottom: var(--space-4); background-color: var(--warning); border-color: var(--warning); color: #000;"
               onmouseover="this.style.filter='brightness(1.1)';"
               onmouseout="this.style.filter='none';">
                🧩 <?php esc_html_e( 'Install Extension', 'quantum-mentor-world' ); ?>
            </a>
            
            <div style="display: flex; gap: var(--space-3); align-items: flex-start; padding: var(--space-3) var(--space-4); background: rgba(30, 41, 59, 0.6); border-radius: var(--radius-sm); border: 1px solid var(--border);">
                <span style="font-size: 18px; line-height: 1; flex-shrink: 0; margin-top: 2px;">⚠️</span>
                <p class="small-text" style="font-size: 12px; line-height: 1.5; color: var(--text-muted); margin: 0;">
                    <strong><?php esc_html_e( 'Extension Notice:', 'quantum-mentor-world' ); ?></strong>
                    <?php esc_html_e( 'This extension links to official Web Stores. Review store reviews and extension permission boundaries before installing.', 'quantum-mentor-world' ); ?>
                </p>
            </div>
        </div>

    <!-- Case 4: Built-in Tool Jump Anchor -->
    <?php elseif ( $access_type === 'Built-in Tool' ) : ?>
        <div class="glass-card p-6" style="border: 1px solid var(--primary); background: rgba(0, 212, 255, 0.02); border-radius: var(--radius-md);">
            <h3 class="card-title mb-3" style="font-size: 15px; font-weight: 700; color: var(--text-main); margin-top: 0;"><?php esc_html_e( 'Built-in Browser Utility', 'quantum-mentor-world' ); ?></h3>
            <p style="font-size: 12px; color: var(--text-muted); line-height: 1.5; margin-bottom: var(--space-4);"><?php esc_html_e( 'This tool runs securely directly inside your browser. No files are uploaded to our servers.', 'quantum-mentor-world' ); ?></p>
            <a href="#built-in-tool-workspace" class="btn btn-secondary" style="width: 100%; justify-content: center; border-color: var(--primary); color: var(--primary);">
                ⚡ <?php esc_html_e( 'Go to Workspace', 'quantum-mentor-world' ); ?>
            </a>
        </div>
    <?php endif; ?>

</div>
