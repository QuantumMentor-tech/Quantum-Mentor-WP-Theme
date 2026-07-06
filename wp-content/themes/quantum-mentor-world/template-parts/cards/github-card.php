<?php
/**
 * GitHub Repository Card Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id    = get_the_ID();
$repo_name  = get_field( 'repo_name', $post_id ) ?: get_the_title();
$repo_desc  = get_field( 'repo_short_description', $post_id ) ?: get_the_excerpt();
$repo_url   = get_field( 'repo_github_url', $post_id );
$language   = get_field( 'repo_language_field', $post_id );
$license    = get_field( 'repo_license_field', $post_id );
$difficulty = get_field( 'repo_difficulty', $post_id );
$stars      = get_field( 'repo_stars_count', $post_id );
$forks      = get_field( 'repo_forks_count', $post_id );

$difficulty_label = $difficulty;
$diff_color = 'var(--text-muted)';
if ( $difficulty === 'Beginner' ) {
    $difficulty_label = '🟢 ' . __( 'Beginner', 'quantum-mentor-world' );
    $diff_color = 'var(--success)';
} elseif ( $difficulty === 'Intermediate' ) {
    $difficulty_label = '🟡 ' . __( 'Intermediate', 'quantum-mentor-world' );
    $diff_color = 'var(--warning)';
} elseif ( $difficulty === 'Advanced' ) {
    $difficulty_label = '🔴 ' . __( 'Advanced', 'quantum-mentor-world' );
    $diff_color = 'var(--danger)';
}
?>

<article class="glass-card card-repo transition-all" style="height: 100%; display: flex; flex-direction: column; position: relative; border-left: 3px solid var(--secondary);">
    
    <!-- Top Row: Icon and Badges -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: var(--space-4); gap: var(--space-2);">
        <div style="font-size: 22px; color: var(--primary); width: 42px; height: 42px; border-radius: var(--radius-sm); background-color: rgba(0, 212, 255, 0.05); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(0, 212, 255, 0.15); flex-shrink: 0;">
            🐙
        </div>
        
        <div style="display: flex; gap: 4px; flex-wrap: wrap; justify-content: flex-end;">
            <?php if ( ! empty( $language ) ) : ?>
                <span class="badge badge-primary" style="font-size: 8px; padding: 2px 8px; font-family: var(--font-sans);"><?php echo esc_html( $language ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $license ) ) : ?>
                <span class="badge badge-muted" style="font-size: 8px; padding: 2px 8px;"><?php echo esc_html( $license ); ?></span>
            <?php endif; ?>
            <?php if ( ! empty( $difficulty ) ) : ?>
                <span class="badge badge-muted" style="font-size: 8px; padding: 2px 8px; border-color: rgba(255,255,255,0.03); color: <?php echo esc_attr( $diff_color ); ?>;">
                    <?php echo esc_html( $difficulty_label ); ?>
                </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- Repository Title -->
    <h3 class="card-title" style="margin-bottom: var(--space-2); font-size: 16px; font-weight: 700;">
        <a href="<?php the_permalink(); ?>" style="color: var(--text-main); text-decoration: none;" onmouseover="this.style.color='var(--primary)';" onmouseout="this.style.color='var(--text-main)';">
            <?php echo esc_html( $repo_name ); ?>
        </a>
    </h3>

    <!-- Description -->
    <p class="small-text" style="font-size: 13px; line-height: 1.5; color: var(--text-muted); margin-bottom: var(--space-6); flex: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
        <?php echo esc_html( wp_trim_words( $repo_desc, 16, '...' ) ); ?>
    </p>

    <!-- Star & Fork metrics -->
    <div class="repo-stats" style="margin-bottom: var(--space-4); display: flex; gap: var(--space-4); font-size: 12px; color: var(--text-muted); padding-top: var(--space-3); border-top: 1px dashed var(--border);">
        <span style="display: inline-flex; align-items: center; gap: 4px;">
            <span style="color: var(--warning); font-size: 14px;">★</span>
            <?php echo ! empty( $stars ) ? esc_html( number_format_i18n( $stars ) ) : '0'; ?>
        </span>
        <span style="display: inline-flex; align-items: center; gap: 4px;">
            <span>🍴</span>
            <?php echo ! empty( $forks ) ? esc_html( number_format_i18n( $forks ) ) : '0'; ?>
        </span>
    </div>

    <!-- Action links -->
    <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--border); display: flex; gap: var(--space-2);">
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="flex: 1; padding: 6px 12px; min-height: auto; font-size: 12px; justify-content: center;">
            <?php esc_html_e( 'View Details', 'quantum-mentor-world' ); ?>
        </a>
        <?php if ( ! empty( $repo_url ) ) : ?>
            <a href="<?php echo esc_url( $repo_url ); ?>" 
               class="btn btn-primary" 
               style="padding: 6px 12px; min-height: auto; font-size: 12px; justify-content: center;" 
               target="_blank" 
               rel="nofollow noopener noreferrer">
                <?php esc_html_e( 'GitHub', 'quantum-mentor-world' ); ?>
            </a>
        <?php endif; ?>
    </div>

</article>
