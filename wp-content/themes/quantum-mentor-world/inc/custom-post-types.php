<?php
/**
 * Quantum Mentor World — Custom Post Types, Taxonomies & Category Seeding
 *
 * Registers all 8 CPTs, 16 taxonomies, and pre-seeds every taxonomy
 * with the exact category terms required by the platform specification.
 *
 * CPT Slugs (URL-facing):
 *   software, themes-plugins, games, books, watch, tools, news, github-repos
 *
 * @package Quantum_Mentor_World
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// 1. REGISTER CUSTOM POST TYPES
// ============================================================

/**
 * Register all 8 Custom Post Types.
 *
 * Each CPT supports:
 *  - title, editor, excerpt, featured image, author, comments
 *  - custom-fields (required for ACF meta storage)
 *  - revisions (content history)
 *  - has_archive   → archive page at /{slug}/
 *  - show_in_rest  → Gutenberg block editor + REST API
 *  - search support via 'publicly_queryable' => true
 *  - SEO plugin compatibility via public + show_in_sitemap
 */
function qmw_register_cpts() {

    $cpts = array(

        // 1. Software
        'software' => array(
            'labels' => array(
                'name'                  => 'Software',
                'singular_name'         => 'Software',
                'menu_name'             => 'Software',
                'name_admin_bar'        => 'Software',
                'add_new'               => 'Add New Software',
                'add_new_item'          => 'Add New Software',
                'new_item'              => 'New Software',
                'edit_item'             => 'Edit Software',
                'view_item'             => 'View Software',
                'all_items'             => 'All Software',
                'search_items'          => 'Search Software',
                'not_found'             => 'No software found.',
                'not_found_in_trash'    => 'No software found in Trash.',
                'featured_image'        => 'Software Icon / Logo',
                'set_featured_image'    => 'Set Software Icon',
                'remove_featured_image' => 'Remove Software Icon',
                'archives'              => 'Software Archive',
                'insert_into_item'      => 'Insert into software page',
                'uploaded_to_this_item' => 'Uploaded to this software',
            ),
            'menu_icon'     => 'dashicons-desktop',
            'rewrite_slug'  => 'software',
            'menu_position' => 5,
        ),

        // 2. Themes & Plugins
        'themes_plugins' => array(
            'labels' => array(
                'name'                  => 'Themes & Plugins',
                'singular_name'         => 'Theme & Plugin',
                'menu_name'             => 'Themes & Plugins',
                'name_admin_bar'        => 'Theme & Plugin',
                'add_new'               => 'Add New',
                'add_new_item'          => 'Add New Theme or Plugin',
                'new_item'              => 'New Theme / Plugin',
                'edit_item'             => 'Edit Theme / Plugin',
                'view_item'             => 'View Theme / Plugin',
                'all_items'             => 'All Themes & Plugins',
                'search_items'          => 'Search Themes & Plugins',
                'not_found'             => 'No themes or plugins found.',
                'not_found_in_trash'    => 'No themes or plugins found in Trash.',
                'featured_image'        => 'Theme / Plugin Cover Image',
                'set_featured_image'    => 'Set Cover Image',
                'remove_featured_image' => 'Remove Cover Image',
                'archives'              => 'Themes & Plugins Directory',
                'insert_into_item'      => 'Insert into item page',
                'uploaded_to_this_item' => 'Uploaded to this item',
            ),
            'menu_icon'     => 'dashicons-admin-plugins',
            'rewrite_slug'  => 'themes-plugins',
            'menu_position' => 6,
        ),

        // 3. Games
        'games' => array(
            'labels' => array(
                'name'                  => 'Games',
                'singular_name'         => 'Game',
                'menu_name'             => 'Games',
                'name_admin_bar'        => 'Game',
                'add_new'               => 'Add New Game',
                'add_new_item'          => 'Add New Game',
                'new_item'              => 'New Game',
                'edit_item'             => 'Edit Game',
                'view_item'             => 'View Game',
                'all_items'             => 'All Games',
                'search_items'          => 'Search Games',
                'not_found'             => 'No games found.',
                'not_found_in_trash'    => 'No games found in Trash.',
                'featured_image'        => 'Game Cover Image',
                'set_featured_image'    => 'Set Game Cover',
                'remove_featured_image' => 'Remove Game Cover',
                'archives'              => 'Games Directory',
                'insert_into_item'      => 'Insert into game page',
                'uploaded_to_this_item' => 'Uploaded to this game',
            ),
            'menu_icon'     => 'dashicons-games',
            'rewrite_slug'  => 'games',
            'menu_position' => 7,
        ),

        // 4. Books
        'books' => array(
            'labels' => array(
                'name'                  => 'Books',
                'singular_name'         => 'Book',
                'menu_name'             => 'Books',
                'name_admin_bar'        => 'Book',
                'add_new'               => 'Add New Book',
                'add_new_item'          => 'Add New Book',
                'new_item'              => 'New Book',
                'edit_item'             => 'Edit Book',
                'view_item'             => 'View Book',
                'all_items'             => 'All Books',
                'search_items'          => 'Search Books',
                'not_found'             => 'No books found.',
                'not_found_in_trash'    => 'No books found in Trash.',
                'featured_image'        => 'Book Cover Image',
                'set_featured_image'    => 'Set Book Cover',
                'remove_featured_image' => 'Remove Book Cover',
                'archives'              => 'Books Library',
                'insert_into_item'      => 'Insert into book page',
                'uploaded_to_this_item' => 'Uploaded to this book',
            ),
            'menu_icon'     => 'dashicons-book-alt',
            'rewrite_slug'  => 'books',
            'menu_position' => 8,
        ),

        // 5. Watch Content
        'watch' => array(
            'labels' => array(
                'name'                  => 'Watch Content',
                'singular_name'         => 'Watch Item',
                'menu_name'             => 'Watch',
                'name_admin_bar'        => 'Watch Item',
                'add_new'               => 'Add New Content',
                'add_new_item'          => 'Add New Watch Content',
                'new_item'              => 'New Watch Item',
                'edit_item'             => 'Edit Watch Item',
                'view_item'             => 'View Watch Item',
                'all_items'             => 'All Watch Content',
                'search_items'          => 'Search Watch Content',
                'not_found'             => 'No watch content found.',
                'not_found_in_trash'    => 'No watch content found in Trash.',
                'featured_image'        => 'Poster Image',
                'set_featured_image'    => 'Set Poster Image',
                'remove_featured_image' => 'Remove Poster',
                'archives'              => 'Watch Content Library',
                'insert_into_item'      => 'Insert into watch page',
                'uploaded_to_this_item' => 'Uploaded to this watch item',
            ),
            'menu_icon'     => 'dashicons-video-alt3',
            'rewrite_slug'  => 'watch',
            'menu_position' => 9,
        ),

        // 6. Online Tools
        'tools' => array(
            'labels' => array(
                'name'                  => 'Online Tools',
                'singular_name'         => 'Tool',
                'menu_name'             => 'Tools',
                'name_admin_bar'        => 'Tool',
                'add_new'               => 'Add New Tool',
                'add_new_item'          => 'Add New Tool',
                'new_item'              => 'New Tool',
                'edit_item'             => 'Edit Tool',
                'view_item'             => 'View Tool',
                'all_items'             => 'All Tools',
                'search_items'          => 'Search Tools',
                'not_found'             => 'No tools found.',
                'not_found_in_trash'    => 'No tools found in Trash.',
                'featured_image'        => 'Tool Icon / Screenshot',
                'set_featured_image'    => 'Set Tool Icon',
                'remove_featured_image' => 'Remove Tool Icon',
                'archives'              => 'Tools Directory',
                'insert_into_item'      => 'Insert into tool page',
                'uploaded_to_this_item' => 'Uploaded to this tool',
            ),
            'menu_icon'     => 'dashicons-admin-tools',
            'rewrite_slug'  => 'tools',
            'menu_position' => 10,
        ),

        // 7. AI & Tech News
        'news' => array(
            'labels' => array(
                'name'                  => 'AI & Tech News',
                'singular_name'         => 'News Article',
                'menu_name'             => 'News',
                'name_admin_bar'        => 'News Article',
                'add_new'               => 'Add New Article',
                'add_new_item'          => 'Add New News Article',
                'new_item'              => 'New Article',
                'edit_item'             => 'Edit Article',
                'view_item'             => 'View Article',
                'all_items'             => 'All News Articles',
                'search_items'          => 'Search News',
                'not_found'             => 'No news articles found.',
                'not_found_in_trash'    => 'No news articles found in Trash.',
                'featured_image'        => 'News Cover Image',
                'set_featured_image'    => 'Set News Cover',
                'remove_featured_image' => 'Remove News Cover',
                'archives'              => 'News Archive',
                'insert_into_item'      => 'Insert into article',
                'uploaded_to_this_item' => 'Uploaded to this article',
            ),
            'menu_icon'     => 'dashicons-megaphone',
            'rewrite_slug'  => 'news',
            'menu_position' => 11,
        ),

        // 8. GitHub Repositories
        'github_repos' => array(
            'labels' => array(
                'name'                  => 'GitHub Repositories',
                'singular_name'         => 'GitHub Repo',
                'menu_name'             => 'GitHub Repos',
                'name_admin_bar'        => 'GitHub Repo',
                'add_new'               => 'Add New Repo',
                'add_new_item'          => 'Add New GitHub Repository',
                'new_item'              => 'New Repository',
                'edit_item'             => 'Edit Repository',
                'view_item'             => 'View Repository',
                'all_items'             => 'All GitHub Repos',
                'search_items'          => 'Search Repositories',
                'not_found'             => 'No repositories found.',
                'not_found_in_trash'    => 'No repositories found in Trash.',
                'featured_image'        => 'Repository Banner',
                'set_featured_image'    => 'Set Repository Banner',
                'remove_featured_image' => 'Remove Repository Banner',
                'archives'              => 'GitHub Repository Index',
                'insert_into_item'      => 'Insert into repo page',
                'uploaded_to_this_item' => 'Uploaded to this repo',
            ),
            'menu_icon'     => 'dashicons-networking',
            'rewrite_slug'  => 'github-repos',
            'menu_position' => 12,
        ),

    ); // end $cpts

    foreach ( $cpts as $post_type_key => $cpt ) {
        register_post_type(
            $post_type_key,
            array(
                'labels'             => $cpt['labels'],
                'public'             => true,
                'publicly_queryable' => true,
                'show_ui'            => true,
                'show_in_menu'       => true,
                'show_in_nav_menus'  => true,
                'show_in_admin_bar'  => true,
                'query_var'          => true,
                'rewrite'            => array(
                    'slug'       => $cpt['rewrite_slug'],
                    'with_front' => false,
                    'feeds'      => true,
                    'pages'      => true,
                ),
                'capability_type'    => 'post',
                'map_meta_cap'       => true,
                'has_archive'        => $cpt['rewrite_slug'], // archive at /{slug}/
                'hierarchical'       => false,
                'menu_position'      => $cpt['menu_position'],
                'menu_icon'          => $cpt['menu_icon'],
                'supports'           => array(
                    'title',
                    'editor',
                    'excerpt',
                    'thumbnail',      // featured image
                    'author',
                    'comments',
                    'revisions',
                    'custom-fields',  // required for ACF post meta storage
                ),
                'taxonomies'         => array(),
                'show_in_rest'       => true,  // Block Editor + REST API + WP CLI support
                'rest_base'          => $cpt['rewrite_slug'],
                'rest_controller_class' => 'WP_REST_Posts_Controller',
                'can_export'         => true,
                'delete_with_user'   => false,
            )
        );
    }
}
add_action( 'init', 'qmw_register_cpts', 0 );


