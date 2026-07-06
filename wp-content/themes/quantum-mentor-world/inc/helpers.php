<?php
/**
 * Global Helper functions and dynamically injected schemas
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * 1. Safe Embed URL Helper
 *
 * Canonical definition is in inc/acf-fields.php (loaded before this file).
 * That version accepts a raw video URL (YouTube, Vimeo, Dailymotion, or any
 * direct embed URL) and returns a sanitised <iframe> HTML string.
 *
 * The old version here accepted pre-built iframe HTML strings and sanitised them.
 * The new version is more useful for the theme's ACF field workflow where
 * admins store raw URLs (not iframe code) in custom fields.
 *
 * If for any reason acf-fields.php is skipped, this fallback ensures the function
 * is still available, accepting a URL and returning a basic iframe.
 */
if ( ! function_exists( 'quantum_get_safe_embed' ) ) {
    function quantum_get_safe_embed( $url ) {
        if ( empty( $url ) ) {
            return '';
        }
        return sprintf(
            '<iframe src="%s" width="100%%" height="100%%" frameborder="0" allowfullscreen loading="lazy" title="Embed" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>',
            esc_url( $url )
        );
    }
}


/**
 * 2. Dynamic JSON-LD Schema Generator
 */
function quantum_mentor_world_render_json_ld_schema() {
    if ( ! is_singular() ) {
        return;
    }

    global $post;
    $post_id = $post->ID;
    $post_type = get_post_type($post_id);

    $schema = array();

    switch ( $post_type ) {
        case 'software':
            $version    = get_post_meta( $post_id, 'software_version', true );
            $license    = get_post_meta( $post_id, 'software_license', true );
            $platforms  = get_post_meta( $post_id, 'software_platform', true );
            $developer  = get_post_meta( $post_id, 'software_developer', true );
            $file_size  = get_post_meta( $post_id, 'software_size', true );
            $dl_url     = get_post_meta( $post_id, 'software_download_url', true );
            $operating_system = is_array( $platforms ) ? implode( ', ', $platforms ) : $platforms;

            $schema = array(
                '@context'            => 'https://schema.org',
                '@type'               => 'SoftwareApplication',
                'name'                => get_the_title( $post_id ),
                'operatingSystem'     => ! empty( $operating_system ) ? esc_html( $operating_system ) : 'Windows, macOS, Linux, Android, iOS',
                'applicationCategory' => 'EducationalApplication',
                'softwareVersion'     => ! empty( $version ) ? esc_html( $version ) : '1.0.0',
                'offers'              => array(
                    '@type'         => 'Offer',
                    'price'         => '0.00',
                    'priceCurrency' => 'USD',
                ),
            );
            if ( ! empty( $developer ) ) {
                $schema['author'] = array(
                    '@type' => 'Organization',
                    'name'  => esc_html( $developer ),
                );
            }
            if ( ! empty( $file_size ) ) {
                $schema['fileSize'] = esc_html( $file_size );
            }
            if ( ! empty( $dl_url ) ) {
                $schema['downloadUrl'] = esc_url( $dl_url );
            }
            break;

        case 'themes_plugins':
            $version   = get_post_meta( $post_id, 'tp_version', true );
            $developer = get_post_meta( $post_id, 'tp_developer', true );
            $license   = get_post_meta( $post_id, 'tp_license', true );
            $platform  = get_post_meta( $post_id, 'tp_platform', true );
            $type      = get_post_meta( $post_id, 'tp_type', true );
            $dl_url    = get_post_meta( $post_id, 'tp_download_url', true );

            $schema = array(
                '@context'            => 'https://schema.org',
                '@type'               => 'SoftwareApplication',
                'name'                => get_the_title( $post_id ),
                'operatingSystem'     => ! empty( $platform ) ? esc_html( $platform ) : 'WordPress, Shopify, Blogger',
                'applicationCategory' => ( strtolower($type) === 'plugin' || strtolower($type) === 'extension' ) ? 'BusinessApplication' : 'DesignApplication',
                'softwareVersion'     => ! empty( $version ) ? esc_html( $version ) : '1.0.0',
                'offers'              => array(
                    '@type'         => 'Offer',
                    'price'         => '0.00',
                    'priceCurrency' => 'USD',
                ),
            );
            if ( ! empty( $developer ) ) {
                $schema['author'] = array(
                    '@type' => 'Organization',
                    'name'  => esc_html( $developer ),
                );
            }
            if ( ! empty( $dl_url ) ) {
                $schema['downloadUrl'] = esc_url( $dl_url );
            }
            break;

        case 'watch':
            $release_year = get_post_meta( $post_id, 'watch_release_year_field', true );
            $genre_val    = get_post_meta( $post_id, 'watch_genre_field', true );
            if ( empty( $genre_val ) ) {
                $genre_terms  = wp_get_post_terms( $post_id, 'watch_genre', array( 'fields' => 'names' ) );
                $genre_val    = ! is_wp_error( $genre_terms ) && ! empty( $genre_terms ) ? implode( ', ', $genre_terms ) : 'Educational';
            }

            $watch_type = get_post_meta( $post_id, 'watch_type', true );
            $embed_url  = '';
            if ( in_array( $watch_type, array( 'Course', 'Anime', 'Donghua', 'Tutorial' ) ) ) {
                // For serialized content, attempt to grab the first episode's primary server
                $episodes = get_post_meta( $post_id, 'watch_episodes', true );
                if ( ! empty( $episodes ) && is_array( $episodes ) && ! empty( $episodes[0]['server_1_url'] ) ) {
                    $embed_url = $episodes[0]['server_1_url'];
                }
            } else {
                $embed_url = get_post_meta( $post_id, 'watch_srv1_url', true );
            }

            $schema = array(
                '@context'    => 'https://schema.org',
                '@type'       => 'VideoObject',
                'name'        => get_the_title( $post_id ),
                'description' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
                'thumbnailUrl'=> get_the_post_thumbnail_url( $post_id, 'large' ) ?: ( get_post_meta( $post_id, 'watch_poster', true ) ? wp_get_attachment_url( get_post_meta( $post_id, 'watch_poster', true ) ) : '' ),
                'uploadDate'  => get_the_date( 'c', $post_id ),
                'genre'       => esc_html( $genre_val ),
            );
            if ( ! empty( $release_year ) ) {
                $schema['dateCreated'] = esc_html( $release_year );
            }
            if ( ! empty( $embed_url ) ) {
                $schema['embedUrl'] = esc_url( $embed_url );
            }
            break;

        case 'books':
            $b_author = get_post_meta( $post_id, 'book_author_field', true );
            if ( empty( $b_author ) ) {
                $author_terms = wp_get_post_terms( $post_id, 'book_tag', array( 'fields' => 'names' ) );
                $b_author     = ! is_wp_error( $author_terms ) && ! empty( $author_terms ) ? $author_terms[0] : 'Educational Mentor';
            }
            $b_publisher = get_post_meta( $post_id, 'book_publisher', true );
            $b_pub_year  = get_post_meta( $post_id, 'book_pub_year', true );
            $b_lang      = get_post_meta( $post_id, 'book_language_field', true );
            $b_pages     = get_post_meta( $post_id, 'book_pages_count', true );
            $b_url       = get_post_meta( $post_id, 'book_official_url', true );

            $schema = array(
                '@context' => 'https://schema.org',
                '@type'    => 'Book',
                'name'     => get_the_title( $post_id ),
                'author'   => array(
                    '@type' => 'Person',
                    'name'  => esc_html( $b_author ),
                ),
                'bookFormat' => 'https://schema.org/EBook',
            );
            if ( ! empty( $b_publisher ) ) {
                $schema['publisher'] = array(
                    '@type' => 'Organization',
                    'name'  => esc_html( $b_publisher ),
                );
            }
            if ( ! empty( $b_pub_year ) ) {
                $schema['datePublished'] = esc_html( $b_pub_year );
            }
            if ( ! empty( $b_lang ) ) {
                $schema['inLanguage'] = esc_html( $b_lang );
            }
            if ( ! empty( $b_pages ) ) {
                $schema['numberOfPages'] = intval( $b_pages );
            }
            if ( ! empty( $b_url ) ) {
                $schema['sameAs'] = esc_url( $b_url );
            }
            break;

        case 'games':
            $g_developer  = get_post_meta( $post_id, 'game_developer', true );
            $g_genre      = get_post_meta( $post_id, 'game_genre_field', true );
            $g_platforms  = get_post_meta( $post_id, 'game_platform', true );
            $g_version    = get_post_meta( $post_id, 'game_version', true );
            $g_license    = get_post_meta( $post_id, 'game_license', true );
            $g_dl_url     = get_post_meta( $post_id, 'game_download_url', true );
            $g_official   = get_post_meta( $post_id, 'game_official_url', true );
            $g_os         = is_array( $g_platforms ) ? implode( ', ', $g_platforms ) : $g_platforms;

            $schema = array(
                '@context'            => 'https://schema.org',
                '@type'               => 'VideoGame',
                'name'                => get_the_title( $post_id ),
                'description'         => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
                'url'                 => get_permalink( $post_id ),
                'image'               => get_the_post_thumbnail_url( $post_id, 'large' ) ?: '',
                'applicationCategory' => 'Game',
                'offers'              => array(
                    '@type'         => 'Offer',
                    'price'         => 0,
                    'priceCurrency' => 'USD',
                    'availability'  => 'https://schema.org/InStock',
                ),
            );
            if ( ! empty( $g_developer ) ) {
                $schema['author'] = array(
                    '@type' => 'Organization',
                    'name'  => esc_html( $g_developer ),
                );
            }
            if ( ! empty( $g_genre ) ) {
                $schema['genre'] = esc_html( $g_genre );
            }
            if ( ! empty( $g_os ) ) {
                $schema['operatingSystem'] = esc_html( $g_os );
            }
            if ( ! empty( $g_version ) ) {
                $schema['softwareVersion'] = esc_html( $g_version );
            }
            if ( ! empty( $g_dl_url ) ) {
                $schema['downloadUrl'] = esc_url( $g_dl_url );
            }
            if ( ! empty( $g_official ) ) {
                $schema['sameAs'] = esc_url( $g_official );
            }
            if ( ! empty( $g_license ) ) {
                $schema['license'] = esc_html( $g_license );
            }
            break;

        case 'github_repos':
            $repo_url   = get_post_meta( $post_id, 'repo_github_url', true );
            $lang       = get_post_meta( $post_id, 'repo_language_field', true );
            $license    = get_post_meta( $post_id, 'repo_license_field', true );
            $owner      = get_post_meta( $post_id, 'repo_owner_name', true );
            $short_desc = get_post_meta( $post_id, 'repo_short_description', true ) ?: get_the_excerpt( $post_id );

            $schema = array(
                '@context'            => 'https://schema.org',
                '@type'               => 'SoftwareSourceCode',
                'name'                => get_the_title( $post_id ),
                'description'         => wp_strip_all_tags( $short_desc ),
                'programmingLanguage' => esc_html( $lang ?: 'PHP' ),
            );
            if ( ! empty( $repo_url ) ) {
                $schema['codeRepository'] = esc_url( $repo_url );
            }
            if ( ! empty( $license ) ) {
                $schema['license'] = esc_html( $license );
            }
            if ( ! empty( $owner ) ) {
                $schema['author'] = array(
                    '@type' => 'Organization',
                    'name'  => esc_html( $owner ),
                );
            }
            break;

        case 'news':
            $news_title   = get_post_meta( $post_id, 'news_title', true ) ?: get_the_title( $post_id );
            $news_summary = get_post_meta( $post_id, 'news_summary', true ) ?: get_the_excerpt( $post_id );
            $news_date    = get_post_meta( $post_id, 'news_date', true ) ?: get_the_date( 'Y-m-d', $post_id );
            $news_author  = get_post_meta( $post_id, 'news_author_name', true ) ?: get_the_author_meta( 'display_name', $post->post_author );
            $src_name     = get_post_meta( $post_id, 'news_source_name_field', true );
            $src_url      = get_post_meta( $post_id, 'news_source_url_field', true );

            $schema = array(
                '@context'         => 'https://schema.org',
                '@type'            => 'NewsArticle',
                'headline'         => esc_html( $news_title ),
                'description'      => wp_strip_all_tags( $news_summary ),
                'datePublished'    => esc_html( $news_date ),
                'mainEntityOfPage' => get_permalink( $post_id ),
                'author'           => array(
                    '@type' => 'Person',
                    'name'  => esc_html( $news_author ),
                ),
            );

            // Featured Image
            if ( has_post_thumbnail( $post_id ) ) {
                $schema['image'] = array(
                    '@type' => 'ImageObject',
                    'url'   => get_the_post_thumbnail_url( $post_id, 'large' ),
                );
            }

            // Original Source Attribution
            if ( ! empty( $src_name ) ) {
                $schema['publisher'] = array(
                    '@type' => 'Organization',
                    'name'  => esc_html( $src_name ),
                );
                if ( ! empty( $src_url ) ) {
                    $schema['publisher']['sameAs'] = esc_url( $src_url );
                }
            }
            break;


        case 'tools':
            $tool_type   = get_post_meta( $post_id, 'tool_type_field', true );
            $access_type = get_post_meta( $post_id, 'tool_access_type', true );
            $tool_url    = get_post_meta( $post_id, 'tool_url', true );
            $dl_url      = get_post_meta( $post_id, 'tool_download_url', true );

            $schema_type = 'WebApplication';
            if ( $access_type === 'Downloadable Tool' ) {
                $schema_type = 'SoftwareApplication';
            }

            $schema = array(
                '@context'            => 'https://schema.org',
                '@type'               => $schema_type,
                'name'                => get_the_title( $post_id ),
                'description'         => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
                'applicationCategory' => esc_html( $tool_type ?: 'Utility' ),
            );

            // Thumbnail/Icon
            $icon_id = get_post_meta( $post_id, 'tool_icon', true );
            if ( ! empty( $icon_id ) ) {
                $schema['image'] = wp_get_attachment_url( $icon_id );
            } elseif ( has_post_thumbnail( $post_id ) ) {
                $schema['image'] = get_the_post_thumbnail_url( $post_id, 'large' );
            }

            if ( $schema_type === 'WebApplication' && ! empty( $tool_url ) ) {
                $schema['url'] = esc_url( $tool_url );
            } elseif ( $schema_type === 'SoftwareApplication' ) {
                if ( ! empty( $dl_url ) ) {
                    $schema['downloadUrl'] = esc_url( $dl_url );
                }
                if ( ! empty( $tool_url ) ) {
                    $schema['installUrl'] = esc_url( $tool_url );
                }
            }

            // Offers
            $schema['offers'] = array(
                '@type'         => 'Offer',
                'price'         => 0,
                'priceCurrency' => 'USD',
                'availability'  => 'https://schema.org/InStock',
            );
            break;
    }

    if ( ! empty( $schema ) ) {
        echo "\n" . '<script type="application/ld+json">' . json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'quantum_mentor_world_render_json_ld_schema' );

/**
 * 3. AJAX Live Search Handler
 *    Handles the 'quantum_live_search' AJAX action called from main.js.
 *    Returns JSON array of matching posts across all 8 CPTs.
 */
function quantum_mentor_world_ajax_live_search() {
    // 1. Verify nonce for security
    if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'quantum_search_nonce' ) ) {
        wp_send_json_error( array( 'message' => 'Invalid nonce.' ), 403 );
    }

    // 2. Sanitize & validate query
    $query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';
    if ( strlen( $query ) < 2 ) {
        wp_send_json_error( array( 'message' => 'Query too short.' ), 400 );
    }

    // 3. Post type human-readable labels
    $type_labels = array(
        'software'       => 'Software',
        'themes_plugins' => 'Theme / Plugin',
        'games'          => 'Game',
        'books'          => 'Book',
        'watch'          => 'Watch',
        'tools'          => 'Tool',
        'news'           => 'News',
        'github_repos'   => 'GitHub Repo',
        'post'           => 'Article',
        'page'           => 'Page',
    );

    // 4. Run search across all CPTs
    $search_args = array(
        'post_type'      => array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'news', 'github_repos', 'post' ),
        'post_status'    => 'publish',
        's'              => $query,
        'posts_per_page' => 10,
        'no_found_rows'  => true, // performance: skip counting total rows
    );

    $search_query = new WP_Query( $search_args );
    $results      = array();

    if ( $search_query->have_posts() ) {
        while ( $search_query->have_posts() ) {
            $search_query->the_post();
            $post_type      = get_post_type();
            $thumbnail_url  = get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' );

            // Fallback thumbnail per type
            if ( ! $thumbnail_url ) {
                $fallback_map = array(
                    'software'       => '💻',
                    'themes_plugins' => '🎨',
                    'games'          => '🎮',
                    'books'          => '📚',
                    'watch'          => '🎬',
                    'tools'          => '⚙️',
                    'news'           => '📰',
                    'github_repos'   => '🐙',
                );
                $thumbnail_url = ''; // Use emoji fallback in JS
            }

            $results[] = array(
                'title'     => get_the_title(),
                'url'       => get_permalink(),
                'type'      => isset( $type_labels[ $post_type ] ) ? $type_labels[ $post_type ] : ucfirst( $post_type ),
                'thumbnail' => $thumbnail_url,
            );
        }
        wp_reset_postdata();
    }

    wp_send_json_success( $results );
}
// Register for both logged-in and logged-out users
add_action( 'wp_ajax_quantum_live_search',        'quantum_mentor_world_ajax_live_search' );
add_action( 'wp_ajax_nopriv_quantum_live_search', 'quantum_mentor_world_ajax_live_search' );

