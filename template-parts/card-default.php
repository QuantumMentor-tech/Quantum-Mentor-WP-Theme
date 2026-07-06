<?php
/**
 * Template part for displaying a generic fallback resource card
 *
 * @package Quantum_Mentor_Theme
 */

$post_id = get_the_ID();
$cpt_obj = get_post_type_object( get_post_type() );
$cpt_label = $cpt_obj ? $cpt_obj->labels->singular_name : 'Resource';
?>

<article class="glass-card p-6 flex flex-col justify-between h-full">
    <div>
        <!-- Card Header: Visual Placeholder & Badge -->
        <div class="relative mb-4 overflow-hidden rounded-lg">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-48 object-cover rounded-lg' ) ); ?>
            <?php else : ?>
                <div class="w-full h-48 bg-gradient-to-br from-[#1E293B] to-[#0F172A] rounded-lg flex items-center justify-center border border-white/5">
                    <span class="font-display font-bold text-lg text-slate-400"><?php echo esc_html( $cpt_label ); ?></span>
                </div>
            <?php endif; ?>
            
            <div class="absolute top-3 right-3">
                <span class="badge badge-primary"><?php echo esc_html( $cpt_label ); ?></span>
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
    </div>

    <!-- Card Footer -->
    <div class="flex items-center justify-between border-t border-white/5 pt-4">
        <span class="text-xs text-[#94A3B8]"><?php echo get_the_date( 'M d, Y' ); ?></span>
        <a href="<?php the_permalink(); ?>" class="neon-btn text-xs py-2 px-4 shadow-none">Explore</a>
    </div>
</article>