// ============================================================
// 2. REGISTER CUSTOM TAXONOMIES
// ============================================================

/**
 * Register all 16 custom taxonomies (2 per CPT: Category + Tag).
 * All are hierarchical for Categories, flat for Tags.
 * All support REST API and show in admin column.
 */
function qmw_register_taxonomies() {

    $taxonomies = array(

        // ── Software ──────────────────────────────────────────
        'software_category' => array(
            'object_type'  => array( 'software' ),
            'single'       => 'Software Category',
            'plural'       => 'Software Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'software-category',
            'admin_column' => true,
        ),
        'software_tag' => array(
            'object_type'  => array( 'software' ),
            'single'       => 'Software Tag',
            'plural'       => 'Software Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'software-tag',
            'admin_column' => false,
        ),

        // ── Themes & Plugins ──────────────────────────────────
        'theme_plugin_category' => array(
            'object_type'  => array( 'themes_plugins' ),
            'single'       => 'Theme & Plugin Category',
            'plural'       => 'Theme & Plugin Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'theme-plugin-category',
            'admin_column' => true,
        ),
        'theme_plugin_tag' => array(
            'object_type'  => array( 'themes_plugins' ),
            'single'       => 'Theme & Plugin Tag',
            'plural'       => 'Theme & Plugin Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'theme-plugin-tag',
            'admin_column' => false,
        ),

        // ── Games ─────────────────────────────────────────────
        'game_category' => array(
            'object_type'  => array( 'games' ),
            'single'       => 'Game Category',
            'plural'       => 'Game Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'game-category',
            'admin_column' => true,
        ),
        'game_tag' => array(
            'object_type'  => array( 'games' ),
            'single'       => 'Game Tag',
            'plural'       => 'Game Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'game-tag',
            'admin_column' => false,
        ),

        // ── Books ─────────────────────────────────────────────
        'book_category' => array(
            'object_type'  => array( 'books' ),
            'single'       => 'Book Category',
            'plural'       => 'Book Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'book-category',
            'admin_column' => true,
        ),
        'book_tag' => array(
            'object_type'  => array( 'books' ),
            'single'       => 'Book Tag',
            'plural'       => 'Book Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'book-tag',
            'admin_column' => false,
        ),

        // ── Watch ─────────────────────────────────────────────
        'watch_category' => array(
            'object_type'  => array( 'watch' ),
            'single'       => 'Watch Category',
            'plural'       => 'Watch Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'watch-category',
            'admin_column' => true,
        ),
        'watch_tag' => array(
            'object_type'  => array( 'watch' ),
            'single'       => 'Watch Tag',
            'plural'       => 'Watch Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'watch-tag',
            'admin_column' => false,
        ),

        // ── Tools ─────────────────────────────────────────────
        'tool_category' => array(
            'object_type'  => array( 'tools' ),
            'single'       => 'Tool Category',
            'plural'       => 'Tool Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'tool-category',
            'admin_column' => true,
        ),
        'tool_tag' => array(
            'object_type'  => array( 'tools' ),
            'single'       => 'Tool Tag',
            'plural'       => 'Tool Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'tool-tag',
            'admin_column' => false,
        ),

        // ── News ──────────────────────────────────────────────
        'news_category' => array(
            'object_type'  => array( 'news' ),
            'single'       => 'News Category',
            'plural'       => 'News Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'news-category',
            'admin_column' => true,
        ),
        'news_tag' => array(
            'object_type'  => array( 'news' ),
            'single'       => 'News Tag',
            'plural'       => 'News Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'news-tag',
            'admin_column' => false,
        ),

        // ── GitHub Repos ──────────────────────────────────────
        'repo_category' => array(
            'object_type'  => array( 'github_repos' ),
            'single'       => 'Repo Category',
            'plural'       => 'Repo Categories',
            'hierarchical' => true,
            'rewrite_slug' => 'repo-category',
            'admin_column' => true,
        ),
        'repo_tag' => array(
            'object_type'  => array( 'github_repos' ),
            'single'       => 'Repo Tag',
            'plural'       => 'Repo Tags',
            'hierarchical' => false,
            'rewrite_slug' => 'repo-tag',
            'admin_column' => false,
        ),

    ); // end $taxonomies

    foreach ( $taxonomies as $taxonomy_key => $tax ) {
        $labels = array(
            'name'                       => _x( $tax['plural'], 'taxonomy general name', 'quantum-mentor-world' ),
            'singular_name'              => _x( $tax['single'], 'taxonomy singular name', 'quantum-mentor-world' ),
            'search_items'               => __( 'Search ' . $tax['plural'], 'quantum-mentor-world' ),
            'popular_items'              => $tax['hierarchical'] ? null : __( 'Popular ' . $tax['plural'], 'quantum-mentor-world' ),
            'all_items'                  => __( 'All ' . $tax['plural'], 'quantum-mentor-world' ),
            'parent_item'                => $tax['hierarchical'] ? __( 'Parent ' . $tax['single'], 'quantum-mentor-world' ) : null,
            'parent_item_colon'          => $tax['hierarchical'] ? __( 'Parent ' . $tax['single'] . ':', 'quantum-mentor-world' ) : null,
            'edit_item'                  => __( 'Edit ' . $tax['single'], 'quantum-mentor-world' ),
            'view_item'                  => __( 'View ' . $tax['single'], 'quantum-mentor-world' ),
            'update_item'                => __( 'Update ' . $tax['single'], 'quantum-mentor-world' ),
            'add_new_item'               => __( 'Add New ' . $tax['single'], 'quantum-mentor-world' ),
            'new_item_name'              => __( 'New ' . $tax['single'] . ' Name', 'quantum-mentor-world' ),
            'separate_items_with_commas' => $tax['hierarchical'] ? null : __( 'Separate ' . strtolower( $tax['plural'] ) . ' with commas', 'quantum-mentor-world' ),
            'add_or_remove_items'        => $tax['hierarchical'] ? null : __( 'Add or remove ' . strtolower( $tax['plural'] ), 'quantum-mentor-world' ),
            'choose_from_most_used'      => $tax['hierarchical'] ? null : __( 'Choose from the most used ' . strtolower( $tax['plural'] ), 'quantum-mentor-world' ),
            'not_found'                  => __( 'No ' . strtolower( $tax['plural'] ) . ' found.', 'quantum-mentor-world' ),
            'no_terms'                   => __( 'No ' . strtolower( $tax['plural'] ), 'quantum-mentor-world' ),
            'menu_name'                  => __( $tax['plural'], 'quantum-mentor-world' ),
            'items_list_navigation'      => __( $tax['plural'] . ' list navigation', 'quantum-mentor-world' ),
            'items_list'                 => __( $tax['plural'] . ' list', 'quantum-mentor-world' ),
            'most_used'                  => __( 'Most Used', 'quantum-mentor-world' ),
            'back_to_items'              => __( '&larr; Go to ' . $tax['plural'], 'quantum-mentor-world' ),
        );

        register_taxonomy(
            $taxonomy_key,
            $tax['object_type'],
            array(
                'hierarchical'          => $tax['hierarchical'],
                'labels'                => $labels,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'show_in_nav_menus'     => true,
                'show_admin_column'     => $tax['admin_column'],
                'query_var'             => true,
                'rewrite'               => array(
                    'slug'         => $tax['rewrite_slug'],
                    'with_front'   => false,
                    'hierarchical' => $tax['hierarchical'],
                ),
                'show_in_rest'          => true,
                'rest_base'             => $tax['rewrite_slug'],
                'rest_controller_class' => 'WP_REST_Terms_Controller',
                'show_tagcloud'         => ! $tax['hierarchical'],
                'show_in_quick_edit'    => true,
                'meta_box_cb'           => null, // use default metabox
            )
        );
    }
}
add_action( 'init', 'qmw_register_taxonomies', 0 );


