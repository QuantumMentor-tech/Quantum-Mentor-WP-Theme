<?php
/**
 * Quantum Mentor World — Custom Admin Dashboard Widgets & Panel
 *
 * Implements dashboard stats counters, quick links, recent content list,
 * and review widgets.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Hook to register dashboard widgets
add_action( 'wp_dashboard_setup', 'qmw_add_dashboard_widgets' );

function qmw_add_dashboard_widgets() {
    if ( ! current_user_can( 'edit_posts' ) ) {
        return;
    }

    wp_add_dashboard_widget(
        'qmw_dashboard_stats',
        '📊 Quantum Mentor — Platform Statistics',
        'qmw_render_dashboard_stats_widget'
    );

    wp_add_dashboard_widget(
        'qmw_dashboard_quick_add',
        '⚡ Quantum Mentor — Quick Actions & Links',
        'qmw_render_dashboard_quick_add_widget'
    );

    wp_add_dashboard_widget(
        'qmw_dashboard_reviews',
        '🛡️ Quantum Mentor — Content Needing Review',
        'qmw_render_dashboard_reviews_widget'
    );
}

/**
 * Render Platform Statistics Widget
 */
function qmw_render_dashboard_stats_widget() {
    $cpts = array(
        'software'       => array( 'label' => 'Software', 'icon' => 'dashicons-desktop' ),
        'themes_plugins' => array( 'label' => 'Themes & Plugins', 'icon' => 'dashicons-admin-plugins' ),
        'games'          => array( 'label' => 'Games', 'icon' => 'dashicons-games' ),
        'books'          => array( 'label' => 'Books', 'icon' => 'dashicons-book-alt' ),
        'watch'          => array( 'label' => 'Watch Content', 'icon' => 'dashicons-video-alt3' ),
        'tools'          => array( 'label' => 'Tools', 'icon' => 'dashicons-admin-tools' ),
        'news'           => array( 'label' => 'News Articles', 'icon' => 'dashicons-megaphone' ),
        'github_repos'   => array( 'label' => 'GitHub Repos', 'icon' => 'dashicons-networking' ),
    );

    $pending_submissions = wp_count_posts( 'user_submissions' )->pending ?? 0;
    $unread_contacts = 0;
    
    // Count unread contact messages
    $contacts_query = new WP_Query( array(
        'post_type'      => 'contact_messages',
        'post_status'    => 'publish',
        'meta_query'     => array(
            array(
                'key'     => 'contact_status',
                'value'     => 'New',
                'compare' => '=',
            ),
        ),
        'fields'         => 'ids',
        'posts_per_page' => -1,
    ) );
    $unread_contacts = $contacts_query->found_posts;
    wp_reset_postdata();

    echo '<div class="qmw-dashboard-stats-grid">';
    
    foreach ( $cpts as $cpt => $data ) {
        $count = wp_count_posts( $cpt )->publish ?? 0;
        $url = admin_url( 'edit.php?post_type=' . $cpt );
        echo '<div class="qmw-stat-card">';
        echo '  <span class="dashicons ' . esc_attr( $data['icon'] ) . '"></span>';
        echo '  <div class="qmw-stat-details">';
        echo '    <span class="qmw-stat-count">' . esc_html( $count ) . '</span>';
        echo '    <a class="qmw-stat-label" href="' . esc_url( $url ) . '">' . esc_html( $data['label'] ) . '</a>';
        echo '  </div>';
        echo '</div>';
    }

    // Pending submissions
    $sub_url = admin_url( 'edit.php?post_type=user_submissions&post_status=pending' );
    echo '<div class="qmw-stat-card qmw-stat-pending ' . ( $pending_submissions > 0 ? 'highlight-pending' : '' ) . '">';
    echo '  <span class="dashicons dashicons-upload"></span>';
    echo '  <div class="qmw-stat-details">';
    echo '    <span class="qmw-stat-count">' . esc_html( $pending_submissions ) . '</span>';
    echo '    <a class="qmw-stat-label" href="' . esc_url( $sub_url ) . '">Pending Submissions</a>';
    echo '  </div>';
    echo '</div>';

    // Unread contacts
    $contact_url = admin_url( 'edit.php?post_type=contact_messages' );
    echo '<div class="qmw-stat-card qmw-stat-contacts ' . ( $unread_contacts > 0 ? 'highlight-contacts' : '' ) . '">';
    echo '  <span class="dashicons dashicons-email"></span>';
    echo '  <div class="qmw-stat-details">';
    echo '    <span class="qmw-stat-count">' . esc_html( $unread_contacts ) . '</span>';
    echo '    <a class="qmw-stat-label" href="' . esc_url( $contact_url ) . '">New Contact Messages</a>';
    echo '  </div>';
    echo '</div>';

    echo '</div>';
}

