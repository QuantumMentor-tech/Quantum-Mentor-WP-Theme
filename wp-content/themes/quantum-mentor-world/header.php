<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php 
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}
?>

    <!-- Skip Navigation Link (A11y requirement) -->
    <a href="#main-content" class="skip-link"><?php esc_html_e( 'Skip to main content', 'quantum-mentor-world' ); ?></a>

    <!-- Sticky Header (80px height) -->
    <header class="sticky-header-container" role="banner">
        <div class="container container-desktop header-inner">
            
            <!-- Left: Logo & Site Name -->
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo-wrapper" rel="home">
                <?php 
                if ( function_exists( 'has_custom_logo' ) && has_custom_logo() ) {
                    echo get_custom_logo();
                } else {
                    $logo_url = get_template_directory_uri() . '/Quantum Mentor logo design.png';
                    echo '<img src="' . esc_url( $logo_url ) . '" alt="Quantum Mentor World Logo" class="custom-logo" style="height: 36px; width: auto; object-fit: contain; border-radius: var(--radius-sm);">';
                }
                ?>
                <span style="font-family: var(--font-display); font-weight: 800; font-size: 20px; letter-spacing: -0.01em; color: var(--text-main);">
                    <?php bloginfo( 'name' ); ?>
                </span>
            </a>

            <!-- Center: Primary Horizontal Navigation (Desktop only) -->
            <nav class="desktop-nav" aria-label="<?php esc_attr_e( 'Desktop Primary Navigation', 'quantum-mentor-world' ); ?>">
                <?php get_template_part( 'template-parts/navigation/primary-menu' ); ?>
            </nav>

            <!-- Right: Search, Theme Toggle, User Icon -->
            <div class="header-actions">
                <!-- Global Search Trigger -->
                <button id="search-trigger" class="icon-btn" aria-label="<?php esc_attr_e( 'Open Search Overlay', 'quantum-mentor-world' ); ?>" title="<?php esc_attr_e( 'Search resources', 'quantum-mentor-world' ); ?>">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>

                <!-- Theme Toggle Switch -->
                <button id="theme-toggle" class="icon-btn" aria-label="<?php esc_attr_e( 'Toggle dark or light mode', 'quantum-mentor-world' ); ?>" title="<?php esc_attr_e( 'Toggle light or dark theme', 'quantum-mentor-world' ); ?>">
                    <!-- Moon icon for light mode toggle state -->
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                    <span id="theme-toggle-dot" style="display:none;"></span>
                </button>

                <!-- User Account/Profile Link -->
                <a href="<?php echo esc_url( home_url( '/account/' ) ); ?>" class="icon-btn desktop-only" aria-label="<?php esc_attr_e( 'User profile account dashboard', 'quantum-mentor-world' ); ?>" title="<?php esc_attr_e( 'Account profile', 'quantum-mentor-world' ); ?>">
                    <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </a>

                <!-- Mobile Hamburger Button -->
                <button id="hamburger-btn" class="hamburger-btn" aria-label="<?php esc_attr_e( 'Toggle mobile site navigation menu', 'quantum-mentor-world' ); ?>" aria-expanded="false" aria-controls="mobile-drawer">
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                    <span class="hamburger-line"></span>
                </button>
            </div>

        </div>
    </header>

    <!-- Backdrop blur overlay for mobile drawer -->
    <div id="backdrop-blur-overlay" class="backdrop-blur-overlay"></div>

    <!-- Include Mobile Drawer Menu Component -->
    <?php get_template_part( 'template-parts/navigation/mobile-menu' ); ?>

    <!-- Include Search Overlay Component -->
    <?php get_template_part( 'template-parts/components/search-overlay' ); ?>

    <!-- Main Page Content Section -->
    <main id="main-content" style="outline: none;">