// ============================================================
// 3. AUTO-SEED ALL TAXONOMY CATEGORY TERMS
// ============================================================

/**
 * Seeds all category terms on first admin load.
 * Uses a versioned option flag so re-seeding can be triggered
 * by bumping the version number below.
 *
 * HOW TO RE-SEED: Change '2' to '3' in the version check below.
 */
function qmw_seed_all_taxonomy_terms() {
    $seed_version = 2; // bump this number to force re-seed
    if ( (int) get_option( 'qmw_taxonomy_seed_version' ) >= $seed_version ) {
        return;
    }

    /**
     * Complete taxonomy seeding data.
     * Every term from the platform specification is listed here.
     * Terms are idempotent — safe to re-run, will not create duplicates.
     */
    $seed_data = array(

        // ── Software Categories (10 terms) ──
        'software_category' => array(
            'Windows',
            'Mac',
            'Linux',
            'Android',
            'iPhone',
            'AI Apps',
            'Utilities',
            'Security',
            'Productivity',
            'Developer Tools',
        ),

        // ── Themes & Plugins Categories (7 terms) ──
        'theme_plugin_category' => array(
            'WordPress Themes',
            'WordPress Plugins',
            'WooCommerce',
            'Shopify',
            'Hostinger',
            'GoDaddy',
            'Blogger Templates',
        ),

        // ── Games Categories (9 terms) ──
        'game_category' => array(
            'PC Games',
            'Mobile Games',
            'Browser Games',
            'Open Source Games',
            'Educational Games',
            'Action',
            'Adventure',
            'Puzzle',
            'Racing',
        ),

        // ── Books Categories (10 terms) ──
        'book_category' => array(
            'Educational',
            'Religious',
            'Programming',
            'Business',
            'Novels',
            'AI',
            'Freelancing',
            'Marketing',
            'History',
            'Science',
        ),

        // ── Watch Categories (6 terms) ──
        'watch_category' => array(
            'Movies',
            'Courses',
            'Anime',
            'Donghua',
            'Tutorials',
            'Documentaries',
        ),

        // ── Tools Categories (8 terms) ──
        'tool_category' => array(
            'File Converter',
            'PDF Tools',
            'Image Tools',
            'Video Tools',
            'Text Tools',
            'AI Tools',
            'SEO Tools',
            'Developer Tools',
        ),

        // ── News Categories (8 terms) ──
        'news_category' => array(
            'AI News',
            'Software News',
            'Games News',
            'OS News',
            'Themes News',
            'Tools News',
            'Movies News',
            'Anime News',
        ),

        // ── GitHub Repo Categories (10 terms) ──
        'repo_category' => array(
            'AI',
            'Web Development',
            'Mobile Development',
            'Python',
            'JavaScript',
            'Automation',
            'SEO',
            'Marketing',
            'WordPress',
            'Security',
        ),

    );

    foreach ( $seed_data as $taxonomy => $terms ) {
        foreach ( $terms as $term_name ) {
            $term_name = trim( $term_name );
            if ( empty( $term_name ) ) {
                continue;
            }
            // Only insert if the term does not already exist
            if ( ! term_exists( $term_name, $taxonomy ) ) {
                $result = wp_insert_term(
                    $term_name,
                    $taxonomy,
                    array(
                        'slug' => sanitize_title( $term_name ),
                    )
                );
                // Log errors to debug log if WP_DEBUG is on
                if ( is_wp_error( $result ) && defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                    error_log( 'QMW Seed: Failed to insert term "' . $term_name . '" into "' . $taxonomy . '": ' . $result->get_error_message() );
                }
            }
        }
    }

    update_option( 'qmw_taxonomy_seed_version', $seed_version );
}
add_action( 'admin_init', 'qmw_seed_all_taxonomy_terms' );


