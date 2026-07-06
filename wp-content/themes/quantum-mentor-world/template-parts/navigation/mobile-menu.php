<?php
/**
 * Mobile Drawer Menu Template Part
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<aside id="mobile-drawer" class="mobile-drawer" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Mobile Menu Drawer', 'quantum-mentor-world' ); ?>">
    
    <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: var(--space-4); border-bottom: 1px solid var(--border); margin-bottom: var(--space-6);">
        <span style="font-family: var(--font-display); font-weight: 800; font-size: 18px; color: var(--text-main);">
            <?php esc_html_e( 'Directory Menu', 'quantum-mentor-world' ); ?>
        </span>
        <button id="mobile-drawer-close" class="icon-btn" aria-label="<?php esc_attr_e( 'Close mobile menu', 'quantum-mentor-world' ); ?>" title="<?php esc_attr_e( 'Close menu', 'quantum-mentor-world' ); ?>">
            <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Main Mobile Navigation Menu Links -->
    <nav style="display: flex; flex-direction: column; gap: var(--space-3);" aria-label="<?php esc_attr_e( 'Mobile Directory Menu', 'quantum-mentor-world' ); ?>">
        <?php 
        if ( has_nav_menu( 'primary_menu' ) ) {
            wp_nav_menu( array(
                'theme_location' => 'primary_menu',
                'container'      => false,
                'menu_class'     => 'mobile-nav-links',
                'items_wrap'     => '%3$s',
                'fallback_cb'    => 'quantum_mentor_world_mobile_fallback_menu',
            ) );
        } else {
            quantum_mentor_world_mobile_fallback_menu();
        }
        ?>
    </nav>

    <!-- Social Links & Legal Info at the bottom of drawer -->
    <div style="margin-top: auto; padding-top: var(--space-6); border-top: 1px solid var(--border); display: flex; flex-direction: column; gap: var(--space-6);">
        
        <!-- Social Networks Area -->
        <div>
            <h4 class="small-text" style="font-weight: 700; text-transform: uppercase; margin-bottom: var(--space-3); color: var(--text-main); font-size: 11px; letter-spacing: 0.05em;">
                <?php esc_html_e( 'Social Ecosystem', 'quantum-mentor-world' ); ?>
            </h4>
            <div class="social-links" style="gap: 6px;">
                <?php 
                if ( has_nav_menu( 'social_menu' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'social_menu',
                        'container'      => false,
                        'menu_class'     => 'social-links',
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => 'quantum_mentor_world_social_fallback_menu',
                    ) );
                } else {
                    quantum_mentor_world_social_fallback_menu();
                }
                ?>
            </div>
        </div>

        <!-- Privacy & Legal Archive Links -->
        <div>
            <h4 class="small-text" style="font-weight: 700; text-transform: uppercase; margin-bottom: var(--space-3); color: var(--text-main); font-size: 11px; letter-spacing: 0.05em;">
                <?php esc_html_e( 'Legal Information', 'quantum-mentor-world' ); ?>
            </h4>
            <ul class="footer-links" style="font-size: 13px; display: flex; flex-direction: column; gap: var(--space-2); list-style: none;">
                <?php 
                if ( has_nav_menu( 'legal_menu' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'legal_menu',
                        'container'      => false,
                        'menu_class'     => 'footer-links',
                        'items_wrap'     => '%3$s',
                        'fallback_cb'    => 'quantum_mentor_world_legal_fallback_menu',
                    ) );
                } else {
                    quantum_mentor_world_legal_fallback_menu();
                }
                ?>
            </ul>
        </div>

    </div>
</aside>
