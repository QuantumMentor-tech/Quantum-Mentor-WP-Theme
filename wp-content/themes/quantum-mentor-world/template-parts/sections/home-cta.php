<?php
/**
 * Homepage Call-to-Action Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<section class="py-24" style="background: linear-gradient(180deg, transparent, rgba(124, 58, 237, 0.04));">
    <div class="container container-desktop" style="text-align: center;">
        <div style="max-width: 720px; margin: 0 auto; display: flex; flex-direction: column; gap: var(--space-4); align-items: center; justify-content: center;">
            
            <h2 class="hero-title" style="font-size: 36px; margin-bottom: 0;">
                <?php esc_html_e( 'Discover, Learn, Build, and Grow', 'quantum-mentor-world' ); ?>
            </h2>
            
            <p class="body-text" style="color: var(--text-muted); max-width: 600px; margin-bottom: var(--space-6); font-size: 17px; line-height: 1.7;">
                <?php esc_html_e( 'Quantum Mentor World helps students, creators, developers, and digital learners find useful, verified, and legal resources faster.', 'quantum-mentor-world' ); ?>
            </p>
            
            <a href="#category-explorer" class="btn btn-primary" style="padding: 12px 36px; font-size: 15px; border-radius: var(--radius-btn);">
                <?php esc_html_e( 'Start Exploring Now', 'quantum-mentor-world' ); ?>
            </a>
            
        </div>
    </div>
</section>
