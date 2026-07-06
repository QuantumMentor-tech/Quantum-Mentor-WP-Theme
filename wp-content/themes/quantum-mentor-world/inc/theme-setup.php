<?php
/**
 * Theme Setup and support features registration
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function quantum_mentor_world_setup() {
    // 1. Title Tag Support
    add_theme_support( 'title-tag' );

    // 2. Post Thumbnails
    add_theme_support( 'post-thumbnails' );

    // 3. Custom Logo Support (Use existing logo design)
    add_theme_support( 'custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // 4. HTML5 markup support
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // 5. Automatic feed links
    add_theme_support( 'automatic-feed-links' );

    // 6. Register Navigation Menus
    register_nav_menus( array(
        'primary_menu' => esc_html__( 'Primary Menu', 'quantum-mentor-world' ),
        'footer_menu'  => esc_html__( 'Footer Menu', 'quantum-mentor-world' ),
        'legal_menu'   => esc_html__( 'Legal Menu', 'quantum-mentor-world' ),
        'social_menu'  => esc_html__( 'Social Menu', 'quantum-mentor-world' ),
    ) );
}
add_action( 'after_setup_theme', 'quantum_mentor_world_setup' );

/**
 * Add theme-specific classes to the body classes.
 */
function quantum_mentor_world_body_classes( $classes ) {
    // Determine theme from cookie or default to dark
    $theme = isset( $_COOKIE['qmw_theme'] ) ? $_COOKIE['qmw_theme'] : 'dark';
    if ( ! in_array( $theme, array( 'dark', 'light' ) ) ) {
        $theme = 'dark';
    }
    $classes[] = 'qmw-' . $theme;
    return $classes;
}
add_filter( 'body_class', 'quantum_mentor_world_body_classes' );

/**
 * Handle custom filters and sorting parameters on the Software CPT archive page
 */
function quantum_mentor_world_software_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( is_post_type_archive( 'software' ) || is_tax( array( 'software_category', 'software_tag' ) ) ) {
        // Force post type to software
        $query->set( 'post_type', 'software' );

        // 1. Taxonomy Category Filter
        if ( ! empty( $_GET['category'] ) ) {
            $category_slug = sanitize_text_field( $_GET['category'] );
            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => 'software_category',
                    'field'    => 'slug',
                    'terms'    => $category_slug,
                ),
            ) );
        }

        // 2. Custom Meta Queries
        $meta_query = array();

        // Platform filter
        if ( ! empty( $_GET['platform'] ) ) {
            $platform = sanitize_text_field( $_GET['platform'] );
            $platform_map = array(
                'windows' => 'Windows',
                'mac'     => 'Mac',
                'linux'   => 'Linux',
                'android' => 'Android',
                'iphone'  => 'iPhone',
            );
            if ( isset( $platform_map[ strtolower( $platform ) ] ) ) {
                $meta_query[] = array(
                    'key'     => 'software_platform',
                    'value'   => $platform_map[ strtolower( $platform ) ],
                    'compare' => 'LIKE',
                );
            }
        }

        // License filter
        if ( ! empty( $_GET['license'] ) ) {
            $license = sanitize_text_field( $_GET['license'] );
            $license_map = array(
                'open-source'   => 'Open Source',
                'freeware'      => 'Freeware',
                'freemium'      => 'Freemium',
                'trial'         => 'Trial',
                'paid-official' => 'Paid Official Link',
                'public-domain' => 'Public Domain',
            );
            if ( isset( $license_map[ strtolower( $license ) ] ) ) {
                $meta_query[] = array(
                    'key'     => 'software_license',
                    'value'   => $license_map[ strtolower( $license ) ],
                    'compare' => '=',
                );
            }
        }

        if ( ! empty( $meta_query ) ) {
            $query->set( 'meta_query', $meta_query );
        }

        // 3. Sorting
        $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
        switch ( $sort ) {
            case 'popular':
                $query->set( 'orderby', 'comment_count' );
                $query->set( 'order', 'DESC' );
                break;
            case 'featured':
                // Featured first by meta key 'admin_priority' sorting F (Featured) -> N (Normal) -> P (Popular) -> T (Trending)
                // In our ACF: Choices are 'Normal', 'Featured', 'Trending', 'Popular'.
                // To display 'Featured' first, we query Featured posts at the top by meta query or custom sort.
                // We'll set the meta key and sort by meta value ASC so 'Featured' (F) comes before 'Normal' (N).
                $query->set( 'meta_key', 'admin_priority' );
                $query->set( 'orderby', array(
                    'meta_value' => 'ASC',
                    'date'       => 'DESC'
                ) );
                break;
            case 'a-z':
                $query->set( 'orderby', 'title' );
                $query->set( 'order', 'ASC' );
                break;
            case 'latest':
            default:
                $query->set( 'orderby', 'date' );
                $query->set( 'order', 'DESC' );
                break;
        }

        // 4. Custom Software Search parameter
        if ( ! empty( $_GET['software_search'] ) ) {
            $query->set( 's', sanitize_text_field( $_GET['software_search'] ) );
        }
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_software_archive_query' );

