<!DOCTYPE html>
<html <?php language_attributes(); ?> class="scroll-smooth">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'bg-[#0F172A] text-[#F8FAFC] min-h-screen font-sans antialiased overflow-x-hidden selection:bg-[#00D4FF]/30 selection:text-[#00D4FF]' ); ?>>

<div class="site-container flex flex-col min-h-screen lg:flex-row">
    
    <!-- Mobile Navigation Topbar -->
    <header class="mobile-header flex items-center justify-between px-6 py-4 bg-[#1E293B] border-b border-white/10 lg:hidden sticky top-0 z-50 backdrop-blur-md bg-opacity-80">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center space-x-2">
            <?php 
            if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                the_custom_logo();
            } else {
                $logo_url = get_template_directory_uri() . '/Quantum Mentor logo design.png';
                echo '<img src="' . esc_url( $logo_url ) . '" alt="Quantum Mentor Logo" class="h-8 w-auto object-contain rounded">';
            }
            ?>
        </a>
        <button id="mobile-menu-toggle" class="text-[#F8FAFC] hover:text-[#00D4FF] focus:outline-none transition-colors" aria-label="Toggle Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </header>

    <!-- Sidebar Dashboard Navigation (Fixed Left Desktop / Drawer Mobile) -->
    <aside id="sidebar-navigation" class="w-72 bg-[#1E293B]/95 border-r border-white/10 p-6 flex flex-col justify-between fixed lg:sticky top-0 h-screen z-40 transition-transform -translate-x-full lg:translate-x-0 overflow-y-auto backdrop-blur-md bg-opacity-90">
        
        <div>
            <!-- Logo Section -->
            <div class="hidden lg:flex items-center space-x-3 mb-10">
                <?php 
                if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    $logo_url = get_template_directory_uri() . '/Quantum Mentor logo design.png';
                    echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="block">';
                    echo '<img src="' . esc_url( $logo_url ) . '" alt="Quantum Mentor Logo" class="h-12 w-auto object-contain rounded shadow-[0_0_15px_rgba(0,212,255,0.2)]">';
                    echo '</a>';
                }
                ?>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1">
                <div class="text-[10px] text-[#94A3B8] uppercase font-bold tracking-widest px-3 mb-2">Explore</div>
                
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 hover:bg-[#00D4FF]/10 hover:text-[#00D4FF] group <?php echo is_front_page() ? 'bg-[#00D4FF]/10 text-[#00D4FF] border-l-2 border-[#00D4FF]' : 'text-[#94A3B8]'; ?>">
                    <span class="w-2 h-2 rounded-full bg-[#00D4FF] group-hover:scale-125 transition-transform"></span>
                    <span>Home</span>
                </a>

                <?php 
                $nav_items = array(
                    'software'       => array( 'label' => 'Software', 'slug' => 'software' ),
                    'themes_plugins' => array( 'label' => 'Themes & Plugins', 'slug' => 'themes-plugins' ),
                    'games'          => array( 'label' => 'Games', 'slug' => 'games' ),
                    'news'           => array( 'label' => 'Tech News', 'slug' => 'news' ),
                    'tools'          => array( 'label' => 'Online Tools', 'slug' => 'tools' ),
                    'books'          => array( 'label' => 'Books & Guides', 'slug' => 'books' ),
                    'watch'          => array( 'label' => 'Watch Media', 'slug' => 'watch' ),
                    'github_repos'   => array( 'label' => 'GitHub Repos', 'slug' => 'github-repos' ),
                );

                foreach ( $nav_items as $cpt => $data ) :
                    $is_active = is_post_type_archive( $cpt ) || ( is_singular( $cpt ) ) || ( get_query_var( 'post_type' ) === $cpt );
                ?>
                <a href="<?php echo esc_url( home_url( '/' . $data['slug'] . '/' ) ); ?>" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 hover:bg-[#00D4FF]/10 hover:text-[#00D4FF] group <?php echo $is_active ? 'bg-[#00D4FF]/10 text-[#00D4FF] border-l-2 border-[#00D4FF]' : 'text-[#94A3B8]'; ?>">
                    <span class="w-2 h-2 rounded-full bg-slate-600 group-hover:bg-[#00D4FF] group-hover:scale-125 transition-all"></span>
                    <span><?php echo esc_html( $data['label'] ); ?></span>
                </a>
                <?php endforeach; ?>
            </nav>
        </div>

        <!-- System Status Badge -->
        <div class="mt-8 border-t border-white/10 pt-6">
            <div class="glass-card p-4 rounded-xl border border-white/5 bg-[#0F172A]/50 flex items-center space-x-3">
                <div class="relative flex h-3.5 w-3.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#22C55E] opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3.5 w-3.5 bg-[#22C55E]"></span>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-200">Legal Ecosystem</p>
                    <span class="text-[10px] text-[#22C55E] uppercase tracking-wider font-bold">100% Certified Safe</span>
                </div>
            </div>
            
            <!-- Light/Dark Mode Switcher Placeholder -->
            <div class="flex items-center justify-between mt-4 px-2">
                <span class="text-xs text-[#94A3B8]">AI Dark Engine</span>
                <button id="theme-toggle" class="w-8 h-4 rounded-full bg-[#7C3AED] relative transition-colors focus:outline-none" aria-label="Toggle Theme">
                    <span class="w-3.5 h-3.5 rounded-full bg-white absolute top-0.5 right-0.5 transition-transform" id="theme-toggle-dot"></span>
                </button>
            </div>
        </div>
    </aside>

    <!-- Overlay backdrops for mobile navigation drawer -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden"></div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 min-h-screen">