// ============================================================
// 4. FLUSH REWRITE RULES ON CPT REGISTRATION
// ============================================================

/**
 * Flush rewrite rules on theme activation so CPT and taxonomy
 * URL slugs work immediately without requiring a manual
 * Settings → Permalinks save.
 */
function qmw_flush_rewrite_rules_on_activation() {
    qmw_register_cpts();
    qmw_register_taxonomies();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'qmw_flush_rewrite_rules_on_activation' );


// ============================================================
// 5. ADMIN COLUMNS — FEATURED IMAGE THUMBNAIL
// ============================================================

/**
 * Adds a thumbnail column to each CPT list table in the admin.
 */
function qmw_add_thumbnail_column( $columns ) {
    $new = array( 'cb' => $columns['cb'] );
    $new['thumbnail'] = '<span class="dashicons dashicons-format-image" title="Thumbnail"></span>';
    unset( $columns['cb'] );
    return array_merge( $new, $columns );
}

function qmw_render_thumbnail_column( $column, $post_id ) {
    if ( $column === 'thumbnail' ) {
        $thumb = get_the_post_thumbnail( $post_id, array( 48, 48 ) );
        echo $thumb ? $thumb : '<span style="color:#ccc;">—</span>';
    }
}

foreach (
    array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'news', 'github_repos' )
    as $cpt_key
) {
    add_filter( "manage_{$cpt_key}_posts_columns",       'qmw_add_thumbnail_column' );
    add_action( "manage_{$cpt_key}_posts_custom_column", 'qmw_render_thumbnail_column', 10, 2 );
}