/**
 * Handle custom filters and sorting parameters on the Themes & Plugins CPT archive page
 */
function quantum_mentor_world_themes_plugins_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( is_post_type_archive( 'themes_plugins' ) || is_tax( array( 'theme_plugin_category', 'theme_plugin_tag' ) ) ) {
        // Force post type to themes_plugins
        $query->set( 'post_type', 'themes_plugins' );

        // 1. Taxonomy Category Filter
        if ( ! empty( $_GET['category'] ) ) {
            $category_slug = sanitize_text_field( $_GET['category'] );
            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => 'theme_plugin_category',
                    'field'    => 'slug',
                    'terms'    => $category_slug,
                ),
            ) );
        }

        // 2. Custom Meta Queries
        $meta_query = array();

        // Platform filter
        if ( ! empty( $_GET['platform'] ) ) {
            $platform = sanitize_text_field( $_GET['platform'] );
            $platform_map = array(
                'wordpress'   => 'WordPress',
                'woocommerce' => 'WooCommerce',
                'shopify'     => 'Shopify',
                'hostinger'   => 'Hostinger',
                'godaddy'     => 'GoDaddy',
                'blogger'     => 'Blogger',
            );
            if ( isset( $platform_map[ strtolower( $platform ) ] ) ) {
                $meta_query[] = array(
                    'key'     => 'tp_platform',
                    'value'   => $platform_map[ strtolower( $platform ) ],
                    'compare' => '=',
                );
            }
        }

        // Type filter
        if ( ! empty( $_GET['type'] ) ) {
            $type = sanitize_text_field( $_GET['type'] );
            $type_map = array(
                'theme'     => 'Theme',
                'plugin'    => 'Plugin',
                'template'  => 'Template',
                'extension' => 'Extension',
                'app'       => 'App',
            );
            if ( isset( $type_map[ strtolower( $type ) ] ) ) {
                $meta_query[] = array(
                    'key'     => 'tp_type',
                    'value'   => $type_map[ strtolower( $type ) ],
                    'compare' => '=',
                );
            }
        }

        // License filter
        if ( ! empty( $_GET['license'] ) ) {
            $license = sanitize_text_field( $_GET['license'] );
            $license_map = array(
                'free'          => 'Free',
                'open-source'   => 'Open Source',
                'gpl'           => 'GPL',
                'freemium'      => 'Freemium',
                'paid-official' => 'Paid Official Link',
            );
            if ( isset( $license_map[ strtolower( $license ) ] ) ) {
                $meta_query[] = array(
                    'key'     => 'tp_license',
                    'value'   => $license_map[ strtolower( $license ) ],
                    'compare' => '=',
                );
            }
        }

        if ( ! empty( $meta_query ) ) {
            $query->set( 'meta_query', $meta_query );
        }

        // 3. Sorting
        $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
        switch ( $sort ) {
            case 'popular':
                $query->set( 'orderby', 'comment_count' );
                $query->set( 'order', 'DESC' );
                break;
            case 'featured':
                // Featured first by meta key 'admin_priority'
                $query->set( 'meta_key', 'admin_priority' );
                $query->set( 'orderby', array(
                    'meta_value' => 'ASC',
                    'date'       => 'DESC'
                ) );
                break;
            case 'a-z':
                $query->set( 'orderby', 'title' );
                $query->set( 'order', 'ASC' );
                break;
            case 'latest':
            default:
                $query->set( 'orderby', 'date' );
                $query->set( 'order', 'DESC' );
                break;
        }

        // 4. Custom Search parameter
        if ( ! empty( $_GET['tp_search'] ) ) {
            $query->set( 's', sanitize_text_field( $_GET['tp_search'] ) );
        }
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_themes_plugins_archive_query' );


