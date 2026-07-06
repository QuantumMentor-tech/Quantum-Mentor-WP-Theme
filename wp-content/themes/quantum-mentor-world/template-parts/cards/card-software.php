<?php
/**
 * Template part for displaying software cards
 *
 * @package Quantum_Mentor_World
 */

$post_id = get_the_ID();
$version = get_post_meta( $post_id, 'software_version', true );
$size    = get_post_meta( $post_id, 'software_size', true );
$license = get_post_meta( $post_id, 'software_license', true );
$platforms = get_post_meta( $post_id, 'software_platform', true );
?>

<article class="glass-card p-6 flex flex-col justify-between h-full">
    <div>
        <!-- Card Header: Image & Badges -->
        <div class="relative mb-4 overflow-hidden rounded-lg group-hover:scale-105 transition-transform duration-300">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-48 object-cover rounded-lg' ) ); ?>
            <?php else : ?>
                <div class="w-full h-48 bg-gradient-to-br from-[#1E293B] to-[#0F172A] rounded-lg flex items-center justify-center border border-white/5">
                    <span class="font-display font-bold text-2xl text-[#00D4FF]">QM Software</span>
                </div>
            <?php endif; ?>
            
            <div class="absolute top-3 right-3 flex flex-col gap-1.5">
                <?php if ( ! empty( $license ) ) : ?>
                    <span class="badge badge-primary"><?php echo esc_html( $license ); ?></span>
                <?php endif; ?>
                <?php if ( ! empty( $version ) ) : ?>
                    <span class="badge badge-secondary"><?php echo esc_html( $version ); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Title -->
        <h3 class="font-display text-lg font-bold text-white mb-2 line-clamp-1 hover:text-[#00D4FF] transition-colors">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>

        <!-- Description -->
        <p class="text-xs text-slate-400 mb-4 line-clamp-2">
            <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
        </p>

        <!-- Platform Badges -->
        <?php if ( ! empty( $platforms ) && is_array( $platforms ) ) : ?>
        <div class="flex flex-wrap gap-1.5 mb-4">
            <?php foreach ( $platforms as $platform ) : ?>
                <span class="badge badge-muted text-[10px]"><?php echo esc_html( $platform ); ?></span>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- Card Footer -->
    <div class="flex items-center justify-between border-t border-white/5 pt-4">
        <span class="text-xs text-[#94A3B8]"><?php echo esc_html( $size ? $size : 'N/A' ); ?></span>
        <a href="<?php the_permalink(); ?>" class="neon-btn text-xs py-2 px-4 shadow-none">Get Details</a>
    </div>
</article>
