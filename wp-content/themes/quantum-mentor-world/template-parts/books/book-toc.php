<?php
/**
 * Single Book — Table of Contents
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

global $post;
$post_id = $post->ID;
$toc      = get_field( 'book_toc', $post_id );

if ( empty( $toc ) ) {
    return;
}
?>

<!-- ============================================================
     BOOK TABLE OF CONTENTS
     ============================================================ -->
<section class="book-toc-section glass-card p-6" style="border-left: 4px solid var(--warning);" aria-label="<?php esc_attr_e( 'Table of Contents', 'quantum-mentor-world' ); ?>">
    <h2 class="card-title mb-4" style="font-size: 18px; display: flex; align-items: center; gap: 8px; margin-top: 0;">
        📋 <?php esc_html_e( 'Table of Contents', 'quantum-mentor-world' ); ?>
    </h2>
    <div class="book-toc-content">
        <pre class="book-toc-pre" style="font-family: var(--font-sans); white-space: pre-line; font-size: 14px; line-height: 1.7; color: var(--text-muted); margin: 0; background: transparent; border: none; padding: 0; overflow: visible;"><?php echo esc_html( $toc ); ?></pre>
    </div>
</section>