// ============================================================
// 6. ADMIN COLUMNS — RESOURCE STATUS
// ============================================================

/**
 * Adds a "Status" admin column for CPTs that use the status ACF field.
 */
function qmw_add_status_column( $columns ) {
    $columns['resource_status'] = 'Status';
    return $columns;
}

function qmw_render_status_column( $column, $post_id ) {
    if ( $column !== 'resource_status' ) {
        return;
    }
    // Try common ACF status field names
    $field_names = array(
        'software_status', 'tp_status', 'game_status', 'book_status',
        'watch_status_field', 'tool_status_field',
    );
    $status = '';
    foreach ( $field_names as $fn ) {
        $val = get_post_meta( $post_id, $fn, true );
        if ( ! empty( $val ) ) {
            $status = $val;
            break;
        }
    }
    if ( empty( $status ) ) {
        echo '<span style="color:#aaa;">—</span>';
        return;
    }
    $colors = array(
        'Active'     => '#22c55e',
        'Updated'    => '#3b82f6',
        'Deprecated' => '#f59e0b',
        'Removed'    => '#ef4444',
        'Completed'  => '#22c55e',
        'Ongoing'    => '#3b82f6',
        'Upcoming'   => '#a855f7',
    );
    $color = isset( $colors[ $status ] ) ? $colors[ $status ] : '#6b7280';
    printf(
        '<span style="display:inline-block;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;color:#fff;background:%s;">%s</span>',
        esc_attr( $color ),
        esc_html( $status )
    );
}

