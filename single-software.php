<?php
/**
 * The template for displaying single software downloads
 *
 * @package Quantum_Mentor_Theme
 */

get_header(); ?>

<main class="main-content-area py-12 px-6 lg:px-12 max-w-7xl mx-auto">
    <?php
    while ( have_posts() ) :
        the_post();
        $post_id = get_the_ID();

        // Retrieve ACF / Meta Fields
        $version          = get_post_meta( $post_id, 'software_version', true );
        $size             = get_post_meta( $post_id, 'software_size', true );
        $license          = get_post_meta( $post_id, 'software_license', true );
        $platforms        = get_post_meta( $post_id, 'software_platform', true );
        $official_url     = get_post_meta( $post_id, 'software_official_url', true );
        $download_url     = get_post_meta( $post_id, 'software_download_url', true );
        $requirements     = get_post_meta( $post_id, 'software_system_requirements', true );
        $screenshots      = get_post_meta( $post_id, 'software_screenshots', true );
        ?>

        <!-- Breadcrumbs Navigation -->
        <nav class="breadcrumbs mb-6 text-xs text-[#94A3B8] font-medium flex items-center space-x-2">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#00D4FF]">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url( home_url( '/software/' ) ); ?>" class="hover:text-[#00D4FF]">Software</a>
            <span>/</span>
            <span class="text-white"><?php the_title(); ?></span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Main Column (Details, Gallery, Requirements) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Main Header Card -->
                <div class="glass-card p-6 flex flex-col md:flex-row gap-6">
                    <div class="w-full md:w-48 h-48 rounded-xl overflow-hidden flex-shrink-0 bg-[#0F172A] border border-white/5 flex items-center justify-center">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                        <?php else : ?>
                            <span class="font-display font-bold text-xl text-[#00D4FF]">QM</span>
                        <?php endif; ?>
                    </div>

                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <?php if ( ! empty( $license ) ) : ?>
                                    <span class="badge badge-primary"><?php echo esc_html( $license ); ?></span>
                                <?php endif; ?>
                                <?php if ( ! empty( $version ) ) : ?>
                                    <span class="badge badge-secondary"><?php echo esc_html( $version ); ?></span>
                                <?php endif; ?>
                                <span class="badge badge-accent">100% Legal & Safe</span>
                            </div>

                            <h1 class="font-display text-2xl md:text-3xl font-extrabold text-white mb-2"><?php the_title(); ?></h1>
                            <p class="text-xs text-slate-400 leading-relaxed"><?php echo esc_html( get_the_excerpt() ); ?></p>
                        </div>

                        <!-- Platforms -->
                        <?php if ( ! empty( $platforms ) && is_array( $platforms ) ) : ?>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <?php foreach ( $platforms as $platform ) : ?>
                                <span class="badge badge-muted text-[10px]"><?php echo esc_html( $platform ); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Detailed Description -->
                <div class="glass-card p-8">
                    <h2 class="font-display text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">Resource Description</h2>
                    <div class="prose prose-invert text-sm text-slate-300 space-y-4 max-w-none">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Screenshots Gallery -->
                <?php if ( ! empty( $screenshots ) && is_array( $screenshots ) ) : ?>
                <div class="glass-card p-8">
                    <h2 class="font-display text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">Screenshots</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <?php foreach ( $screenshots as $image_id ) : 
                            $img_url = wp_get_attachment_image_url( $image_id, 'large' );
                        ?>
                            <a href="<?php echo esc_url( $img_url ); ?>" target="_blank" class="block overflow-hidden rounded-lg border border-white/5 hover:border-[#00D4FF]/30 transition-all">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="Screenshot" class="w-full h-auto object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- System Requirements -->
                <?php if ( ! empty( $requirements ) ) : ?>
                <div class="glass-card p-8">
                    <h2 class="font-display text-lg font-bold text-white mb-4 border-b border-white/5 pb-2">System Requirements</h2>
                    <div class="text-sm text-slate-300 space-y-2">
                        <?php echo wp_kses_post( wpautop( $requirements ) ); ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

            <!-- Right Sidebar Column (Meta Card, Download CTA, Related Content) -->
            <div class="space-y-6">
                
                <!-- Download Action Card -->
                <div class="glass-card p-6 border-t-4 border-[#22C55E]">
                    <h3 class="font-display text-md font-bold text-white mb-4">Get Resource</h3>
                    
                    <div class="space-y-3 mb-6 text-xs text-slate-300">
                        <div class="flex justify-between">
                            <span class="text-slate-400">File Size:</span>
                            <span class="font-semibold text-white"><?php echo esc_html( $size ? $size : 'N/A' ); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Platform:</span>
                            <span class="font-semibold text-white">
                                <?php echo is_array( $platforms ) ? esc_html( implode( ', ', $platforms ) ) : 'All Platforms'; ?>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Status:</span>
                            <span class="font-semibold text-[#22C55E] flex items-center space-x-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#22C55E] animate-pulse"></span>
                                <span>Verified Legal</span>
                            </span>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <?php if ( ! empty( $download_url ) ) : ?>
                            <a href="<?php echo esc_url( $download_url ); ?>" class="neon-btn accent-btn text-center justify-center py-3 w-full" target="_blank" rel="noopener noreferrer">
                                Download Secure Link
                            </a>
                        <?php endif; ?>
                        
                        <?php if ( ! empty( $official_url ) ) : ?>
                            <a href="<?php echo esc_url( $official_url ); ?>" class="neon-btn text-center justify-center py-3 w-full bg-[#0F172A] border border-white/5 text-white hover:bg-[#00D4FF]/10 hover:text-[#00D4FF]" target="_blank" rel="noopener noreferrer">
                                Official Source Site
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Related Content -->
                <div class="glass-card p-6">
                    <h3 class="font-display text-md font-bold text-white mb-4">Related Resources</h3>
                    <div class="space-y-4">
                        <?php
                        $related_args = array(
                            'post_type'      => 'software',
                            'posts_per_page' => 3,
                            'post__not_in'   => array( $post_id ),
                            'orderby'        => 'rand',
                        );
                        $related_query = new WP_Query( $related_args );
                        if ( $related_query->have_posts() ) :
                            while ( $related_query->have_posts() ) : $related_query->the_post();
                            ?>
                            <a href="<?php the_permalink(); ?>" class="flex items-center space-x-3 p-2 rounded hover:bg-white/5 transition-colors">
                                <div class="w-12 h-12 rounded bg-[#0F172A] flex-shrink-0 overflow-hidden flex items-center justify-center border border-white/5">
                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                                    <?php else : ?>
                                        <span class="font-display font-semibold text-xs text-[#00D4FF]">QM</span>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="font-display text-xs font-bold text-white line-clamp-1"><?php the_title(); ?></h4>
                                    <span class="text-[10px] text-slate-400"><?php echo esc_html( get_post_meta( get_the_ID(), 'software_size', true ) ); ?></span>
                                </div>
                            </a>
                            <?php
                            endwhile;
                            wp_reset_postdata();
                        else :
                            echo '<p class="text-[10px] text-slate-400">No related software found.</p>';
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
