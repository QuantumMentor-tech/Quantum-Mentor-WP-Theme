<?php
/**
 * Quantum Mentor World — SEO Integration, Schemas & robots.txt
 *
 * Configures programmatic Rank Math integrations and standalone metadata fallbacks
 * (Open Graph, Twitter Cards, Canonical URLs, sitemaps, robots.txt, and schemas).
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// 1. DYNAMIC ROBOTS.TXT
// ============================================================
add_filter( 'robots_txt', 'qmw_dynamic_robots_rules', 10, 2 );

function qmw_dynamic_robots_rules( $output, $public ) {
    $site_url = esc_url( home_url( '/' ) );
    
    $rules = "User-agent: *\n";
    $rules .= "Disallow: /wp-admin/\n";
    $rules .= "Disallow: /wp-includes/\n";
    $rules .= "Disallow: /xmlrpc.php\n";
    $rules .= "Allow: /wp-admin/admin-ajax.php\n\n";
    
    // Add sitemap reference
    $rules .= "Sitemap: {$site_url}sitemap_index.xml\n";
    $rules .= "Sitemap: {$site_url}sitemap/ (HTML Sitemap)\n";

    return $output . $rules;
}

// ============================================================
// 2. META FALLBACK LAYER (For Non-Rank Math Environments)
// ============================================================
add_action( 'wp_head', 'qmw_render_seo_meta_tags', 2 );

function qmw_render_seo_meta_tags() {
    // If Rank Math or Yoast is active, let them handle standard meta tags
    if ( class_exists( 'RankMath' ) || defined( 'WPSEO_VERSION' ) ) {
        return;
    }

    $seo_title = '';
    $seo_desc = '';
    $seo_keywords = '';
    $canonical_url = '';
    $og_image_url = '';

    if ( is_front_page() || is_home() ) {
        $seo_title = 'Quantum Mentor World | Software, Books, AI Tools, GitHub Repositories & Learning Resources';
        $seo_desc = 'Explore legal software, books, AI tools, GitHub repositories, educational resources, technology news, and digital learning content at Quantum Mentor World.';
        $seo_keywords = 'Software Downloads, AI Tools, Educational Resources, GitHub Repositories, Learning Platform';
        $canonical_url = home_url( '/' );
        
        $logo_id = get_theme_mod( 'custom_logo' );
        if ( $logo_id ) {
            $og_image_url = wp_get_attachment_image_url( $logo_id, 'full' );
        } else {
            $og_image_url = get_template_directory_uri() . '/Quantum Mentor logo design.png';
        }
    } elseif ( is_singular() ) {
        $post_id = get_the_ID();
        $seo_title = get_post_meta( $post_id, 'seo_title', true ) ?: get_the_title();
        $seo_desc = get_post_meta( $post_id, 'seo_meta_description', true ) ?: wp_strip_all_tags( get_the_excerpt() );
        $seo_keywords = get_post_meta( $post_id, 'seo_focus_keyword', true );
        $canonical_url = get_post_meta( $post_id, 'seo_canonical_url', true ) ?: get_permalink();
        
        $og_image_id = get_post_meta( $post_id, 'seo_og_image', true );
        if ( $og_image_id ) {
            $og_image_url = wp_get_attachment_image_url( $og_image_id, 'full' );
        } elseif ( has_post_thumbnail( $post_id ) ) {
            $og_image_url = get_the_post_thumbnail_url( $post_id, 'full' );
        }
    } else {
        $seo_title = wp_title( '|', false, 'right' ) . get_bloginfo( 'name' );
        $seo_desc = get_bloginfo( 'description' );
        $canonical_url = home_url( $_SERVER['REQUEST_URI'] );
    }

    // Output basic tags
    printf( "<title>%s</title>\n", esc_html( $seo_title ) );
    if ( ! empty( $seo_desc ) ) {
        printf( "<meta name=\"description\" content=\"%s\">\n", esc_attr( $seo_desc ) );
    }
    if ( ! empty( $seo_keywords ) ) {
        printf( "<meta name=\"keywords\" content=\"%s\">\n", esc_attr( $seo_keywords ) );
    }
    printf( "<link rel=\"canonical\" href=\"%s\">\n", esc_url( $canonical_url ) );

    // Open Graph Tags
    printf( "<meta property=\"og:title\" content=\"%s\">\n", esc_attr( $seo_title ) );
    if ( ! empty( $seo_desc ) ) {
        printf( "<meta property=\"og:description\" content=\"%s\">\n", esc_attr( $seo_desc ) );
    }
    printf( "<meta property=\"og:type\" content=\"%s\">\n", is_singular() ? 'article' : 'website' );
    printf( "<meta property=\"og:url\" content=\"%s\">\n", esc_url( $canonical_url ) );
    if ( ! empty( $og_image_url ) ) {
        printf( "<meta property=\"og:image\" content=\"%s\">\n", esc_url( $og_image_url ) );
    }

    // Twitter Card Tags
    echo "<meta name=\"twitter:card\" content=\"summary_large_image\">\n";
    printf( "<meta name=\"twitter:title\" content=\"%s\">\n", esc_attr( $seo_title ) );
    if ( ! empty( $seo_desc ) ) {
        printf( "<meta name=\"twitter:description\" content=\"%s\">\n", esc_attr( $seo_desc ) );
    }
    if ( ! empty( $og_image_url ) ) {
        printf( "<meta name=\"twitter:image\" content=\"%s\">\n", esc_url( $og_image_url ) );
    }
}

// Remove default wp_title / title-tag filters if fallback handles it
add_action( 'after_setup_theme', function() {
    if ( ! class_exists( 'RankMath' ) && ! defined( 'WPSEO_VERSION' ) ) {
        remove_action( 'wp_head', '_wp_render_title_tag', 1 );
    }
}, 20 );

// ============================================================
// 3. RANK MATH CONFIGURATION INTEGRATION
// ============================================================
// Hook to override Rank Math title and descriptions programmatically if needed
add_filter( 'rank_math/frontend/title', 'qmw_rank_math_title_override' );
function qmw_rank_math_title_override( $title ) {
    if ( is_front_page() || is_home() ) {
        return 'Quantum Mentor World | Software, Books, AI Tools, GitHub Repositories & Learning Resources';
    }
    return $title;
}

add_filter( 'rank_math/frontend/description', 'qmw_rank_math_description_override' );
function qmw_rank_math_description_override( $desc ) {
    if ( is_front_page() || is_home() ) {
        return 'Explore legal software, books, AI tools, GitHub repositories, educational resources, technology news, and digital learning content at Quantum Mentor World.';
    }
    return $desc;
}

// ============================================================
// 4. PROGRAMMATIC SCHEMA GENERATION (JSON-LD)
// ============================================================
add_action( 'wp_head', 'qmw_render_custom_json_ld_schemas', 90 );

function qmw_render_custom_json_ld_schemas() {
    global $post;

    // A. WebSite & Organization Schema for Homepage
    if ( is_front_page() || is_home() ) {
        $logo_url = get_template_directory_uri() . '/Quantum Mentor logo design.png';
        
        $website_schema = array(
            '@context' => 'https://schema.org',
            '@type'    => 'WebSite',
            'name'     => get_bloginfo( 'name' ),
            'url'      => esc_url( home_url( '/' ) ),
            'potentialAction' => array(
                '@type'       => 'SearchAction',
                'target'      => esc_url( home_url( '/' ) ) . '?s={search_term_string}',
                'query-input' => 'required name=search_term_string'
            )
        );

        $org_schema = array(
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => get_bloginfo( 'name' ),
            'url'      => esc_url( home_url( '/' ) ),
            'logo'     => esc_url( $logo_url ),
            'sameAs'   => array(
                // Put social link handles here if configured in theme menus
            )
        );

        echo '<script type="application/ld+json">' . json_encode( $website_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
        echo '<script type="application/ld+json">' . json_encode( $org_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }

    // B. Books Schema
    if ( is_singular( 'books' ) && ! empty( $post ) ) {
        $author = get_post_meta( $post->ID, 'book_author_field', true ) ?: 'Unknown Author';
        $format = get_post_meta( $post->ID, 'book_format', true );
        $formats = is_array( $format ) ? implode( ', ', $format ) : $format;
        
        $book_schema = array(
            '@context'      => 'https://schema.org',
            '@type'         => 'Book',
            'name'          => get_the_title( $post->ID ),
            'author'        => array(
                '@type' => 'Person',
                'name'  => esc_html( $author )
            ),
            'bookFormat'    => esc_html( $formats ?: 'EBook' ),
            'publisher'     => esc_html( get_post_meta( $post->ID, 'book_publisher', true ) ?: get_bloginfo( 'name' ) ),
            'datePublished' => esc_html( get_post_meta( $post->ID, 'book_pub_year', true ) ?: get_the_date( 'Y', $post->ID ) ),
            'description'   => wp_strip_all_tags( get_the_excerpt( $post->ID ) ),
        );

        if ( has_post_thumbnail( $post->ID ) ) {
            $book_schema['image'] = get_the_post_thumbnail_url( $post->ID, 'full' );
        }

        echo '<script type="application/ld+json">' . json_encode( $book_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }

    // C. Watch Content (VideoObject Schema)
    if ( is_singular( 'watch' ) && ! empty( $post ) ) {
        $type = get_post_meta( $post->ID, 'watch_type', true );
        $url1 = get_post_meta( $post->ID, 'watch_srv1_url', true ) ?: get_permalink( $post->ID );
        $poster_id = get_post_meta( $post->ID, 'watch_poster', true );
        $poster_url = $poster_id ? wp_get_attachment_url( $poster_id ) : get_the_post_thumbnail_url( $post->ID, 'full' );

        $video_schema = array(
            '@context'     => 'https://schema.org',
            '@type'        => 'VideoObject',
            'name'         => get_the_title( $post->ID ),
            'description'  => wp_strip_all_tags( get_the_excerpt( $post->ID ) ),
            'thumbnailUrl' => esc_url( $poster_url ?: home_url( '/wp-content/uploads/fallback.jpg' ) ),
            'uploadDate'   => get_the_date( 'c', $post->ID ),
            'embedUrl'     => esc_url( $url1 ),
        );

        echo '<script type="application/ld+json">' . json_encode( $video_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }

    // D. Breadcrumb sitewide schema
    if ( ! is_front_page() && ! is_home() && ! empty( $post ) ) {
        $crumbs = array();
        
        $crumbs[] = array(
            '@type'    => 'ListItem',
            'position' => 1,
            'name'     => 'Home',
            'item'     => esc_url( home_url( '/' ) )
        );

        $position = 2;

        if ( is_singular() ) {
            $post_type = get_post_type( $post->ID );
            $post_type_obj = get_post_type_object( $post_type );
            
            if ( $post_type_obj && $post_type_obj->has_archive ) {
                $crumbs[] = array(
                    '@type'    => 'ListItem',
                    'position' => $position,
                    'name'     => $post_type_obj->labels->name,
                    'item'     => esc_url( get_post_type_archive_link( $post_type ) )
                );
                $position++;
            }

            $crumbs[] = array(
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => get_the_title( $post->ID ),
                'item'     => esc_url( get_permalink( $post->ID ) )
            );
        } elseif ( is_archive() ) {
            $crumbs[] = array(
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => post_type_archive_title( '', false ),
                'item'     => esc_url( home_url( $_SERVER['REQUEST_URI'] ) )
            );
        }

        $breadcrumb_schema = array(
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $crumbs
        );

        echo '<script type="application/ld+json">' . json_encode( $breadcrumb_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }
}
