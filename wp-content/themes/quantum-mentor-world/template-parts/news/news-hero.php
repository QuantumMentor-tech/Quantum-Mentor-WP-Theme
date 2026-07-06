<?php
/**
 * News Archive — Hero and Search Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Get total published news count
$news_count = wp_count_posts( 'news' )->publish;
$current_search = isset( $_GET['news_search'] ) ? sanitize_text_field( $_GET['news_search'] ) : '';
?>

<!-- ============================================================
     NEWS ARCHIVE HERO SECTION
     ============================================================ -->
<section class="watch-archive-hero" aria-label="<?php esc_attr_e( 'News Spotlight Hero', 'quantum-mentor-world' ); ?>" style="position: relative; overflow: hidden; background: linear-gradient(135deg, rgba(124, 58, 237, 0.08) 0%, rgba(0, 212, 255, 0.04) 100%); border-bottom: 1px solid var(--border); padding: var(--space-12) 0 var(--space-16);">
    <!-- Background Ambient Glow -->
    <div style="position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(124, 58, 237, 0.12) 0%, rgba(0,0,0,0) 70%); top: -100px; left: -100px; z-index: 1; pointer-events: none; filter: blur(50px);"></div>
    <div style="position: absolute; width: 400px; height: 400px; background: radial-gradient(circle, rgba(0, 212, 255, 0.08) 0%, rgba(0,0,0,0) 70%); bottom: -100px; right: -100px; z-index: 1; pointer-events: none; filter: blur(50px);"></div>

    <div class="container container-laptop" style="position: relative; z-index: 2; text-align: center;">

        <!-- Stats pill -->
        <div class="watch-stat-pill" style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.03); border: 1px solid var(--border); padding: 6px 14px; border-radius: 40px; margin-bottom: var(--space-4);">
            <span style="font-size: 14px;">📰</span>
            <span style="font-size: 11px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em;">
                <?php printf( esc_html( _n( '%s Tech Article', '%s Tech Articles', $news_count, 'quantum-mentor-world' ) ), number_format_i18n( $news_count ) ); ?>
            </span>
        </div>

        <h1 class="hero-title" style="margin-bottom: var(--space-4);">
            <?php esc_html_e( 'Tech & AI News', 'quantum-mentor-world' ); ?>
        </h1>

        <p class="body-text" style="color: var(--text-muted); max-width: 600px; margin: 0 auto var(--space-8); font-size: 15px; line-height: 1.6;">
            <?php esc_html_e( 'Read the latest updates about AI, software, tools, games, operating systems, themes, digital learning, and technology.', 'quantum-mentor-world' ); ?>
        </p>

        <!-- Quick Categories Links -->
        <div class="news-quick-links" style="display: flex; gap: var(--space-3); justify-content: center; flex-wrap: wrap; margin-top: var(--space-4);">
            <span style="font-size: 12px; color: var(--text-muted); display: inline-flex; align-items: center;">
                <?php esc_html_e( 'Topics:', 'quantum-mentor-world' ); ?>
            </span>
            <?php
            $topics = array(
                'ai-news'       => '🤖 AI',
                'software-news' => '💻 Software',
                'games-news'    => '🎮 Games',
                'tools-news'    => '⚙️ Tools',
                'tech-general'  => '📱 General'
            );
            $news_archive = get_post_type_archive_link( 'news' );
            foreach ( $topics as $slug => $label ) :
            ?>
                <a href="<?php echo esc_url( add_query_arg( 'category', $slug, $news_archive ) ); ?>" style="font-size: 12px; color: var(--text-muted); text-decoration: none; padding: 4px 10px; border-radius: 4px; border: 1px solid var(--border); background: rgba(255,255,255,0.01); transition: all 0.2s;" onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)'; this.style.background='rgba(0, 212, 255, 0.02)';" onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--text-muted)'; this.style.background='rgba(255,255,255,0.01)';">
                    <?php echo esc_html( $label ); ?>
                </a>
            <?php endforeach; ?>
        </div>

    </div>
</section>
