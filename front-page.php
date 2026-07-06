<?php
/**
 * The template for displaying the front page / homepage
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-homepage-content py-12 px-6 lg:px-12 max-w-7xl mx-auto space-y-16">

    <!-- 1. Hero Section -->
    <section class="hero-section text-center relative py-16 bg-[#1E293B]/30 border border-white/5 rounded-2xl backdrop-blur-md overflow-hidden">
        <!-- Background Accent Glows -->
        <div class="absolute -top-12 -left-12 w-64 h-64 bg-[#00D4FF]/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-[#7C3AED]/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl mx-auto px-4">
            <span class="badge badge-primary mb-4 text-xs tracking-widest font-bold font-display uppercase">Verifiable Legal Directory</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-wide font-display mb-4 leading-tight">
                Discover Open-Source & <br>
                <span class="bg-gradient-to-r from-[#00D4FF] to-[#7C3AED] bg-clip-text text-transparent">Licensed Tech Resources</span>
            </h1>
            <p class="text-sm md:text-md text-[#94A3B8] max-w-2xl mx-auto mb-8 leading-relaxed">
                Welcome to Quantum Mentor World. Search our secure archive of open-source software, public domain ebooks, legal video embeds, online sandbox tools, and developer assets.
            </p>

            <!-- 2. Search Bar Section (AJAX Integrated) -->
            <div class="search-container max-w-xl mx-auto relative">
                <form role="search" method="get" class="flex items-center relative" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <label class="sr-only" for="quantum-search-input">Search resources...</label>
                    <input type="search" id="quantum-search-input" class="w-full bg-[#0F172A] border border-white/10 rounded-xl px-5 py-3.5 text-sm text-white focus:outline-none focus:border-[#00D4FF] placeholder-[#94A3B8] transition-all" placeholder="Search software, tools, books, repos..." value="" name="s" autocomplete="off">
                    <button type="submit" class="absolute right-2 px-4 py-2 bg-gradient-to-r from-[#00D4FF] to-[#7C3AED] text-[#0F172A] text-xs font-bold rounded-lg hover:opacity-90 transition-opacity">Search</button>
                </form>
                <!-- AJAX Live Search results container -->
                <div id="ajax-search-results" class="search-results-dropdown"></div>
            </div>
        </div>
    </section>

    <!-- 3. Featured Categories Grid -->
    <section class="featured-categories-section">
        <h2 class="font-display text-xl font-bold text-white mb-6 flex items-center space-x-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#00D4FF]"></span>
            <span>Featured Categories</span>
        </h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php 
            $categories_cards = array(
                array( 'title' => 'Software', 'desc' => 'PC, Mac, Linux & Mobile', 'slug' => 'software', 'color' => 'border-[#00D4FF]' ),
                array( 'title' => 'Developer Tools', 'desc' => 'Instant Web Apps', 'slug' => 'tools', 'color' => 'border-[#7C3AED]' ),
                array( 'title' => 'E-Books', 'desc' => 'Public Domain Library', 'slug' => 'books', 'color' => 'border-[#22C55E]' ),
                array( 'title' => 'GitHub Repos', 'desc' => 'Open Source Repos', 'slug' => 'github-repos', 'color' => 'border-slate-500' ),
            );
            foreach ( $categories_cards as $cat ) :
            ?>
            <a href="<?php echo esc_url( home_url( '/' . $cat['slug'] . '/' ) ); ?>" class="glass-card p-6 border-l-4 <?php echo esc_attr($cat['color']); ?> hover:bg-[#1E293B]/60">
                <h3 class="font-display font-bold text-white text-md mb-1"><?php echo esc_html( $cat['title'] ); ?></h3>
                <p class="text-[11px] text-[#94A3B8]"><?php echo esc_html( $cat['desc'] ); ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- 4. Latest Software -->
    <section class="latest-software-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-white flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#00D4FF]"></span>
                <span>Latest Software Downloads</span>
            </h2>
            <a href="<?php echo esc_url( home_url( '/software/' ) ); ?>" class="text-xs text-[#00D4FF] hover:underline font-semibold font-display">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $software_query = new WP_Query( array( 'post_type' => 'software', 'posts_per_page' => 3 ) );
            if ( $software_query->have_posts() ) :
                while ( $software_query->have_posts() ) : $software_query->the_post();
                    get_template_part( 'template-parts/card', 'software' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs text-slate-400 col-span-full">No software registered yet.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- 5. Latest Tools -->
    <section class="latest-tools-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-white flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#7C3AED]"></span>
                <span>Web-Based Tools</span>
            </h2>
            <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="text-xs text-[#7C3AED] hover:underline font-semibold font-display">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $tools_query = new WP_Query( array( 'post_type' => 'tools', 'posts_per_page' => 3 ) );
            if ( $tools_query->have_posts() ) :
                while ( $tools_query->have_posts() ) : $tools_query->the_post();
                    get_template_part( 'template-parts/card', 'default' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs text-slate-400 col-span-full">No online tools registered yet.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- 6. Latest Books -->
    <section class="latest-books-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-white flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#22C55E]"></span>
                <span>Featured Open Books</span>
            </h2>
            <a href="<?php echo esc_url( home_url( '/books/' ) ); ?>" class="text-xs text-[#22C55E] hover:underline font-semibold font-display">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $books_query = new WP_Query( array( 'post_type' => 'books', 'posts_per_page' => 3 ) );
            if ( $books_query->have_posts() ) :
                while ( $books_query->have_posts() ) : $books_query->the_post();
                    get_template_part( 'template-parts/card', 'default' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs text-slate-400 col-span-full">No books registered yet.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- 7. Watch Content Section -->
    <section class="latest-watch-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-white flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#7C3AED]"></span>
                <span>Watch Courses & Videos</span>
            </h2>
            <a href="<?php echo esc_url( home_url( '/watch/' ) ); ?>" class="text-xs text-[#7C3AED] hover:underline font-semibold font-display">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $watch_query = new WP_Query( array( 'post_type' => 'watch', 'posts_per_page' => 3 ) );
            if ( $watch_query->have_posts() ) :
                while ( $watch_query->have_posts() ) : $watch_query->the_post();
                    get_template_part( 'template-parts/card', 'watch' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs text-slate-400 col-span-full">No media content registered yet.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- 8. GitHub Repositories Section -->
    <section class="latest-repos-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-white flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#00D4FF]"></span>
                <span>Open-Source GitHub Repositories</span>
            </h2>
            <a href="<?php echo esc_url( home_url( '/github-repos/' ) ); ?>" class="text-xs text-[#00D4FF] hover:underline font-semibold font-display">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $repos_query = new WP_Query( array( 'post_type' => 'github_repos', 'posts_per_page' => 3 ) );
            if ( $repos_query->have_posts() ) :
                while ( $repos_query->have_posts() ) : $repos_query->the_post();
                    get_template_part( 'template-parts/card', 'repo' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs text-slate-400 col-span-full">No GitHub repositories registered yet.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- 9. Latest News -->
    <section class="latest-news-section">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-display text-xl font-bold text-white flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                <span>AI & Tech News</span>
            </h2>
            <a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="text-xs text-slate-400 hover:underline font-semibold font-display">View All →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            $news_query = new WP_Query( array( 'post_type' => 'news', 'posts_per_page' => 3 ) );
            if ( $news_query->have_posts() ) :
                while ( $news_query->have_posts() ) : $news_query->the_post();
                    get_template_part( 'template-parts/card', 'default' );
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs text-slate-400 col-span-full">No news articles registered yet.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- 10. Popular Resources -->
    <section class="popular-resources-section">
        <h2 class="font-display text-xl font-bold text-white mb-6 flex items-center space-x-2">
            <span class="w-2.5 h-2.5 rounded-full bg-[#22C55E]"></span>
            <span>Popular Resources</span>
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            // Querying popular resources based on comment count across CPTs
            $popular_query = new WP_Query( array(
                'post_type'      => array( 'software', 'tools', 'watch', 'github_repos' ),
                'posts_per_page' => 3,
                'orderby'        => 'comment_count',
                'order'          => 'DESC',
            ) );
            if ( $popular_query->have_posts() ) :
                while ( $popular_query->have_posts() ) : $popular_query->the_post();
                    // Load respective template part based on post type
                    $post_type = get_post_type();
                    if ( in_array( $post_type, array( 'software', 'watch', 'github_repos' ) ) ) {
                        get_template_part( 'template-parts/card', $post_type );
                    } else {
                        get_template_part( 'template-parts/card', 'default' );
                    }
                endwhile;
                wp_reset_postdata();
            else :
                echo '<p class="text-xs text-slate-400 col-span-full">No popular resources found.</p>';
            endif;
            ?>
        </div>
    </section>

    <!-- 11. Newsletter Section -->
    <section class="newsletter-section">
        <div class="glass-card p-8 md:p-12 text-center rounded-2xl max-w-4xl mx-auto relative overflow-hidden border border-white/10">
            <div class="absolute -top-12 -right-12 w-48 h-48 bg-[#00D4FF]/5 rounded-full blur-2xl pointer-events-none"></div>
            
            <h2 class="font-display text-2xl md:text-3xl font-bold text-white mb-3">Stay Updated on Safe Releases</h2>
            <p class="text-xs md:text-sm text-[#94A3B8] max-w-lg mx-auto mb-8">
                Subscribe to receive weekly newsletters listing newly verified legal open-source software, learning courses, and tools. No spam, ever.
            </p>

            <form class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto" action="#" method="POST">
                <input type="email" placeholder="Enter your email address" required class="flex-1 bg-[#0F172A] border border-white/10 rounded-xl px-4 py-3 text-xs focus:outline-none focus:border-[#00D4FF] placeholder-[#94A3B8]">
                <button type="submit" class="neon-btn text-xs py-3 px-6">Subscribe</button>
            </form>
        </div>
    </section>

</main>

<?php get_footer(); ?>
