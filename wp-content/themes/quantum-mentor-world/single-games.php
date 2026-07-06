<?php
/**
 * Single Game Detail Template
 *
 * URL example: /games/game-name/
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// ------------------------------------------------------------------
// Gather all ACF field values
// ------------------------------------------------------------------
$post_id       = get_the_ID();
$platform      = get_field( 'game_platform', $post_id );
$genre         = get_field( 'game_genre_field', $post_id );
$developer     = get_field( 'game_developer', $post_id );
$license       = get_field( 'game_license', $post_id );
$version       = get_field( 'game_version', $post_id );
$size          = get_field( 'game_size', $post_id );
$official_url  = get_field( 'game_official_url', $post_id );
$download_url  = get_field( 'game_download_url', $post_id );
$trailer_url   = get_field( 'game_trailer_url', $post_id );
$requirements  = get_field( 'game_requirements', $post_id );
$install_guide = get_field( 'game_installation_guide', $post_id );
$last_updated  = get_field( 'game_last_updated', $post_id );
$safety_note   = get_field( 'game_safety_note', $post_id );

$permalink     = esc_url( get_permalink() );
$title_esc     = esc_attr( get_the_title() );
$formatted_date = ! empty( $last_updated )
    ? date_i18n( get_option( 'date_format' ), strtotime( $last_updated ) )
    : get_the_modified_date( get_option( 'date_format' ), $post_id );

// License badge class
$license_classes = array(
    'Freeware'          => 'badge-success',
    'Open Source'       => 'badge-primary',
    'Demo'              => 'badge-secondary',
    'Freemium'          => 'badge-warning',
    'Paid Official Link'=> 'badge-muted',
    'Public Domain'     => 'badge-success',
);
$license_class = isset( $license_classes[ $license ] ) ? $license_classes[ $license ] : 'badge-muted';
?>

<!-- ============================================================
     SINGLE GAME PAGE WRAPPER
     ============================================================ -->
<div class="single-game-page">
    <div class="container container-laptop">

        <!-- ==================================================
             BREADCRUMBS
             ================================================== -->
        <nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span class="separator" aria-hidden="true">›</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'games' ) ); ?>"><?php esc_html_e( 'Games', 'quantum-mentor-world' ); ?></a>
            <?php
            $game_cats = get_the_terms( $post_id, 'game_category' );
            if ( ! empty( $game_cats ) && ! is_wp_error( $game_cats ) ) :
                $cat = $game_cats[0];
            ?>
                <span class="separator" aria-hidden="true">›</span>
                <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
            <?php endif; ?>
            <span class="separator" aria-hidden="true">›</span>
            <span class="current" aria-current="page"><?php the_title(); ?></span>
        </nav>

        <!-- ==================================================
             HERO HEADER
             ================================================== -->
        <header class="single-game-hero glass-card" aria-label="<?php esc_attr_e( 'Game details header', 'quantum-mentor-world' ); ?>">

            <div class="single-game-hero-inner">

                <!-- Game icon / thumbnail -->
                <div class="single-game-icon-wrap" aria-hidden="true">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php echo get_the_post_thumbnail( $post_id, 'qmw-icon', array(
                            'alt'     => $title_esc,
                            'style'   => 'width:100%; height:100%; object-fit:cover;',
                            'loading' => 'eager',
                        ) ); ?>
                    <?php else : ?>
                        <div style="font-size: 48px; display:flex; align-items:center; justify-content:center; width:100%; height:100%;">🎮</div>
                    <?php endif; ?>
                </div>

                <!-- Title & info block -->
                <div class="single-game-info" style="flex: 1; min-width: 240px;">

                    <!-- Badges row -->
                    <div class="single-game-badges">
                        <?php if ( ! empty( $license ) ) : ?>
                            <span class="badge <?php echo esc_attr( $license_class ); ?>" style="font-size: 10px;"><?php echo esc_html( $license ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $genre ) ) : ?>
                            <span class="badge badge-secondary" style="font-size: 10px;"><?php echo esc_html( $genre ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $version ) ) : ?>
                            <span class="badge badge-muted" style="font-size: 10px;"><?php echo esc_html( $version ); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Title — only H1 on this page -->
                    <h1 class="single-game-title"><?php the_title(); ?></h1>

                    <!-- Short description -->
                    <p class="single-game-excerpt">
                        <?php
                        $excerpt = get_the_excerpt();
                        if ( empty( $excerpt ) ) {
                            $excerpt = wp_strip_all_tags( get_the_content() );
                        }
                        echo esc_html( wp_trim_words( $excerpt, 25, '...' ) );
                        ?>
                    </p>

                    <!-- Platform badges -->
                    <?php if ( ! empty( $platform ) && is_array( $platform ) ) : ?>
                    <div class="single-game-platforms" aria-label="<?php esc_attr_e( 'Platforms', 'quantum-mentor-world' ); ?>">
                        <?php foreach ( $platform as $p ) : ?>
                            <span class="badge badge-muted" style="font-size: 9px; text-transform: uppercase;"><?php echo esc_html( $p ); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- Social Share Panel -->
                <div class="single-game-share" aria-label="<?php esc_attr_e( 'Share this game', 'quantum-mentor-world' ); ?>">
                    <span class="small-text" style="font-weight:600; color:var(--text-muted); display:block; margin-bottom:6px;">
                        <?php esc_html_e( 'Share:', 'quantum-mentor-world' ); ?>
                    </span>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <a href="https://x.com/intent/tweet?url=<?php echo $permalink; ?>&text=<?php echo urlencode( get_the_title() ); ?>"
                           target="_blank" rel="noopener noreferrer" class="game-share-btn" title="<?php esc_attr_e( 'Share on X', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on X (Twitter)', 'quantum-mentor-world' ); ?>">𝕏</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>"
                           target="_blank" rel="noopener noreferrer" class="game-share-btn" title="<?php esc_attr_e( 'Share on Facebook', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on Facebook', 'quantum-mentor-world' ); ?>">f</a>
                        <a href="https://reddit.com/submit?url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>"
                           target="_blank" rel="noopener noreferrer" class="game-share-btn" title="<?php esc_attr_e( 'Share on Reddit', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on Reddit', 'quantum-mentor-world' ); ?>">r/</a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>"
                           target="_blank" rel="noopener noreferrer" class="game-share-btn" title="<?php esc_attr_e( 'Share on LinkedIn', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'quantum-mentor-world' ); ?>">in</a>
                    </div>
                </div>

            </div>
        </header>

        <!-- ==================================================
             TWO COLUMN LAYOUT
             ================================================== -->
        <div class="single-game-layout">

            <!-- =======================================
                 LEFT: Main Content
                 ======================================= -->
            <main class="single-game-main" id="main-content">

                <!-- 1. Trailer Embed -->
                <?php get_template_part( 'template-parts/games/game-trailer' ); ?>

                <!-- 2. About / Full Description -->
                <article class="glass-card p-6" aria-label="<?php esc_attr_e( 'Game Description', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-4" style="font-size: 22px;">
                        🎮 <?php esc_html_e( 'About This Game', 'quantum-mentor-world' ); ?>
                    </h2>
                    <div class="entry-content game-entry-content">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            the_content();
                        endwhile;
                        ?>
                    </div>
                </article>

                <!-- 3. Screenshots Gallery -->
                <?php get_template_part( 'template-parts/games/game-screenshots' ); ?>

                <!-- 4. System Requirements -->
                <?php if ( ! empty( $requirements ) ) : ?>
                <section class="glass-card p-6" style="border-left: 4px solid var(--primary);" aria-label="<?php esc_attr_e( 'System Requirements', 'quantum-mentor-world' ); ?>">
                    <h2 class="card-title mb-3" style="font-size: 18px; display:flex; align-items:center; gap:8px;">
                        ⚙️ <?php esc_html_e( 'System Requirements', 'quantum-mentor-world' ); ?>
                    </h2>
                    <pre style="font-family:var(--font-sans); white-space:pre-line; font-size:14px; line-height:1.7; color:var(--text-muted); margin:0; background:transparent; border:none; padding:0; overflow:visible;"><?php echo esc_html( $requirements ); ?></pre>
                </section>
                <?php endif; ?>

                <!-- 5. Installation Guide -->
                <?php if ( ! empty( $install_guide ) ) : ?>
                <section class="glass-card p-6" style="border-left: 4px solid var(--secondary);" aria-label="<?php esc_attr_e( 'Installation Guide', 'quantum-mentor-world' ); ?>">
                    <h2 class="card-title mb-3" style="font-size: 18px; display:flex; align-items:center; gap:8px;">
                        📝 <?php esc_html_e( 'How to Install / Play', 'quantum-mentor-world' ); ?>
                    </h2>
                    <div style="font-size:14px; line-height:1.7; color:var(--text-muted);">
                        <?php echo wp_kses_post( wpautop( $install_guide ) ); ?>
                    </div>
                </section>
                <?php endif; ?>

                <!-- 6. Safety / Legal Note -->
                <div class="game-legal-full-note" role="note" aria-label="<?php esc_attr_e( 'Legal Note', 'quantum-mentor-world' ); ?>">
                    <span class="game-legal-note-icon" aria-hidden="true">⚠️</span>
                    <div>
                        <p style="font-weight:700; margin-bottom:6px; color:var(--warning);">
                            <?php esc_html_e( 'Legal & Safety Notice', 'quantum-mentor-world' ); ?>
                        </p>
                        <?php if ( ! empty( $safety_note ) ) : ?>
                            <p style="font-size:13px; line-height:1.6; color:var(--text-muted);"><?php echo wp_kses_post( $safety_note ); ?></p>
                        <?php else : ?>
                            <p style="font-size:13px; line-height:1.6; color:var(--text-muted);">
                                <?php esc_html_e( 'Quantum Mentor World only lists legal, official, open-source, freeware, demo, educational, or properly licensed games. We do not promote cracked games, illegal keys, repacks, bypasses, cheats, hacks, or pirated downloads. All links route to official developer or trusted platform sources.', 'quantum-mentor-world' ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 7. Comments & Reviews -->
                <section class="glass-card p-6" aria-label="<?php esc_attr_e( 'Discussion and Reviews', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-6" style="font-size: 22px;">
                        💬 <?php esc_html_e( 'Discussion & Reviews', 'quantum-mentor-world' ); ?>
                    </h2>
                    <?php if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    } ?>
                </section>

            </main>

            <!-- =======================================
                 RIGHT: Sidebar
                 ======================================= -->
            <aside class="single-game-sidebar">

                <!-- Download / Link Box -->
                <?php get_template_part( 'template-parts/games/game-link-box' ); ?>

                <!-- Meta / Specs Card + Trust Badges -->
                <?php get_template_part( 'template-parts/games/game-meta' ); ?>

            </aside>

        </div>

        <!-- ==================================================
             RELATED GAMES (Full Width)
             ================================================== -->
        <div class="single-game-related-wrapper">
            <?php get_template_part( 'template-parts/games/game-related' ); ?>
        </div>

    </div>
</div>

<?php
get_footer();
