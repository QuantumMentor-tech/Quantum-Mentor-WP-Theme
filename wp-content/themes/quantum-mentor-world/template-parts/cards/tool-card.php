<?php
/**
 * Tool Card Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id      = get_the_ID();
$tool_name    = get_field( 'tool_name', $post_id ) ?: get_the_title();
$tool_cat     = get_field( 'tool_type_field', $post_id );
$access_type  = get_field( 'tool_access_type', $post_id );
$icon_id      = get_field( 'tool_icon', $post_id );
$short_desc   = get_field( 'tool_description', $post_id );
$is_verified  = get_field( 'verified_resource', $post_id );

if ( $is_verified === null ) {
    $is_verified = true;
}
?>

<article class="glass-card tool-card transition-all" style="height: 100%; display: flex; flex-direction: column; position: relative;">
    
    <!-- Verified Badge -->
    <?php if ( $is_verified ) : ?>
        <div class="tool-card-badge-wrap" style="position: absolute; top: var(--space-4); right: var(--space-4); z-index: 10;">
            <span class="badge badge-success" style="font-size: 8px;"><?php esc_html_e( 'Verified Safe', 'quantum-mentor-world' ); ?></span>
        </div>
    <?php endif; ?>

    <!-- Icon & Title Row -->
    <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-4);">
        <!-- Icon (Square, rounded borders) -->
        <div class="tool-card-icon-wrap" style="width: 52px; height: 52px; border-radius: var(--radius-sm); border: 1px solid var(--border); overflow: hidden; display: flex; align-items: center; justify-content: center; background-color: var(--bg-primary); flex-shrink: 0; box-shadow: var(--shadow-sm);">
            <?php if ( ! empty( $icon_id ) ) : ?>
                <?php echo wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'lazy' ) ); ?>
            <?php elseif ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'thumbnail', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'lazy' ) ); ?>
            <?php else : ?>
                <div style="font-size: 26px; color: var(--primary); font-family: var(--font-sans); display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; background-color: rgba(0, 212, 255, 0.05);">
                    ⚙️
                </div>
            <?php endif; ?>
        </div>

        <!-- Title & Category Badges -->
        <div style="min-width: 0; flex: 1;">
            <!-- Badges Row -->
            <div style="display: flex; gap: var(--space-1); flex-wrap: wrap; margin-bottom: var(--space-1.5);">
                <?php if ( ! empty( $tool_cat ) ) : ?>
                    <span class="badge badge-primary" style="font-size: 8px; padding: 2px 8px;"><?php echo esc_html( $tool_cat ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $access_type ) ) : ?>
                    <span class="badge badge-muted" style="font-size: 8px; padding: 2px 8px;"><?php echo esc_html( $access_type ); ?></span>
                <?php endif; ?>
            </div>
            
            <h3 class="tool-card-title" style="margin: 0; font-size: 16px; line-height: 1.35; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <a href="<?php the_permalink(); ?>" style="color: inherit; text-decoration: none;" title="<?php echo esc_attr( $tool_name ); ?>">
                    <?php echo esc_html( $tool_name ); ?>
                </a>
            </h3>
        </div>
    </div>

    <!-- Short Description -->
    <p class="tool-card-excerpt" style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: var(--space-5); flex: 1;">
        <?php
        if ( ! empty( $short_desc ) ) {
            echo esc_html( wp_trim_words( $short_desc, 18, '...' ) );
        } else {
            echo esc_html( wp_trim_words( get_the_excerpt(), 18, '...' ) );
        }
        ?>
    </p>

    <!-- Open Tool Button -->
    <div style="margin-top: auto; padding-top: var(--space-4); border-top: 1px solid var(--border);">
        <a href="<?php the_permalink(); ?>" class="btn btn-secondary" style="width: 100%; border-color: var(--primary); color: var(--primary); padding: 8px 12px; min-height: auto; font-size: 13px;" onmouseover="this.style.backgroundColor='var(--primary)'; this.style.color='#0F172A';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary)';">
            <?php esc_html_e( 'Open Tool', 'quantum-mentor-world' ); ?>
        </a>
    </div>

</article>
