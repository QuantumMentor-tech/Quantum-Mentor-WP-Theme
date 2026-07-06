<?php
/**
 * Single Watch — Video Player Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id    = $post->ID;
$watch_type = get_field( 'watch_type', $post_id );

// Parent fields for single items
$srv1_name = get_field( 'watch_srv1_name', $post_id ) ?: __( 'Server 1', 'quantum-mentor-world' );
$srv1_url  = get_field( 'watch_srv1_url', $post_id );
$srv2_name = get_field( 'watch_srv2_name', $post_id ) ?: __( 'Server 2', 'quantum-mentor-world' );
$srv2_url  = get_field( 'watch_srv2_url', $post_id );
$srv3_name = get_field( 'watch_srv3_name', $post_id ) ?: __( 'Server 3', 'quantum-mentor-world' );
$srv3_url  = get_field( 'watch_srv3_url', $post_id );

$is_episodic = in_array( $watch_type, array( 'Course', 'Anime', 'Donghua', 'Tutorial' ) );

// Determine initial default URL for server 1
$default_url = '';
if ( ! $is_episodic ) {
    $default_url = $srv1_url;
} else {
    $episodes = get_field( 'watch_episodes', $post_id );
    if ( ! empty( $episodes ) && is_array( $episodes ) && ! empty( $episodes[0]['server_1_url'] ) ) {
        $default_url = $episodes[0]['server_1_url'];
    }
}
?>

<!-- ============================================================
     WATCH VIDEO PLAYER PANEL
     ============================================================ -->
<div class="watch-player-panel glass-card p-6" 
     id="watch-player-app" 
     data-is-episodic="<?php echo $is_episodic ? 'true' : 'false'; ?>"
     data-post-id="<?php echo esc_attr( $post_id ); ?>">

    <!-- Interactive Player Window -->
    <div class="watch-player-viewport-wrapper">
        <div class="watch-player-viewport">
            
            <!-- Loading indicator spinner -->
            <div class="watch-player-loader" id="player-loader" style="display: none;">
                <span class="loader-spinner"></span>
                <span class="loader-text"><?php esc_html_e( 'Connecting Stream...', 'quantum-mentor-world' ); ?></span>
            </div>

            <!-- Embed Player Iframe (Safe sanitization output) -->
            <?php if ( ! empty( $default_url ) ) : ?>
                <iframe 
                    id="main-video-player" 
                    src="<?php echo esc_url( $default_url ); ?>" 
                    frameborder="0" 
                    allowfullscreen 
                    loading="lazy" 
                    title="<?php esc_attr_e( 'Video Stream Player', 'quantum-mentor-world' ); ?>" 
                    referrerpolicy="no-referrer" 
                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                </iframe>
            <?php else : ?>
                <iframe 
                    id="main-video-player" 
                    src="" 
                    frameborder="0" 
                    allowfullscreen 
                    loading="lazy" 
                    title="<?php esc_attr_e( 'Video Stream Player', 'quantum-mentor-world' ); ?>" 
                    referrerpolicy="no-referrer" 
                    allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    style="display: none;">
                </iframe>
            <?php endif; ?>

            <!-- Error fallback state -->
            <div class="watch-player-error" id="player-error" style="<?php echo empty( $default_url ) ? 'display: flex;' : 'display: none;'; ?>">
                <span class="error-icon">⚠️</span>
                <h3 class="error-heading"><?php esc_html_e( 'No Stream Available', 'quantum-mentor-world' ); ?></h3>
                <p class="error-msg"><?php esc_html_e( 'No legal stream URLs have been configured for this media item. Please check back later.', 'quantum-mentor-world' ); ?></p>
            </div>

        </div>
    </div>

    <!-- Server Selector row -->
    <div class="watch-player-controls-row">
        <span class="watch-controls-label">📡 <?php esc_html_e( 'Embed Servers:', 'quantum-mentor-world' ); ?></span>
        
        <div class="watch-server-selector" id="watch-server-selector">
            <!-- Single media content pulls servers from parent post fields -->
            <?php if ( ! $is_episodic ) : ?>
                <?php if ( ! empty( $srv1_url ) ) : ?>
                    <button class="server-btn active" data-server-idx="1" data-url="<?php echo esc_url( $srv1_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Switch to %s server', 'quantum-mentor-world' ), $srv1_name ) ); ?>">
                        <?php echo esc_html( $srv1_name ); ?>
                    </button>
                <?php endif; ?>
                <?php if ( ! empty( $srv2_url ) ) : ?>
                    <button class="server-btn" data-server-idx="2" data-url="<?php echo esc_url( $srv2_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Switch to %s server', 'quantum-mentor-world' ), $srv2_name ) ); ?>">
                        <?php echo esc_html( $srv2_name ); ?>
                    </button>
                <?php endif; ?>
                <?php if ( ! empty( $srv3_url ) ) : ?>
                    <button class="server-btn" data-server-idx="3" data-url="<?php echo esc_url( $srv3_url ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Switch to %s server', 'quantum-mentor-world' ), $srv3_name ) ); ?>">
                        <?php echo esc_html( $srv3_name ); ?>
                    </button>
                <?php endif; ?>
            <?php else : ?>
                <!-- Episodic media templates populate server URLs dynamically via JS when switching episodes -->
                <button class="server-btn active" data-server-idx="1" style="display: none;"></button>
                <button class="server-btn" data-server-idx="2" style="display: none;"></button>
                <button class="server-btn" data-server-idx="3" style="display: none;"></button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Hidden element containing single-post fallback fields for JS player lookup -->
    <?php if ( ! $is_episodic ) : ?>
        <div id="watch-single-data" 
             style="display: none;" 
             data-srv1="<?php echo esc_url( $srv1_url ); ?>" 
             data-srv2="<?php echo esc_url( $srv2_url ); ?>" 
             data-srv3="<?php echo esc_url( $srv3_url ); ?>">
        </div>
    <?php endif; ?>

</div>
