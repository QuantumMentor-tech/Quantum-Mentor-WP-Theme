<?php
/**
 * Newsletter Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<section id="newsletter-subscription" class="py-16" style="border-bottom: 1px solid var(--border); background: radial-gradient(circle at center, rgba(0, 212, 255, 0.05) 0%, transparent 70%);">
    <div class="container container-desktop">
        <div class="glass-card" style="padding: var(--space-12) var(--space-8); text-align: center; max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: var(--space-4); align-items: center; justify-content: center; position: relative;">
            <div class="absolute -top-12 -left-12 w-36 h-36 bg-[#7C3AED]/5 rounded-full blur-2xl pointer-events-none"></div>
            
            <h2 class="section-title" style="margin-bottom: 0; padding-bottom: 0; align-self: center;">
                <?php esc_html_e( 'Stay Updated with Quantum Mentor World', 'quantum-mentor-world' ); ?>
            </h2>
            
            <p class="body-text" style="color: var(--text-muted); max-width: 550px; margin-top: var(--space-2);">
                <?php esc_html_e( 'Get the latest legal tools, resources, AI updates, and learning content directly in your inbox.', 'quantum-mentor-world' ); ?>
            </p>

            <form class="newsletter-form" action="#" method="POST" style="display: flex; flex-wrap: wrap; gap: var(--space-4); width: 100%; max-width: 500px; margin-top: var(--space-4); justify-content: center;">
                <label for="qmw-newsletter-email" class="sr-only">Email Address</label>
                <input type="email" id="qmw-newsletter-email" name="qmw_newsletter_email" class="search-large-input" style="flex: 1; min-width: 260px; font-size: 14px; padding: 12px 20px;" placeholder="<?php esc_attr_e( 'Enter your email address', 'quantum-mentor-world' ); ?>" required />
                <button type="submit" class="btn btn-primary" style="padding: 0 28px; min-height: 48px; font-size: 14px;">
                    <?php esc_html_e( 'Subscribe', 'quantum-mentor-world' ); ?>
                </button>
            </form>

            <span class="small-text" style="font-size: 11px; margin-top: var(--space-2); color: var(--text-muted);">
                <?php esc_html_e( 'No spam. You can unsubscribe at any time. Your details are secure.', 'quantum-mentor-world' ); ?>
            </span>
        </div>
    </div>
</section>
