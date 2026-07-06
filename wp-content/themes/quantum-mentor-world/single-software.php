<?php
/**
 * Single Software Detail Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

$post_id = get_the_ID();

// Retrieve CPT custom parameters
$platforms    = get_field( 'software_platform', $post_id );
$version      = get_field( 'software_version', $post_id );
$license      = get_field( 'software_license', $post_id );
$developer    = get_field( 'software_developer', $post_id );
$file_size    = get_field( 'software_size', $post_id );
$last_updated = get_field( 'software_last_updated', $post_id );
if ( empty( $last_updated ) ) {
    $last_updated = get_the_modified_date( 'Y-m-d', $post_id );
}
$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $last_updated ) );

$requirements = get_field( 'software_system_requirements', $post_id );
$install_guide = get_field( 'software_installation_guide', $post_id );
$changelog    = get_field( 'software_changelog', $post_id );
$safety_note  = get_field( 'software_safety_note', $post_id );

// Share parameters
$permalink = esc_url( get_permalink() );
$title_esc = esc_attr( get_the_title() );
?>

<div class="single-software-page py-8">
    <div class="container container-laptop">
        
        <!-- Breadcrumbs -->
        <nav class="breadcrumbs mb-8" aria-label="Breadcrumb" style="font-size: 13px; color: var(--text-muted);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'software' ) ); ?>" style="color: inherit;"><?php esc_html_e( 'Software', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary);"><?php the_title(); ?></span>
        </nav>

        <!-- Software Hero Header -->
        <header class="single-software-hero glass-card mb-8 p-6" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.7), rgba(15, 23, 42, 0.7)); display: flex; flex-direction: column; gap: var(--space-6);">
            <div style="display: flex; flex-direction: row; flex-wrap: wrap; gap: var(--space-6); align-items: center;">
                
                <!-- Icon -->
                <div class="software-large-icon-wrapper" style="width: 96px; height: 96px; border-radius: var(--radius-md); border: 2px solid var(--border-hover); background-color: var(--bg-primary); overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: var(--glow-primary); flex-shrink: 0;">
                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                        <?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'alt' => $title_esc ) ); ?>
                    <?php else : ?>
                        <div style="font-size: 48px;">💻</div>
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

                    <!-- Platform Indicator Pills -->
                    <?php if ( ! empty( $platforms ) && is_array( $platforms ) ) : ?>
                        <div style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                            <?php foreach ( $platforms as $p ) : ?>
                                <span class="badge badge-secondary" style="font-size: 9px; text-transform: uppercase;"><?php echo esc_html( $p ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Social Share Panel -->
                <div class="share-box" style="flex-shrink: 0; display: flex; flex-direction: column; gap: var(--space-2); width: 100%; max-width: 200px;">
                    <span class="small-text" style="font-weight: 600; color: var(--text-muted); display: block; margin-bottom: 2px;"><?php esc_html_e( 'Share Resource:', 'quantum-mentor-world' ); ?></span>
                    <div style="display: flex; gap: 8px;">
                        <!-- X / Twitter -->
                        <a href="https://x.com/intent/tweet?url=<?php echo $permalink; ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on X">𝕏</a>
                        <!-- Facebook -->
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on Facebook">F</a>
                        <!-- LinkedIn -->
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on LinkedIn">in</a>
                        <!-- Reddit -->
                        <a href="https://reddit.com/submit?url=<?php echo $permalink; ?>&title=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer" style="display: flex; align-items: center; justify-content: center; width: 32px; height: 32px; border-radius: 50%; background-color: var(--bg-secondary); border: 1px solid var(--border); font-size: 12px; color: var(--text-main);" title="Share on Reddit">r</a>
                    </div>
                </div>

            </div>
        </header>

        <!-- Two Column Main Grid -->
        <div class="grid grid-cols-12 gap-8">
            
            <!-- Left Column: Primary Content (8 columns) -->
            <main class="col-span-12 lg:col-span-8" style="display: flex; flex-direction: column; gap: var(--space-8);">
                
                <!-- Full Description / Content -->
                <article class="glass-card p-6">
                    <h2 class="section-title mb-4" style="font-size: 22px;"><?php esc_html_e( 'Description & Overview', 'quantum-mentor-world' ); ?></h2>
                    <div class="software-content entry-content" style="line-height: 1.7;">
                        <?php 
                        while ( have_posts() ) : the_post();
                            the_content();
                        endwhile; 
                        ?>
                    </div>
                </article>

                <!-- Screenshots Gallery Component -->
                <?php get_template_part( 'template-parts/software/software-screenshots' ); ?>

                <!-- Features & Technical Specifications Panels -->
                <?php if ( ! empty( $requirements ) || ! empty( $install_guide ) || ! empty( $changelog ) ) : ?>
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

                        <!-- Changelog -->
                        <?php if ( ! empty( $changelog ) ) : ?>
                            <section class="changelog-box glass-card p-6" style="border-left: 4px solid var(--success);">
                                <h3 class="card-title mb-3" style="font-size: 18px; display: flex; align-items: center; gap: 8px;">
                                    🔄 <?php esc_html_e( 'Changelog / Release Notes', 'quantum-mentor-world' ); ?>
                                </h3>
                                <pre style="font-family: var(--font-sans); white-space: pre-line; font-size: 14px; line-height: 1.6; color: var(--text-muted); margin: 0;"><?php echo esc_html( $changelog ); ?></pre>
                            </section>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <!-- Comments & Reviews Area -->
                <section class="comments-section-wrapper glass-card p-6" style="border-top: 1px solid var(--border); padding-top: var(--space-6);">
                    <h3 class="section-title mb-6" style="font-size: 22px;"><?php esc_html_e( 'Discussion & Reviews', 'quantum-mentor-world' ); ?></h3>
                    <?php 
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                    ?>
                </section>

            </main>

            <!-- Right Column: Sidebar Specs & Actions (4 columns) -->
            <aside class="col-span-12 lg:col-span-4" style="display: flex; flex-direction: column; gap: var(--space-6);">
                
                <!-- Download Button Actions Box -->
                <?php get_template_part( 'template-parts/software/software-download-box' ); ?>

                <!-- Specs Information Card -->
                <?php get_template_part( 'template-parts/software/software-meta' ); ?>

            </aside>

        </div>

        <!-- Full Width Related Software Section -->
        <div class="mt-12">
            <?php get_template_part( 'template-parts/software/software-related' ); ?>
        </div>

    </div>
</div>

<?php
get_footer();
