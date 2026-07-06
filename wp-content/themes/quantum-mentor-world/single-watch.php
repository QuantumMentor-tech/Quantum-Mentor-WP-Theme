<?php
/**
 * Single Watch Template
 *
 * URL Example: /watch/content-title/
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$post_id        = get_the_ID();
$watch_type     = get_field( 'watch_type', $post_id );
$genre          = get_field( 'watch_genre_field', $post_id );
$language       = get_field( 'watch_language_field', $post_id );
$release_year   = get_field( 'watch_release_year_field', $post_id );
$status         = get_field( 'watch_status_field', $post_id );
$poster_id      = get_field( 'watch_poster', $post_id );
$cover_banner   = get_field( 'watch_cover_banner', $post_id );
$short_desc     = get_field( 'short_description', $post_id );
$official_url   = get_field( 'watch_official_url', $post_id );
$legal_note     = get_field( 'watch_legal_note', $post_id );
$episodes       = get_field( 'watch_episodes', $post_id );

$is_episodic = in_array( $watch_type, array( 'Course', 'Anime', 'Donghua', 'Tutorial' ) );

$permalink = esc_url( get_permalink() );
$title_esc = esc_attr( get_the_title() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-watch-article' ); ?> style="padding-bottom: var(--space-16);">

    <!-- ============================================================
         1. COVER BANNER (Premium Aspect Ratio & Overlay)
         ============================================================ -->
    <div class="watch-cover-banner-wrap" style="position: relative; height: 360px; overflow: hidden; background-color: #020617; border-bottom: 1px solid var(--border);">
        <?php if ( ! empty( $cover_banner ) ) : ?>
            <?php echo wp_get_attachment_image( $cover_banner, 'full', false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'eager' ) ); ?>
        <?php else : ?>
            <!-- Fallback abstract premium dark gradient pattern -->
            <div class="watch-cover-fallback" style="width: 100%; height: 100%; background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #020617 100%);"></div>
        <?php endif; ?>
        
        <!-- Ambient lighting overlays -->
        <div style="position: absolute; inset: 0; background: linear-gradient(to top, #0b0f19 0%, rgba(11,15,25,0.4) 60%, rgba(11,15,25,0.1) 100%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; background: radial-gradient(circle at 30% 30%, rgba(0, 212, 255, 0.1) 0%, rgba(0,0,0,0) 60%); pointer-events: none;"></div>
    </div>

    <!-- Container content -->
    <div class="container container-laptop" style="margin-top: -120px; position: relative; z-index: 10;">

        <!-- Breadcrumbs (SEO Requirement) -->
        <nav class="breadcrumbs mb-6" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>" style="font-size: 13px; color: rgba(255, 255, 255, 0.7); text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'watch' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Watch', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary); font-weight: 600;"><?php the_title(); ?></span>
        </nav>

        <!-- ============================================================
             2. HERO / DETAILS HEADER PANEL
             ============================================================ -->
        <header class="glass-card watch-details-header-card p-6 md:p-8 mb-8" style="background: rgba(11, 15, 25, 0.75); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: var(--shadow-lg);">
            <div class="grid grid-cols-12 gap-6 md:gap-8">
                
                <!-- Poster Image Column -->
                <div class="col-span-12 sm:col-span-4 md:col-span-3 flex justify-center sm:justify-start">
                    <div class="watch-details-poster-wrap" style="aspect-ratio: 2 / 3; width: 100%; max-width: 220px; border-radius: var(--radius-md); overflow: hidden; border: 2px solid rgba(255,255,255,0.1); box-shadow: 0 8px 30px rgba(0,0,0,0.5);">
                        <?php if ( ! empty( $poster_id ) ) : ?>
                            <?php echo wp_get_attachment_image( $poster_id, 'medium_large', false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'eager' ) ); ?>
                        <?php elseif ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium_large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'eager' ) ); ?>
                        <?php else : ?>
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 56px; background-color: var(--bg-secondary);">🎬</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Media Details Column -->
                <div class="col-span-12 sm:col-span-8 md:col-span-9 flex flex-col justify-between">
                    <div>
                        <!-- Badges Row -->
                        <div class="watch-meta-badges mb-3" style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                            <?php if ( ! empty( $watch_type ) ) : ?>
                                <span class="badge badge-primary"><?php echo esc_html( $watch_type ); ?></span>
                            <?php endif; ?>
                            <?php if ( ! empty( $genre ) ) : ?>
                                <span class="badge badge-secondary"><?php echo esc_html( $genre ); ?></span>
                            <?php endif; ?>
                            <?php if ( ! empty( $status ) ) : ?>
                                <span class="badge badge-warning"><?php echo esc_html( $status ); ?></span>
                            <?php endif; ?>
                            <?php if ( ! empty( $release_year ) ) : ?>
                                <span class="badge badge-muted"><?php echo esc_html( $release_year ); ?></span>
                            <?php endif; ?>
                        </div>

                        <!-- One H1 Only (SEO Requirement) -->
                        <h1 class="watch-main-title mb-4" style="font-size: clamp(24px, 4vw, 36px); font-weight: 800; line-height: 1.2; color: var(--text-main);">
                            <?php the_title(); ?>
                        </h1>

                        <!-- Short Description -->
                        <?php if ( ! empty( $short_desc ) ) : ?>
                            <p class="watch-main-excerpt mb-6" style="font-size: 15px; color: var(--text-muted); line-height: 1.6; max-width: 780px;">
                                <?php echo esc_html( $short_desc ); ?>
                            </p>
                        <?php elseif ( has_excerpt() ) : ?>
                            <p class="watch-main-excerpt mb-6" style="font-size: 15px; color: var(--text-muted); line-height: 1.6; max-width: 780px;">
                                <?php echo esc_html( get_the_excerpt() ); ?>
                            </p>
                        <?php endif; ?>
                    </div>

                    <!-- Meta Specification strip -->
                    <div style="display: flex; gap: var(--space-6); flex-wrap: wrap; font-size: 13px; color: var(--text-muted); padding-top: var(--space-4); border-top: 1px solid rgba(255,255,255,0.06);">
                        <?php if ( ! empty( $language ) ) : ?>
                            <span>🌐 <strong><?php esc_html_e( 'Language:', 'quantum-mentor-world' ); ?></strong> <?php echo esc_html( $language ); ?></span>
                        <?php endif; ?>
                        <span>🕒 <strong><?php esc_html_e( 'Indexed On:', 'quantum-mentor-world' ); ?></strong> <?php echo get_the_date(); ?></span>
                        <span>💬 <strong><?php esc_html_e( 'Reviews:', 'quantum-mentor-world' ); ?></strong> <?php echo get_comments_number(); ?></span>
                    </div>
                </div>

            </div>
        </header>

        <!-- ============================================================
             3. VIDEO PLAYER AND EPISODE GRID ROW
             ============================================================ -->
        <?php if ( $is_episodic ) : ?>
            <div class="grid grid-cols-12 gap-6 md:gap-8 mb-8">
                <!-- Video player (left 8 cols) -->
                <div class="col-span-12 lg:col-span-8">
                    <?php get_template_part( 'template-parts/watch/watch-player' ); ?>
                </div>
                <!-- Episode list (right 4 cols sidebar) -->
                <div class="col-span-12 lg:col-span-4">
                    <?php get_template_part( 'template-parts/watch/watch-episodes' ); ?>
                </div>
            </div>
        <?php else : ?>
            <div class="grid grid-cols-12 gap-6 md:gap-8 mb-8">
                <!-- Video player (left 8 cols) -->
                <div class="col-span-12 lg:col-span-8">
                    <?php get_template_part( 'template-parts/watch/watch-player' ); ?>
                </div>
                <!-- Media information sidebar (right 4 cols) -->
                <div class="col-span-12 lg:col-span-4">
                    <?php get_template_part( 'template-parts/watch/watch-meta' ); ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- ============================================================
             4. CORE METADATA, LINKS, LEGAL, AND FULL CONTENT DESCRIPTION
             ============================================================ -->
        <div class="grid grid-cols-12 gap-6 md:gap-8 mb-8">
            
            <!-- Left Main Body Area -->
            <div class="col-span-12 lg:col-span-8">
                
                <!-- Trust & Action Bar -->
                <div class="glass-card p-6 mb-8" style="background: rgba(15, 23, 42, 0.4); border-color: rgba(255,255,255,0.06); display: flex; flex-direction: column; gap: var(--space-4);">
                    
                    <!-- Legal note and Official source button -->
                    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: var(--space-4);">
                        
                        <!-- Legal permission note -->
                        <div style="flex: 1; min-width: 280px;">
                            <span style="font-size: 11px; font-weight: 700; color: var(--success); letter-spacing: 0.05em; display: block; margin-bottom: 4px;">🛡️ <?php esc_html_e( 'LEGAL COMPLIANCE NOTE', 'quantum-mentor-world' ); ?></span>
                            <p class="small-text" style="font-size: 13px; line-height: 1.5; color: var(--text-muted); margin: 0;">
                                <?php 
                                if ( ! empty( $legal_note ) ) {
                                    echo esc_html( $legal_note );
                                } else {
                                    esc_html_e( 'This stream is embedded from verified public, creator-approved channels. We support copyright compliance and do not host unauthorized streams.', 'quantum-mentor-world' );
                                }
                                ?>
                            </p>
                        </div>

                        <!-- Official source button -->
                        <?php if ( ! empty( $official_url ) ) : ?>
                            <div style="flex-shrink: 0;">
                                <a href="<?php echo esc_url( $official_url ); ?>" 
                                   target="_blank" 
                                   rel="noopener noreferrer" 
                                   class="btn btn-primary" 
                                   style="padding: 10px 20px; font-size: 13px; display: inline-flex; align-items: center; gap: 8px;">
                                    <span>🌐</span> <?php esc_html_e( 'Official Source', 'quantum-mentor-world' ); ?>
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

                <!-- Full Description Content -->
                <section class="glass-card p-6 md:p-8 mb-8" aria-label="<?php esc_attr_e( 'Media Description Details', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-4" style="font-size: 22px;">
                        <?php esc_html_e( 'About this Video Content', 'quantum-mentor-world' ); ?>
                    </h2>
                    
                    <div class="entry-content body-text text-muted" style="line-height: 1.8; color: var(--text-muted);">
                        <?php 
                        while ( have_posts() ) : the_post();
                            the_content();
                        endwhile; 
                        ?>
                    </div>

                    <!-- Social Share Buttons Component -->
                    <div class="watch-social-share-wrap" style="margin-top: var(--space-8); padding-top: var(--space-6); border-top: 1px solid var(--border);">
                        <span style="font-size: 13px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: var(--space-3);"><?php esc_html_e( 'Share this Stream:', 'quantum-mentor-world' ); ?></span>
                        <div style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);" aria-label="Share on Facebook">
                                📘 Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url=<?php echo $permalink; ?>&text=<?php echo $title_esc; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);" aria-label="Share on Twitter">
                                🐦 Twitter (X)
                            </a>
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $permalink; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);" aria-label="Share on LinkedIn">
                                🔗 LinkedIn
                            </a>
                            <a href="https://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title() . ' - ' . get_permalink() ); ?>" target="_blank" rel="noopener" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);" aria-label="Share on WhatsApp">
                                💬 WhatsApp
                            </a>
                        </div>
                    </div>
                </section>

                <!-- Comments/Reviews Section -->
                <section class="glass-card p-6 md:p-8" aria-label="<?php esc_attr_e( 'Discussion comments', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-6" style="font-size: 22px;">
                        💬 <?php esc_html_e( 'Comments & Discussion', 'quantum-mentor-world' ); ?>
                    </h2>
                    <?php 
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                    ?>
                </section>

            </div>

            <!-- Right Column Sidebar (Only visible when episodic; contains meta information) -->
            <?php if ( $is_episodic ) : ?>
                <div class="col-span-12 lg:col-span-4">
                    <?php get_template_part( 'template-parts/watch/watch-meta' ); ?>
                </div>
            <?php endif; ?>

        </div>

        <!-- ============================================================
             5. RELATED WATCH RECOMMENDATIONS (4 posts index)
             ============================================================ -->
        <?php get_template_part( 'template-parts/watch/watch-related' ); ?>

    </div>
</article>

<?php
get_footer();