foreach (
    array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools' )
    as $cpt_key
) {
    add_filter( "manage_{$cpt_key}_posts_columns",       'qmw_add_status_column' );
    add_action( "manage_{$cpt_key}_posts_custom_column", 'qmw_render_status_column', 10, 2 );
}


// ============================================================
// 7. SEARCH SUPPORT FOR ALL CPTs
// ============================================================

/**
 * Include all 8 CPTs in the default WordPress search results.
 */
function qmw_include_cpts_in_search( $query ) {
    if ( $query->is_search() && $query->is_main_query() && ! is_admin() ) {
        $query->set(
            'post_type',
            array( 'post', 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'news', 'github_repos' )
        );
    }
    return $query;
}
add_action( 'pre_get_posts', 'qmw_include_cpts_in_search' );


// ============================================================
// 8. CPT ARCHIVE QUERY CUSTOMIZATIONS
// ============================================================

/**
 * Customize the main archive query for CPTs.
 * - Default order: date descending
 * - Allow GET param filtering by category taxonomy
 * - Allow GET param sorting (latest, oldest, a-z, featured)
 * - Set posts_per_page to 18 for archive grid
 */
function qmw_customise_archive_queries( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    $cpt_archive_map = array(
        'software'       => 'software_category',
        'themes_plugins' => 'theme_plugin_category',
        'games'          => 'game_category',
        'books'          => 'book_category',
        'watch'          => 'watch_category',
        'tools'          => 'tool_category',
        'news'           => 'news_category',
        'github_repos'   => 'repo_category',
    );

    foreach ( $cpt_archive_map as $cpt => $taxonomy ) {
        if ( ! $query->is_post_type_archive( $cpt ) ) {
            continue;
        }

        // Posts per page
        $query->set( 'posts_per_page', 18 );

        // Category filter via ?category=slug
        if ( ! empty( $_GET['category'] ) ) {
            $query->set( 'tax_query', array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field( $_GET['category'] ),
                ),
            ) );
        }

        // Sorting
        $sort = isset( $_GET['sort'] ) ? sanitize_text_field( $_GET['sort'] ) : 'latest';
        switch ( $sort ) {
            case 'oldest':
                $query->set( 'order', 'ASC' );
                $query->set( 'orderby', 'date' );
                break;
            case 'a-z':
                $query->set( 'order', 'ASC' );
                $query->set( 'orderby', 'title' );
                break;
            case 'z-a':
                $query->set( 'order', 'DESC' );
                $query->set( 'orderby', 'title' );
                break;
            case 'featured':
                $query->set( 'meta_key', 'admin_priority' );
                $query->set( 'meta_value', 'Featured' );
                $query->set( 'orderby', 'date' );
                $query->set( 'order', 'DESC' );
                break;
            default: // 'latest'
                $query->set( 'order', 'DESC' );
                $query->set( 'orderby', 'date' );
                break;
        }
    }
}
add_action( 'pre_get_posts', 'qmw_customise_archive_queries' );


