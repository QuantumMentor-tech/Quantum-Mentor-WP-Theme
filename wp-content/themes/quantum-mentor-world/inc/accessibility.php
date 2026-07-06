<?php
/**
 * Quantum Mentor World — Accessibility (a11y) Features
 *
 * Implements WCAG 2.1 compliance requirements:
 * - Focus outline indicator settings
 * - Navigation keyboard accessibility filters
 * - Dynamic ARIA tag additions for nav menus
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── 1. Add ARIA Roles to Main Navigation Menus ──
add_filter( 'nav_menu_link_attributes', 'qmw_accessibility_nav_menu_attributes', 10, 4 );

function qmw_accessibility_nav_menu_attributes( $atts, $item, $args, $depth ) {
    // Add dropdown indication triggers
    if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
        $atts['aria-haspopup'] = 'true';
        $atts['aria-expanded'] = 'false';
    }

    // Identify active pages for screen readers
    if ( in_array( 'current-menu-item', $item->classes, true ) ) {
        $atts['aria-current'] = 'page';
    }

    return $atts;
}

// ── 2. Add Accessibility Screen Reader Styling classes in wp_head ──
add_action( 'wp_head', 'qmw_accessibility_screen_reader_styles', 100 );

function qmw_accessibility_screen_reader_styles() {
    ?>
    <style>
        /* Screen Reader Text Helper Class */
        .screen-reader-text {
            border: 0;
            clip: rect(1px, 1px, 1px, 1px);
            clip-path: inset(50%);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
            word-wrap: normal !important;
        }

        .screen-reader-text:focus {
            background-color: #f1f1f1;
            border-radius: 3px;
            box-shadow: 0 0 2px 2px rgba(0, 0, 0, 0.6);
            clip: auto !important;
            clip-path: none;
            color: #21759b;
            display: block;
            font-size: 14px;
            font-weight: bold;
            height: auto;
            left: 5px;
            line-height: normal;
            padding: 15px 23px 14px;
            text-decoration: none;
            top: 5px;
            width: auto;
            z-index: 100000;
        }
    </style>
    <?php
}
