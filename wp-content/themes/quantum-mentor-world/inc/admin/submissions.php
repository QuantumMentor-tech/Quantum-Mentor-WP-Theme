<?php
/**
 * Quantum Mentor World — User Submissions Backend Workflow
 *
 * Registers the submissions CPT, admin meta boxes, and frontend submission AJAX handler.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── 1. Register CPT ──
function qmw_register_submissions_cpt() {
    register_post_type( 'user_submissions', array(
        'labels' => array(
            'name'               => 'User Submissions',
            'singular_name'      => 'User Submission',
            'menu_name'          => 'Submissions',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Submission',
            'edit_item'          => 'Review Submission',
            'all_items'          => 'Submissions',
            'view_item'          => 'View Submission',
        ),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
        'supports'           => array( 'title', 'editor' ),
        'menu_icon'          => 'dashicons-upload',
        'menu_position'      => 21,
    ) );
}
add_action( 'init', 'qmw_register_submissions_cpt' );

// ── 2. Add Details Meta Box ──
add_action( 'add_meta_boxes', 'qmw_add_submissions_meta_box' );

function qmw_add_submissions_meta_box() {
    add_meta_box(
        'qmw_submission_details',
        '📥 Resource Submission Details',
        'qmw_render_submission_details_meta_box',
        'user_submissions',
        'normal',
        'high'
    );
}

function qmw_render_submission_details_meta_box( $post ) {
    $type = get_post_meta( $post->ID, 'submission_type', true );
    $category = get_post_meta( $post->ID, 'submission_category', true );
    $url = get_post_meta( $post->ID, 'submission_url', true );
    $name = get_post_meta( $post->ID, 'submission_user_name', true );
    $email = get_post_meta( $post->ID, 'submission_user_email', true );
    $notes = get_post_meta( $post->ID, 'submission_notes', true );
    $legal = get_post_meta( $post->ID, 'submission_legal_confirmed', true );

    echo '<table class="form-table qmw-admin-table">';
    echo '  <tr>';
    echo '    <th><strong>Suggested Title</strong></th>';
    echo '    <td>' . esc_html( $post->post_title ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Resource Type</strong></th>';
    echo '    <td><span class="qmw-badge qmw-badge-' . esc_attr( $type ) . '">' . esc_html( ucfirst( $type ) ) . '</span></td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Suggested Category</strong></th>';
    echo '    <td>' . esc_html( $category ?: 'None' ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Official / Source URL</strong></th>';
    echo '    <td><a href="' . esc_url( $url ) . '" target="_blank" rel="nofollow noopener noreferrer">' . esc_url( $url ) . ' ↗</a></td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Description / Content</strong></th>';
    echo '    <td>' . nl2br( esc_html( $post->post_content ) ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Submitted By</strong></th>';
    echo '    <td><strong>' . esc_html( $name ) . '</strong> (<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>)</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>User Notes</strong></th>';
    echo '    <td>' . esc_html( $notes ?: 'No notes provided.' ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Legal Agreement Status</strong></th>';
    echo '    <td>' . ( $legal ? '✅ <strong style="color:green;">Yes</strong> - Confirmed resource is legal, official, public-domain, or creator-approved.' : '❌ <strong style="color:red;">No</strong>' ) . '</td>';
    echo '  </tr>';
    echo '</table>';
}

// ── 3. Frontend AJAX Submission Handler ──
add_action( 'wp_ajax_qmw_submit_resource', 'qmw_handle_resource_submission' );
add_action( 'wp_ajax_nopriv_qmw_submit_resource', 'qmw_handle_resource_submission' );

function qmw_handle_resource_submission() {
    // Nonce verification
    if ( ! isset( $_POST['qmw_nonce'] ) || ! wp_verify_nonce( $_POST['qmw_nonce'], 'qmw_submit_resource_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security token expired. Please refresh the page and try again.' ) );
    }

    // Required fields check
    $title      = isset( $_POST['res_title'] ) ? sanitize_text_field( $_POST['res_title'] ) : '';
    $type       = isset( $_POST['res_type'] ) ? sanitize_text_field( $_POST['res_type'] ) : '';
    $category   = isset( $_POST['res_category'] ) ? sanitize_text_field( $_POST['res_category'] ) : '';
    $url        = isset( $_POST['res_url'] ) ? esc_url_raw( $_POST['res_url'] ) : '';
    $desc       = isset( $_POST['res_desc'] ) ? sanitize_textarea_field( $_POST['res_desc'] ) : '';
    $user_name  = isset( $_POST['user_name'] ) ? sanitize_text_field( $_POST['user_name'] ) : '';
    $user_email = isset( $_POST['user_email'] ) ? sanitize_email( $_POST['user_email'] ) : '';
    $notes      = isset( $_POST['notes'] ) ? sanitize_textarea_field( $_POST['notes'] ) : '';
    $legal      = isset( $_POST['legal_confirm'] ) ? 1 : 0;

    if ( empty( $title ) || empty( $type ) || empty( $url ) || empty( $user_name ) || empty( $user_email ) || ! $legal ) {
        wp_send_json_error( array( 'message' => 'All mandatory fields must be filled and the legal checkbox checked.' ) );
    }

    // Insert as user_submissions with pending status
    $post_data = array(
        'post_title'   => $title,
        'post_content' => $desc,
        'post_status'  => 'pending',
        'post_type'    => 'user_submissions',
    );

    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) || ! $post_id ) {
        wp_send_json_error( array( 'message' => 'Could not process submission due to an internal server error.' ) );
    }

    // Save metadata
    update_post_meta( $post_id, 'submission_type', $type );
    update_post_meta( $post_id, 'submission_category', $category );
    update_post_meta( $post_id, 'submission_url', $url );
    update_post_meta( $post_id, 'submission_user_name', $user_name );
    update_post_meta( $post_id, 'submission_user_email', $user_email );
    update_post_meta( $post_id, 'submission_notes', $notes );
    update_post_meta( $post_id, 'submission_legal_confirmed', $legal );

    // Admin notification email
    $admin_email = get_option( 'admin_email' );
    $subject = 'New Resource Submission - Quantum Mentor World';
    $message = "A new resource has been submitted on Quantum Mentor World.\n\n";
    $message .= "Resource Title: " . $title . "\n";
    $message .= "Resource Type: " . $type . "\n";
    $message .= "Category: " . $category . "\n";
    $message .= "Source URL: " . $url . "\n";
    $message .= "Submitted By: " . $user_name . " (" . $user_email . ")\n";
    $message .= "User Notes: " . $notes . "\n\n";
    $message .= "Admin Review Note: Log in to the administrator backend to review, verify, and approve this resource.\n";

    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );

    wp_mail( $admin_email, $subject, $message, $headers );

    wp_send_json_success( array( 'message' => 'Thank you! Your resource suggestion has been received and is pending administrative review.' ) );
}
