<?php
/**
 * Homepage Hero Section
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<section class="hero-section" style="position: relative; padding: var(--space-24) 0; overflow: hidden; background: radial-gradient(circle at top right, rgba(124, 58, 237, 0.08), transparent 45%), radial-gradient(circle at bottom left, rgba(0, 212, 255, 0.08), transparent 45%); border-bottom: 1px solid var(--border);">
    <div class="container container-desktop" style="position: relative; z-index: 10;">

        <div class="hero-grid">
            <!-- Left Info Block -->
            <div style="display: flex; flex-direction: column; gap: var(--space-4); text-align: left;">
                <span class="badge badge-primary" style="align-self: flex-start; margin-bottom: var(--space-2); font-size: 12px; letter-spacing: 0.1em;">
                    <?php esc_html_e( '100% VERIFIED LEGAL PLATFORM', 'quantum-mentor-world' ); ?>
                </span>

                <h1 class="hero-title" style="margin-bottom: var(--space-2);">
                    Quantum Mentor World
                </h1>

                <p class="body-text" style="color: var(--text-muted); font-size: 18px; max-width: 640px; margin-bottom: var(--space-4);">
                    Explore legal software, books, AI tools, GitHub repositories, learning resources, and digital knowledge in one powerful platform.
                </p>

                <!-- Search box container -->
                <div class="glass-card" style="padding: var(--space-4); border-radius: var(--radius-md); max-width: 600px; margin-bottom: var(--space-4);">
                    <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                        <label for="hero-search-field" class="sr-only">Search resources...</label>
                        <input type="search" id="hero-search-field" name="s" class="search-large-input" style="flex: 1; min-width: 200px; padding: 12px 20px; font-size: 15px;" placeholder="Search software, books, tools, courses, repos..." required />
                        <button type="submit" class="btn btn-primary" style="padding: 0 24px; min-height: 48px; font-size: 15px;">
                            <?php esc_html_e( 'Search', 'quantum-mentor-world' ); ?>
                        </button>
                    </form>
                </div>

                <!-- Action links buttons -->
                <div style="display: flex; gap: var(--space-4); flex-wrap: wrap; margin-bottom: var(--space-4);">
                    <a href="#category-explorer" class="btn btn-primary"><?php esc_html_e( 'Explore Resources', 'quantum-mentor-world' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="btn btn-secondary"><?php esc_html_e( 'Browse Tools', 'quantum-mentor-world' ); ?></a>
                </div>

                <!-- Feature Badges -->
                <div style="display: flex; flex-wrap: wrap; gap: var(--space-6); margin-top: var(--space-4);">
                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <span style="color: var(--primary); font-size: 18px;">✔</span>
                        <span class="small-text" style="color: var(--text-main); font-weight: 600;">Fast Downloads</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <span style="color: var(--primary); font-size: 18px;">✔</span>
                        <span class="small-text" style="color: var(--text-main); font-weight: 600;">Legal Resources</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <span style="color: var(--primary); font-size: 18px;">✔</span>
                        <span class="small-text" style="color: var(--text-main); font-weight: 600;">AI Knowledge</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: var(--space-2);">
                        <span style="color: var(--primary); font-size: 18px;">✔</span>
                        <span class="small-text" style="color: var(--text-main); font-weight: 600;">Student Friendly</span>
                    </div>
                </div>
            </div>

            <!-- Right floating mockups (visible on desktop only via CSS) -->
            <div class="hero-decorative">
                <!-- Floating Card 1: Software -->
                <div class="glass-card hero-float-card hero-float-card--top-left" style="box-shadow: var(--glow-primary);">
                    <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-2);">
                        <span style="font-size: 24px;">💻</span>
                        <div>
                            <h4 style="font-size: 14px; margin: 0; color: var(--text-main);">VS Code IDE</h4>
                            <span class="badge badge-primary" style="font-size: 8px; padding: 2px 6px;">Open Source</span>
                        </div>
                    </div>
                    <p class="small-text" style="font-size: 11px; margin: 0;">Verified safe developer IDE build.</p>
                </div>

                <!-- Floating Card 2: E-Book -->
                <div class="glass-card hero-float-card hero-float-card--bottom-right" style="box-shadow: var(--glow-secondary); border-color: var(--secondary);">
                    <div style="display: flex; align-items: center; gap: var(--space-3); margin-bottom: var(--space-2);">
                        <span style="font-size: 24px;">📚</span>
                        <div>
                            <h4 style="font-size: 14px; margin: 0; color: var(--text-main);">Algorithms 101</h4>
                            <span class="badge badge-secondary" style="font-size: 8px; padding: 2px 6px;">Free Book</span>
                        </div>
                    </div>
                    <p class="small-text" style="font-size: 11px; margin: 0;">Introduction to data structures PDF.</p>
                </div>

                <!-- Floating Card 3: Online Tool -->
                <div class="glass-card hero-float-card hero-float-card--mid-right" style="border-color: var(--success);">
                    <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-1);">
                        <span style="font-size: 20px; color: var(--success);">⚙</span>
                        <h4 style="font-size: 13px; margin: 0; color: var(--text-main);">PDF Converter</h4>
                    </div>
                    <span class="badge badge-success" style="font-size: 8px; padding: 2px 6px;">Web App</span>
                </div>
            </div>

        </div>
    </div>
</section>