/**
 * Handle custom filters and sorting parameters on the Games CPT archive page.
 *
 * Supported GET params:
 *   platform    — windows | mac | linux | android | iphone | browser | web
 *   genre       — action | adventure | puzzle | racing | strategy | simulation | educational | open-source
 *   license     — freeware | open-source | demo | freemium | paid-official | public-domain
 *   sort        — latest (default) | featured | popular | a-z
 *   game_search — free-text search
 */
function quantum_mentor_world_games_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! is_post_type_archive( 'games' ) && ! is_tax( array( 'game_category', 'game_tag' ) ) ) {
        return;
    }

    // Posts per page
    $query->set( 'posts_per_page', 18 );

    // ----- Platform filter -----
    if ( ! empty( $_GET['platform'] ) ) {
        $platform_map = array(
            'windows' => 'Windows',
            'mac'     => 'Mac',
            'linux'   => 'Linux',
            'android' => 'Android',
            'iphone'  => 'iPhone',
            'browser' => 'Browser',
            'web'     => 'Web',
        );
        $slug = sanitize_text_field( $_GET['platform'] );
        if ( isset( $platform_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'game_platform',
                'value'   => $platform_map[ $slug ],
                'compare' => 'LIKE',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Genre filter -----
    if ( ! empty( $_GET['genre'] ) ) {
        $genre_map = array(
            'action'      => 'Action',
            'adventure'   => 'Adventure',
            'puzzle'      => 'Puzzle',
            'racing'      => 'Racing',
            'strategy'    => 'Strategy',
            'simulation'  => 'Simulation',
            'educational' => 'Educational',
            'open-source' => 'Open Source',
        );
        $slug = sanitize_text_field( $_GET['genre'] );
        if ( isset( $genre_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'game_genre_field',
                'value'   => $genre_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- License filter -----
    if ( ! empty( $_GET['license'] ) ) {
        $license_map = array(
            'freeware'      => 'Freeware',
            'open-source'   => 'Open Source',
            'demo'          => 'Demo',
            'freemium'      => 'Freemium',
            'paid-official' => 'Paid Official Link',
            'public-domain' => 'Public Domain',
        );
        $slug = sanitize_text_field( $_GET['license'] );
        if ( isset( $license_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'game_license',
                'value'   => $license_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Sorting -----
    $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
    switch ( $sort ) {
        case 'popular':
            $query->set( 'orderby', 'comment_count' );
            $query->set( 'order', 'DESC' );
            break;
        case 'featured':
            $query->set( 'meta_key', 'admin_priority' );
            $query->set( 'orderby', array(
                'meta_value' => 'ASC',
                'date'       => 'DESC',
            ) );
            break;
        case 'a-z':
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'ASC' );
            break;
        case 'latest':
        default:
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' );
            break;
    }

    // ----- Free-text search -----
    if ( ! empty( $_GET['game_search'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['game_search'] ) );
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_games_archive_query' );


/**
 * Handle custom filters and sorting parameters on the Books CPT archive page.
 *
 * Supported GET params:
 *   category    — programming | ai | business | freelancing | science | novels | history | educational | marketing | religious
 *   type        — free | public-domain | open-access | creative-commons | paid-official
 *   format      — pdf | epub | mobi | docx | online-read | audio
 *   language    — english | urdu | arabic | spanish | french | german | chinese | hindi | other
 *   sort        — latest (default) | featured | popular | a-z
 *   book_search — free-text search
 */
function quantum_mentor_world_books_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! is_post_type_archive( 'books' ) && ! is_tax( array( 'book_category', 'book_tag' ) ) ) {
        return;
    }

    // Set posts per page
    $query->set( 'posts_per_page', 24 );

    // ----- Category filter -----
    if ( ! empty( $_GET['category'] ) ) {
        $category_slug = sanitize_text_field( $_GET['category'] );
        $query->set( 'tax_query', array(
            array(
                'taxonomy' => 'book_category',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        ) );
    }

    // ----- Type filter -----
    if ( ! empty( $_GET['type'] ) ) {
        $type_map = array(
            'free'             => 'Free',
            'public-domain'    => 'Public Domain',
            'open-access'      => 'Open Access',
            'creative-commons' => 'Creative Commons',
            'paid-official'    => 'Paid Official Link',
        );
        $slug = sanitize_text_field( $_GET['type'] );
        if ( isset( $type_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'book_type',
                'value'   => $type_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Format filter -----
    if ( ! empty( $_GET['format'] ) ) {
        $format_map = array(
            'pdf'         => 'PDF',
            'epub'        => 'EPUB',
            'mobi'        => 'MOBI',
            'docx'        => 'DOCX',
            'online-read' => 'Online Read',
            'audio'       => 'Audio',
        );
        $slug = sanitize_text_field( $_GET['format'] );
        if ( isset( $format_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'book_format',
                'value'   => $format_map[ $slug ],
                'compare' => 'LIKE',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Language filter -----
    if ( ! empty( $_GET['language'] ) ) {
        $lang_map = array(
            'english' => 'English',
            'urdu'    => 'Urdu',
            'arabic'  => 'Arabic',
            'spanish' => 'Spanish',
            'french'  => 'French',
            'german'  => 'German',
            'chinese' => 'Chinese',
            'hindi'   => 'Hindi',
            'other'   => 'Other',
        );
        $slug = sanitize_text_field( $_GET['language'] );
        if ( isset( $lang_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'book_language_field',
                'value'   => $lang_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Sorting -----
    $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
    switch ( $sort ) {
        case 'popular':
            $query->set( 'orderby', 'comment_count' );
            $query->set( 'order', 'DESC' );
            break;
        case 'featured':
            $query->set( 'meta_key', 'admin_priority' );
            $query->set( 'orderby', array(
                'meta_value' => 'ASC',
                'date'       => 'DESC',
            ) );
            break;
        case 'a-z':
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'ASC' );
            break;
        case 'latest':
        default:
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' );
            break;
    }

    // ----- Free-text search -----
    if ( ! empty( $_GET['book_search'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['book_search'] ) );
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_books_archive_query' );


/**
 * ============================================================
 * 8. NAVIGATION MENU FALLBACKS
 * ============================================================
 */

// Desktop Horizontal Fallbacks for Navigation links
if ( ! function_exists( 'quantum_mentor_world_desktop_fallback_menu' ) ) {
    function quantum_mentor_world_desktop_fallback_menu() {
        $nav_items = array(
            ''               => 'Home',
            'software'       => 'Software',
            'themes-plugins' => 'Themes & Plugins',
            'games'          => 'Games',
            'news'           => 'News',
            'tools'          => 'Tools',
            'books'          => 'Books',
            'watch'          => 'Watch',
            'github-repos'   => 'GitHub Repos',
        );

        foreach ( $nav_items as $slug => $label ) :
            $url = empty( $slug ) ? home_url( '/' ) : home_url( '/' . $slug . '/' );
            $is_active = empty( $slug ) ? is_front_page() : ( is_post_type_archive( str_replace('-', '_', $slug) ) || ( get_query_var( 'post_type' ) === str_replace('-', '_', $slug) ) );
            $active_class = $is_active ? 'active' : '';
        ?>
        <a href="<?php echo esc_url( $url ); ?>" class="nav-link <?php echo $active_class; ?>">
            <?php echo esc_html( $label ); ?>
        </a>
        <?php 
        endforeach;
    }
}

// Fallback Mobile links
if ( ! function_exists( 'quantum_mentor_world_mobile_fallback_menu' ) ) {
    function quantum_mentor_world_mobile_fallback_menu() {
        $nav_items = array(
            ''               => 'Home',
            'software'       => 'Software',
            'themes-plugins' => 'Themes & Plugins',
            'games'          => 'Games',
            'news'           => 'News',
            'tools'          => 'Tools',
            'books'          => 'Books',
            'watch'          => 'Watch',
            'github-repos'   => 'GitHub Repos',
        );

        foreach ( $nav_items as $slug => $label ) :
            $url = empty( $slug ) ? home_url( '/' ) : home_url( '/' . $slug . '/' );
            $is_active = empty( $slug ) ? is_front_page() : ( is_post_type_archive( str_replace('-', '_', $slug) ) || ( get_query_var( 'post_type' ) === str_replace('-', '_', $slug) ) );
        ?>
        <a href="<?php echo esc_url( $url ); ?>" class="nav-link" style="display: block; padding: var(--space-2) var(--space-4); border-radius: var(--radius-sm); font-size: 15px; <?php echo $is_active ? 'color: var(--primary); background-color: rgba(0, 212, 255, 0.05);' : ''; ?>">
            <?php echo esc_html( $label ); ?>
        </a>
        <?php 
        endforeach;
    }
}

// Fallbacks for Footer Menu Quick links
if ( ! function_exists( 'quantum_mentor_world_footer_fallback_menu' ) ) {
    function quantum_mentor_world_footer_fallback_menu() {
        $footer_items = array(
            ''             => 'Home',
            'software'     => 'Software',
            'tools'        => 'Tools',
            'books'        => 'Books',
            'watch'        => 'Watch',
            'news'         => 'News',
        );

        foreach ( $footer_items as $slug => $label ) :
            $url = empty( $slug ) ? home_url( '/' ) : home_url( '/' . $slug . '/' );
        ?>
        <li><a href="<?php echo esc_url( $url ); ?>" class="footer-link"><?php echo esc_html( $label ); ?></a></li>
        <?php
        endforeach;
    }
}

// Fallback menus for footer legal links
if ( ! function_exists( 'quantum_mentor_world_legal_fallback_menu' ) ) {
    function quantum_mentor_world_legal_fallback_menu() {
        ?>
        <li><a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" class="footer-link"><?php esc_html_e( 'About Us', 'quantum-mentor-world' ); ?></a></li>
        <li><a href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>" class="footer-link"><?php esc_html_e( 'Contact Us', 'quantum-mentor-world' ); ?></a></li>
        <li><a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>" class="footer-link"><?php esc_html_e( 'Disclaimer', 'quantum-mentor-world' ); ?></a></li>
        <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="footer-link"><?php esc_html_e( 'Privacy Policy', 'quantum-mentor-world' ); ?></a></li>
        <?php
    }
}

// Fallback menus for footer social links
if ( ! function_exists( 'quantum_mentor_world_social_fallback_menu' ) ) {
    function quantum_mentor_world_social_fallback_menu() {
        $socials = array(
            'youtube'   => 'YouTube',
            'facebook'  => 'Facebook',
            'tiktok'    => 'TikTok',
            'instagram' => 'Instagram',
            'whatsapp'  => 'WhatsApp',
            'telegram'  => 'Telegram',
            'github'    => 'GitHub',
        );

        foreach ( $socials as $slug => $label ) :
        ?>
        <a href="#" class="social-btn" title="<?php echo esc_attr( $label ); ?>" target="_blank" rel="noopener noreferrer">
            <?php echo esc_html( $label ); ?>
        </a>
        <?php 
        endforeach;
    }
}

/**
 * Handle custom filters and sorting parameters on the Watch CPT archive page.
 *
 * Supported GET params:
 *   type         — movie | course | anime | donghua | tutorial | documentary
 *   genre        — education | technology | ai | programming | business | entertainment | history | science
 *   language     — english | urdu | hindi | arabic | japanese | chinese | other
 *   status       — ongoing | completed | upcoming
 *   sort         — latest (default) | featured | popular | a-z
 *   watch_search — free-text search
 */
function quantum_mentor_world_watch_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! is_post_type_archive( 'watch' ) && ! is_tax( array( 'watch_category', 'watch_tag' ) ) ) {
        return;
    }

    // Set posts per page
    $query->set( 'posts_per_page', 12 );

    // ----- Content Type filter -----
    if ( ! empty( $_GET['type'] ) ) {
        $type_map = array(
            'movie'       => 'Movie',
            'course'      => 'Course',
            'anime'       => 'Anime',
            'donghua'     => 'Donghua',
            'tutorial'    => 'Tutorial',
            'documentary' => 'Documentary',
        );
        $slug = sanitize_text_field( $_GET['type'] );
        if ( isset( $type_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'watch_type',
                'value'   => $type_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Genre filter -----
    if ( ! empty( $_GET['genre'] ) ) {
        $genre_map = array(
            'education'     => 'Education',
            'technology'    => 'Technology',
            'ai'            => 'AI',
            'programming'   => 'Programming',
            'business'      => 'Business',
            'entertainment' => 'Entertainment',
            'history'       => 'History',
            'science'       => 'Science',
        );
        $slug = sanitize_text_field( $_GET['genre'] );
        if ( isset( $genre_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'watch_genre_field',
                'value'   => $genre_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Language filter -----
    if ( ! empty( $_GET['language'] ) ) {
        $lang_map = array(
            'english'  => 'English',
            'urdu'     => 'Urdu',
            'hindi'    => 'Hindi',
            'arabic'   => 'Arabic',
            'japanese' => 'Japanese',
            'chinese'  => 'Chinese',
            'other'    => 'Other',
        );
        $slug = sanitize_text_field( $_GET['language'] );
        if ( isset( $lang_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'watch_language_field',
                'value'   => $lang_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Status filter -----
    if ( ! empty( $_GET['status'] ) ) {
        $status_map = array(
            'ongoing'   => 'Ongoing',
            'completed' => 'Completed',
            'upcoming'  => 'Upcoming',
        );
        $slug = sanitize_text_field( $_GET['status'] );
        if ( isset( $status_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'watch_status_field',
                'value'   => $status_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Sorting -----
    $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
    switch ( $sort ) {
        case 'popular':
            $query->set( 'orderby', 'comment_count' );
            $query->set( 'order', 'DESC' );
            break;
        case 'featured':
            $query->set( 'meta_key', 'admin_priority' );
            $query->set( 'orderby', array(
                'meta_value' => 'ASC',
                'date'       => 'DESC',
            ) );
            break;
        case 'a-z':
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'ASC' );
            break;
        case 'latest':
        default:
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' );
            break;
    }

    // ----- Free-text search -----
    if ( ! empty( $_GET['watch_search'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['watch_search'] ) );
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_watch_archive_query' );

/**
 * Handle custom filters and sorting parameters on the Tools CPT archive page.
 *
 * Supported GET params:
 *   category     — file-converter | pdf-tools | image-tools | video-tools | text-tools | ai-tools | seo-tools | developer-tools
 *   access       — built-in-tool | external-tool | downloadable-tool | browser-extension
 *   sort         — latest (default) | featured | popular | a-z
 *   tools_search — free-text search
 */
function quantum_mentor_world_tools_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! is_post_type_archive( 'tools' ) && ! is_tax( array( 'tool_category', 'tool_tag' ) ) ) {
        return;
    }

    // Set posts per page
    $query->set( 'posts_per_page', 12 );

    // ----- Category Taxonomy filter -----
    if ( ! empty( $_GET['category'] ) ) {
        $category_slug = sanitize_text_field( $_GET['category'] );
        $query->set( 'tax_query', array(
            array(
                'taxonomy' => 'tool_category',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        ) );
    }

    // ----- Access Type filter -----
    if ( ! empty( $_GET['access'] ) ) {
        $access_map = array(
            'built-in-tool'     => 'Built-in Tool',
            'external-tool'     => 'External Tool',
            'downloadable-tool' => 'Downloadable Tool',
            'browser-extension' => 'Browser Extension',
        );
        $slug = sanitize_text_field( $_GET['access'] );
        if ( isset( $access_map[ $slug ] ) ) {
            $existing_meta = $query->get( 'meta_query' ) ?: array();
            $existing_meta[] = array(
                'key'     => 'tool_access_type',
                'value'   => $access_map[ $slug ],
                'compare' => '=',
            );
            $query->set( 'meta_query', $existing_meta );
        }
    }

    // ----- Sorting -----
    $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
    switch ( $sort ) {
        case 'popular':
            $query->set( 'orderby', 'comment_count' );
            $query->set( 'order', 'DESC' );
            break;
        case 'featured':
            $query->set( 'meta_key', 'admin_priority' );
            $query->set( 'orderby', array(
                'meta_value' => 'ASC',
                'date'       => 'DESC',
            ) );
            break;
        case 'a-z':
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'ASC' );
            break;
        case 'latest':
        default:
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' );
            break;
    }

    // ----- Free-text search -----
    if ( ! empty( $_GET['tools_search'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['tools_search'] ) );
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_tools_archive_query' );

/**
 * Handle custom filters and sorting parameters on the News CPT archive page.
 *
 * Supported GET params:
 *   category    — news-category slugs
 *   sort        — latest (default) | popular | featured | a-z
 *   news_search — keyword search query
 */
function quantum_mentor_world_news_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! $query->is_post_type_archive( 'news' ) && ! $query->is_tax( array( 'news_category', 'news_tag' ) ) ) {
        return;
    }

    // Set posts per page
    $query->set( 'posts_per_page', 9 );

    // ----- Category Taxonomy filter -----
    if ( ! empty( $_GET['category'] ) ) {
        $category_slug = sanitize_text_field( $_GET['category'] );
        $query->set( 'tax_query', array(
            array(
                'taxonomy' => 'news_category',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        ) );
    }

    // ----- Sorting -----
    $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
    switch ( $sort ) {
        case 'popular':
            $query->set( 'orderby', 'comment_count' );
            $query->set( 'order', 'DESC' );
            break;
        case 'featured':
            $query->set( 'meta_key', 'admin_priority' );
            $query->set( 'orderby', array(
                'meta_value' => 'ASC',
                'date'       => 'DESC',
            ) );
            break;
        case 'a-z':
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'ASC' );
            break;
        case 'latest':
        default:
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' );
            break;
    }

    // ----- Free-text search -----
    if ( ! empty( $_GET['news_search'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['news_search'] ) );
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_news_archive_query' );

/**
 * Handle custom filters and sorting parameters on the GitHub Repos CPT archive page.
 *
 * Supported GET params:
 *   category    — repo-category slugs
 *   language    — programming language meta field matches (e.g. Python, JavaScript)
 *   difficulty  — difficulty level meta field matches (e.g. Beginner, Intermediate, Advanced)
 *   license     — license type meta field matches (e.g. MIT, Apache 2.0)
 *   sort        — latest (default) | popular | featured | stars | forks | a-z
 *   repo_search — keyword search query
 */
function quantum_mentor_world_github_repos_archive_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    if ( ! $query->is_post_type_archive( 'github_repos' ) && ! $query->is_tax( array( 'repo_category', 'repo_tag' ) ) ) {
        return;
    }

    // Set posts per page
    $query->set( 'posts_per_page', 9 );

    $meta_query = array( 'relation' => 'AND' );

    // ----- Category Taxonomy filter -----
    if ( ! empty( $_GET['category'] ) ) {
        $category_slug = sanitize_text_field( $_GET['category'] );
        $query->set( 'tax_query', array(
            array(
                'taxonomy' => 'repo_category',
                'field'    => 'slug',
                'terms'    => $category_slug,
            ),
        ) );
    }

    // ----- Language Meta filter -----
    if ( ! empty( $_GET['language'] ) ) {
        $meta_query[] = array(
            'key'     => 'repo_language_field',
            'value'   => sanitize_text_field( $_GET['language'] ),
            'compare' => '=',
        );
    }

    // ----- Difficulty Meta filter -----
    if ( ! empty( $_GET['difficulty'] ) ) {
        $meta_query[] = array(
            'key'     => 'repo_difficulty',
            'value'   => sanitize_text_field( $_GET['difficulty'] ),
            'compare' => '=',
        );
    }

    // ----- License Meta filter -----
    if ( ! empty( $_GET['license'] ) ) {
        $meta_query[] = array(
            'key'     => 'repo_license_field',
            'value'   => sanitize_text_field( $_GET['license'] ),
            'compare' => '=',
        );
    }

    if ( count( $meta_query ) > 1 ) {
        $query->set( 'meta_query', $meta_query );
    }

    // ----- Sorting -----
    $sort = ! empty( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
    switch ( $sort ) {
        case 'popular':
            $query->set( 'orderby', 'comment_count' );
            $query->set( 'order', 'DESC' );
            break;
        case 'stars':
            $query->set( 'meta_key', 'repo_stars_count' );
            $query->set( 'orderby', 'meta_value_num' );
            $query->set( 'order', 'DESC' );
            break;
        case 'forks':
            $query->set( 'meta_key', 'repo_forks_count' );
            $query->set( 'orderby', 'meta_value_num' );
            $query->set( 'order', 'DESC' );
            break;
        case 'featured':
            $query->set( 'meta_key', 'admin_priority' );
            $query->set( 'orderby', array(
                'meta_value' => 'ASC',
                'date'       => 'DESC',
            ) );
            break;
        case 'a-z':
            $query->set( 'orderby', 'title' );
            $query->set( 'order', 'ASC' );
            break;
        case 'latest':
        default:
            $query->set( 'orderby', 'date' );
            $query->set( 'order', 'DESC' );
            break;
    }

    // ----- Free-text search -----
    if ( ! empty( $_GET['repo_search'] ) ) {
        $query->set( 's', sanitize_text_field( $_GET['repo_search'] ) );
    }
}
add_action( 'pre_get_posts', 'quantum_mentor_world_github_repos_archive_query' );





