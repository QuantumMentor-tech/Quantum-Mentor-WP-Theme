<?php
/**
 * Global Search Overlay Modal Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<div id="search-overlay" class="search-overlay-modal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Global Search Database', 'quantum-mentor-world' ); ?>">
    <div class="search-overlay-container">
        
        <div class="search-overlay-header">
            <span style="font-family: var(--font-display); font-weight: 700; font-size: 18px; color: var(--text-main);">
                <?php esc_html_e( 'Search Platform Resources', 'quantum-mentor-world' ); ?>
            </span>
            <button id="search-close" class="icon-btn" aria-label="<?php esc_attr_e( 'Close search overlay', 'quantum-mentor-world' ); ?>" title="<?php esc_attr_e( 'Close search', 'quantum-mentor-world' ); ?>">
                <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- WordPress standard-compatible search form -->
        <div class="search-form-overlay-wrapper">
            <?php get_search_form(); ?>
        </div>

        <!-- Suggestion results & trending tags -->
        <div class="search-suggestions-box">
            <!-- Autocomplete matches list container -->
            <div id="search-suggestions-dropdown" class="autocomplete-dropdown" aria-live="polite"></div>

            <!-- Trending search keywords tags -->
            <div class="trending-searches">
                <h5 class="small-text" style="font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-muted); font-size: 11px;">
                    <?php esc_html_e( 'Trending Digital Resources', 'quantum-mentor-world' ); ?>
                </h5>
                <div class="trending-list">
                    <span class="trending-tag" onclick="const input = document.getElementById('qmw-search-field'); if (input) { input.value = this.innerText; input.dispatchEvent(new Event('input')); }">Visual Studio Code</span>
                    <span class="trending-tag" onclick="const input = document.getElementById('qmw-search-field'); if (input) { input.value = this.innerText; input.dispatchEvent(new Event('input')); }">Flutter SDK</span>
                    <span class="trending-tag" onclick="const input = document.getElementById('qmw-search-field'); if (input) { input.value = this.innerText; input.dispatchEvent(new Event('input')); }">WordPress Theme Boilerplate</span>
                    <span class="trending-tag" onclick="const input = document.getElementById('qmw-search-field'); if (input) { input.value = this.innerText; input.dispatchEvent(new Event('input')); }">Next.js Framework</span>
                </div>
            </div>
        </div>

    </div>
</div>
