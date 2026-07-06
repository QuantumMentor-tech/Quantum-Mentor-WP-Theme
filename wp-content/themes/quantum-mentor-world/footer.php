<?php
/**
 * The template for displaying the footer
 *
 * @package Quantum_Mentor_World
 */
?>
    
    </main> <!-- End of #main-content -->

    <!-- Site Footer (4-column Layout) -->
    <footer class="site-footer" role="contentinfo">
        <div class="container container-desktop">
            
            <div class="footer-grid">
                
                <!-- Column 1: Logo & Description -->
                <div style="display: flex; flex-direction: column; gap: var(--space-4);">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-wrapper" rel="home">
                        <?php 
                        if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
                            echo get_custom_logo();
                        } else {
                            $logo_url = get_template_directory_uri() . '/Quantum Mentor logo design.png';
                            echo '<img src="' . esc_url( $logo_url ) . '" alt="Quantum Mentor World Logo" style="height: 32px; width: auto; object-fit: contain; border-radius: var(--radius-sm);">';
                        }
                        ?>
                        <span style="font-family: var(--font-display); font-weight: 800; font-size: 18px; color: var(--text-main);">
                            <?php bloginfo( 'name' ); ?>
                        </span>
                    </a>
                    <p class="small-text" style="line-height: 1.6;">
                        <?php bloginfo( 'name' ); ?> <?php esc_html_e( 'is an educational technology hub for legal software, tools, books, AI resources, GitHub repositories, and digital learning.', 'quantum-mentor-world' ); ?>
                    </p>
                </div>

                <!-- Column 2: Quick Links (CPTs) -->
                <div>
                    <h3 class="footer-title"><?php esc_html_e( 'Quick Links', 'quantum-mentor-world' ); ?></h3>
                    <ul class="footer-links">
                        <?php 
                        if ( has_nav_menu( 'footer_menu' ) ) {
                            wp_nav_menu( array(
                                'theme_location' => 'footer_menu',
                                'container'      => false,
                                'menu_class'     => 'footer-links',
                                'items_wrap'     => '%3$s',
                                'fallback_cb'    => 'quantum_mentor_world_footer_fallback_menu',
                            ) );
                        } else {
                            quantum_mentor_world_footer_fallback_menu();
                        }
                        ?>
                    </ul>
                </div>

                <!-- Column 3: Important Pages -->
                <div>
                    <h3 class="footer-title"><?php esc_html_e( 'Important Pages', 'quantum-mentor-world' ); ?></h3>
                    <ul class="footer-links">
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

                <!-- Column 4: Social Links -->
                <div>
                    <h3 class="footer-title"><?php esc_html_e( 'Social Links', 'quantum-mentor-world' ); ?></h3>
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

            </div>

            <!-- Bottom Copyright bar -->
            <div class="footer-bottom">
                <p>
                    &copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; font-weight: 600;"><?php bloginfo( 'name' ); ?></a>. <?php esc_html_e( 'All rights reserved.', 'quantum-mentor-world' ); ?>
                </p>
                <div style="display: inline-flex; align-items: center; gap: 8px; background-color: var(--bg-primary); border: 1px solid var(--border); padding: 6px 14px; border-radius: 30px;">
                    <span style="width: 8px; height: 8px; border-radius: 50%; background-color: var(--success); box-shadow: 0 0 8px var(--success);"></span>
                    <span style="font-size: 11px; font-weight: 700; color: var(--text-main); font-family: var(--font-display); text-transform: uppercase; letter-spacing: 0.05em;">
                        <?php esc_html_e( 'Protected by Secure Shield Architecture', 'quantum-mentor-world' ); ?>
                    </span>
                </div>
            </div>

        </div>
    </footer>

<?php wp_footer(); ?>
</body>
</html>