// ============================================================
// 9. TEMPLATE MAPPING — ARCHIVE & SINGLE TEMPLATE ROUTING
// ============================================================

/**
 * URL Slug Reference Table
 * ─────────────────────────────────────────────────────────────
 * CPT Key          │ Archive URL          │ Single URL Example
 * ─────────────────────────────────────────────────────────────
 * software         │ /software/           │ /software/vlc-media-player/
 * themes_plugins   │ /themes-plugins/     │ /themes-plugins/astra-theme/
 * games            │ /games/              │ /games/0-ad-strategy/
 * books            │ /books/              │ /books/introduction-to-algorithms/
 * watch            │ /watch/              │ /watch/attack-on-titan/
 * tools            │ /tools/              │ /tools/pdf-compressor/
 * news             │ /news/               │ /news/gpt-5-announced/
 * github_repos     │ /github-repos/       │ /github-repos/llama-cpp/
 * ─────────────────────────────────────────────────────────────
 *
 * Template Files Expected:
 *   archive-{cpt_key}.php  (e.g., archive-software.php)
 *   single-{cpt_key}.php   (e.g., single-software.php)
 *
 * WordPress automatically routes to these files when they exist.
 * Fallback: archive.php / single.php
 */

// No PHP code needed here — WordPress template hierarchy handles routing.
// This section serves as documentation for the theme developer.
