<?php
/**
 * The template for displaying Online Tool pages
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-7xl mx-auto">
    <?php
    while ( have_posts() ) :
        the_post();
        $post_id = get_the_ID();

        // Retrieve metadata fields
        $tool_mode     = get_post_meta( $post_id, 'tool_mode', true ); // 'In-site Web App' or 'External Service'
        $embed_code    = get_post_meta( $post_id, 'tool_embed_code', true );
        $official_url  = get_post_meta( $post_id, 'tool_official_url', true );

        // Taxonomies
        $categories = wp_get_post_terms( $post_id, 'tool_category', array( 'fields' => 'names' ) );
        $category   = ! is_wp_error( $categories ) && ! empty( $categories ) ? $categories[0] : 'Utility';
        ?>

        <!-- Breadcrumbs Navigation -->
        <nav class="breadcrumbs mb-6 text-xs text-[#94A3B8] font-medium flex items-center space-x-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#00D4FF]">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>" class="hover:text-[#00D4FF]">Tools</a>
            <span>/</span>
            <span class="text-white"><?php the_title(); ?></span>
        </nav>

        <div class="space-y-8">
            
            <!-- Tool Heading Card -->
            <div class="glass-card p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center space-x-2 mb-2">
                        <span class="badge badge-primary"><?php echo esc_html( $category ); ?></span>
                        <span class="badge badge-accent">100% Free Sandbox</span>
                    </div>
                    <h1 class="font-display text-2xl font-extrabold text-white leading-none"><?php the_title(); ?></h1>
                </div>
                
                <?php if ( ! empty( $official_url ) ) : ?>
                    <a href="<?php echo esc_url( $official_url ); ?>" target="_blank" rel="noopener noreferrer" class="neon-btn text-xs">
                        Open Official Website
                    </a>
                <?php endif; ?>
            </div>

            <!-- In-Site Sandbox / Embed Window -->
            <?php if ( $tool_mode === 'In-site Web App' && ! empty( $embed_code ) ) : ?>
                <div class="tool-embed-wrapper bg-[#1E293B] border border-white/10 rounded-2xl p-4 md:p-6 shadow-2xl">
                    <div class="video-player-container bg-[#0F172A] rounded-xl overflow-hidden border border-white/5 relative min-h-[500px]">
                        <?php echo quantum_get_safe_embed( $embed_code ); ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="glass-card p-8 text-center max-w-2xl mx-auto">
                    <div class="w-16 h-16 rounded-full bg-[#00D4FF]/10 flex items-center justify-center mx-auto mb-4 text-[#00D4FF] text-2xl font-display font-extrabold">⌥</div>
                    <h2 class="font-display text-lg font-bold text-white mb-2">External Tool Sandbox</h2>
                    <p class="text-xs text-slate-400 mb-6 leading-relaxed">This tool functions through an external verified legal service endpoint. Click below to redirect securely.</p>
                    <?php if ( ! empty( $official_url ) ) : ?>
                        <a href="<?php echo esc_url( $official_url ); ?>" target="_blank" rel="noopener noreferrer" class="neon-btn text-xs py-3 px-8 shadow-md">Launch Secure Endpoint</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Tool Documentation Description -->
            <div class="glass-card p-8">
                <h2 class="font-display text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">Tool Documentation & Instructions</h2>
                <div class="prose prose-invert text-sm text-slate-300 space-y-4">
                    <?php the_content(); ?>
                </div>
            </div>

        </div>

    <?php
    endwhile; // End of the loop.
    ?>
</main>

<?php get_footer(); ?>
