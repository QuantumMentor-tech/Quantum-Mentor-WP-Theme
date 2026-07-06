<?php
/**
 * Single Watch — Episode List (Sidebar)
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id    = $post->ID;
$watch_type = get_field( 'watch_type', $post_id );
$episodes   = get_field( 'watch_episodes', $post_id );

$is_episodic = in_array( $watch_type, array( 'Course', 'Anime', 'Donghua', 'Tutorial' ) );

// Nothing to render if this is not episodic or has no episodes
if ( ! $is_episodic || empty( $episodes ) || ! is_array( $episodes ) ) {
    return;
}
?>

<!-- ============================================================
     WATCH EPISODES LIST PANEL
     ============================================================ -->
<div class="watch-episodes-panel glass-card">
    
    <div class="watch-episodes-header">
        <h3 class="watch-episodes-title" style="margin: 0; font-size: 16px;">
            📺 <?php printf( esc_html__( 'Episodes (%d)', 'quantum-mentor-world' ), count( $episodes ) ); ?>
        </h3>
    </div>

    <div class="watch-episodes-list-wrapper">
        <ul class="watch-episodes-list" role="list">
            <?php foreach ( $episodes as $idx => $ep ) :
                $ep_num   = ! empty( $ep['episode_number'] ) ? intval( $ep['episode_number'] ) : ( $idx + 1 );
                $ep_title = ! empty( $ep['episode_title'] ) ? $ep['episode_title'] : sprintf( __( 'Episode %d', 'quantum-mentor-world' ), $ep_num );
                $ep_desc  = ! empty( $ep['episode_description'] ) ? $ep['episode_description'] : '';
                
                $srv1 = ! empty( $ep['server_1_url'] ) ? esc_url( $ep['server_1_url'] ) : '';
                $srv2 = ! empty( $ep['server_2_url'] ) ? esc_url( $ep['server_2_url'] ) : '';
                $srv3 = ! empty( $ep['server_3_url'] ) ? esc_url( $ep['server_3_url'] ) : '';
                
                $is_first = ( $idx === 0 );
            ?>
            <li class="watch-ep-item <?php echo $is_first ? 'active' : ''; ?>" 
                role="listitem"
                data-ep-num="<?php echo esc_attr( $ep_num ); ?>"
                data-ep-title="<?php echo esc_attr( $ep_title ); ?>"
                data-ep-desc="<?php echo esc_attr( $ep_desc ); ?>"
                data-srv1="<?php echo esc_url( $srv1 ); ?>"
                data-srv2="<?php echo esc_url( $srv2 ); ?>"
                data-srv3="<?php echo esc_url( $srv3 ); ?>">
                
                <button class="watch-ep-btn" type="button" aria-label="<?php echo esc_attr( sprintf( __( 'Load Episode %d: %s', 'quantum-mentor-world' ), $ep_num, $ep_title ) ); ?>">
                    <span class="watch-ep-number-badge">Ep <?php echo esc_html( $ep_num ); ?></span>
                    
                    <div class="watch-ep-details">
                        <span class="watch-ep-title"><?php echo esc_html( $ep_title ); ?></span>
                        <?php if ( ! empty( $ep_desc ) ) : ?>
                            <span class="watch-ep-desc"><?php echo esc_html( wp_trim_words( $ep_desc, 12, '...' ) ); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <span class="watch-ep-play-arrow" aria-hidden="true">▶</span>
                </button>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>
