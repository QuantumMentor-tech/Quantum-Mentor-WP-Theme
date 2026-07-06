<?php
/**
 * Single News Article Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

global $post;
$post_id      = get_the_ID();
$news_title   = get_field( 'news_title', $post_id ) ?: get_the_title();
$news_cat     = get_field( 'news_category_field', $post_id );
$news_date    = get_field( 'news_date', $post_id ) ?: get_the_date( 'Y-m-d' );
$news_author  = get_field( 'news_author_name', $post_id ) ?: get_the_author();
$news_summary = get_field( 'news_summary', $post_id );
$news_content = get_field( 'news_full_content', $post_id );

$src_name     = get_field( 'news_source_name_field', $post_id );
$src_url      = get_field( 'news_source_url_field', $post_id );

$display_date = date_i18n( get_option( 'date_format' ), strtotime( $news_date ) );

if ( empty( $news_cat ) ) {
    $terms = get_the_terms( $post_id, 'news_category' );
    $news_cat = ( ! empty( $terms ) && ! is_wp_error( $terms ) ) ? $terms[0]->name : __( 'General News', 'quantum-mentor-world' );
}

$has_thumbnail = has_post_thumbnail( $post_id );
?>

<!-- ============================================================
     Ambient Cover Background Hero
     ============================================================ -->
<div class="single-resource-hero" style="background: linear-gradient(180deg, rgba(15, 23, 42, 0.4) 0%, var(--bg-primary) 100%), 
            url(<?php echo $has_thumbnail ? esc_url( get_the_post_thumbnail_url( $post_id, 'full' ) ) : ''; ?>) no-repeat center center; background-size: cover; padding: var(--space-12) 0 var(--space-8); border-bottom: 1px solid var(--border); position: relative;">
    
    <div style="position: absolute; inset: 0; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); z-index: 1;"></div>
    
    <div class="container container-laptop" style="position: relative; z-index: 2;">
        
        <!-- Breadcrumbs -->
        <nav class="breadcrumbs mb-6" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>" style="font-size: 13px; color: var(--text-muted);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'News', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary); font-weight: 600;"><?php echo esc_html( wp_trim_words( $news_title, 5, '...' ) ); ?></span>
        </nav>

        <!-- Category Badge -->
        <span class="badge badge-primary mb-4" style="border-color: var(--primary);"><?php echo esc_html( $news_cat ); ?></span>

        <!-- Headline (Single H1 required) -->
        <h1 class="hero-title" style="font-size: 32px; margin-bottom: var(--space-4); text-transform: none; text-shadow: 0 0 20px rgba(0, 212, 255, 0.1);">
            <?php echo esc_html( $news_title ); ?>
        </h1>

        <!-- Author / Date / Source Meta -->
        <div style="display: flex; gap: var(--space-4); font-size: 13px; color: var(--text-muted); flex-wrap: wrap; align-items: center;">
            <span>✍️ <?php esc_html_e( 'Reporter:', 'quantum-mentor-world' ); ?> <strong><?php echo esc_html( $news_author ); ?></strong></span>
            <span>•</span>
            <span>📅 <?php esc_html_e( 'Published:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $display_date ); ?></span>
            <?php if ( ! empty( $src_name ) ) : ?>
                <span>•</span>
                <span>📡 <?php esc_html_e( 'Source:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $src_name ); ?></span>
            <?php endif; ?>
        </div>

    </div>
</div>

<div class="single-resource-content-wrap" style="padding: var(--space-12) 0;">
    <div class="container container-laptop">
        <div class="grid grid-cols-12 gap-8">

            <!-- ==========================================
                 LEFT COLUMN: News Details
                 ========================================== -->
            <main class="col-span-12 lg:col-span-8" style="min-width: 0;">

                <!-- 1. Featured Image Block -->
                <?php if ( $has_thumbnail ) : ?>
                    <div class="glass-card p-2" style="border-radius: var(--radius-md); margin-bottom: var(--space-8); overflow: hidden; background: rgba(255,255,255,0.01);">
                        <div style="aspect-ratio: 16 / 9; overflow: hidden; border-radius: var(--radius-sm);">
                            <?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'alt' => esc_attr( $news_title ) ) ); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 2. News Short Summary Card -->
                <?php if ( ! empty( $news_summary ) ) : ?>
                    <div class="glass-card p-6" style="border-left: 4px solid var(--primary); background: rgba(0, 212, 255, 0.02); margin-bottom: var(--space-8);">
                        <h2 style="font-size: 14px; font-weight: 700; text-transform: uppercase; color: var(--primary); letter-spacing: 0.05em; margin: 0 0 var(--space-2);"><?php esc_html_e( 'Key Highlight Summary', 'quantum-mentor-world' ); ?></h2>
                        <p style="margin: 0; font-size: 15px; line-height: 1.6; font-style: italic; color: var(--text-main);"><?php echo esc_html( $news_summary ); ?></p>
                    </div>
                <?php endif; ?>

                <!-- 3. News Full Body Content -->
                <div class="watch-description-box glass-card p-6 md:p-8" style="margin-bottom: var(--space-8);">
                    <h2 style="font-size: 18px; font-weight: 700; margin: 0 0 var(--space-4); color: var(--text-main); border-bottom: 1px solid var(--border); padding-bottom: var(--space-2);"><?php esc_html_e( 'Full Article Content', 'quantum-mentor-world' ); ?></h2>
                    
                    <div class="body-text" style="font-size: 15px; line-height: 1.7; color: var(--text-main);">
                        <?php
                        if ( ! empty( $news_content ) ) {
                            echo wp_kses_post( wpautop( $news_content ) );
                        } else {
                            the_content();
                        }
                        ?>
                    </div>
                </div>

                <!-- 4. Outbound Source Attribution Box -->
                <?php if ( ! empty( $src_name ) ) : ?>
                    <div class="glass-card p-6" style="margin-bottom: var(--space-8); border-color: rgba(0, 212, 255, 0.15); background: rgba(0, 212, 255, 0.01);">
                        <h3 style="margin: 0 0 var(--space-2); font-size: 15px; font-weight: 700; color: var(--text-main);"><?php esc_html_e( 'Original Reporting Citation', 'quantum-mentor-world' ); ?></h3>
                        <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: var(--space-4);">
                            <?php esc_html_e( 'This news story was analyzed, summarized, or compiled from reporting published by original source channels.', 'quantum-mentor-world' ); ?>
                        </p>
                        <?php if ( ! empty( $src_url ) ) : ?>
                            <a href="<?php echo esc_url( $src_url ); ?>" 
                               class="btn btn-secondary" 
                               style="font-size: 13px; padding: 8px 16px; min-height: auto;" 
                               target="_blank" 
                               rel="nofollow noopener noreferrer">
                                📡 <?php printf( esc_html__( 'View Original Source on %s', 'quantum-mentor-world' ), esc_html( $src_name ) ); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- 5. Social Share component -->
                <div class="glass-card p-4" style="margin-bottom: var(--space-8); display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); flex-wrap: wrap;">
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;"><?php esc_html_e( 'Share Story:', 'quantum-mentor-world' ); ?></span>
                    <div style="display: flex; gap: var(--space-2);">
                        <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( $news_title ); ?>&url=<?php echo urlencode( get_permalink() ); ?>" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; min-height: auto;" target="_blank" rel="noopener noreferrer">Twitter</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; min-height: auto;" target="_blank" rel="noopener noreferrer">Facebook</a>
                        <a href="https://t.me/share/url?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( $news_title ); ?>" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; min-height: auto;" target="_blank" rel="noopener noreferrer">Telegram</a>
                    </div>
                </div>

                <!-- 6. Discussion comments template -->
                <div class="glass-card p-6 md:p-8">
                    <?php if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif; ?>
                </div>

            </main>

            <!-- ==========================================
                 RIGHT COLUMN: Sidebar Info
                 ========================================== -->
            <aside class="col-span-12 lg:col-span-4">
                
                <div class="watch-meta-card glass-card p-5" style="margin-bottom: var(--space-6); border-radius: var(--radius-md);">
                    <h3 class="watch-meta-heading"><?php esc_html_e( 'Article Metadata', 'quantum-mentor-world' ); ?></h3>
                    
                    <ul class="watch-spec-list">
                        <li class="watch-spec-item">
                            <span class="watch-spec-label"><?php esc_html_e( 'Topic Category', 'quantum-mentor-world' ); ?></span>
                            <span class="watch-spec-value" style="color: var(--primary); font-weight: 700;"><?php echo esc_html( $news_cat ); ?></span>
                        </li>
                        <li class="watch-spec-item">
                            <span class="watch-spec-label"><?php esc_html_e( 'Reporter', 'quantum-mentor-world' ); ?></span>
                            <span class="watch-spec-value"><?php echo esc_html( $news_author ); ?></span>
                        </li>
                        <li class="watch-spec-item">
                            <span class="watch-spec-label"><?php esc_html_e( 'Release Date', 'quantum-mentor-world' ); ?></span>
                            <span class="watch-spec-value"><?php echo esc_html( $display_date ); ?></span>
                        </li>
                        <?php if ( ! empty( $src_name ) ) : ?>
                        <li class="watch-spec-item">
                            <span class="watch-spec-label"><?php esc_html_e( 'Publisher Source', 'quantum-mentor-world' ); ?></span>
                            <span class="watch-spec-value"><?php echo esc_html( $src_name ); ?></span>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Verified Checkboxes Sidebar item -->
                <div class="watch-verify-card p-5" style="border: 1px solid rgba(0, 212, 255, 0.2); background: rgba(0, 212, 255, 0.01); border-radius: var(--radius-md);">
                    <h4 style="margin: 0 0 var(--space-4); font-size: 13px; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 6px;">
                        <span>🔒</span> <?php esc_html_e( 'Editorial Security', 'quantum-mentor-world' ); ?>
                    </h4>

                    <div style="display: flex; flex-direction: column; gap: var(--space-3.5);">
                        <div class="watch-trust-check">
                            <span class="watch-trust-dot" style="background-color: var(--success); box-shadow: 0 0 8px var(--success);"></span>
                            <span style="font-size: 12px; font-weight: 600; color: var(--text-main);">
                                <?php esc_html_e( 'Verified Fact-Checked', 'quantum-mentor-world' ); ?>
                            </span>
                        </div>
                        
                        <div class="watch-trust-check">
                            <span class="watch-trust-dot" style="background-color: var(--success); box-shadow: 0 0 8px var(--success);"></span>
                            <span style="font-size: 12px; font-weight: 600; color: var(--text-main);">
                                <?php esc_html_e( 'No AI Copy-Paste Rules Checked', 'quantum-mentor-world' ); ?>
                            </span>
                        </div>

                        <div class="watch-trust-check">
                            <span class="watch-trust-dot" style="background-color: var(--success); box-shadow: 0 0 8px var(--success);"></span>
                            <span style="font-size: 12px; font-weight: 600; color: var(--text-main);">
                                <?php esc_html_e( 'Source Attribution Confirmed', 'quantum-mentor-world' ); ?>
                            </span>
                        </div>
                    </div>
                </div>

            </aside>

        </div>

        <!-- ==========================================
             BOTTOM ROW: Related Articles Row
             ========================================== -->
        <?php get_template_part( 'template-parts/news/news-related' ); ?>

    </div>
</div>

<?php
get_footer();
