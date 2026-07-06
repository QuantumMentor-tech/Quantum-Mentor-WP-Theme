<?php
/**
 * Books Archive Template
 *
 * URL: /books/
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Detect active filters
$has_filters = (
    ! empty( $_GET['category'] )    ||
    ! empty( $_GET['type'] )        ||
    ! empty( $_GET['format'] )      ||
    ! empty( $_GET['language'] )    ||
    ! empty( $_GET['book_search'] )
);
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

// 1. Hero Template
get_template_part( 'template-parts/books/book-hero' );
?>

<div class="books-archive-wrapper">
    <div class="container container-laptop">

        <!-- 2. Filter Controls Template -->
        <?php get_template_part( 'template-parts/books/book-filters' ); ?>

        <!-- ============================================================
             3. FEATURED BOOKS (page 1 only, no active filters)
             ============================================================ -->
        <?php
        if ( ! $has_filters && $paged === 1 ) :
            $featured_args = array(
                'post_type'      => 'books',
                'posts_per_page' => 4,
                'meta_query'     => array(
                    array(
                        'key'     => 'admin_priority',
                        'value'   => 'Featured',
                        'compare' => '=',
                    ),
                ),
                'no_found_rows'  => true,
            );
            $featured_query = new WP_Query( $featured_args );
            if ( $featured_query->have_posts() ) :
        ?>
        <section class="books-featured-section" aria-label="<?php esc_attr_e( 'Featured Books', 'quantum-mentor-world' ); ?>">
            <div class="section-header mb-6">
                <h2 class="section-title" style="font-size: 24px;">
                    ✨ <?php esc_html_e( 'Featured Books & Guides', 'quantum-mentor-world' ); ?>
                </h2>
                <span class="featured-strip-badge">
                    <?php esc_html_e( 'FEATURED', 'quantum-mentor-world' ); ?>
                </span>
            </div>

            <div class="books-featured-grid">
                <?php while ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
                    <div class="book-featured-card-wrapper">
                        <?php get_template_part( 'template-parts/cards/book-card' ); ?>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        </section>
        <?php
            endif; // have_posts
        endif; // !has_filters && page 1
        ?>

        <!-- ============================================================
             4. MAIN BOOKS GRID (4 columns desktop)
             ============================================================ -->
        <section class="books-directory-section" aria-label="<?php esc_attr_e( 'All Books', 'quantum-mentor-world' ); ?>">

            <div class="section-header mb-6">
                <h2 class="section-title" style="font-size: 24px;">
                    📂 <?php
                    if ( $has_filters ) {
                        esc_html_e( 'Filtered Results', 'quantum-mentor-world' );
                    } else {
                        esc_html_e( 'Books Catalog', 'quantum-mentor-world' );
                    }
                    ?>
                </h2>
                <?php if ( have_posts() ) : ?>
                <span class="badge badge-muted" style="font-size: 12px;">
                    <?php echo esc_html( $wp_query->found_posts ); ?> <?php esc_html_e( 'books', 'quantum-mentor-world' ); ?>
                </span>
                <?php endif; ?>
            </div>

            <?php if ( have_posts() ) : ?>

                <div class="books-grid">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/cards/book-card' ); ?>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="books-pagination-wrap">
                    <?php
                    echo get_the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => esc_html__( '« Previous', 'quantum-mentor-world' ),
                        'next_text' => esc_html__( 'Next »', 'quantum-mentor-world' ),
                        'class'     => 'qmw-pagination',
                    ) );
                    ?>
                </div>

            <?php else : ?>
                <!-- Empty state fallback -->
                <div class="books-empty-state glass-card">
                    <div class="books-empty-icon" aria-hidden="true">📚</div>
                    <h3 class="card-title" style="margin-bottom: var(--space-3);">
                        <?php esc_html_e( 'No Books Found', 'quantum-mentor-world' ); ?>
                    </h3>
                    <p class="small-text" style="margin-bottom: var(--space-6); max-width: 400px; margin-left: auto; margin-right: auto;">
                        <?php esc_html_e( 'No books or guides match your search or filter selections. Please clear filters or try a different search query.', 'quantum-mentor-world' ); ?>
                    </p>
                    <a href="<?php echo esc_url( get_post_type_archive_link( 'books' ) ); ?>" class="btn btn-primary">
                        <?php esc_html_e( 'Reset Catalog', 'quantum-mentor-world' ); ?>
                    </a>
                </div>
            <?php endif; ?>

        </section>

        <!-- ============================================================
             5. SEO INTRO CONTENT BLOCK
             ============================================================ -->
        <section class="books-seo-intro glass-card" aria-label="<?php esc_attr_e( 'About the Digital Library', 'quantum-mentor-world' ); ?>">
            <h2 style="font-size: 20px; font-weight: 700; color: var(--text-main); margin-bottom: var(--space-4);">
                <?php esc_html_e( 'Verified Safe & Legal Digital Books Library', 'quantum-mentor-world' ); ?>
            </h2>
            <div style="display: grid; gap: var(--space-6);" class="books-seo-grid">
                <div>
                    <p>
                        <?php esc_html_e( 'Welcome to the Quantum Mentor World Books & Guides Library. We provide a curated, safe, and indexed repository of legal free books, programming handbooks, freelancing guides, and open-access educational resources. Whether you are looking to learn programming languages, artificial intelligence, business growth, freelancing skills, or scientific principles, we have cataloged high-quality legal resources for you.', 'quantum-mentor-world' ); ?>
                    </p>
                    <p style="margin-top: var(--space-4);">
                        <?php esc_html_e( 'Every publication in our catalog goes through an integrity check. We only link to legal resources, such as public domain works, Creative Commons open-licensed publications, or official free versions released by authors. Every download link routes directly to safe, secure platforms like GitHub, publisher official web domains, or digital archives.', 'quantum-mentor-world' ); ?>
                    </p>
                </div>
                <div>
                    <p>
                        <?php esc_html_e( 'We enforce a strict zero-piracy policy. We do not host or distribute cracked books, copyrighted commercial publications, leaked study guides, course answers, or scanned PDFs. By providing legal avenues to digital knowledge, we protect reader privacy, avoid malicious downloads, and respect authors\' work.', 'quantum-mentor-world' ); ?>
                    </p>
                    <!-- Internal SEO links by Subject -->
                    <nav class="books-seo-links subject-seo-links" aria-label="<?php esc_attr_e( 'Browse by Subject', 'quantum-mentor-world' ); ?>" style="margin-top: var(--space-4);">
                        <span style="font-size: 12px; font-weight: 600; color: var(--text-muted); display: block; margin-bottom: var(--space-2);">
                            <?php esc_html_e( 'Browse by Subject:', 'quantum-mentor-world' ); ?>
                        </span>
                        <?php
                        $seo_categories = array(
                            'programming' => 'Programming',
                            'ai'          => 'AI & ML',
                            'business'    => 'Business',
                            'freelancing' => 'Freelancing',
                            'science'     => 'Science',
                            'novels'      => 'Novels',
                        );
                        $archive_url = get_post_type_archive_link( 'books' );
                        foreach ( $seo_categories as $slug => $label ) :
                        ?>
                        <a href="<?php echo esc_url( add_query_arg( 'category', $slug, $archive_url ) ); ?>" rel="nofollow">
                            <?php echo esc_html( $label ); ?> <?php esc_html_e( 'Books', 'quantum-mentor-world' ); ?>
                        </a>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </section>

    </div>
</div>

<!-- ============================================================
     6. FAQ SECTION (full-width outside container)
     ============================================================ -->
<?php get_template_part( 'template-parts/books/book-faq' ); ?>

<?php
get_footer();
