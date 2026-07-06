<?php
/**
 * Template part for displaying watch content cards
 *
 * @package Quantum_Mentor_Theme
 */

$post_id = get_the_ID();
$status       = get_post_meta( $post_id, 'watch_status', true );
$release_year = get_post_meta( $post_id, 'watch_release_year', true );
$duration     = get_post_meta( $post_id, 'watch_duration', true );

// Get first watch category term
$categories = wp_get_post_terms( $post_id, 'watch_category', array( 'fields' => 'names' ) );
$category   = ! is_wp_error( $categories ) && ! empty( $categories ) ? $categories[0] : 'Media';
?>

<article class="glass-card p-6 flex flex-col justify-between h-full">
    <div>
        <!-- Card Header: Poster & Status Badges -->
        <div class="relative mb-4 overflow-hidden rounded-lg">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'w-full h-56 object-cover rounded-lg' ) ); ?>
            <?php else : ?>
                <div class="w-full h-56 bg-gradient-to-br from-[#7C3AED]/20 to-[#0F172A] rounded-lg flex items-center justify-center border border-white/5">
                    <span class="font-display font-bold text-2xl text-[#7C3AED]">QM Video</span>
                </div>
            <?php endif; ?>

            <div class="absolute top-3 right-3 flex flex-col gap-1.5">
                <span class="badge badge-secondary"><?php echo esc_html( $category ); ?></span>
                <?php if ( ! empty( $status ) ) : ?>
                    <span class="badge badge-accent"><?php echo esc_html( $status ); ?></span>
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
    </div>

    <!-- Card Footer -->
    <div class="flex items-center justify-between border-t border-white/5 pt-4">
        <span class="text-xs text-[#94A3B8]"><?php echo esc_html( $release_year ? $release_year : 'N/A' ); ?> <?php echo $duration ? '• ' . esc_html( $duration ) : ''; ?></span>
        <a href="<?php the_permalink(); ?>" class="neon-btn text-xs py-2 px-4 shadow-none">Watch Now</a>
    </div>
</article>
