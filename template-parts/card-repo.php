<?php
/**
 * Template part for displaying GitHub Repository cards
 *
 * @package Quantum_Mentor_Theme
 */

$post_id = get_the_ID();
$stars   = get_post_meta( $post_id, 'repo_stars', true );
$forks   = get_post_meta( $post_id, 'repo_forks', true );
$license = get_post_meta( $post_id, 'repo_license', true );
$repo_url = get_post_meta( $post_id, 'repo_url', true );

// Get programming languages taxonomy
$languages = wp_get_post_terms( $post_id, 'repo_language', array( 'fields' => 'names' ) );
$language   = ! is_wp_error( $languages ) && ! empty( $languages ) ? $languages[0] : 'Open Source';
?>

<article class="glass-card p-6 flex flex-col justify-between h-full border-t-2 border-[#7C3AED]">
    <div>
        <!-- Card Header: Title & Language Badge -->
        <div class="flex items-center justify-between mb-4">
            <span class="badge badge-secondary"><?php echo esc_html( $language ); ?></span>
            <?php if ( ! empty( $license ) ) : ?>
                <span class="badge badge-muted text-[10px]"><?php echo esc_html( $license ); ?></span>
            <?php endif; ?>
        </div>

        <!-- Repo Logo / Visual Placeholder -->
        <div class="mb-4 flex items-center space-x-3">
            <svg class="w-8 h-8 text-slate-300" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.166 6.839 9.489.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.603-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.464-1.11-1.464-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.831.092-.646.35-1.086.636-1.336-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.577.688.479C19.138 20.162 22 16.418 22 12c0-5.523-4.477-10-10-10z"/>
            </svg>
            <h3 class="font-display text-lg font-bold text-white line-clamp-1 hover:text-[#00D4FF] transition-colors">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </div>

        <!-- Description -->
        <p class="text-xs text-slate-400 mb-4 line-clamp-3">
            <?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>
        </p>
    </div>

    <!-- Card Footer -->
    <div class="flex items-center justify-between border-t border-white/5 pt-4">
        <!-- Stats -->
        <div class="flex items-center space-x-3 text-xs text-[#94A3B8]">
            <span class="flex items-center space-x-1">
                <span class="text-[#00D4FF] font-semibold">★</span>
                <span><?php echo esc_html( $stars ? $stars : '0' ); ?></span>
            </span>
            <?php if ( ! empty( $forks ) ) : ?>
            <span class="flex items-center space-x-1">
                <span class="text-[#7C3AED] font-semibold">⌥</span>
                <span><?php echo esc_html( $forks ); ?></span>
            </span>
            <?php endif; ?>
        </div>
        
        <?php if ( ! empty( $repo_url ) ) : ?>
            <a href="<?php echo esc_url( $repo_url ); ?>" target="_blank" rel="noopener noreferrer" class="neon-btn text-xs py-1.5 px-3 shadow-none">Visit GitHub</a>
        <?php else : ?>
            <a href="<?php the_permalink(); ?>" class="neon-btn text-xs py-1.5 px-3 shadow-none">View Details</a>
        <?php endif; ?>
    </div>
</article>