/**
 * 4. Template Auto-Routing for Login, Register, Profile, and Submit Resource Pages
 */
function qmw_auto_route_frontend_templates( $template ) {
    global $wp_query;

    if ( is_admin() ) {
        return $template;
    }

    // Clean request URI to extract relative slug
    $request = trim( parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' );
    
    // Support subdirectory WordPress installations
    $site_path = trim( parse_url( home_url(), PHP_URL_PATH ), '/' );
    if ( ! empty( $site_path ) ) {
        if ( strpos( $request, $site_path ) === 0 ) {
            $request = trim( substr( $request, strlen( $site_path ) ), '/' );
        }
    }

    $parts = explode( '/', $request );
    $slug = $parts[0] ?? '';

    $custom_templates = array(
        'login'           => 'page-login.php',
        'register'        => 'page-register.php',
        'profile'         => 'page-profile.php',
        'submit-resource' => 'page-submit-resource.php',
        'sitemap'         => 'page-sitemap.php',
    );

    if ( array_key_exists( $slug, $custom_templates ) ) {
        $custom_file = QMW_THEME_DIR . '/' . $custom_templates[ $slug ];
        if ( file_exists( $custom_file ) ) {
            status_header( 200 );
            $wp_query->is_404 = false;
            $wp_query->is_page = true;
            $wp_query->is_singular = true;
            return $custom_file;
        }
    }

    return $template;
}
add_filter( 'template_include', 'qmw_auto_route_frontend_templates' );


