<?php
/**
 * Quantum Mentor World — Complete ACF Field Groups Registration
 *
 * All 10 field groups:
 *   1.  Software Details
 *   2.  Themes & Plugins Details
 *   3.  Games Details
 *   4.  Books Details
 *   5.  Watch Content Details
 *   6.  Online Tools Details
 *   7.  News Article Details
 *   8.  GitHub Repository Details
 *   9.  Global SEO Fields  (all 8 CPTs + post + page)
 *   10. Global Admin Control Fields (all 8 CPTs + post + page)
 *
 * Naming Convention for field keys:
 *   group_{cpt}_{section}
 *   field_{cpt}_{field_name}
 *
 * @package Quantum_Mentor_World
 * @version 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'acf/init', 'qmw_register_all_acf_fields' );

function qmw_register_all_acf_fields() {

    // Guard: ACF must be active
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    // ============================================================
    // 1. SOFTWARE FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'      => 'group_software_details',
        'title'    => '📦 Software Specifications',
        'fields'   => array(

            // ── Tab: Core Info ──
            array(
                'key'   => 'field_sw_tab_core',
                'label' => 'Core Information',
                'type'  => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'         => 'field_software_name',
                'label'       => 'Software Name',
                'name'        => 'software_name',
                'type'        => 'text',
                'required'    => 1,
                'placeholder' => 'e.g., VLC Media Player',
                'instructions' => 'Full display name of the software application.',
            ),
            array(
                'key'         => 'field_software_version',
                'label'       => 'Version',
                'name'        => 'software_version',
                'type'        => 'text',
                'placeholder' => 'e.g., 3.0.18',
                'instructions' => 'Current stable version number.',
            ),
            array(
                'key'          => 'field_software_platform',
                'label'        => 'Platform / OS',
                'name'         => 'software_platform',
                'type'         => 'checkbox',
                'choices'      => array(
                    'Windows' => '🪟 Windows',
                    'Mac'     => '🍎 macOS',
                    'Linux'   => '🐧 Linux',
                    'Android' => '🤖 Android',
                    'iPhone'  => '📱 iPhone / iOS',
                    'Web'     => '🌐 Web / Browser',
                ),
                'layout'       => 'horizontal',
                'instructions' => 'Select all supported platforms.',
            ),
            array(
                'key'         => 'field_software_developer',
                'label'       => 'Developer / Company',
                'name'        => 'software_developer',
                'type'        => 'text',
                'placeholder' => 'e.g., VideoLAN Organization',
            ),
            array(
                'key'         => 'field_software_license',
                'label'       => 'License Type',
                'name'        => 'software_license',
                'type'        => 'select',
                'choices'     => array(
                    'Open Source'        => 'Open Source',
                    'Freeware'           => 'Freeware',
                    'Free Trial'         => 'Free Trial',
                    'Public Domain'      => 'Public Domain',
                    'Creative Commons'   => 'Creative Commons',
                    'GNU GPL'            => 'GNU GPL',
                    'MIT License'        => 'MIT License',
                    'Apache 2.0'         => 'Apache 2.0',
                    'Proprietary Free'   => 'Proprietary (Free)',
                    'Paid Official Link' => 'Paid — Official Link Only',
                ),
                'allow_null'  => 0,
                'default_value' => 'Freeware',
                'instructions' => 'Only legal license types are allowed.',
            ),
            array(
                'key'         => 'field_software_size',
                'label'       => 'File Size',
                'name'        => 'software_size',
                'type'        => 'text',
                'placeholder' => 'e.g., 45.2 MB',
            ),

            // ── Tab: URLs ──
            array(
                'key'      => 'field_sw_tab_urls',
                'label'    => 'URLs & Links',
                'type'     => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'         => 'field_software_official_url',
                'label'       => 'Official Website URL',
                'name'        => 'software_official_url',
                'type'        => 'url',
                'placeholder' => 'https://',
                'instructions' => 'Link to the official developer website.',
            ),
            array(
                'key'         => 'field_software_download_url',
                'label'       => 'Download URL',
                'name'        => 'software_download_url',
                'type'        => 'url',
                'placeholder' => 'https://',
                'instructions' => 'Direct official download link only. No third-party mirrors unless verified.',
            ),
            array(
                'key'         => 'field_software_github_url',
                'label'       => 'GitHub Repository URL',
                'name'        => 'software_github_url',
                'type'        => 'url',
                'placeholder' => 'https://github.com/',
                'instructions' => 'Leave blank if the software is not open source.',
            ),

            // ── Tab: Media & Docs ──
            array(
                'key'      => 'field_sw_tab_media',
                'label'    => 'Media & Documentation',
                'type'     => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'           => 'field_software_screenshots',
                'label'         => 'Screenshots Gallery',
                'name'          => 'software_screenshots',
                'type'          => 'gallery',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'instructions'  => 'Upload screenshots of the software interface.',
            ),
            array(
                'key'          => 'field_software_requirements',
                'label'        => 'System Requirements',
                'name'         => 'software_system_requirements',
                'type'         => 'textarea',
                'rows'         => 4,
                'placeholder'  => "OS: Windows 10/11\nRAM: 4 GB minimum\nDisk: 200 MB",
                'instructions' => 'List the minimum and recommended system requirements.',
            ),
            array(
                'key'         => 'field_software_install_guide',
                'label'       => 'Installation Guide',
                'name'        => 'software_installation_guide',
                'type'        => 'textarea',
                'rows'        => 4,
                'placeholder' => 'Step-by-step installation instructions...',
            ),
            array(
                'key'          => 'field_software_safety_note',
                'label'        => 'Safety Note',
                'name'         => 'software_safety_note',
                'type'         => 'textarea',
                'rows'         => 2,
                'default_value'=> 'Verified 100% legal, safe, and malware-free.',
                'instructions' => 'Add a verified safety note for users. Always confirm legal compliance.',
            ),
            array(
                'key'         => 'field_software_changelog',
                'label'       => 'Changelog',
                'name'        => 'software_changelog',
                'type'        => 'textarea',
                'rows'        => 4,
                'placeholder' => 'v3.0.18 — Bug fixes and performance improvements...',
                'instructions' => 'Latest version changelog. Optional.',
            ),

            // ── Tab: Status ──
            array(
                'key'      => 'field_sw_tab_status',
                'label'    => 'Status & Date',
                'type'     => 'tab',
                'placement' => 'top',
                'endpoint'  => 0,
            ),
            array(
                'key'            => 'field_software_last_updated',
                'label'          => 'Last Updated Date',
                'name'           => 'software_last_updated',
                'type'           => 'date_picker',
                'display_format' => 'F j, Y',
                'return_format'  => 'Y-m-d',
                'first_day'      => 1,
                'instructions'   => 'Date the software was last updated.',
            ),
            array(
                'key'           => 'field_software_status',
                'label'         => 'Resource Status',
                'name'          => 'software_status',
                'type'          => 'select',
                'choices'       => array(
                    'Active'     => '✅ Active',
                    'Updated'    => '🔄 Recently Updated',
                    'Deprecated' => '⚠️ Deprecated',
                    'Removed'    => '❌ Removed / Unavailable',
                ),
                'default_value' => 'Active',
                'allow_null'    => 0,
                'required'      => 1,
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'software' ) ),
        ),
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ) );


    // ============================================================
    // 2. THEMES & PLUGINS FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_themes_plugins_details',
        'title'  => '🎨 Theme & Plugin Specifications',
        'fields' => array(

            // ── Tab: Core Info ──
            array(
                'key' => 'field_tp_tab_core', 'label' => 'Core Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_tp_name', 'label' => 'Item Name',
                'name' => 'tp_name', 'type' => 'text', 'required' => 1,
                'placeholder' => 'e.g., Astra Theme',
            ),
            array(
                'key'     => 'field_tp_type',
                'label'   => 'Type',
                'name'    => 'tp_type',
                'type'    => 'select',
                'choices' => array(
                    'Theme'     => '🖼️ Theme',
                    'Plugin'    => '🔌 Plugin',
                    'Extension' => '🧩 Extension',
                    'Addon'     => '➕ Add-on',
                ),
                'default_value' => 'Plugin',
                'required'      => 1,
            ),
            array(
                'key'     => 'field_tp_platform',
                'label'   => 'Platform',
                'name'    => 'tp_platform',
                'type'    => 'select',
                'choices' => array(
                    'WordPress'  => 'WordPress',
                    'WooCommerce'=> 'WooCommerce',
                    'Shopify'    => 'Shopify',
                    'Hostinger'  => 'Hostinger',
                    'GoDaddy'    => 'GoDaddy',
                    'Blogger'    => 'Blogger / Blogspot',
                    'Elementor'  => 'Elementor',
                    'Other'      => 'Other',
                ),
                'default_value' => 'WordPress',
                'required'      => 1,
            ),
            array(
                'key' => 'field_tp_version', 'label' => 'Version',
                'name' => 'tp_version', 'type' => 'text', 'placeholder' => 'e.g., 4.2.1',
            ),
            array(
                'key' => 'field_tp_developer', 'label' => 'Developer / Author',
                'name' => 'tp_developer', 'type' => 'text',
            ),
            array(
                'key'     => 'field_tp_license',
                'label'   => 'License Type',
                'name'    => 'tp_license',
                'type'    => 'select',
                'choices' => array(
                    'GPL v2'             => 'GPL v2 (Free)',
                    'GPL v3'             => 'GPL v3 (Free)',
                    'MIT'                => 'MIT License',
                    'Freemium'           => 'Freemium (Free + Pro)',
                    'Free Official'      => 'Free — Official Only',
                    'Paid Official Link' => 'Paid — Official Link Only',
                ),
                'default_value' => 'GPL v2',
            ),

            // ── Tab: URLs ──
            array(
                'key' => 'field_tp_tab_urls', 'label' => 'URLs & Links',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_tp_official_url', 'label' => 'Official Website URL',
                'name' => 'tp_official_url', 'type' => 'url', 'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_tp_download_url', 'label' => 'Download URL',
                'name' => 'tp_download_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'Official download link only.',
            ),
            array(
                'key' => 'field_tp_demo_url', 'label' => 'Live Demo URL',
                'name' => 'tp_demo_url', 'type' => 'url', 'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_tp_doc_url', 'label' => 'Documentation URL',
                'name' => 'tp_doc_url', 'type' => 'url', 'placeholder' => 'https://',
            ),

            // ── Tab: Media & Docs ──
            array(
                'key' => 'field_tp_tab_media', 'label' => 'Media & Requirements',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_tp_screenshots', 'label' => 'Screenshots Gallery',
                'name' => 'tp_screenshots', 'type' => 'gallery',
                'return_format' => 'id', 'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_tp_requirements', 'label' => 'Requirements',
                'name' => 'tp_requirements', 'type' => 'textarea', 'rows' => 3,
                'placeholder' => "WordPress: 5.0+\nPHP: 7.4+\nMySQL: 5.6+",
            ),
            array(
                'key' => 'field_tp_install_guide', 'label' => 'Installation Guide',
                'name' => 'tp_installation_guide', 'type' => 'textarea', 'rows' => 4,
            ),

            // ── Tab: Status ──
            array(
                'key' => 'field_tp_tab_status', 'label' => 'Status & Date',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_tp_last_updated', 'label' => 'Last Updated Date',
                'name' => 'tp_last_updated', 'type' => 'date_picker',
                'display_format' => 'F j, Y', 'return_format' => 'Y-m-d', 'first_day' => 1,
            ),
            array(
                'key'           => 'field_tp_status', 'label' => 'Resource Status',
                'name'          => 'tp_status', 'type' => 'select',
                'choices'       => array(
                    'Active' => '✅ Active', 'Updated' => '🔄 Recently Updated',
                    'Deprecated' => '⚠️ Deprecated', 'Removed' => '❌ Removed',
                ),
                'default_value' => 'Active', 'required' => 1,
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'themes_plugins' ) ),
        ),
        'menu_order' => 0, 'position' => 'normal', 'style' => 'default',
        'label_placement' => 'top', 'instruction_placement' => 'label', 'active' => true,
    ) );


    // ============================================================
    // 3. GAMES FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_games_details',
        'title'  => '🎮 Game Specifications',
        'fields' => array(

            // ── Tab: Core Info ──
            array(
                'key' => 'field_game_tab_core', 'label' => 'Core Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_game_name', 'label' => 'Game Name',
                'name' => 'game_name', 'type' => 'text', 'required' => 1,
                'placeholder' => 'e.g., 0 A.D. — Empires Ascendant',
            ),
            array(
                'key'     => 'field_game_platform',
                'label'   => 'Platform',
                'name'    => 'game_platform',
                'type'    => 'checkbox',
                'choices' => array(
                    'Windows' => '🪟 Windows',
                    'Mac'     => '🍎 macOS',
                    'Linux'   => '🐧 Linux',
                    'Android' => '🤖 Android',
                    'iOS'     => '📱 iOS',
                    'Browser' => '🌐 Browser',
                ),
                'layout' => 'horizontal',
            ),
            array(
                'key'     => 'field_game_genre',
                'label'   => 'Genre',
                'name'    => 'game_genre_field',
                'type'    => 'select',
                'choices' => array(
                    'Action'      => 'Action',
                    'Adventure'   => 'Adventure',
                    'Puzzle'      => 'Puzzle',
                    'Racing'      => 'Racing',
                    'Strategy'    => 'Strategy',
                    'RPG'         => 'RPG',
                    'Sports'      => 'Sports',
                    'Simulation'  => 'Simulation',
                    'Educational' => 'Educational',
                    'Arcade'      => 'Arcade',
                ),
                'allow_null' => 1,
            ),
            array(
                'key' => 'field_game_developer', 'label' => 'Developer / Studio',
                'name' => 'game_developer', 'type' => 'text',
            ),
            array(
                'key'     => 'field_game_license', 'label' => 'License Type',
                'name'    => 'game_license', 'type' => 'select',
                'choices' => array(
                    'Open Source'   => 'Open Source',
                    'Freeware'      => 'Freeware',
                    'Public Domain' => 'Public Domain',
                    'Free to Play'  => 'Free to Play (Official)',
                    'GPL'           => 'GNU GPL',
                ),
                'default_value' => 'Freeware',
            ),
            array(
                'key' => 'field_game_size', 'label' => 'File Size',
                'name' => 'game_size', 'type' => 'text', 'placeholder' => 'e.g., 800 MB',
            ),
            array(
                'key' => 'field_game_version', 'label' => 'Version',
                'name' => 'game_version', 'type' => 'text', 'placeholder' => 'e.g., 0.26.0',
            ),

            // ── Tab: URLs & Media ──
            array(
                'key' => 'field_game_tab_media', 'label' => 'URLs & Media',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_game_official_url', 'label' => 'Official Website URL',
                'name' => 'game_official_url', 'type' => 'url', 'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_game_download_url', 'label' => 'Download URL',
                'name' => 'game_download_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'Official download link only.',
            ),
            array(
                'key' => 'field_game_trailer_url', 'label' => 'Trailer Embed URL',
                'name' => 'game_trailer_url', 'type' => 'url',
                'placeholder' => 'https://www.youtube.com/embed/...',
                'instructions' => 'YouTube embed URL for official game trailer.',
            ),
            array(
                'key' => 'field_game_screenshots', 'label' => 'Screenshots Gallery',
                'name' => 'game_screenshots', 'type' => 'gallery',
                'return_format' => 'id', 'preview_size' => 'medium',
            ),

            // ── Tab: Technical ──
            array(
                'key' => 'field_game_tab_tech', 'label' => 'Technical Details',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_game_requirements', 'label' => 'System Requirements',
                'name' => 'game_requirements', 'type' => 'textarea', 'rows' => 4,
                'placeholder' => "OS: Windows 7+\nRAM: 2 GB\nGPU: OpenGL 2.0",
            ),
            array(
                'key' => 'field_game_install_guide', 'label' => 'Installation Guide',
                'name' => 'game_installation_guide', 'type' => 'textarea', 'rows' => 4,
            ),

            // ── Tab: Status ──
            array(
                'key' => 'field_game_tab_status', 'label' => 'Status & Date',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_game_last_updated', 'label' => 'Last Updated Date',
                'name' => 'game_last_updated', 'type' => 'date_picker',
                'display_format' => 'F j, Y', 'return_format' => 'Y-m-d', 'first_day' => 1,
            ),
            array(
                'key'           => 'field_game_status', 'label' => 'Resource Status',
                'name'          => 'game_status', 'type' => 'select',
                'choices'       => array(
                    'Active' => '✅ Active', 'Updated' => '🔄 Recently Updated',
                    'Deprecated' => '⚠️ Deprecated', 'Removed' => '❌ Removed',
                ),
                'default_value' => 'Active', 'required' => 1,
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'games' ) ),
        ),
        'menu_order' => 0, 'position' => 'normal', 'style' => 'default',
        'label_placement' => 'top', 'instruction_placement' => 'label', 'active' => true,
    ) );


    // ============================================================
    // 4. BOOKS FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_books_details',
        'title'  => '📚 Book Details',
        'fields' => array(

            // ── Tab: Bibliographic Info ──
            array(
                'key' => 'field_book_tab_bib', 'label' => 'Bibliographic Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_book_title_field', 'label' => 'Book Title',
                'name' => 'book_title_field', 'type' => 'text', 'required' => 1,
                'placeholder' => 'e.g., Introduction to Algorithms',
                'instructions' => 'Full book title as it appears on the cover.',
            ),
            array(
                'key' => 'field_book_author_field', 'label' => 'Author(s)',
                'name' => 'book_author_field', 'type' => 'text',
                'placeholder' => 'e.g., Thomas H. Cormen',
            ),
            array(
                'key' => 'field_book_publisher', 'label' => 'Publisher',
                'name' => 'book_publisher', 'type' => 'text',
                'placeholder' => 'e.g., MIT Press',
            ),
            array(
                'key'     => 'field_book_language_field', 'label' => 'Language',
                'name'    => 'book_language_field', 'type' => 'select',
                'choices' => array(
                    'English'  => 'English',
                    'Urdu'     => 'Urdu',
                    'Arabic'   => 'Arabic',
                    'Spanish'  => 'Spanish',
                    'French'   => 'French',
                    'German'   => 'German',
                    'Chinese'  => 'Chinese',
                    'Hindi'    => 'Hindi',
                    'Other'    => 'Other',
                ),
                'default_value' => 'English',
                'allow_null'    => 0,
            ),
            array(
                'key' => 'field_book_pages_count', 'label' => 'Number of Pages',
                'name' => 'book_pages_count', 'type' => 'number',
                'min' => 1, 'placeholder' => 'e.g., 456',
            ),
            array(
                'key'     => 'field_book_type',
                'label'   => 'Book Type / Access',
                'name'    => 'book_type',
                'type'    => 'select',
                'choices' => array(
                    'Free'               => '🆓 Free',
                    'Public Domain'      => '📜 Public Domain',
                    'Open Access'        => '🔓 Open Access',
                    'Creative Commons'   => '🔄 Creative Commons',
                    'Paid Official Link' => '💳 Paid — Official Link Only',
                ),
                'required'      => 1,
                'default_value' => 'Free',
                'instructions'  => 'Only legal access types are permitted.',
            ),
            array(
                'key'     => 'field_book_format',
                'label'   => 'Available Format(s)',
                'name'    => 'book_format',
                'type'    => 'checkbox',
                'choices' => array(
                    'PDF'         => 'PDF',
                    'EPUB'        => 'EPUB',
                    'MOBI'        => 'MOBI',
                    'DOCX'        => 'DOCX',
                    'Online Read' => 'Online Read',
                    'Audio'       => 'Audiobook',
                ),
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_book_pub_year', 'label' => 'Publication Year',
                'name' => 'book_pub_year', 'type' => 'text',
                'placeholder' => 'e.g., 2009',
            ),

            // ── Tab: URLs ──
            array(
                'key' => 'field_book_tab_urls', 'label' => 'Source URLs',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_book_official_url', 'label' => 'Official Source URL',
                'name' => 'book_official_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'Publisher or author official page URL.',
            ),
            array(
                'key' => 'field_book_download_url', 'label' => 'Download URL',
                'name' => 'book_download_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'Direct download link. Must be from a legal source.',
            ),
            array(
                'key' => 'field_book_read_online_url', 'label' => 'Read Online URL',
                'name' => 'book_read_online_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'Link to read the book online (e.g., Google Books, Internet Archive).',
            ),

            // ── Tab: Content ──
            array(
                'key' => 'field_book_tab_content', 'label' => 'Book Content',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_book_summary', 'label' => 'Short Summary',
                'name' => 'book_summary', 'type' => 'textarea', 'rows' => 3,
                'placeholder' => 'Brief overview of what the book covers...',
                'instructions' => 'A 2–4 sentence summary shown in cards and excerpts.',
            ),
            array(
                'key' => 'field_book_toc', 'label' => 'Table of Contents',
                'name' => 'book_toc', 'type' => 'textarea', 'rows' => 6,
                'placeholder' => "Chapter 1: Introduction\nChapter 2: ...",
            ),
            array(
                'key' => 'field_book_license_note', 'label' => 'License / Copyright Note',
                'name' => 'book_license_note', 'type' => 'textarea', 'rows' => 2,
                'placeholder' => 'e.g., This book is freely available under CC BY-SA 4.0 license.',
                'instructions' => 'Always state the exact legal permission. Mandatory.',
            ),

            // ── Tab: Status ──
            array(
                'key' => 'field_book_tab_status', 'label' => 'Status',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key'           => 'field_book_status', 'label' => 'Resource Status',
                'name'          => 'book_status', 'type' => 'select',
                'choices'       => array(
                    'Active' => '✅ Available', 'Updated' => '🔄 Updated Edition',
                    'Deprecated' => '⚠️ Old Edition', 'Removed' => '❌ Link Unavailable',
                ),
                'default_value' => 'Active', 'required' => 1,
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'books' ) ),
        ),
        'menu_order' => 0, 'position' => 'normal', 'style' => 'default',
        'label_placement' => 'top', 'instruction_placement' => 'label', 'active' => true,
    ) );


    // ============================================================
    // 5. WATCH CONTENT FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_watch_details',
        'title'  => '🎬 Watch Content Details',
        'fields' => array(

            // ── Tab: Core Info ──
            array(
                'key' => 'field_watch_tab_core', 'label' => 'Core Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_watch_title', 'label' => 'Content Title',
                'name' => 'watch_title', 'type' => 'text', 'required' => 1,
                'placeholder' => 'e.g., Attack on Titan',
                'instructions' => 'The official title of the movie, course, anime, etc.',
            ),
            array(
                'key'     => 'field_watch_type',
                'label'   => 'Content Type',
                'name'    => 'watch_type',
                'type'    => 'select',
                'choices' => array(
                    'Movie'        => '🎬 Movie',
                    'Course'       => '📖 Online Course',
                    'Anime'        => '🗾 Anime',
                    'Donghua'      => '🐉 Donghua (Chinese Animation)',
                    'Tutorial'     => '🎓 Tutorial Series',
                    'Documentary'  => '📽️ Documentary',
                ),
                'required'      => 1,
                'default_value' => 'Movie',
                'instructions'  => 'Select the correct content type. This controls which fields appear.',
            ),
            array(
                'key'     => 'field_watch_language_field', 'label' => 'Language',
                'name'    => 'watch_language_field', 'type' => 'select',
                'choices' => array(
                    'English'   => 'English',
                    'Japanese'  => 'Japanese',
                    'Chinese'   => 'Chinese (Mandarin)',
                    'Korean'    => 'Korean',
                    'Hindi'     => 'Hindi',
                    'Urdu'      => 'Urdu',
                    'Arabic'    => 'Arabic',
                    'Spanish'   => 'Spanish',
                    'French'    => 'French',
                    'Multi'     => 'Multi-language',
                ),
                'default_value' => 'English',
            ),
            array(
                'key'     => 'field_watch_genre_field', 'label' => 'Genre',
                'name'    => 'watch_genre_field', 'type' => 'select',
                'choices' => array(
                    'Action'       => 'Action',
                    'Adventure'    => 'Adventure',
                    'Comedy'       => 'Comedy',
                    'Drama'        => 'Drama',
                    'Fantasy'      => 'Fantasy',
                    'Horror'       => 'Horror',
                    'Romance'      => 'Romance',
                    'Sci-Fi'       => 'Sci-Fi',
                    'Thriller'     => 'Thriller',
                    'Educational'  => 'Educational',
                    'Documentary'  => 'Documentary',
                    'Technology'   => 'Technology',
                ),
                'allow_null' => 1,
            ),
            array(
                'key' => 'field_watch_release_year_field', 'label' => 'Release Year',
                'name' => 'watch_release_year_field', 'type' => 'text',
                'placeholder' => 'e.g., 2013',
            ),
            array(
                'key'     => 'field_watch_status_field', 'label' => 'Airing / Completion Status',
                'name'    => 'watch_status_field', 'type' => 'select',
                'choices' => array(
                    'Completed' => '✅ Completed',
                    'Ongoing'   => '🔄 Ongoing',
                    'Upcoming'  => '🕐 Upcoming',
                    'Paused'    => '⏸️ Paused / On Hiatus',
                ),
                'default_value' => 'Completed',
            ),

            // ── Tab: Images ──
            array(
                'key' => 'field_watch_tab_images', 'label' => 'Images',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_watch_poster', 'label' => 'Poster Image',
                'name' => 'watch_poster', 'type' => 'image',
                'return_format' => 'id', 'preview_size' => 'medium',
                'instructions' => 'Portrait-style poster image (recommended: 400×600px).',
            ),
            array(
                'key' => 'field_watch_cover_banner', 'label' => 'Cover Banner',
                'name' => 'watch_cover_banner', 'type' => 'image',
                'return_format' => 'id', 'preview_size' => 'medium_large',
                'instructions' => 'Wide landscape banner for single page hero (recommended: 1280×480px).',
            ),

            // ── Tab: Embed Servers (Movie / Documentary) ──
            array(
                'key' => 'field_watch_tab_servers', 'label' => 'Embed Servers (Movie / Doc)',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key'          => 'field_watch_tab_servers_notice',
                'label'        => '',
                'name'         => '',
                'type'         => 'message',
                'message'      => '<strong>⚠️ Movie / Documentary only.</strong> For episodic content (Anime, Courses, Donghua, Tutorials), use the Episode List tab below. Embed only from verified legal streaming sources.',
                'esc_html'     => 0,
            ),
            array(
                'key' => 'field_watch_srv1_name', 'label' => 'Embed Server 1 Name',
                'name' => 'watch_srv1_name', 'type' => 'text',
                'placeholder' => 'e.g., Server A — Archive.org',
            ),
            array(
                'key' => 'field_watch_srv1_url', 'label' => 'Embed Server 1 URL',
                'name' => 'watch_srv1_url', 'type' => 'url',
                'placeholder' => 'https://archive.org/embed/...',
                'instructions' => 'Full iframe-compatible embed URL.',
            ),
            array(
                'key' => 'field_watch_srv2_name', 'label' => 'Embed Server 2 Name',
                'name' => 'watch_srv2_name', 'type' => 'text',
                'placeholder' => 'e.g., Server B — Dailymotion',
            ),
            array(
                'key' => 'field_watch_srv2_url', 'label' => 'Embed Server 2 URL',
                'name' => 'watch_srv2_url', 'type' => 'url', 'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_watch_srv3_name', 'label' => 'Embed Server 3 Name',
                'name' => 'watch_srv3_name', 'type' => 'text',
                'placeholder' => 'e.g., Server C — Vimeo',
            ),
            array(
                'key' => 'field_watch_srv3_url', 'label' => 'Embed Server 3 URL',
                'name' => 'watch_srv3_url', 'type' => 'url', 'placeholder' => 'https://',
            ),

            // ── Tab: Episode List (Anime / Courses / Donghua / Tutorials) ──
            array(
                'key' => 'field_watch_tab_episodes', 'label' => 'Episode List',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key'          => 'field_watch_episodes_notice',
                'label'        => '',
                'name'         => '',
                'type'         => 'message',
                'message'      => '<strong>📺 For Anime, Courses, Donghua, and Tutorial series only.</strong> Add one row per episode. Leave empty for Movies and Documentaries.',
                'esc_html'     => 0,
            ),
            array(
                'key'        => 'field_watch_episodes',
                'label'      => 'Episode List',
                'name'       => 'watch_episodes',
                'type'       => 'repeater',
                'layout'     => 'block',
                'button_label' => '+ Add Episode',
                'min'        => 0,
                'max'        => 0,
                'sub_fields' => array(
                    array(
                        'key'         => 'field_watch_ep_number',
                        'label'       => 'Episode Number',
                        'name'        => 'episode_number',
                        'type'        => 'number',
                        'required'    => 1,
                        'min'         => 1,
                        'placeholder' => '1',
                        'wrapper'     => array( 'width' => '10' ),
                    ),
                    array(
                        'key'         => 'field_watch_ep_title',
                        'label'       => 'Episode Title',
                        'name'        => 'episode_title',
                        'type'        => 'text',
                        'required'    => 1,
                        'placeholder' => 'e.g., To You, in 2000 Years',
                        'wrapper'     => array( 'width' => '30' ),
                    ),
                    array(
                        'key'         => 'field_watch_ep_description',
                        'label'       => 'Episode Description',
                        'name'        => 'episode_description',
                        'type'        => 'textarea',
                        'rows'        => 2,
                        'placeholder' => 'Brief description of this episode...',
                        'wrapper'     => array( 'width' => '60' ),
                    ),
                    array(
                        'key'         => 'field_watch_ep_srv1',
                        'label'       => 'Server 1 URL',
                        'name'        => 'server_1_url',
                        'type'        => 'url',
                        'placeholder' => 'https://',
                        'wrapper'     => array( 'width' => '33' ),
                    ),
                    array(
                        'key'         => 'field_watch_ep_srv2',
                        'label'       => 'Server 2 URL',
                        'name'        => 'server_2_url',
                        'type'        => 'url',
                        'placeholder' => 'https://',
                        'wrapper'     => array( 'width' => '33' ),
                    ),
                    array(
                        'key'         => 'field_watch_ep_srv3',
                        'label'       => 'Server 3 URL',
                        'name'        => 'server_3_url',
                        'type'        => 'url',
                        'placeholder' => 'https://',
                        'wrapper'     => array( 'width' => '33' ),
                    ),
                ),
            ),

            // ── Tab: Legal Info ──
            array(
                'key' => 'field_watch_tab_legal', 'label' => 'Legal & Source',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_watch_official_url', 'label' => 'Official Source URL',
                'name' => 'watch_official_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'Link to the official streaming platform, publisher, or studio.',
            ),
            array(
                'key' => 'field_watch_legal_note', 'label' => 'Legal Permission Note',
                'name' => 'watch_legal_note', 'type' => 'textarea', 'rows' => 2,
                'default_value' => 'This content is sourced from an officially licensed, legal streaming platform.',
                'instructions'  => 'REQUIRED. State exactly why this content is legally permissible to embed.',
            ),
            array(
                'key' => 'field_watch_related', 'label' => 'Related Content',
                'name' => 'watch_related_content', 'type' => 'relationship',
                'post_type' => array( 'watch' ),
                'filters' => array( 'search', 'taxonomy' ),
                'max'     => 6,
                'return_format' => 'object',
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'watch' ) ),
        ),
        'menu_order' => 0, 'position' => 'normal', 'style' => 'default',
        'label_placement' => 'top', 'instruction_placement' => 'label', 'active' => true,
    ) );


    // ============================================================
    // 6. ONLINE TOOLS FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_tools_details',
        'title'  => '⚙️ Tool Specifications',
        'fields' => array(

            // ── Tab: Core ──
            array(
                'key' => 'field_tool_tab_core', 'label' => 'Core Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_tool_name', 'label' => 'Tool Name',
                'name' => 'tool_name', 'type' => 'text', 'required' => 1,
                'placeholder' => 'e.g., ILovePDF Compressor',
            ),
            array(
                'key'     => 'field_tool_type_field', 'label' => 'Tool Type / Category',
                'name'    => 'tool_type_field', 'type' => 'select',
                'choices' => array(
                    'File Converter' => 'File Converter',
                    'PDF Tool'       => 'PDF Tool',
                    'Image Tool'     => 'Image Tool',
                    'Video Tool'     => 'Video Tool',
                    'Text Tool'      => 'Text Tool',
                    'AI Tool'        => 'AI Tool',
                    'SEO Tool'       => 'SEO Tool',
                    'Developer Tool' => 'Developer Tool',
                    'Utility'        => 'General Utility',
                    'Other'          => 'Other',
                ),
                'required'      => 1,
                'default_value' => 'Utility',
            ),
            array(
                'key'     => 'field_tool_access_type', 'label' => 'Tool Access Type',
                'name'    => 'tool_access_type', 'type' => 'select',
                'choices' => array(
                    'Built-in Tool'      => '🔧 Built-in Tool (runs on this site)',
                    'External Tool'      => '🌐 External Web Tool (opens in new tab)',
                    'Downloadable Tool'  => '📥 Downloadable Tool (requires download)',
                    'Browser Extension'  => '🧩 Browser Extension',
                ),
                'required'      => 1,
                'default_value' => 'External Tool',
            ),
            array(
                'key'         => 'field_tool_description',
                'label'       => 'Tool Short Description',
                'name'        => 'tool_description',
                'type'        => 'textarea',
                'rows'        => 3,
                'placeholder' => 'Briefly describe what this tool does and who it is for...',
                'instructions' => 'Shown in cards and search results. Keep it under 160 characters.',
            ),

            // ── Tab: URLs & Access ──
            array(
                'key' => 'field_tool_tab_urls', 'label' => 'URLs & Access',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_tool_url', 'label' => 'Tool URL',
                'name' => 'tool_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'For external tools: the direct link. For built-in: the page slug.',
            ),
            array(
                'key' => 'field_tool_download_url', 'label' => 'Download URL (if downloadable)',
                'name' => 'tool_download_url', 'type' => 'url', 'placeholder' => 'https://',
                'instructions' => 'Only for downloadable tools. Leave blank for web-based tools.',
            ),
            array(
                'key' => 'field_tool_icon', 'label' => 'Tool Icon',
                'name' => 'tool_icon', 'type' => 'image',
                'return_format' => 'id', 'preview_size' => 'thumbnail',
                'instructions' => 'Small square icon for the tool card (recommended: 128×128px).',
            ),

            // ── Tab: Documentation ──
            array(
                'key' => 'field_tool_tab_docs', 'label' => 'Documentation',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_tool_instructions', 'label' => 'How to Use (Instructions)',
                'name' => 'tool_instructions', 'type' => 'wysiwyg',
                'tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0,
                'instructions' => 'Step-by-step usage instructions shown on the single tool page.',
            ),
            array(
                'key' => 'field_tool_features', 'label' => 'Key Features',
                'name' => 'tool_features', 'type' => 'textarea', 'rows' => 4,
                'placeholder' => "• Feature 1\n• Feature 2\n• Feature 3",
            ),
            array(
                'key' => 'field_tool_limitations', 'label' => 'Known Limitations',
                'name' => 'tool_limitations', 'type' => 'textarea', 'rows' => 3,
                'placeholder' => "• File size limit: 50 MB\n• Free tier: 5 conversions/day",
            ),

            // ── Tab: Status ──
            array(
                'key' => 'field_tool_tab_status', 'label' => 'Status',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key'           => 'field_tool_status_field', 'label' => 'Tool Status',
                'name'          => 'tool_status_field', 'type' => 'select',
                'choices'       => array(
                    'Active'      => '✅ Active',
                    'Updated'     => '🔄 Recently Updated',
                    'Maintenance' => '🔧 Under Maintenance',
                    'Deprecated'  => '⚠️ Deprecated',
                    'Removed'     => '❌ Removed',
                ),
                'default_value' => 'Active', 'required' => 1,
            ),
            array(
                'key'     => 'field_tool_related',
                'label'   => 'Related Tools',
                'name'    => 'tool_related_posts',
                'type'    => 'relationship',
                'post_type' => array( 'tools' ),
                'filters' => array( 'search' ),
                'max'     => 4,
                'return_format' => 'object',
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'tools' ) ),
        ),
        'menu_order' => 0, 'position' => 'normal', 'style' => 'default',
        'label_placement' => 'top', 'instruction_placement' => 'label', 'active' => true,
    ) );


    // ============================================================
    // 7. NEWS FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_news_details',
        'title'  => '📰 News Article Details',
        'fields' => array(

            // ── Tab: Article Info ──
            array(
                'key' => 'field_news_tab_info', 'label' => 'Article Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_news_title', 'label' => 'News Headline',
                'name' => 'news_title', 'type' => 'text', 'required' => 1,
                'placeholder' => 'e.g., OpenAI Releases GPT-5 with Advanced Reasoning',
                'instructions' => 'The clickable news headline. Should be clear and factual.',
            ),
            array(
                'key'     => 'field_news_category_field', 'label' => 'News Category',
                'name'    => 'news_category_field', 'type' => 'select',
                'choices' => array(
                    'AI News'       => '🤖 AI News',
                    'Software News' => '💻 Software News',
                    'Games News'    => '🎮 Games News',
                    'OS News'       => '🖥️ OS News',
                    'Themes News'   => '🎨 Themes & Plugins News',
                    'Tools News'    => '⚙️ Tools News',
                    'Movies News'   => '🎬 Movies News',
                    'Anime News'    => '🗾 Anime News',
                    'Tech General'  => '📱 General Tech',
                ),
                'required'      => 1,
                'default_value' => 'AI News',
            ),
            array(
                'key' => 'field_news_date', 'label' => 'Published Date',
                'name' => 'news_date', 'type' => 'date_picker',
                'display_format' => 'F j, Y', 'return_format' => 'Y-m-d', 'first_day' => 1,
                'instructions' => 'Original publication date of the news story.',
            ),
            array(
                'key' => 'field_news_author_name', 'label' => 'Author / Reporter Name',
                'name' => 'news_author_name', 'type' => 'text',
                'placeholder' => 'e.g., John Doe or Staff Reporter',
            ),

            // ── Tab: Source ──
            array(
                'key' => 'field_news_tab_source', 'label' => 'Source Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_news_source_name_field', 'label' => 'Source / Publisher Name',
                'name' => 'news_source_name_field', 'type' => 'text',
                'placeholder' => 'e.g., The Verge, BBC Tech, OpenAI Blog',
                'required' => 1,
                'instructions' => 'Name of the original publisher or source of this news.',
            ),
            array(
                'key' => 'field_news_source_url_field', 'label' => 'Source URL',
                'name' => 'news_source_url_field', 'type' => 'url',
                'placeholder' => 'https://theverge.com/...',
                'instructions' => 'Direct URL to the original article. Used for attribution and SEO.',
            ),

            // ── Tab: Content ──
            array(
                'key' => 'field_news_tab_content', 'label' => 'Content',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_news_summary', 'label' => 'Short Summary (Excerpt)',
                'name' => 'news_summary', 'type' => 'textarea', 'rows' => 3,
                'placeholder' => '2–3 sentence summary of the key news points...',
                'instructions' => 'Used for article cards, meta descriptions, and Open Graph previews.',
            ),
            array(
                'key' => 'field_news_full_content', 'label' => 'Full News Content',
                'name' => 'news_full_content', 'type' => 'wysiwyg',
                'tabs' => 'all', 'toolbar' => 'full', 'media_upload' => 1,
                'instructions' => 'Paste the full article text here. Alternatively, leave empty and use the WordPress editor (post content area above) for the main article body.',
            ),
            array(
                'key' => 'field_news_related', 'label' => 'Related Resources',
                'name' => 'news_related_resources', 'type' => 'relationship',
                'post_type' => array( 'software', 'tools', 'github_repos', 'news' ),
                'filters' => array( 'search', 'post_type' ),
                'max' => 4,
                'return_format' => 'object',
                'instructions' => 'Link related software, tools, or repositories to this article.',
            ),

            // ── Tab: SEO ──
            array(
                'key' => 'field_news_tab_seo', 'label' => 'SEO',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_news_seo_keyword', 'label' => 'SEO Focus Keyword',
                'name' => 'news_seo_keyword', 'type' => 'text',
                'placeholder' => 'e.g., GPT-5 release date features',
                'instructions' => 'Primary keyword for this article\'s SEO targeting.',
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'news' ) ),
        ),
        'menu_order' => 0, 'position' => 'normal', 'style' => 'default',
        'label_placement' => 'top', 'instruction_placement' => 'label', 'active' => true,
    ) );


    // ============================================================
    // 8. GITHUB REPOSITORIES FIELD GROUP
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_github_repos_details',
        'title'  => '🐙 GitHub Repository Details',
        'fields' => array(

            // ── Tab: Core ──
            array(
                'key' => 'field_repo_tab_core', 'label' => 'Repository Information',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_repo_name', 'label' => 'Repository Name',
                'name' => 'repo_name', 'type' => 'text', 'required' => 1,
                'placeholder' => 'e.g., llama.cpp',
                'instructions' => 'The exact repository name as shown on GitHub.',
            ),
            array(
                'key' => 'field_repo_short_desc', 'label' => 'Short Description',
                'name' => 'repo_short_description', 'type' => 'textarea', 'rows' => 2,
                'placeholder' => 'One-line description from GitHub...',
                'instructions' => 'Mirrors the GitHub repository description. Shown in cards.',
            ),
            array(
                'key' => 'field_repo_github_url', 'label' => 'GitHub Repository URL',
                'name' => 'repo_github_url', 'type' => 'url', 'required' => 1,
                'placeholder' => 'https://github.com/ggerganov/llama.cpp',
                'instructions' => 'Full GitHub URL. Must be the correct, public repository.',
            ),
            array(
                'key' => 'field_repo_owner_name', 'label' => 'Owner / Organization Name',
                'name' => 'repo_owner_name', 'type' => 'text',
                'placeholder' => 'e.g., ggerganov',
            ),
            array(
                'key'     => 'field_repo_language_field', 'label' => 'Primary Programming Language',
                'name'    => 'repo_language_field', 'type' => 'select',
                'choices' => array(
                    'Python'     => 'Python',
                    'JavaScript' => 'JavaScript',
                    'TypeScript' => 'TypeScript',
                    'C++'        => 'C++',
                    'C'          => 'C',
                    'Rust'       => 'Rust',
                    'Go'         => 'Go',
                    'Java'       => 'Java',
                    'PHP'        => 'PHP',
                    'Ruby'       => 'Ruby',
                    'Swift'      => 'Swift',
                    'Kotlin'     => 'Kotlin',
                    'Shell'      => 'Shell / Bash',
                    'HTML/CSS'   => 'HTML/CSS',
                    'Multiple'   => 'Multiple Languages',
                ),
                'allow_null' => 1,
            ),
            array(
                'key'     => 'field_repo_license_field', 'label' => 'License',
                'name'    => 'repo_license_field', 'type' => 'select',
                'choices' => array(
                    'MIT'          => 'MIT License',
                    'Apache 2.0'   => 'Apache 2.0',
                    'GPL v2'       => 'GNU GPL v2',
                    'GPL v3'       => 'GNU GPL v3',
                    'BSD 2-Clause' => 'BSD 2-Clause',
                    'BSD 3-Clause' => 'BSD 3-Clause',
                    'CC BY'        => 'Creative Commons BY',
                    'CC0'          => 'CC0 (Public Domain)',
                    'Unlicense'    => 'The Unlicense',
                    'Other'        => 'Other Open Source',
                ),
                'allow_null' => 1,
            ),

            // ── Tab: Statistics ──
            array(
                'key' => 'field_repo_tab_stats', 'label' => 'Statistics',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_repo_stars_count', 'label' => 'Stars Count',
                'name' => 'repo_stars_count', 'type' => 'number',
                'min' => 0, 'placeholder' => 'e.g., 45000',
                'instructions' => 'Current GitHub stars. Update periodically.',
            ),
            array(
                'key' => 'field_repo_forks_count', 'label' => 'Forks Count',
                'name' => 'repo_forks_count', 'type' => 'number',
                'min' => 0, 'placeholder' => 'e.g., 3200',
            ),

            // ── Tab: Technical ──
            array(
                'key' => 'field_repo_tab_tech', 'label' => 'Technical Details',
                'type' => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key' => 'field_repo_doc_url', 'label' => 'Official Documentation URL',
                'name' => 'repo_doc_url', 'type' => 'url', 'placeholder' => 'https://',
            ),
            array(
                'key' => 'field_repo_install_cmd', 'label' => 'Installation Command',
                'name' => 'repo_install_cmd', 'type' => 'text',
                'placeholder' => 'pip install package-name OR git clone https://...',
                'instructions' => 'The primary command to install or clone the repo. Shown with copy button.',
            ),
            array(
                'key' => 'field_repo_use_case', 'label' => 'Use Case / Problem It Solves',
                'name' => 'repo_use_case', 'type' => 'textarea', 'rows' => 3,
                'placeholder' => 'Describe what problem this repo solves and who benefits from using it...',
            ),
            array(
                'key'     => 'field_repo_difficulty', 'label' => 'Difficulty Level',
                'name'    => 'repo_difficulty', 'type' => 'select',
                'choices' => array(
                    'Beginner'     => '🟢 Beginner',
                    'Intermediate' => '🟡 Intermediate',
                    'Advanced'     => '🔴 Advanced',
                ),
                'allow_null'    => 0,
                'default_value' => 'Intermediate',
                'required'      => 1,
            ),
            array(
                'key' => 'field_repo_last_updated', 'label' => 'Last Updated Date',
                'name' => 'repo_last_updated', 'type' => 'date_picker',
                'display_format' => 'F j, Y', 'return_format' => 'Y-m-d', 'first_day' => 1,
                'instructions' => 'Date the repository was last meaningfully updated.',
            ),
            array(
                'key'     => 'field_repo_related',
                'label'   => 'Related Repositories',
                'name'    => 'repo_related',
                'type'    => 'relationship',
                'post_type' => array( 'github_repos' ),
                'filters' => array( 'search' ),
                'max'     => 4,
                'return_format' => 'object',
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'github_repos' ) ),
        ),
        'menu_order' => 0, 'position' => 'normal', 'style' => 'default',
        'label_placement' => 'top', 'instruction_placement' => 'label', 'active' => true,
    ) );


    // ============================================================
    // 9. GLOBAL SEO FIELDS (All 8 CPTs + Post + Page)
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_global_seo',
        'title'  => '🔍 SEO Settings',
        'fields' => array(

            array(
                'key'   => 'field_seo_tab', 'label' => 'SEO Fields',
                'type'  => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),
            array(
                'key'          => 'field_seo_title',
                'label'        => 'SEO Title',
                'name'         => 'seo_title',
                'type'         => 'text',
                'placeholder'  => 'SEO-optimised title (50–60 characters)',
                'instructions' => 'Overrides the browser tab/search engine title. Leave blank to use the post title.',
                'maxlength'    => 70,
            ),
            array(
                'key'          => 'field_seo_meta_description',
                'label'        => 'Meta Description',
                'name'         => 'seo_meta_description',
                'type'         => 'textarea',
                'rows'         => 2,
                'placeholder'  => 'Compelling meta description (120–160 characters)',
                'instructions' => 'Shown below your title in Google search results.',
                'maxlength'    => 165,
            ),
            array(
                'key'         => 'field_seo_focus_keyword',
                'label'       => 'Focus Keyword',
                'name'        => 'seo_focus_keyword',
                'type'        => 'text',
                'placeholder' => 'e.g., free VLC media player download',
                'instructions' => 'Primary SEO keyword this page should rank for.',
            ),
            array(
                'key'           => 'field_seo_og_image',
                'label'         => 'Open Graph / Social Share Image',
                'name'          => 'seo_og_image',
                'type'          => 'image',
                'return_format' => 'id',
                'preview_size'  => 'medium',
                'instructions'  => 'Image shown when shared on Facebook, Twitter, LinkedIn (recommended: 1200×630px).',
            ),
            array(
                'key'         => 'field_seo_canonical_url',
                'label'       => 'Canonical URL',
                'name'        => 'seo_canonical_url',
                'type'        => 'url',
                'placeholder' => 'https://quantummentorworld.com/...',
                'instructions' => 'Override the canonical URL if this content is duplicated elsewhere. Leave blank for auto.',
            ),
            array(
                'key'          => 'field_seo_noindex',
                'label'        => 'Hide from Search Engines (Noindex)',
                'name'         => 'seo_noindex',
                'type'         => 'true_false',
                'message'      => 'Set noindex meta tag (hide this page from Google)',
                'default_value'=> 0,
                'ui'           => 1,
                'instructions' => '⚠️ Only enable if you want this page excluded from search results.',
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'software' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'themes_plugins' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'games' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'books' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'watch' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'tools' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'news' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'github_repos' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'page' ) ),
        ),
        'menu_order'            => 100, // Push to bottom of edit screen
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ) );


    // ============================================================
    // 10. GLOBAL ADMIN CONTROL FIELDS (All 8 CPTs + Post + Page)
    // ============================================================
    acf_add_local_field_group( array(
        'key'    => 'group_global_admin_controls',
        'title'  => '🛡️ Admin Controls & Verification',
        'fields' => array(

            array(
                'key'   => 'field_admin_tab', 'label' => 'Admin Controls',
                'type'  => 'tab', 'placement' => 'top', 'endpoint' => 0,
            ),

            // ── Verification Toggles ──
            array(
                'key'          => 'field_admin_verified',
                'label'        => 'Verified Resource',
                'name'         => 'admin_verified',
                'type'         => 'true_false',
                'message'      => '✅ This resource has been manually verified by an admin',
                'default_value'=> 0,
                'ui'           => 1,
                'ui_on_text'   => 'Verified',
                'ui_off_text'  => 'Pending',
                'instructions' => 'Toggle ON only after confirming the resource is legal and safe.',
            ),
            array(
                'key'          => 'field_admin_source_confirmed',
                'label'        => 'Official Source Confirmed',
                'name'         => 'admin_source_confirmed',
                'type'         => 'true_false',
                'message'      => '🔗 Source URL has been confirmed as official',
                'default_value'=> 0,
                'ui'           => 1,
                'ui_on_text'   => 'Confirmed',
                'ui_off_text'  => 'Unconfirmed',
                'instructions' => 'Toggle ON after verifying the official website/download URL is correct.',
            ),
            array(
                'key'          => 'field_admin_safety_checked',
                'label'        => 'Safety Checked',
                'name'         => 'admin_safety_checked',
                'type'         => 'true_false',
                'message'      => '🛡️ This download/link has been scanned and is malware-free',
                'default_value'=> 0,
                'ui'           => 1,
                'ui_on_text'   => 'Safe',
                'ui_off_text'  => 'Not Checked',
                'instructions' => 'Toggle ON only after scanning downloadable files for malware.',
            ),

            // ── Admin Notes ──
            array(
                'key'          => 'field_admin_notes',
                'label'        => 'Admin Notes (Internal)',
                'name'         => 'admin_notes',
                'type'         => 'textarea',
                'rows'         => 3,
                'placeholder'  => 'Internal notes about this resource, legal status, source verification, etc.',
                'instructions' => '⚠️ These notes are INTERNAL ONLY. They will NOT appear on the frontend.',
            ),

            // ── Content Priority ──
            array(
                'key'          => 'field_admin_priority',
                'label'        => 'Content Priority',
                'name'         => 'admin_priority',
                'type'         => 'select',
                'choices'      => array(
                    'Normal'   => 'Normal',
                    'Featured' => '⭐ Featured (shown in hero/spotlight)',
                    'Trending' => '🔥 Trending (shown in trending section)',
                    'Popular'  => '👥 Popular (shown in popular section)',
                ),
                'default_value' => 'Normal',
                'allow_null'    => 0,
                'instructions'  => 'Controls where this content appears in featured/trending/popular sections.',
            ),

            // ── Resource Status ──
            array(
                'key'          => 'field_admin_resource_status',
                'label'        => 'Resource Status',
                'name'         => 'resource_status',
                'type'         => 'select',
                'choices'      => array(
                    'Active'     => 'Active',
                    'Updated'    => 'Updated',
                    'Deprecated' => 'Deprecated',
                    'Removed'    => 'Removed',
                ),
                'default_value' => 'Active',
                'allow_null'    => 0,
                'instructions'  => 'Status of this resource (Active, Updated, Deprecated, Removed).',
            ),

        ),
        'location' => array(
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'software' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'themes_plugins' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'games' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'books' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'watch' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'tools' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'news' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'github_repos' ) ),
            array( array( 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ) ),
        ),
        'menu_order'            => 110, // Below SEO group
        'position'              => 'side',   // Shows in the right sidebar panel
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ) );

} // end qmw_register_all_acf_fields()


// ============================================================
// HELPER: Safe Embed URL Builder
// ============================================================

/**
 * Converts a YouTube/Vimeo/Dailymotion watch URL to an embeddable
 * iframe-safe URL. Falls back to the original URL if unrecognised.
 *
 * Used in single-watch.php and single-games.php templates.
 *
 * @param string $url  Raw video URL
 * @return string      <iframe> HTML string or empty string
 */
if ( ! function_exists( 'quantum_get_safe_embed' ) ) {
    function quantum_get_safe_embed( $url ) {
        if ( empty( $url ) ) {
            return '';
        }

        $embed_url = $url;

        // YouTube: convert watch URL to embed URL
        if ( preg_match( '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches ) ) {
            $embed_url = 'https://www.youtube.com/embed/' . $matches[1] . '?rel=0&modestbranding=1';
        }
        // Vimeo
        elseif ( preg_match( '/vimeo\.com\/(\d+)/', $url, $matches ) ) {
            $embed_url = 'https://player.vimeo.com/video/' . $matches[1];
        }
        // Dailymotion
        elseif ( preg_match( '/dailymotion\.com\/video\/([a-zA-Z0-9]+)/', $url, $matches ) ) {
            $embed_url = 'https://www.dailymotion.com/embed/video/' . $matches[1];
        }

        return sprintf(
            '<iframe src="%s" width="100%%" height="100%%" frameborder="0" allowfullscreen loading="lazy" title="Video embed" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"></iframe>',
            esc_url( $embed_url )
        );
    }
}