/**
 * Render Quick Add Panel & Recent Activity
 */
function qmw_render_dashboard_quick_add_widget() {
    $cpts = array(
        'software'       => 'Add Software',
        'books'          => 'Add Book',
        'tools'          => 'Add Tool',
        'watch'          => 'Add Watch Content',
        'news'           => 'Add News',
        'github_repos'   => 'Add GitHub Repo',
    );

    echo '<div class="qmw-quick-add-section">';
    echo '  <h4>Quick Add Resource</h4>';
    echo '  <div class="qmw-quick-add-buttons">';
    foreach ( $cpts as $cpt => $label ) {
        $url = admin_url( 'post-new.php?post_type=' . $cpt );
        echo '    <a href="' . esc_url( $url ) . '" class="button button-primary qmw-quick-btn">' . esc_html( $label ) . '</a>';
    }
    echo '  </div>';
    echo '</div>';

    // Recent Content List
    $recent = get_posts( array(
        'post_type'      => array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'news', 'github_repos' ),
        'posts_per_page' => 5,
        'post_status'    => 'any',
    ) );

    echo '<div class="qmw-recent-activity-section" style="margin-top: 15px; border-top: 1px solid #eee; padding-top: 10px;">';
    echo '  <h4>Recent Activity</h4>';
    if ( ! empty( $recent ) ) {
        echo '<ul class="qmw-recent-list">';
        foreach ( $recent as $p ) {
            $edit_url = get_edit_post_link( $p->ID );
            $post_type_obj = get_post_type_object( $p->post_type );
            $label = $post_type_obj ? $post_type_obj->labels->singular_name : $p->post_type;
            $status = get_post_status( $p->ID );
            
            echo '<li>';
            echo '  <span class="qmw-badge qmw-badge-' . esc_attr( $p->post_type ) . '">' . esc_html( $label ) . '</span>';
            echo '  <a href="' . esc_url( $edit_url ) . '"><strong>' . esc_html( $p->post_title ) . '</strong></a>';
            echo '  <span class="qmw-recent-meta">(' . esc_html( ucfirst( $status ) ) . ' - ' . esc_html( get_the_modified_date( 'M j, g:i a', $p ) ) . ')</span>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No recent activity found.</p>';
    }
    echo '</div>';
}

/**
 * Render Content Needing Review Widget
 */
function qmw_render_dashboard_reviews_widget() {
    $needs_review = get_posts( array(
        'post_type'      => array( 'software', 'themes_plugins', 'games', 'books', 'watch', 'tools', 'github_repos' ),
        'posts_per_page' => 5,
        'post_status'    => 'publish',
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => 'admin_verified',
                'value'   => '0',
                'compare' => '=',
            ),
            array(
                'key'     => 'admin_verified',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key'     => 'admin_safety_checked',
                'value'   => '0',
                'compare' => '=',
            ),
            array(
                'key'     => 'admin_safety_checked',
                'compare' => 'NOT EXISTS',
            ),
        ),
    ) );

    if ( ! empty( $needs_review ) ) {
        echo '<p class="description">The following published resources are missing verification or safety markings:</p>';
        echo '<ul class="qmw-review-list">';
        foreach ( $needs_review as $p ) {
            $edit_url = get_edit_post_link( $p->ID );
            $verified = get_post_meta( $p->ID, 'admin_verified', true );
            $safety = get_post_meta( $p->ID, 'admin_safety_checked', true );

            $issues = array();
            if ( ! $verified ) {
                $issues[] = '⚠️ Not Verified';
            }
            if ( ! $safety ) {
                $issues[] = '🛡️ Safety Unchecked';
            }

            echo '<li>';
            echo '  <a href="' . esc_url( $edit_url ) . '"><strong>' . esc_html( $p->post_title ) . '</strong></a>';
            echo '  <span class="qmw-issues-badge">' . esc_html( implode( ', ', $issues ) ) . '</span>';
            echo '</li>';
        }
        echo '</ul>';
        echo '<p><a href="' . esc_url( admin_url( 'edit.php?post_status=publish&post_type=software' ) ) . '" class="button button-secondary">Go to resources</a></p>';
    } else {
        echo '<p class="qmw-success-message">✅ All published resources are verified and safety checked!</p>';
    }
}
