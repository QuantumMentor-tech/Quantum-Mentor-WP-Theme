<?php
/**
 * Quantum Mentor World — Contact Messages Custom Post Type & Handler
 *
 * Registers the contact_messages CPT, admin meta box for status updates,
 * and AJAX form submission handling.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── 1. Register CPT ──
function qmw_register_contact_messages_cpt() {
    register_post_type( 'contact_messages', array(
        'labels' => array(
            'name'               => 'Contact Messages',
            'singular_name'      => 'Contact Message',
            'menu_name'          => 'Contacts',
            'all_items'          => 'Contact Messages',
            'view_item'          => 'View Message',
        ),
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'capability_type'    => 'post',
        'map_meta_cap'       => true,
        'supports'           => array( 'title', 'editor' ),
        'menu_icon'          => 'dashicons-email',
        'menu_position'      => 22,
    ) );
}
add_action( 'init', 'qmw_register_contact_messages_cpt' );

// ── 2. Metabox for Viewing & Updating Message Details/Status ──
add_action( 'add_meta_boxes', 'qmw_add_contact_messages_meta_box' );

function qmw_add_contact_messages_meta_box() {
    add_meta_box(
        'qmw_contact_details',
        '✉️ Contact Message Details & Review',
        'qmw_render_contact_details_meta_box',
        'contact_messages',
        'normal',
        'high'
    );
}

function qmw_render_contact_details_meta_box( $post ) {
    // Nonce field for security
    wp_nonce_field( 'qmw_save_contact_status_action', 'qmw_contact_status_nonce' );

    $name   = get_post_meta( $post->ID, 'contact_name', true );
    $email  = get_post_meta( $post->ID, 'contact_email', true );
    $status = get_post_meta( $post->ID, 'contact_status', true ) ?: 'New';

    echo '<table class="form-table qmw-admin-table">';
    echo '  <tr>';
    echo '    <th><strong>Sender Name</strong></th>';
    echo '    <td>' . esc_html( $name ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Sender Email</strong></th>';
    echo '    <td><a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a></td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Subject</strong></th>';
    echo '    <td>' . esc_html( $post->post_title ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Message</strong></th>';
    echo '    <td>' . nl2br( esc_html( $post->post_content ) ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Received Date</strong></th>';
    echo '    <td>' . esc_html( get_the_date( 'F j, Y, g:i a', $post ) ) . '</td>';
    echo '  </tr>';
    echo '  <tr>';
    echo '    <th><strong>Message Status</strong></th>';
    echo '    <td>';
    echo '      <select name="qmw_contact_status" id="qmw_contact_status">';
    foreach ( array( 'New', 'Read', 'Replied', 'Archived' ) as $s ) {
        printf( '<option value="%s" %s>%s</option>', esc_attr( $s ), selected( $status, $s, false ), esc_html( $s ) );
    }
    echo '      </select>';
    echo '    </td>';
    echo '  </tr>';
    echo '</table>';
}

// Save contact status selection on post update
add_action( 'save_post_contact_messages', 'qmw_save_contact_message_status' );

function qmw_save_contact_message_status( $post_id ) {
    if ( ! isset( $_POST['qmw_contact_status_nonce'] ) || ! wp_verify_nonce( $_POST['qmw_contact_status_nonce'], 'qmw_save_contact_status_action' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['qmw_contact_status'] ) ) {
        $status = sanitize_text_field( $_POST['qmw_contact_status'] );
        if ( in_array( $status, array( 'New', 'Read', 'Replied', 'Archived' ), true ) ) {
            update_post_meta( $post_id, 'contact_status', $status );
        }
    }
}

// ── 3. Frontend AJAX Form Submission Handler ──
add_action( 'wp_ajax_qmw_contact_form_submit', 'qmw_handle_contact_form_submission' );
add_action( 'wp_ajax_nopriv_qmw_contact_form_submit', 'qmw_handle_contact_form_submission' );

function qmw_handle_contact_form_submission() {
    // Nonce verification
    if ( ! isset( $_POST['qmw_nonce'] ) || ! wp_verify_nonce( $_POST['qmw_nonce'], 'qmw_contact_form_action' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please refresh and try again.' ) );
    }

    // Required fields check
    $name    = isset( $_POST['contact_name'] ) ? sanitize_text_field( $_POST['contact_name'] ) : '';
    $email   = isset( $_POST['contact_email'] ) ? sanitize_email( $_POST['contact_email'] ) : '';
    $subject = isset( $_POST['contact_subject'] ) ? sanitize_text_field( $_POST['contact_subject'] ) : '';
    $msg     = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( $_POST['contact_message'] ) : '';

    if ( empty( $name ) || empty( $email ) || empty( $subject ) || empty( $msg ) ) {
        wp_send_json_error( array( 'message' => 'All fields are required.' ) );
    }

    // Insert contact message into custom CPT
    $post_data = array(
        'post_title'   => $subject,
        'post_content' => $msg,
        'post_status'  => 'publish', // Published internally so it's queryable
        'post_type'    => 'contact_messages',
    );

    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) || ! $post_id ) {
        wp_send_json_error( array( 'message' => 'Could not save message due to a server error. Please try again.' ) );
    }

    // Save fields
    update_post_meta( $post_id, 'contact_name', $name );
    update_post_meta( $post_id, 'contact_email', $email );
    update_post_meta( $post_id, 'contact_status', 'New' );

    // Optional admin email notification (soft action)
    $admin_email = get_option( 'admin_email' );
    $email_subject = 'New Contact Message: ' . $subject . ' - Quantum Mentor World';
    $email_body = "You have received a new contact message from $name ($email).\n\nSubject: $subject\n\nMessage:\n$msg\n\nReview this message here: " . admin_url( 'post.php?post=' . $post_id . '&action=edit' );
    $headers = array( 'Content-Type: text/plain; charset=UTF-8' );

    wp_mail( $admin_email, $email_subject, $email_body, $headers );

    wp_send_json_success( array( 'message' => 'Your message has been sent successfully. We will get back to you shortly!' ) );
}
