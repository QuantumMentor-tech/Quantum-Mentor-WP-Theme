<?php
/**
 * Primary Desktop Navigation Menu
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>

<?php 
if ( has_nav_menu( 'primary_menu' ) ) {
    wp_nav_menu( array(
        'theme_location' => 'primary_menu',
        'container'      => false,
        'menu_class'     => 'desktop-nav',
        'items_wrap'     => '%3$s',
        'fallback_cb'    => 'quantum_mentor_world_desktop_fallback_menu',
    ) );
} else {
    quantum_mentor_world_desktop_fallback_menu();
}
?>
