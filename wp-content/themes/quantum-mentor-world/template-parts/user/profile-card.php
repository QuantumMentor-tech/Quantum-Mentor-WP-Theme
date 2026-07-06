<?php
/**
 * Template part for displaying the user profile card
 *
 * @package Quantum_Mentor_World
 */

if ( ! is_user_logged_in() ) {
    return;
}

$current_user = wp_get_current_user();
$roles = $current_user->roles;
$primary_role = ! empty( $roles ) ? $roles[0] : 'subscriber';

// Map roles to pretty labels
$role_labels = array(
    'administrator'       => '🚀 Super Admin',
    'qmw_content_manager' => '✍️ Content Manager',
    'qmw_editor'          => '📝 Quantum Editor',
    'qmw_contributor'     => '🧩 Contributor',
    'qmw_subscriber'      => '🎓 Member / Learner',
);

$pretty_role = isset( $role_labels[ $primary_role ] ) ? $role_labels[ $primary_role ] : ucfirst( $primary_role );

// Count comments by user
global $wpdb;
$comments_count = $wpdb->get_var( $wpdb->prepare(
    "SELECT COUNT(*) FROM $wpdb->comments WHERE user_id = %d AND comment_approved = 1",
    $current_user->ID
) ) ?: 0;

// Count submissions by user
$submissions_count = 0;
$user_subs = get_posts( array(
    'post_type'      => 'user_submissions',
    'post_status'    => 'any',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => 'submission_user_email',
            'value'   => $current_user->user_email,
            'compare' => '=',
        ),
    ),
    'fields'         => 'ids',
) );
if ( ! is_wp_error( $user_subs ) && ! empty( $user_subs ) ) {
    $submissions_count = count( $user_subs );
}
?>

<div class="qmw-glass-card qmw-profile-card">
    <div class="qmw-profile-avatar-wrapper">
        <?php echo get_avatar( $current_user->ID, 100, '', $current_user->display_name, array( 'class' => 'qmw-profile-avatar' ) ); ?>
    </div>
    
    <div class="qmw-profile-info-summary">
        <h4><?php echo esc_html( $current_user->display_name ?: $current_user->user_login ); ?></h4>
        <span class="qmw-profile-role-badge <?php echo esc_attr( 'qmw-role-' . str_replace( 'qmw_', '', $primary_role ) ); ?>">
            <?php echo esc_html( $pretty_role ); ?>
        </span>
    </div>

    <div class="qmw-profile-stats-grid" style="margin-top: 25px; border-top: 1px solid var(--border); padding-top: 20px;">
        <div class="qmw-profile-stat-box">
            <span class="stat-num"><?php echo esc_html( $submissions_count ); ?></span>
            <span class="stat-lbl">Submissions</span>
        </div>
        <div class="qmw-profile-stat-box">
            <span class="stat-num"><?php echo esc_html( $comments_count ); ?></span>
            <span class="stat-lbl">Comments</span>
        </div>
    </div>
</div>
