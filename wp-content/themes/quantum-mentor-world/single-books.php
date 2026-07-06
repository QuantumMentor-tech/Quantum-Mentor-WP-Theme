<?php
/**
 * Single Book Detail Template
 *
 * URL example: /books/book-name/
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
$post_id          = get_the_ID();
$author           = get_field( 'book_author_field', $post_id );
$publisher        = get_field( 'book_publisher', $post_id );
$language         = get_field( 'book_language_field', $post_id );
$pages            = get_field( 'book_pages_count', $post_id );
$book_type        = get_field( 'book_type', $post_id );
$format           = get_field( 'book_format', $post_id );
$official_url     = get_field( 'book_official_url', $post_id );
$download_url     = get_field( 'book_download_url', $post_id );
$read_online_url  = get_field( 'book_read_online_url', $post_id );
$summary          = get_field( 'book_summary', $post_id );
$toc              = get_field( 'book_toc', $post_id );
$pub_year         = get_field( 'book_pub_year', $post_id );
$license_note     = get_field( 'book_license_note', $post_id );

$permalink        = esc_url( get_permalink() );
$title_esc        = esc_attr( get_the_title() );
$formatted_date   = get_the_modified_date( get_option( 'date_format' ), $post_id );
?>

<!-- ============================================================
     SINGLE BOOK PAGE WRAPPER
     ============================================================ -->
<div class="single-book-page">
    <div class="container container-laptop">

        <!-- ==================================================
             BREADCRUMBS
             ================================================== -->
        <nav class="breadcrumbs" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span class="separator" aria-hidden="true">›</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'books' ) ); ?>"><?php esc_html_e( 'Books', 'quantum-mentor-world' ); ?></a>
            <?php
            $book_cats = get_the_terms( $post_id, 'book_category' );
            if ( ! empty( $book_cats ) && ! is_wp_error( $book_cats ) ) :
                $cat = $book_cats[0];
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
        <header class="single-book-hero glass-card" aria-label="<?php esc_attr_e( 'Book details header', 'quantum-mentor-world' ); ?>">

            <div class="single-book-hero-inner">

                <!-- Book cover (3:4 aspect ratio) -->
                <div class="single-book-cover-wrap" aria-hidden="true">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php echo get_the_post_thumbnail( $post_id, 'medium_large', array(
                            'alt'     => $title_esc,
                            'style'   => 'width:100%; height:100%; object-fit:cover;',
                            'loading' => 'eager',
                        ) ); ?>
                    <?php else : ?>
                        <div style="font-size: 48px; display:flex; align-items:center; justify-content:center; width:100%; height:100%;">📚</div>
                    <?php endif; ?>
                </div>

                <!-- Title & info block -->
                <div class="single-book-info" style="flex: 1; min-width: 240px;">

                    <!-- Badges row -->
                    <div class="single-book-badges">
                        <?php if ( ! empty( $book_type ) ) : ?>
                            <span class="badge badge-warning" style="font-size: 10px;"><?php echo esc_html( $book_type ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $language ) ) : ?>
                            <span class="badge badge-secondary" style="font-size: 10px;"><?php echo esc_html( $language ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $pages ) ) : ?>
                            <span class="badge badge-muted" style="font-size: 10px;"><?php echo esc_html( $pages ); ?> <?php esc_html_e( 'Pages', 'quantum-mentor-world' ); ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Title -->
                    <h1 class="single-book-title"><?php the_title(); ?></h1>

                    <!-- Short summary from ACF -->
                    <p class="single-book-excerpt">
                        <?php
                        if ( ! empty( $summary ) ) {
                            echo esc_html( $summary );
                        } else {
                            $excerpt = get_the_excerpt();
                            if ( empty( $excerpt ) ) {
                                $excerpt = wp_strip_all_tags( get_the_content() );
                            }
                            echo esc_html( wp_trim_words( $excerpt, 25, '...' ) );
                        }
                        ?>
                    </p>

                    <!-- Available formats list -->
                    <?php if ( ! empty( $format ) && is_array( $format ) ) : ?>
                    <div class="single-book-formats" aria-label="<?php esc_attr_e( 'Available Formats', 'quantum-mentor-world' ); ?>">
                        <span class="small-text" style="color:var(--text-muted); font-size:11px; margin-right:8px; font-weight:600;"><?php esc_html_e( 'Formats:', 'quantum-mentor-world' ); ?></span>
                        <?php foreach ( $format as $fmt ) : ?>
                            <span class="badge badge-muted" style="font-size: 9px; text-transform: uppercase;"><?php echo esc_html( $fmt ); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>

                <!-- Social Share Panel -->
                <div class="single-book-share" aria-label="<?php esc_attr_e( 'Share this book', 'quantum-mentor-world' ); ?>">
                    <span class="small-text" style="font-weight:600; color:var(--text-muted); display:block; margin-bottom:6px;">
                        <?php esc_html_e( 'Share:', 'quantum-mentor-world' ); ?>
                    </span>
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <a href="https://x.com/intent/tweet?url=<?php echo $permalink; ?>&text=<?php echo urlencode( get_the_title() ); ?>"
                           target="_blank" rel="noopener noreferrer" class="book-share-btn" title="<?php esc_attr_e( 'Share on X', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on X (Twitter)', 'quantum-mentor-world' ); ?>">𝕏</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>"
                           target="_blank" rel="noopener noreferrer" class="book-share-btn" title="<?php esc_attr_e( 'Share on Facebook', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on Facebook', 'quantum-mentor-world' ); ?>">f</a>
                        <a href="https://reddit.com/submit?url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>"
                           target="_blank" rel="noopener noreferrer" class="book-share-btn" title="<?php esc_attr_e( 'Share on Reddit', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on Reddit', 'quantum-mentor-world' ); ?>">r/</a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>"
                           target="_blank" rel="noopener noreferrer" class="book-share-btn" title="<?php esc_attr_e( 'Share on LinkedIn', 'quantum-mentor-world' ); ?>" aria-label="<?php esc_attr_e( 'Share on LinkedIn', 'quantum-mentor-world' ); ?>">in</a>
                    </div>
                </div>

            </div>
        </header>

        <!-- ==================================================
             TWO COLUMN LAYOUT
             ================================================== -->
        <div class="single-book-layout">

            <!-- =======================================
                 LEFT: Main Content
                 ======================================= -->
            <main class="single-book-main" id="main-content">

                <!-- 1. Table of Contents sub-template -->
                <?php get_template_part( 'template-parts/books/book-toc' ); ?>

                <!-- 2. About / Full Description -->
                <article class="glass-card p-6" aria-label="<?php esc_attr_e( 'Book Description', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-4" style="font-size: 22px;">
                        📖 <?php esc_html_e( 'About This Publication', 'quantum-mentor-world' ); ?>
                    </h2>
                    <div class="entry-content book-entry-content">
                        <?php
                        while ( have_posts() ) :
                            the_post();
                            the_content();
                        endwhile;
                        ?>
                    </div>
                </article>

                <!-- 3. Safety / License / Legal Note -->
                <div class="book-legal-full-note" role="note" aria-label="<?php esc_attr_e( 'Legal Note', 'quantum-mentor-world' ); ?>">
                    <span class="book-legal-note-icon" aria-hidden="true">⚠️</span>
                    <div>
                        <p style="font-weight:700; margin-bottom:6px; color:var(--warning);">
                            <?php esc_html_e( 'License & Digital Rights Notice', 'quantum-mentor-world' ); ?>
                        </p>
                        <?php if ( ! empty( $license_note ) ) : ?>
                            <p style="font-size:13px; line-height:1.6; color:var(--text-muted);"><?php echo wp_kses_post( $license_note ); ?></p>
                        <?php else : ?>
                            <p style="font-size:13px; line-height:1.6; color:var(--text-muted);">
                                <?php esc_html_e( 'Quantum Mentor World strictly lists open-access, Creative Commons, public domain, or officially free resources. We respect all intellectual property rights. If you are the author or copyright holder of this publication and wish to modify or request removal of this listing, please use our official contact page.', 'quantum-mentor-world' ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 4. Comments & Reviews -->
                <section class="glass-card p-6" aria-label="<?php esc_attr_e( 'Reader Reviews', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-6" style="font-size: 22px;">
                        💬 <?php esc_html_e( 'Reader Discussion & Reviews', 'quantum-mentor-world' ); ?>
                    </h2>
                    <?php if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    } ?>
                </section>

            </main>

            <!-- =======================================
                 RIGHT: Sidebar
                 ======================================= -->
            <aside class="single-book-sidebar">

                <!-- Actions / Link Box -->
                <?php get_template_part( 'template-parts/books/book-link-box' ); ?>

                <!-- Meta / Specs Card + Trust Badges -->
                <?php get_template_part( 'template-parts/books/book-meta' ); ?>

            </aside>

        </div>

        <!-- ==================================================
             RELATED BOOKS (Full Width)
             ================================================== -->
        <div class="single-book-related-wrapper">
            <?php get_template_part( 'template-parts/books/book-related' ); ?>
        </div>

    </div>
</div>

<?php
get_footer();
