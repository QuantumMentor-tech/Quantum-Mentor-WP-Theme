<?php
/**
 * Single Themes & Plugins Detail Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

$post_id = get_the_ID();

// ACF parameters
$platform     = get_field( 'tp_platform', $post_id );
$type         = get_field( 'tp_type', $post_id );
$version      = get_field( 'tp_version', $post_id );
$license      = get_field( 'tp_license', $post_id );
$developer    = get_field( 'tp_developer', $post_id );
$requirements = get_field( 'tp_requirements', $post_id );
$install_guide = get_field( 'tp_installation_guide', $post_id );
$last_updated = get_field( 'tp_last_updated', $post_id );
if ( empty( $last_updated ) ) {
    $last_updated = get_the_modified_date( 'Y-m-d', $post_id );
}
$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $last_updated ) );

$permalink = esc_url( get_permalink() );
$title_esc = esc_attr( get_the_title() );
?>

<div class="single-tp-page py-8">
    <div class="container container-laptop">
        
        <!-- Breadcrumbs -->
        <nav class="breadcrumbs mb-8" aria-label="Breadcrumb" style="font-size: 13px; color: var(--text-muted);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'themes_plugins' ) ); ?>" style="color: inherit;"><?php esc_html_e( 'Themes & Plugins', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary);"><?php the_title(); ?></span>
        </nav>

        <!-- Resource Hero Header -->
        <header class="single-software-hero glass-card mb-8 p-6" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.7)); display: flex; flex-direction: column; gap: var(--space-6);">
            <div style="display: flex; flex-direction: row; flex-wrap: wrap; gap: var(--space-6); align-items: center;">
                
                <!-- Large Cover Thumbnail (16:9 aspect ratio) -->
                <div class="tp-large-cover-wrapper" style="width: 140px; aspect-ratio: 16/9; border-radius: var(--radius-sm); border: 2px solid var(--border-hover); background-color: var(--bg-primary); overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: var(--glow-secondary); flex-shrink: 0;">
                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                        <?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'alt' => $title_esc ) ); ?>
                    <?php else : ?>
                        <div style="font-size: 36px;">🎨</div>
                    <?php endif; ?>
                </div>

                <!-- Info Block -->
                <div style="flex: 1; min-width: 250px;">
                    <div style="display: flex; gap: var(--space-2); margin-bottom: var(--space-2); flex-wrap: wrap;">
                        <?php if ( ! empty( $version ) ) : ?>
                            <span class="badge badge-muted" style="font-size: 10px;"><?php echo esc_html( $version ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $license ) ) : ?>
                            <span class="badge badge-primary" style="font-size: 10px;"><?php echo esc_html( $license ); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <h1 class="hero-title" style="font-size: 28px; line-height: 1.2; margin-bottom: var(--space-2);">
                        <?php the_title(); ?>
                    </h1>
                    
                    <p class="body-text text-muted" style="font-size: 14px; margin-bottom: var(--space-3); color: var(--text-muted);">
                        <?php 
                        $excerpt = get_the_excerpt();
                        if ( empty( $excerpt ) ) {
                            $excerpt = wp_strip_all_tags( get_the_content() );
                        }
                        echo esc_html( wp_trim_words( $excerpt, 22, '...' ) ); 
                        ?>
                    </p>

                    <!-- Platform and Type indicator Pills -->
                    <div style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                        <?php if ( ! empty( $platform ) ) : ?>
                            <span class="badge badge-secondary" style="font-size: 9px; text-transform: uppercase;"><?php echo esc_html( $platform ); ?></span>
                        <?php endif; ?>
                        <?php if ( ! empty( $type ) ) : ?>
                            <span class="badge badge-success" style="font-size: 9px; text-transform: uppercase;"><?php echo esc_html( $type ); ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Social Share Panel -->
                <div class="share-box" style="flex-shrink: 0; display: flex; flex-direction: column; gap: var(--space-2); width: 100%; max-width: 200px;">
                    <span class="small-text" style="font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 2px;"><?php esc_html_e( 'Share Resource:', 'quantum-mentor-world' ); ?></span>
                    <div style="display: flex; gap: 8px;">
                        <a href="https://x.com/intent/tweet?url=<?php echo $permalink; ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on X">𝕏</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on Facebook">F</a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on LinkedIn">in</a>
                        <a href="https://reddit.com/submit?url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on Reddit">r</a>
                    </div>
                </div>

            </div>
        </header>

        <!-- Two Column Content Grid -->
        <div class="grid grid-cols-12 gap-8">
            
            <!-- Left Column (8 cols) -->
            <main class="col-span-12 lg:col-span-8" style="display: flex; flex-direction: column; gap: var(--space-8);">
                
                <!-- Description -->
                <article class="glass-card p-6">
                    <h2 class="section-title mb-4" style="font-size: 22px;"><?php esc_html_e( 'Description & Features', 'quantum-mentor-world' ); ?></h2>
                    <div class="tp-content entry-content" style="line-height: 1.7;">
                        <?php 
                        while ( have_posts() ) : the_post();
                            the_content();
                        endwhile; 
                        ?>
                    </div>
                </article>

                <!-- Screenshots Gallery -->
                <?php get_template_part( 'template-parts/themes-plugins/tp-screenshots' ); ?>

                <!-- Requirements & Install panels -->
                <?php if ( ! empty( $requirements ) || ! empty( $install_guide ) ) : ?>
                    <div class="technical-tabs-content" style="display: flex; flex-direction: column; gap: var(--space-6);">
                        
                        <!-- System Requirements -->
                        <?php if ( ! empty( $requirements ) ) : ?>
                            <section class="requirements-box glass-card p-6" style="border-left: 4px solid var(--primary);">
                                <h3 class="card-title mb-3" style="font-size: 18px; display: flex; align-items: center; gap: 8px;">
                                    ⚙️ <?php esc_html_e( 'System Requirements', 'quantum-mentor-world' ); ?>
                                </h3>
                                <pre style="font-family: var(--font-sans); white-space: pre-line; font-size: 14px; line-height: 1.6; color: var(--text-muted); margin: 0;"><?php echo esc_html( $requirements ); ?></pre>
                            </section>
                        <?php endif; ?>

                        <!-- Installation Guide -->
                        <?php if ( ! empty( $install_guide ) ) : ?>
                            <section class="installation-box glass-card p-6" style="border-left: 4px solid var(--secondary);">
                                <h3 class="card-title mb-3" style="font-size: 18px; display: flex; align-items: center; gap: 8px;">
                                    📝 <?php esc_html_e( 'How to Install', 'quantum-mentor-world' ); ?>
                                </h3>
                                <div style="font-size: 14px; line-height: 1.6; color: var(--text-muted);">
                                    <?php echo wp_kses_post( wpautop( $install_guide ) ); ?>
                                </div>
                            </section>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <!-- Discussion/Comments -->
                <section class="comments-section-wrapper glass-card p-6" style="border-top: 1px solid var(--border); padding-top: var(--space-6);">
                    <h3 class="section-title mb-6" style="font-size: 22px;"><?php esc_html_e( 'Discussion & Feedback', 'quantum-mentor-world' ); ?></h3>
                    <?php 
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                    ?>
                </section>

            </main>

            <!-- Right Column (4 cols) -->
            <aside class="col-span-12 lg:col-span-4" style="display: flex; flex-direction: column; gap: var(--space-6);">
                
                <!-- Link Box Actions -->
                <?php get_template_part( 'template-parts/themes-plugins/tp-link-box' ); ?>

                <!-- Specs Sidebar -->
                <?php get_template_part( 'template-parts/themes-plugins/tp-meta' ); ?>

            </aside>

        </div>

        <!-- Full Width Related section -->
        <div class="mt-12">
            <?php get_template_part( 'template-parts/themes-plugins/tp-related' ); ?>
        </div>

    </div>
</div>

<?php
get_footer();
