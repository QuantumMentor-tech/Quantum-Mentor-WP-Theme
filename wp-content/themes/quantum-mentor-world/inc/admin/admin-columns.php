<?php
/**
 * Quantum Mentor World — Custom Admin Columns Configuration
 *
 * Implements custom columns and cell contents for all CPTs.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ============================================================
// 1. HELPERS FOR BADGES & MARKS
// ============================================================

function qmw_admin_get_priority_badge( $priority ) {
    $priority = $priority ? $priority : 'Normal';
    $class = strtolower( $priority );
    $icon = '';
    switch ( $priority ) {
        case 'Featured': $icon = '⭐ '; break;
        case 'Trending': $icon = '🔥 '; break;
        case 'Popular':  $icon = '👥 '; break;
    }
    return sprintf( '<span class="qmw-col-badge qmw-badge-pri-%s">%s%s</span>', esc_attr( $class ), $icon, esc_html( $priority ) );
}

function qmw_admin_get_status_badge( $status ) {
    $status = $status ? $status : 'Active';
    $class = strtolower( $status );
    return sprintf( '<span class="qmw-col-badge qmw-badge-stat-%s">%s</span>', esc_attr( $class ), esc_html( $status ) );
}

function qmw_admin_get_verified_mark( $val ) {
    return $val ? '<span class="qmw-col-verify qmw-verified">✅ Verified</span>' : '<span class="qmw-col-verify qmw-pending">⏳ Pending</span>';
}

function qmw_admin_render_thumbnail( $post_id ) {
    if ( has_post_thumbnail( $post_id ) ) {
        return get_the_post_thumbnail( $post_id, array( 40, 40 ), array( 'style' => 'border-radius:4px; object-fit:cover;' ) );
    }
    return '<span class="qmw-no-thumb" style="display:inline-block;width:40px;height:40px;background:#f0f0f0;border:1px solid #ddd;border-radius:4px;line-height:40px;text-align:center;color:#999;font-size:10px;">None</span>';
}

// ============================================================
// 2. REGISTER COLUMNS & HANDLERS BY POST TYPE
// ============================================================

// ── Software ──
add_filter( 'manage_software_posts_columns', 'qmw_set_software_columns' );
add_action( 'manage_software_posts_custom_column', 'qmw_render_software_columns', 10, 2 );

function qmw_set_software_columns( $columns ) {
    $new_columns = array(
        'cb'               => $columns['cb'],
        'qmw_thumb'        => 'Thumbnail',
        'title'            => $columns['title'],
        'qmw_platform'     => 'Platform',
        'qmw_license'      => 'License Type',
        'qmw_version'      => 'Version',
        'qmw_status'       => 'Resource Status',
        'qmw_priority'     => 'Content Priority',
        'qmw_verified'     => 'Verified',
        'date'             => 'Last Updated',
    );
    return $new_columns;
}

function qmw_render_software_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_thumb':
            echo qmw_admin_render_thumbnail( $post_id );
            break;
        case 'qmw_platform':
            $platforms = get_field( 'software_platform', $post_id );
            echo $platforms ? esc_html( implode( ', ', (array) $platforms ) ) : '—';
            break;
        case 'qmw_license':
            echo esc_html( get_field( 'software_license', $post_id ) ?: '—' );
            break;
        case 'qmw_version':
            echo esc_html( get_field( 'software_version', $post_id ) ?: '—' );
            break;
        case 'qmw_status':
            echo qmw_admin_get_status_badge( get_field( 'resource_status', $post_id ) );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
        case 'qmw_verified':
            echo qmw_admin_get_verified_mark( get_field( 'admin_verified', $post_id ) );
            break;
    }
}

// ── Themes & Plugins ──
add_filter( 'manage_themes_plugins_posts_columns', 'qmw_set_themes_plugins_columns' );
add_action( 'manage_themes_plugins_posts_custom_column', 'qmw_render_themes_plugins_columns', 10, 2 );

function qmw_set_themes_plugins_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'qmw_thumb'        => 'Thumbnail',
        'title'            => $columns['title'],
        'qmw_platform'     => 'Platform',
        'qmw_type'         => 'Type',
        'qmw_license'      => 'License Type',
        'qmw_version'      => 'Version',
        'qmw_status'       => 'Resource Status',
        'qmw_priority'     => 'Content Priority',
        'qmw_verified'     => 'Verified',
        'date'             => $columns['date'],
    );
}

function qmw_render_themes_plugins_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_thumb':
            echo qmw_admin_render_thumbnail( $post_id );
            break;
        case 'qmw_platform':
            echo esc_html( get_field( 'tp_platform', $post_id ) ?: '—' );
            break;
        case 'qmw_type':
            echo esc_html( get_field( 'tp_type', $post_id ) ?: '—' );
            break;
        case 'qmw_license':
            echo esc_html( get_field( 'tp_license', $post_id ) ?: '—' );
            break;
        case 'qmw_version':
            echo esc_html( get_field( 'tp_version', $post_id ) ?: '—' );
            break;
        case 'qmw_status':
            echo qmw_admin_get_status_badge( get_field( 'resource_status', $post_id ) );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
        case 'qmw_verified':
            echo qmw_admin_get_verified_mark( get_field( 'admin_verified', $post_id ) );
            break;
    }
}

// ── Games ──
add_filter( 'manage_games_posts_columns', 'qmw_set_games_columns' );
add_action( 'manage_games_posts_custom_column', 'qmw_render_games_columns', 10, 2 );

function qmw_set_games_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'qmw_thumb'        => 'Thumbnail',
        'title'            => $columns['title'],
        'qmw_platform'     => 'Platform',
        'qmw_genre'        => 'Genre',
        'qmw_license'      => 'License Type',
        'qmw_status'       => 'Resource Status',
        'qmw_priority'     => 'Content Priority',
        'qmw_verified'     => 'Verified',
        'date'             => $columns['date'],
    );
}

function qmw_render_games_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_thumb':
            echo qmw_admin_render_thumbnail( $post_id );
            break;
        case 'qmw_platform':
            $platforms = get_field( 'game_platform', $post_id );
            echo $platforms ? esc_html( implode( ', ', (array) $platforms ) ) : '—';
            break;
        case 'qmw_genre':
            echo esc_html( get_field( 'game_genre_field', $post_id ) ?: '—' );
            break;
        case 'qmw_license':
            echo esc_html( get_field( 'game_license', $post_id ) ?: '—' );
            break;
        case 'qmw_status':
            echo qmw_admin_get_status_badge( get_field( 'resource_status', $post_id ) );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
        case 'qmw_verified':
            echo qmw_admin_get_verified_mark( get_field( 'admin_verified', $post_id ) );
            break;
    }
}

// ── Books ──
add_filter( 'manage_books_posts_columns', 'qmw_set_books_columns' );
add_action( 'manage_books_posts_custom_column', 'qmw_render_books_columns', 10, 2 );

function qmw_set_books_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'qmw_thumb'        => 'Cover',
        'title'            => $columns['title'],
        'qmw_author'       => 'Author',
        'qmw_lang'         => 'Language',
        'qmw_book_type'    => 'Book Type',
        'qmw_format'       => 'Format',
        'qmw_status'       => 'Resource Status',
        'qmw_priority'     => 'Content Priority',
        'qmw_verified'     => 'Verified',
        'date'             => $columns['date'],
    );
}

function qmw_render_books_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_thumb':
            echo qmw_admin_render_thumbnail( $post_id );
            break;
        case 'qmw_author':
            echo esc_html( get_field( 'book_author_field', $post_id ) ?: '—' );
            break;
        case 'qmw_lang':
            echo esc_html( get_field( 'book_language_field', $post_id ) ?: '—' );
            break;
        case 'qmw_book_type':
            echo esc_html( get_field( 'book_type', $post_id ) ?: '—' );
            break;
        case 'qmw_format':
            $formats = get_field( 'book_format', $post_id );
            echo $formats ? esc_html( implode( ', ', (array) $formats ) ) : '—';
            break;
        case 'qmw_status':
            echo qmw_admin_get_status_badge( get_field( 'resource_status', $post_id ) );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
        case 'qmw_verified':
            echo qmw_admin_get_verified_mark( get_field( 'admin_verified', $post_id ) );
            break;
    }
}

// ── Watch Content ──
add_filter( 'manage_watch_posts_columns', 'qmw_set_watch_columns' );
add_action( 'manage_watch_posts_custom_column', 'qmw_render_watch_columns', 10, 2 );

function qmw_set_watch_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'qmw_thumb'        => 'Poster',
        'title'            => $columns['title'],
        'qmw_watch_type'   => 'Content Type',
        'qmw_lang'         => 'Language',
        'qmw_watch_status' => 'Status',
        'qmw_status'       => 'Resource Status',
        'qmw_priority'     => 'Content Priority',
        'qmw_verified'     => 'Verified',
        'date'             => $columns['date'],
    );
}

function qmw_render_watch_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_thumb':
            // Poster image is in ACF watch_poster or fallback to thumbnail
            $poster_id = get_field( 'watch_poster', $post_id );
            if ( $poster_id ) {
                echo wp_get_attachment_image( $poster_id, array( 40, 40 ), false, array( 'style' => 'border-radius:4px; object-fit:cover;' ) );
            } else {
                echo qmw_admin_render_thumbnail( $post_id );
            }
            break;
        case 'qmw_watch_type':
            echo esc_html( get_field( 'watch_type', $post_id ) ?: '—' );
            break;
        case 'qmw_lang':
            echo esc_html( get_field( 'watch_language_field', $post_id ) ?: '—' );
            break;
        case 'qmw_watch_status':
            echo esc_html( get_field( 'watch_status_field', $post_id ) ?: '—' );
            break;
        case 'qmw_status':
            echo qmw_admin_get_status_badge( get_field( 'resource_status', $post_id ) );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
        case 'qmw_verified':
            echo qmw_admin_get_verified_mark( get_field( 'admin_verified', $post_id ) );
            break;
    }
}

// ── Tools ──
add_filter( 'manage_tools_posts_columns', 'qmw_set_tools_columns' );
add_action( 'manage_tools_posts_custom_column', 'qmw_render_tools_columns', 10, 2 );

function qmw_set_tools_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'qmw_thumb'        => 'Icon',
        'title'            => $columns['title'],
        'qmw_tool_type'    => 'Tool Type',
        'qmw_access'       => 'Access Type',
        'qmw_status'       => 'Tool Status', // Resource Status
        'qmw_priority'     => 'Content Priority',
        'qmw_verified'     => 'Verified',
        'date'             => $columns['date'],
    );
}

function qmw_render_tools_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_thumb':
            // Tool icon image is in ACF tool_icon or fallback to thumbnail
            $icon_id = get_field( 'tool_icon', $post_id );
            if ( $icon_id ) {
                echo wp_get_attachment_image( $icon_id, array( 40, 40 ), false, array( 'style' => 'border-radius:4px; object-fit:cover;' ) );
            } else {
                echo qmw_admin_render_thumbnail( $post_id );
            }
            break;
        case 'qmw_tool_type':
            echo esc_html( get_field( 'tool_type_field', $post_id ) ?: '—' );
            break;
        case 'qmw_access':
            echo esc_html( get_field( 'tool_access_type', $post_id ) ?: '—' );
            break;
        case 'qmw_status':
            echo qmw_admin_get_status_badge( get_field( 'resource_status', $post_id ) );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
        case 'qmw_verified':
            echo qmw_admin_get_verified_mark( get_field( 'admin_verified', $post_id ) );
            break;
    }
}

// ── News ──
add_filter( 'manage_news_posts_columns', 'qmw_set_news_columns' );
add_action( 'manage_news_posts_custom_column', 'qmw_render_news_columns', 10, 2 );

function qmw_set_news_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'qmw_thumb'        => 'Featured Image',
        'title'            => $columns['title'],
        'qmw_news_cat'     => 'News Category',
        'qmw_news_source'  => 'Source Name',
        'qmw_news_date'    => 'Published Date',
        'qmw_news_author'  => 'Author Name',
        'qmw_priority'     => 'Content Priority',
    );
}

function qmw_render_news_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_thumb':
            echo qmw_admin_render_thumbnail( $post_id );
            break;
        case 'qmw_news_cat':
            $terms = get_the_terms( $post_id, 'news_category' );
            if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
                $term_names = wp_list_pluck( $terms, 'name' );
                echo esc_html( implode( ', ', $term_names ) );
            } else {
                echo '—';
            }
            break;
        case 'qmw_news_source':
            echo esc_html( get_field( 'news_source_name', $post_id ) ?: '—' );
            break;
        case 'qmw_news_date':
            echo esc_html( get_the_date( 'Y-m-d', $post_id ) );
            break;
        case 'qmw_news_author':
            echo esc_html( get_field( 'news_author_name', $post_id ) ?: '—' );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
    }
}

// ── GitHub Repositories ──
add_filter( 'manage_github_repos_posts_columns', 'qmw_set_github_repos_columns' );
add_action( 'manage_github_repos_posts_custom_column', 'qmw_render_github_repos_columns', 10, 2 );

function qmw_set_github_repos_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'title'            => 'Repository Name',
        'qmw_repo_lang'    => 'Programming Language',
        'qmw_repo_license' => 'License',
        'qmw_repo_diff'    => 'Difficulty Level',
        'qmw_repo_stars'   => 'Stars Count',
        'qmw_priority'     => 'Content Priority',
        'date'             => $columns['date'],
    );
}

function qmw_render_github_repos_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_repo_lang':
            $langs = get_the_terms( $post_id, 'repo_language' );
            if ( ! empty( $langs ) && ! is_wp_error( $langs ) ) {
                $names = wp_list_pluck( $langs, 'name' );
                echo esc_html( implode( ', ', $names ) );
            } else {
                echo '—';
            }
            break;
        case 'qmw_repo_license':
            $licenses = get_the_terms( $post_id, 'repo_license' );
            if ( ! empty( $licenses ) && ! is_wp_error( $licenses ) ) {
                $names = wp_list_pluck( $licenses, 'name' );
                echo esc_html( implode( ', ', $names ) );
            } else {
                echo '—';
            }
            break;
        case 'qmw_repo_diff':
            echo esc_html( get_field( 'repo_difficulty', $post_id ) ?: '—' );
            break;
        case 'qmw_repo_stars':
            echo esc_html( number_format( (int) get_field( 'repo_stars_count', $post_id ) ) );
            break;
        case 'qmw_priority':
            echo qmw_admin_get_priority_badge( get_field( 'admin_priority', $post_id ) );
            break;
    }
}

// ── User Submissions ──
add_filter( 'manage_user_submissions_posts_columns', 'qmw_set_user_submissions_columns' );
add_action( 'manage_user_submissions_posts_custom_column', 'qmw_render_user_submissions_columns', 10, 2 );

function qmw_set_user_submissions_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'title'            => 'Resource Title',
        'qmw_sub_type'     => 'Resource Type',
        'qmw_sub_cat'      => 'Category',
        'qmw_sub_url'      => 'URL',
        'qmw_sub_by'       => 'Submitted By',
        'qmw_sub_legal'    => 'Legal Confirmed',
        'date'             => 'Submitted Date',
    );
}

function qmw_render_user_submissions_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_sub_type':
            echo esc_html( get_post_meta( $post_id, 'submission_type', true ) ?: '—' );
            break;
        case 'qmw_sub_cat':
            echo esc_html( get_post_meta( $post_id, 'submission_category', true ) ?: '—' );
            break;
        case 'qmw_sub_url':
            $url = get_post_meta( $post_id, 'submission_url', true );
            if ( $url ) {
                echo '<a href="' . esc_url( $url ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $url ) . '</a>';
            } else {
                echo '—';
            }
            break;
        case 'qmw_sub_by':
            $name = get_post_meta( $post_id, 'submission_user_name', true );
            $email = get_post_meta( $post_id, 'submission_user_email', true );
            echo esc_html( $name ) . '<br><small style="color:#666;">' . esc_html( $email ) . '</small>';
            break;
        case 'qmw_sub_legal':
            $legal = get_post_meta( $post_id, 'submission_legal_confirmed', true );
            echo $legal ? '✅ Legal source confirmed' : '❌ No';
            break;
    }
}

// ── Contact Messages ──
add_filter( 'manage_contact_messages_posts_columns', 'qmw_set_contact_messages_columns' );
add_action( 'manage_contact_messages_posts_custom_column', 'qmw_render_contact_messages_columns', 10, 2 );

function qmw_set_contact_messages_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'title'            => 'Subject',
        'qmw_msg_sender'   => 'From',
        'qmw_msg_status'   => 'Status',
        'date'             => 'Date Received',
    );
}

function qmw_render_contact_messages_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_msg_sender':
            $name = get_post_meta( $post_id, 'contact_name', true );
            $email = get_post_meta( $post_id, 'contact_email', true );
            echo esc_html( $name ) . '<br><small style="color:#666;">' . esc_html( $email ) . '</small>';
            break;
        case 'qmw_msg_status':
            $status = get_post_meta( $post_id, 'contact_status', true ) ?: 'New';
            $class = strtolower( $status );
            echo '<span class="qmw-col-badge qmw-badge-msg-' . esc_attr( $class ) . '">' . esc_html( $status ) . '</span>';
            break;
    }
}

// ── Security Logs ──
add_filter( 'manage_security_logs_posts_columns', 'qmw_set_security_logs_columns' );
add_action( 'manage_security_logs_posts_custom_column', 'qmw_render_security_logs_columns', 10, 2 );

function qmw_set_security_logs_columns( $columns ) {
    return array(
        'cb'               => $columns['cb'],
        'title'            => 'Event Summary',
        'qmw_sec_user'     => 'Attempted Username',
        'qmw_sec_ip'       => 'IP Address',
        'date'             => 'Log Timestamp',
    );
}

function qmw_render_security_logs_columns( $column, $post_id ) {
    switch ( $column ) {
        case 'qmw_sec_user':
            echo esc_html( get_post_meta( $post_id, 'log_username', true ) ?: '—' );
            break;
        case 'qmw_sec_ip':
            echo esc_html( get_post_meta( $post_id, 'log_ip', true ) ?: '—' );
            break;
    }
}

// ============================================================
// 3. SORTABLE COLUMNS SEEDING
// ============================================================
function qmw_make_columns_sortable( $sortable_columns ) {
    $sortable_columns['qmw_status']   = 'qmw_status';
    $sortable_columns['qmw_priority'] = 'qmw_priority';
    $sortable_columns['qmw_verified'] = 'qmw_verified';
    return $sortable_columns;
}
add_filter( 'manage_edit-software_sortable_columns', 'qmw_make_columns_sortable' );
add_filter( 'manage_edit-themes_plugins_sortable_columns', 'qmw_make_columns_sortable' );
add_filter( 'manage_edit-games_sortable_columns', 'qmw_make_columns_sortable' );
add_filter( 'manage_edit-books_sortable_columns', 'qmw_make_columns_sortable' );
add_filter( 'manage_edit-watch_sortable_columns', 'qmw_make_columns_sortable' );
add_filter( 'manage_edit-tools_sortable_columns', 'qmw_make_columns_sortable' );
add_filter( 'manage_edit-github_repos_sortable_columns', 'qmw_make_columns_sortable' );
