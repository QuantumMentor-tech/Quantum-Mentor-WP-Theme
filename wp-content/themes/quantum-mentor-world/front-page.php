<?php
/**
 * The template for displaying the front page / homepage
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header(); ?>

<div class="homepage-wrapper" style="display: flex; flex-direction: column; width: 100%;">
    
    <!-- 1. Hero Banner Zone -->
    <?php get_template_part( 'template-parts/sections/hero' ); ?>

    <!-- 2. Grid Categories Explorer Links -->
    <?php get_template_part( 'template-parts/sections/category-explorer' ); ?>

    <!-- 3. Curated Featured Resources -->
    <?php get_template_part( 'template-parts/sections/featured-resources' ); ?>

    <!-- 4. Latest Software CPT List -->
    <?php get_template_part( 'template-parts/sections/latest-software' ); ?>

    <!-- 5. Latest Online Tools CPT List -->
    <?php get_template_part( 'template-parts/sections/latest-tools' ); ?>

    <!-- 6. Latest Books & Guides CPT List -->
    <?php get_template_part( 'template-parts/sections/latest-books' ); ?>

    <!-- 7. Watch Courses & Streaming CPT List -->
    <?php get_template_part( 'template-parts/sections/watch-content' ); ?>

    <!-- 8. GitHub Repositories CPT List -->
    <?php get_template_part( 'template-parts/sections/github-repos' ); ?>

    <!-- 9. AI & Tech News Articles List -->
    <?php get_template_part( 'template-parts/sections/latest-news' ); ?>

    <!-- 10. Trending & Popular Resources Section -->
    <?php get_template_part( 'template-parts/sections/trending-resources' ); ?>

    <!-- 11. Email Newsletter Subscription -->
    <?php get_template_part( 'template-parts/sections/newsletter' ); ?>

    <!-- 12. Main CTA exploring banner -->
    <?php get_template_part( 'template-parts/sections/home-cta' ); ?>

</div>

<?php get_footer(); ?>
