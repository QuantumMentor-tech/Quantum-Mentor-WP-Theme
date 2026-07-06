<?php
/**
 * The template for displaying media watch content (Courses, Movies, Anime, Donghua)
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-7xl mx-auto">
    <?php
    while ( have_posts() ) :
        the_post();
        $post_id = get_the_ID();

        // Retrieve Watch Meta fields
        $status       = get_post_meta( $post_id, 'watch_status', true );
        $release_year = get_post_meta( $post_id, 'watch_release_year', true );
        $duration     = get_post_meta( $post_id, 'watch_duration', true );
        $servers      = get_post_meta( $post_id, 'watch_servers', true ); // Repeater array
        $episodes     = get_post_meta( $post_id, 'watch_episodes', true ); // Repeater array

        // Clean taxonomies
        $categories   = wp_get_post_terms( $post_id, 'watch_category', array( 'fields' => 'names' ) );
        $category     = ! is_wp_error( $categories ) && ! empty( $categories ) ? $categories[0] : 'Media';
        $genres       = wp_get_post_terms( $post_id, 'watch_genre', array( 'fields' => 'names' ) );
        $languages    = wp_get_post_terms( $post_id, 'watch_language', array( 'fields' => 'names' ) );
        ?>

        <!-- Breadcrumbs Navigation -->
        <nav class="breadcrumbs mb-6 text-xs text-[#94A3B8] font-medium flex items-center space-x-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#00D4FF]">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url( home_url( '/watch/' ) ); ?>" class="hover:text-[#00D4FF]">Watch</a>
            <span>/</span>
            <span class="text-white"><?php the_title(); ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Main Column (Video Player + Metadata) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Watch Player Area -->
                <div class="video-player-wrapper bg-black rounded-2xl overflow-hidden border border-white/10 relative">
                    
                    <!-- Player Box -->
                    <div class="video-player-container" id="main-watch-player-frame">
                        <?php 
                        // Find default initial embed code to render
                        $initial_embed = '';
                        
                        // If it has episodes, use the first server of episode 1, otherwise use the general servers
                        if ( ! empty( $episodes ) && is_array( $episodes ) ) {
                            if ( isset( $episodes[0]['episode_servers'] ) && is_array( $episodes[0]['episode_servers'] ) ) {
                                $initial_embed = $episodes[0]['episode_servers'][0]['server_embed_code'];
                            }
                        } elseif ( ! empty( $servers ) && is_array( $servers ) ) {
                            $initial_embed = $servers[0]['server_embed_code'];
                        }

                        if ( ! empty( $initial_embed ) ) :
                            echo quantum_get_safe_embed( $initial_embed );
                        else :
                        ?>
                            <div class="absolute inset-0 flex flex-col items-center justify-center p-8 bg-[#0F172A] text-center">
                                <span class="text-[#7C3AED] font-display text-4xl mb-2">▶</span>
                                <p class="text-slate-400 text-xs">Media player offline. No legal streaming server is registered for this item yet.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Server Selectors (Tabs) -->
                    <div class="p-4 bg-[#1E293B] border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <span class="text-xs text-[#94A3B8] font-semibold flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#00D4FF] animate-pulse"></span>
                            <span>Legal Server Stream Option:</span>
                        </span>
                        
                        <div class="flex flex-wrap gap-2" id="server-switcher-tabs">
                            <?php 
                            if ( empty( $episodes ) && ! empty( $servers ) && is_array( $servers ) ) :
                                foreach ( $servers as $index => $srv ) :
                            ?>
                                <button class="px-3 py-1.5 rounded bg-[#0F172A] border border-white/5 hover:border-[#00D4FF]/30 text-xs font-medium text-slate-300 hover:text-white transition-all <?php echo $index === 0 ? 'active-server border-[#00D4FF] text-[#00D4FF]' : ''; ?>" 
                                        data-embed="<?php echo esc_attr( $srv['server_embed_code'] ); ?>">
                                    <?php echo esc_html( $srv['server_name'] ); ?>
                                </button>
                            <?php 
                                endforeach;
                            elseif ( ! empty( $episodes ) && is_array( $episodes ) ) :
                                // Load servers for the active episode 1
                                if ( isset( $episodes[0]['episode_servers'] ) && is_array( $episodes[0]['episode_servers'] ) ) :
                                    foreach ( $episodes[0]['episode_servers'] as $index => $srv ) :
                            ?>
                                    <button class="px-3 py-1.5 rounded bg-[#0F172A] border border-white/5 hover:border-[#00D4FF]/30 text-xs font-medium text-slate-300 hover:text-white transition-all <?php echo $index === 0 ? 'active-server border-[#00D4FF] text-[#00D4FF]' : ''; ?>" 
                                            data-embed="<?php echo esc_attr( $srv['server_embed_code'] ); ?>">
                                        <?php echo esc_html( $srv['server_name'] ); ?>
                                    </button>
                            <?php 
                                    endforeach;
                                endif;
                            endif; 
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Info Details Card -->
                <div class="glass-card p-8">
                    <div class="flex flex-col md:flex-row gap-6 mb-6">
                        <div class="w-32 h-44 rounded-lg overflow-hidden flex-shrink-0 bg-[#0F172A] border border-white/5">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                            <?php endif; ?>
                        </div>
                        <div>
                            <span class="badge badge-secondary mb-2"><?php echo esc_html( $category ); ?></span>
                            <h1 class="font-display text-2xl font-extrabold text-white mb-2"><?php the_title(); ?></h1>
                            
                            <div class="flex flex-wrap gap-x-4 gap-y-2 text-xs text-slate-400 mt-3 mb-4">
                                <span>Release Year: <strong class="text-slate-200"><?php echo esc_html( $release_year ? $release_year : 'N/A' ); ?></strong></span>
                                <span>Duration/Ep: <strong class="text-slate-200"><?php echo esc_html( $duration ? $duration : 'N/A' ); ?></strong></span>
                                <span>Status: <strong class="text-slate-200"><?php echo esc_html( $status ? $status : 'Active' ); ?></strong></span>
                            </div>

                            <p class="text-xs text-slate-300 leading-relaxed"><?php echo esc_html( get_the_excerpt() ); ?></p>
                        </div>
                    </div>

                    <!-- Full post content -->
                    <div class="prose prose-invert text-sm text-slate-300 border-t border-white/5 pt-6 space-y-4">
                        <?php the_content(); ?>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar Column (Episode Index & Metadata) -->
            <div class="space-y-6">
                
                <!-- Episodes Playlist Card -->
                <?php if ( ! empty( $episodes ) && is_array( $episodes ) ) : ?>
                <div class="glass-card p-6">
                    <h3 class="font-display text-md font-bold text-white mb-4 flex items-center justify-between">
                        <span>Course/Episode List</span>
                        <span class="badge badge-muted"><?php echo count( $episodes ); ?> Items</span>
                    </h3>
                    
                    <!-- Episodes Grid -->
                    <div class="grid grid-cols-1 gap-2 max-h-96 overflow-y-auto pr-2" id="episodes-select-list">
                        <?php foreach ( $episodes as $index => $ep ) : ?>
                            <button class="episode-select-btn flex items-center justify-between p-3 rounded-lg border text-left transition-all duration-300 text-xs font-semibold <?php echo $index === 0 ? 'bg-[#7C3AED]/20 border-[#7C3AED] text-white' : 'bg-[#0F172A] border-white/5 text-slate-400 hover:text-white hover:bg-white/5'; ?>"
                                    data-ep-num="<?php echo esc_attr( $ep['episode_number'] ); ?>"
                                    data-servers-json='<?php echo esc_attr( json_encode( $ep['episode_servers'] ) ); ?>'>
                                <span>Ep <?php echo esc_html( $ep['episode_number'] ); ?>: <?php echo esc_html( $ep['episode_title'] ); ?></span>
                                <span class="play-icon text-[9px] text-[#00D4FF]">▶</span>
                            </button>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Metadata Card -->
                <div class="glass-card p-6 space-y-4">
                    <h3 class="font-display text-md font-bold text-white border-b border-white/5 pb-2">Properties</h3>
                    
                    <div class="space-y-3 text-xs">
                        <?php if ( ! empty( $genres ) && ! is_wp_error( $genres ) ) : ?>
                        <div>
                            <span class="text-slate-400 block mb-1">Genre:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <?php foreach ( $genres as $gen ) : ?>
                                    <span class="badge badge-muted text-[10px]"><?php echo esc_html( $gen ); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if ( ! empty( $languages ) && ! is_wp_error( $languages ) ) : ?>
                        <div>
                            <span class="text-slate-400 block mb-1">Languages:</span>
                            <div class="flex flex-wrap gap-1.5">
                                <?php foreach ( $languages as $lang ) : ?>
                                    <span class="badge badge-primary text-[10px]"><?php echo esc_html( $lang ); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="pt-2">
                            <span class="text-[10px] text-[#22C55E] uppercase tracking-wider font-extrabold block mb-1">Legal Streaming notice</span>
                            <p class="text-[10px] text-slate-400 leading-normal">This content is streamed using legally verified embedding endpoints from YouTube, open-license developers, or creator-approved source hosts. No local illegal hosting is practiced.</p>
                        </div>
                    </div>
                </div>

                <!-- Related Content -->
                <div class="glass-card p-6">
                    <h3 class="font-display text-md font-bold text-white mb-4">Related Videos</h3>
                    <div class="space-y-4">
                        <?php
                        $related_args = array(
                            'post_type'      => 'watch',
                            'posts_per_page' => 3,
                            'post__not_in'   => array( $post_id ),
                            'orderby'        => 'rand',
                        );
                        $related_query = new WP_Query( $related_args );
                        if ( $related_query->have_posts() ) :
                            while ( $related_query->have_posts() ) : $related_query->the_post();
                            ?>
                            <a href="<?php the_permalink(); ?>" class="flex items-center space-x-3 p-2 rounded hover:bg-white/5 transition-colors">
                                <div class="w-16 h-12 rounded bg-[#0F172A] flex-shrink-0 overflow-hidden flex items-center justify-center border border-white/5">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                                    <?php else : ?>
                                        <span class="font-display font-semibold text-xs text-[#7C3AED]">QM</span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="font-display text-xs font-bold text-white line-clamp-1"><?php the_title(); ?></h4>
                                    <span class="text-[10px] text-slate-400"><?php echo esc_html( get_post_meta( get_the_ID(), 'watch_duration', true ) ); ?></span>
                                </div>
                            </a>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="text-[10px] text-slate-400">No related content found.</p>';
                        endif;
                        ?>
                    </div>
                </div>

            </div>

        </div>

        <!-- Comments Area -->
        <div class="mt-12 max-w-4xl">
            <?php
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        </div>

    <?php
    endwhile; // End of the loop.
    ?>
</main>

<?php get_footer(); ?>
