<?php
/**
 * Programmatic ACF field groups registration for Quantum Mentor World
 *
 * @package Quantum_Mentor_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

add_action( 'acf/init', 'quantum_mentor_register_acf_fields' );

function quantum_mentor_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    /**
     * 1. Software CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_software_details',
        'title' => 'Software Specifications',
        'fields' => array(
            array(
                'key' => 'field_software_name',
                'label' => 'Software Name',
                'name' => 'software_name',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_software_version',
                'label' => 'Version',
                'name' => 'software_version',
                'type' => 'text',
                'placeholder' => 'e.g., v2.5.0',
            ),
            array(
                'key' => 'field_software_platform',
                'label' => 'Platform',
                'name' => 'software_platform',
                'type' => 'checkbox',
                'choices' => array(
                    'Windows' => 'Windows',
                    'Mac'     => 'macOS',
                    'Linux'   => 'Linux',
                    'Android' => 'Android',
                    'iPhone'  => 'iPhone / iOS',
                ),
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_software_developer',
                'label' => 'Developer',
                'name' => 'software_developer',
                'type' => 'text',
            ),
            array(
                'key' => 'field_software_license',
                'label' => 'License Type',
                'name' => 'software_license',
                'type' => 'text',
                'placeholder' => 'e.g., Open Source, Freeware',
            ),
            array(
                'key' => 'field_software_size',
                'label' => 'File Size',
                'name' => 'software_size',
                'type' => 'text',
                'placeholder' => 'e.g., 45.2 MB',
            ),
            array(
                'key' => 'field_software_official_url',
                'label' => 'Official Website URL',
                'name' => 'software_official_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_software_download_url',
                'label' => 'Download URL',
                'name' => 'software_download_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_software_github_url',
                'label' => 'GitHub Repository URL',
                'name' => 'software_github_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_software_screenshots',
                'label' => 'Screenshots Gallery',
                'name' => 'software_screenshots',
                'type' => 'gallery',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_software_system_requirements',
                'label' => 'System Requirements',
                'name' => 'software_system_requirements',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_software_installation_guide',
                'label' => 'Installation Guide',
                'name' => 'software_installation_guide',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_software_safety_note',
                'label' => 'Safety Note',
                'name' => 'software_safety_note',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Verified 100% legal & malware-free.',
            ),
            array(
                'key' => 'field_software_changelog',
                'label' => 'Changelog',
                'name' => 'software_changelog',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_software_last_updated',
                'label' => 'Last Updated Date',
                'name' => 'software_last_updated',
                'type' => 'date_picker',
                'display_format' => 'F j, Y',
                'return_format' => 'Y-m-d',
            ),
            array(
                'key' => 'field_software_status',
                'label' => 'Resource Status',
                'name' => 'software_status',
                'type' => 'select',
                'choices' => array(
                    'Active'     => 'Active',
                    'Updated'    => 'Updated',
                    'Deprecated' => 'Deprecated',
                    'Removed'    => 'Removed',
                ),
                'default_value' => 'Active',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'software',
                ),
            ),
        ),
    ) );

    /**
     * 2. Themes & Plugins CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_themes_plugins_details',
        'title' => 'Theme & Plugin Specifications',
        'fields' => array(
            array(
                'key' => 'field_tp_name',
                'label' => 'Item Name',
                'name' => 'tp_name',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_tp_platform',
                'label' => 'Platform',
                'name' => 'tp_platform',
                'type' => 'select',
                'choices' => array(
                    'WordPress'   => 'WordPress',
                    'WooCommerce' => 'WooCommerce',
                    'Shopify'     => 'Shopify',
                    'Hostinger'   => 'Hostinger',
                    'GoDaddy'     => 'GoDaddy',
                    'Blogger'     => 'Blogger',
                ),
            ),
            array(
                'key' => 'field_tp_type',
                'label' => 'Type',
                'name' => 'tp_type',
                'type' => 'radio',
                'choices' => array(
                    'Theme'  => 'Theme',
                    'Plugin' => 'Plugin',
                ),
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_tp_version',
                'label' => 'Version',
                'name' => 'tp_version',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tp_developer',
                'label' => 'Developer',
                'name' => 'tp_developer',
                'type' => 'text',
            ),
            array(
                'key' => 'field_tp_license',
                'label' => 'License Type',
                'name' => 'tp_license',
                'type' => 'text',
                'default_value' => 'GPL',
            ),
            array(
                'key' => 'field_tp_official_url',
                'label' => 'Official Website URL',
                'name' => 'tp_official_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_tp_download_url',
                'label' => 'Download URL',
                'name' => 'tp_download_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_tp_demo_url',
                'label' => 'Demo URL',
                'name' => 'tp_demo_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_tp_documentation_url',
                'label' => 'Documentation URL',
                'name' => 'tp_documentation_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_tp_screenshots',
                'label' => 'Screenshots Gallery',
                'name' => 'tp_screenshots',
                'type' => 'gallery',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_tp_requirements',
                'label' => 'Requirements',
                'name' => 'tp_requirements',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_tp_installation_guide',
                'label' => 'Installation Guide',
                'name' => 'tp_installation_guide',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_tp_last_updated',
                'label' => 'Last Updated Date',
                'name' => 'tp_last_updated',
                'type' => 'date_picker',
                'display_format' => 'F j, Y',
                'return_format' => 'Y-m-d',
            ),
            array(
                'key' => 'field_tp_status',
                'label' => 'Resource Status',
                'name' => 'tp_status',
                'type' => 'select',
                'choices' => array(
                    'Active'     => 'Active',
                    'Updated'    => 'Updated',
                    'Deprecated' => 'Deprecated',
                    'Removed'    => 'Removed',
                ),
                'default_value' => 'Active',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'themes_plugins',
                ),
            ),
        ),
    ) );

    /**
     * 3. Games CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_games_details',
        'title' => 'Game Specifications',
        'fields' => array(
            array(
                'key' => 'field_game_name',
                'label' => 'Game Name',
                'name' => 'game_name',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_game_platform',
                'label' => 'Platform',
                'name' => 'game_platform',
                'type' => 'checkbox',
                'choices' => array(
                    'PC'      => 'PC',
                    'Mobile'  => 'Mobile',
                    'Browser' => 'Browser',
                    'Console' => 'Console',
                ),
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_game_genre_field',
                'label' => 'Genre',
                'name' => 'game_genre_field',
                'type' => 'text',
            ),
            array(
                'key' => 'field_game_developer',
                'label' => 'Developer',
                'name' => 'game_developer',
                'type' => 'text',
            ),
            array(
                'key' => 'field_game_license',
                'label' => 'License Type',
                'name' => 'game_license',
                'type' => 'text',
            ),
            array(
                'key' => 'field_game_size',
                'label' => 'File Size',
                'name' => 'game_size',
                'type' => 'text',
            ),
            array(
                'key' => 'field_game_version',
                'label' => 'Version',
                'name' => 'game_version',
                'type' => 'text',
            ),
            array(
                'key' => 'field_game_official_url',
                'label' => 'Official Website URL',
                'name' => 'game_official_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_game_download_url',
                'label' => 'Download URL',
                'name' => 'game_download_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_game_trailer_url',
                'label' => 'Trailer Embed URL',
                'name' => 'game_trailer_url',
                'type' => 'text',
                'placeholder' => 'e.g., YouTube embed iframe code or video URL',
            ),
            array(
                'key' => 'field_game_screenshots',
                'label' => 'Screenshots Gallery',
                'name' => 'game_screenshots',
                'type' => 'gallery',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_game_requirements',
                'label' => 'System Requirements',
                'name' => 'game_requirements',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_game_installation_guide',
                'label' => 'Installation Guide',
                'name' => 'game_installation_guide',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_game_last_updated',
                'label' => 'Last Updated Date',
                'name' => 'game_last_updated',
                'type' => 'date_picker',
                'display_format' => 'F j, Y',
                'return_format' => 'Y-m-d',
            ),
            array(
                'key' => 'field_game_status',
                'label' => 'Resource Status',
                'name' => 'game_status',
                'type' => 'select',
                'choices' => array(
                    'Active'     => 'Active',
                    'Updated'    => 'Updated',
                    'Deprecated' => 'Deprecated',
                    'Removed'    => 'Removed',
                ),
                'default_value' => 'Active',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'games',
                ),
            ),
        ),
    ) );

    /**
     * 4. Books CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_books_details',
        'title' => 'Book Specifications',
        'fields' => array(
            array(
                'key' => 'field_book_title_field',
                'label' => 'Book Title',
                'name' => 'book_title_field',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_book_author_field',
                'label' => 'Author',
                'name' => 'book_author_field',
                'type' => 'text',
            ),
            array(
                'key' => 'field_book_publisher',
                'label' => 'Publisher',
                'name' => 'book_publisher',
                'type' => 'text',
            ),
            array(
                'key' => 'field_book_language_field',
                'label' => 'Language',
                'name' => 'book_language_field',
                'type' => 'text',
                'default_value' => 'English',
            ),
            array(
                'key' => 'field_book_pages_count',
                'label' => 'Pages',
                'name' => 'book_pages_count',
                'type' => 'number',
            ),
            array(
                'key' => 'field_book_type',
                'label' => 'Book Type',
                'name' => 'book_type',
                'type' => 'select',
                'choices' => array(
                    'Free'               => 'Free Download',
                    'Public Domain'      => 'Public Domain',
                    'Open Access'        => 'Open Access',
                    'Paid Official Link' => 'Paid (Official Redirect Link)',
                ),
                'default_value' => 'Free',
            ),
            array(
                'key' => 'field_book_format',
                'label' => 'Format',
                'name' => 'book_format',
                'type' => 'checkbox',
                'choices' => array(
                    'PDF'         => 'PDF',
                    'EPUB'        => 'EPUB',
                    'MOBI'        => 'MOBI',
                    'DOCX'        => 'DOCX',
                    'Online Read' => 'Online Read',
                ),
                'layout' => 'horizontal',
            ),
            array(
                'key' => 'field_book_official_url',
                'label' => 'Official Source URL',
                'name' => 'book_official_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_book_download_url',
                'label' => 'Download URL',
                'name' => 'book_download_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_book_read_online_url',
                'label' => 'Read Online URL',
                'name' => 'book_read_online_url',
                'type' => 'url',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_book_format',
                            'operator' => '==',
                            'value' => 'Online Read',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_book_cover',
                'label' => 'Cover Image',
                'name' => 'book_cover',
                'type' => 'image',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_book_summary',
                'label' => 'Short Summary',
                'name' => 'book_summary',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_book_toc',
                'label' => 'Table of Contents',
                'name' => 'book_toc',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_book_pub_year',
                'label' => 'Publication Year',
                'name' => 'book_pub_year',
                'type' => 'number',
            ),
            array(
                'key' => 'field_book_license_note',
                'label' => 'License/Copyright Note',
                'name' => 'book_license_note',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Licensed for legal free distribution.',
            ),
            array(
                'key' => 'field_book_status',
                'label' => 'Resource Status',
                'name' => 'book_status',
                'type' => 'select',
                'choices' => array(
                    'Active'     => 'Active',
                    'Updated'    => 'Updated',
                    'Deprecated' => 'Deprecated',
                    'Removed'    => 'Removed',
                ),
                'default_value' => 'Active',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'books',
                ),
            ),
        ),
    ) );

    /**
     * 5. Watch Content CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_watch_details',
        'title' => 'Watch Media Specifications',
        'fields' => array(
            array(
                'key' => 'field_watch_title',
                'label' => 'Content Title',
                'name' => 'watch_title',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_watch_type',
                'label' => 'Content Type',
                'name' => 'watch_type',
                'type' => 'select',
                'choices' => array(
                    'Movie'       => 'Movie',
                    'Course'      => 'Course',
                    'Anime'       => 'Anime',
                    'Donghua'     => 'Donghua',
                    'Tutorial'    => 'Tutorial',
                    'Documentary' => 'Documentary',
                ),
                'required' => 1,
            ),
            array(
                'key' => 'field_watch_poster',
                'label' => 'Poster Image',
                'name' => 'watch_poster',
                'type' => 'image',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_watch_banner',
                'label' => 'Cover Banner',
                'name' => 'watch_banner',
                'type' => 'image',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_watch_language_field',
                'label' => 'Language',
                'name' => 'watch_language_field',
                'type' => 'text',
            ),
            array(
                'key' => 'field_watch_genre_field',
                'label' => 'Genre',
                'name' => 'watch_genre_field',
                'type' => 'text',
            ),
            array(
                'key' => 'field_watch_release_year_field',
                'label' => 'Release Year',
                'name' => 'watch_release_year_field',
                'type' => 'number',
            ),
            array(
                'key' => 'field_watch_status_field',
                'label' => 'Status',
                'name' => 'watch_status_field',
                'type' => 'select',
                'choices' => array(
                    'Ongoing'   => 'Ongoing',
                    'Completed' => 'Completed',
                    'Upcoming'  => 'Upcoming',
                ),
                'default_value' => 'Completed',
            ),
            array(
                'key' => 'field_watch_short_desc',
                'label' => 'Short Description',
                'name' => 'watch_short_desc',
                'type' => 'textarea',
                'rows' => 2,
            ),
            
            // Embed servers for single media (Movies / Documentaries)
            array(
                'key' => 'field_watch_srv1_name',
                'label' => 'Embed Server 1 Name',
                'name' => 'watch_srv1_name',
                'type' => 'text',
                'default_value' => 'Official Stream',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Movie',
                        ),
                    ),
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Documentary',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_watch_srv1_url',
                'label' => 'Embed Server 1 HTML Code / URL',
                'name' => 'watch_srv1_url',
                'type' => 'textarea',
                'rows' => 2,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Movie',
                        ),
                    ),
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Documentary',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_watch_srv2_name',
                'label' => 'Embed Server 2 Name',
                'name' => 'watch_srv2_name',
                'type' => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Movie',
                        ),
                    ),
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Documentary',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_watch_srv2_url',
                'label' => 'Embed Server 2 HTML Code / URL',
                'name' => 'watch_srv2_url',
                'type' => 'textarea',
                'rows' => 2,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Movie',
                        ),
                    ),
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Documentary',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_watch_srv3_name',
                'label' => 'Embed Server 3 Name',
                'name' => 'watch_srv3_name',
                'type' => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Movie',
                        ),
                    ),
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Documentary',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_watch_srv3_url',
                'label' => 'Embed Server 3 HTML Code / URL',
                'name' => 'watch_srv3_url',
                'type' => 'textarea',
                'rows' => 2,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Movie',
                        ),
                    ),
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '==',
                            'value' => 'Documentary',
                        ),
                    ),
                ),
            ),

            // Episodes list (For series, courses, anime, donghua)
            array(
                'key' => 'field_watch_episodes_list',
                'label' => 'Episodes Index (Course Modules)',
                'name' => 'watch_episodes_list',
                'type' => 'repeater',
                'layout' => 'block',
                'button_label' => 'Add Episode / Module',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '!=',
                            'value' => 'Movie',
                        ),
                        array(
                            'field' => 'field_watch_type',
                            'operator' => '!=',
                            'value' => 'Documentary',
                        ),
                    ),
                ),
                'sub_fields' => array(
                    array(
                        'key' => 'field_episode_num',
                        'label' => 'Episode/Module Number',
                        'name' => 'episode_num',
                        'type' => 'number',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_episode_title',
                        'label' => 'Title',
                        'name' => 'episode_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_episode_desc',
                        'label' => 'Short Description',
                        'name' => 'episode_desc',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_ep_srv1_url',
                        'label' => 'Server 1 HTML/Iframe Code',
                        'name' => 'ep_srv1_url',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_ep_srv2_url',
                        'label' => 'Server 2 HTML/Iframe Code',
                        'name' => 'ep_srv2_url',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                    array(
                        'key' => 'field_ep_srv3_url',
                        'label' => 'Server 3 HTML/Iframe Code',
                        'name' => 'ep_srv3_url',
                        'type' => 'textarea',
                        'rows' => 2,
                    ),
                ),
            ),
            array(
                'key' => 'field_watch_official_url',
                'label' => 'Official Creator Source Link',
                'name' => 'watch_official_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_watch_legal_note',
                'label' => 'Legal Permission & Licensing Note',
                'name' => 'watch_legal_note',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Streamed legally using official embedded player sources.',
            ),
            array(
                'key' => 'field_watch_related_posts',
                'label' => 'Related Content',
                'name' => 'watch_related_posts',
                'type' => 'relationship',
                'post_type' => array( 'watch' ),
                'filters' => array( 'search', 'taxonomy' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'watch',
                ),
            ),
        ),
    ) );

    /**
     * 6. Tools CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_tools_details',
        'title' => 'Online Tool Specifications',
        'fields' => array(
            array(
                'key' => 'field_tool_name_field',
                'label' => 'Tool Name',
                'name' => 'tool_name_field',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_tool_type_field',
                'label' => 'Tool Type',
                'name' => 'tool_type_field',
                'type' => 'text',
                'placeholder' => 'e.g., Conversion, PDF Utility',
            ),
            array(
                'key' => 'field_tool_description_field',
                'label' => 'Tool Description',
                'name' => 'tool_description_field',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_tool_access_type',
                'label' => 'Tool Access Type',
                'name' => 'tool_access_type',
                'type' => 'select',
                'choices' => array(
                    'Built-in Tool'      => 'Built-in Tool (In-site Sandbox Embed)',
                    'External Tool'      => 'External Tool (Redirect Page link)',
                    'Downloadable Tool'  => 'Downloadable Tool (Binary Utility)',
                ),
                'default_value' => 'Built-in Tool',
                'required' => 1,
            ),
            array(
                'key' => 'field_tool_url_field',
                'label' => 'Tool External Access URL',
                'name' => 'tool_url_field',
                'type' => 'url',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_tool_access_type',
                            'operator' => '==',
                            'value' => 'External Tool',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_tool_download_url',
                'label' => 'Tool Direct Download URL',
                'name' => 'tool_download_url',
                'type' => 'url',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_tool_access_type',
                            'operator' => '==',
                            'value' => 'Downloadable Tool',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_tool_icon_field',
                'label' => 'Tool Icon',
                'name' => 'tool_icon_field',
                'type' => 'image',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_tool_instructions',
                'label' => 'Instructions for Use',
                'name' => 'tool_instructions',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_tool_features',
                'label' => 'Key Features',
                'name' => 'tool_features',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_tool_limitations',
                'label' => 'Tool Limitations',
                'name' => 'tool_limitations',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_tool_status_field',
                'label' => 'Tool Status',
                'name' => 'tool_status_field',
                'type' => 'select',
                'choices' => array(
                    'Active'     => 'Active (Online)',
                    'Deprecated' => 'Deprecated',
                    'Offline'    => 'Offline',
                ),
                'default_value' => 'Active',
            ),
            array(
                'key' => 'field_tool_related_posts',
                'label' => 'Related Tools',
                'name' => 'tool_related_posts',
                'type' => 'relationship',
                'post_type' => array( 'tools' ),
                'filters' => array( 'search' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tools',
                ),
            ),
        ),
    ) );

    /**
     * 7. News CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_news_details',
        'title' => 'News Specifications',
        'fields' => array(
            array(
                'key' => 'field_news_title_field',
                'label' => 'News Title',
                'name' => 'news_title_field',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_news_category_field',
                'label' => 'Editorial Category',
                'name' => 'news_category_field',
                'type' => 'text',
            ),
            array(
                'key' => 'field_news_source_name_field',
                'label' => 'Source Name',
                'name' => 'news_source_name_field',
                'type' => 'text',
            ),
            array(
                'key' => 'field_news_source_url_field',
                'label' => 'Original Source URL',
                'name' => 'news_source_url_field',
                'type' => 'url',
            ),
            array(
                'key' => 'field_news_featured_image',
                'label' => 'Cover Image',
                'name' => 'news_featured_image',
                'type' => 'image',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_news_summary',
                'label' => 'Short Summary',
                'name' => 'news_summary',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_news_full_content',
                'label' => 'Full News Content',
                'name' => 'news_full_content',
                'type' => 'wysiwyg',
            ),
            array(
                'key' => 'field_news_date',
                'label' => 'Published Date',
                'name' => 'news_date',
                'type' => 'date_picker',
                'display_format' => 'F j, Y',
                'return_format' => 'Y-m-d',
            ),
            array(
                'key' => 'field_news_author_name',
                'label' => 'Author Name',
                'name' => 'news_author_name',
                'type' => 'text',
            ),
            array(
                'key' => 'field_news_related_resources',
                'label' => 'Related Resources',
                'name' => 'news_related_resources',
                'type' => 'relationship',
                'post_type' => array( 'software', 'tools', 'github_repos' ),
            ),
            array(
                'key' => 'field_news_seo_keyword',
                'label' => 'SEO Focus Keyword',
                'name' => 'news_seo_keyword',
                'type' => 'text',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'news',
                ),
            ),
        ),
    ) );

    /**
     * 8. GitHub Repository CPT Field Group
     */
    acf_add_local_field_group( array(
        'key' => 'group_github_repos_details',
        'title' => 'GitHub Repository Specifications',
        'fields' => array(
            array(
                'key' => 'field_repo_name_field',
                'label' => 'Repository Name',
                'name' => 'repo_name_field',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_repo_description',
                'label' => 'Short Description',
                'name' => 'repo_description',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_repo_github_url',
                'label' => 'GitHub Project URL',
                'name' => 'repo_github_url',
                'type' => 'url',
                'required' => 1,
            ),
            array(
                'key' => 'field_repo_language_field',
                'label' => 'Primary Programming Language',
                'name' => 'repo_language_field',
                'type' => 'text',
                'placeholder' => 'e.g., Python, Rust',
            ),
            array(
                'key' => 'field_repo_license_field',
                'label' => 'License',
                'name' => 'repo_license_field',
                'type' => 'text',
                'default_value' => 'MIT',
            ),
            array(
                'key' => 'field_repo_stars_count',
                'label' => 'Stars Count',
                'name' => 'repo_stars_count',
                'type' => 'number',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_repo_forks_count',
                'label' => 'Forks Count',
                'name' => 'repo_forks_count',
                'type' => 'number',
                'default_value' => 0,
            ),
            array(
                'key' => 'field_repo_owner_name',
                'label' => 'Owner Name/Organization',
                'name' => 'repo_owner_name',
                'type' => 'text',
            ),
            array(
                'key' => 'field_repo_doc_url',
                'label' => 'Official Documentation URL',
                'name' => 'repo_doc_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_repo_install_cmd',
                'label' => 'Installation Command',
                'name' => 'repo_install_cmd',
                'type' => 'text',
                'placeholder' => 'e.g., pip install package-name',
            ),
            array(
                'key' => 'field_repo_use_case',
                'label' => 'Use Case',
                'name' => 'repo_use_case',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_repo_difficulty',
                'label' => 'Difficulty Level',
                'name' => 'repo_difficulty',
                'type' => 'select',
                'choices' => array(
                    'Beginner'     => 'Beginner',
                    'Intermediate' => 'Intermediate',
                    'Advanced'     => 'Advanced',
                ),
                'default_value' => 'Beginner',
            ),
            array(
                'key' => 'field_repo_last_updated',
                'label' => 'Last Updated Date',
                'name' => 'repo_last_updated',
                'type' => 'date_picker',
                'display_format' => 'F j, Y',
                'return_format' => 'Y-m-d',
            ),
            array(
                'key' => 'field_repo_related',
                'label' => 'Related Repositories',
                'name' => 'repo_related',
                'type' => 'relationship',
                'post_type' => array( 'github_repos' ),
                'filters' => array( 'search' ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'github_repos',
                ),
            ),
        ),
    ) );

    /**
     * 9. Global SEO Fields Group (Applied to all 8 CPTs)
     */
    acf_add_local_field_group( array(
        'key' => 'group_global_seo',
        'title' => 'Search Engine Optimization (SEO)',
        'fields' => array(
            array(
                'key' => 'field_seo_title',
                'label' => 'SEO Title',
                'name' => 'seo_title',
                'type' => 'text',
                'placeholder' => 'H1 title fallback if empty',
            ),
            array(
                'key' => 'field_seo_meta_desc',
                'label' => 'Meta Description',
                'name' => 'seo_meta_desc',
                'type' => 'textarea',
                'rows' => 2,
                'placeholder' => 'Max 160 characters describing the resource.',
            ),
            array(
                'key' => 'field_seo_focus_keyword',
                'label' => 'Focus Keyword',
                'name' => 'seo_focus_keyword',
                'type' => 'text',
            ),
            array(
                'key' => 'field_seo_og_image',
                'label' => 'Open Graph Image',
                'name' => 'seo_og_image',
                'type' => 'image',
                'return_format' => 'id',
            ),
            array(
                'key' => 'field_seo_canonical_url',
                'label' => 'Canonical URL',
                'name' => 'seo_canonical_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_seo_noindex',
                'label' => 'Noindex Tag Toggle',
                'name' => 'seo_noindex',
                'type' => 'true_false',
                'message' => 'Tell search engines not to index this resource.',
                'default_value' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'software',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'themes_plugins',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'games',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'books',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'watch',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tools',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'news',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'github_repos',
                ),
            ),
        ),
        'menu_order' => 90,
        'position' => 'normal',
    ) );

    /**
     * 10. Global Admin Control Fields Group (Applied to Downloadable Post types)
     */
    acf_add_local_field_group( array(
        'key' => 'group_global_admin_controls',
        'title' => 'Admin Validation & Licensing Controls',
        'fields' => array(
            array(
                'key' => 'field_admin_verified',
                'label' => 'Verified Resource Toggle',
                'name' => 'admin_verified',
                'type' => 'true_false',
                'message' => 'Confirmed 100% legal, uncracked, and malware-free',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_admin_source_confirmed',
                'label' => 'Official Source Confirmed Toggle',
                'name' => 'admin_source_confirmed',
                'type' => 'true_false',
                'message' => 'Direct official release links verified',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_admin_safety_checked',
                'label' => 'Safety Checked Toggle',
                'name' => 'admin_safety_checked',
                'type' => 'true_false',
                'message' => 'Scanned against virus, trojan, and spyware models',
                'default_value' => 1,
            ),
            array(
                'key' => 'field_admin_notes',
                'label' => 'Internal Admin Notes',
                'name' => 'admin_notes',
                'type' => 'textarea',
                'rows' => 2,
            ),
            array(
                'key' => 'field_admin_priority',
                'label' => 'Content Priority Placement',
                'name' => 'admin_priority',
                'type' => 'select',
                'choices' => array(
                    'Normal'   => 'Normal Grid Placement',
                    'Featured' => 'Featured Hero Banner Carousel',
                    'Trending' => 'Trending Section Placement',
                    'Popular'  => 'Popular Query Placement',
                ),
                'default_value' => 'Normal',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'software',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'themes_plugins',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'games',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'books',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tools',
                ),
            ),
        ),
        'menu_order' => 100,
        'position' => 'side',
    ) );
}
