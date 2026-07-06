<?php
/**
 * Single Online Tool Detail Template
 *
 * URL Example: /tools/tool-name/
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$post_id         = get_the_ID();
$tool_name       = get_field( 'tool_name', $post_id ) ?: get_the_title();
$tool_cat        = get_field( 'tool_type_field', $post_id );
$access_type     = get_field( 'tool_access_type', $post_id );
$tool_url        = get_field( 'tool_url', $post_id );
$download_url    = get_field( 'tool_download_url', $post_id );
$icon_id         = get_field( 'tool_icon', $post_id );
$short_desc      = get_field( 'tool_description', $post_id );
$instructions    = get_field( 'tool_instructions', $post_id );
$features        = get_field( 'tool_features', $post_id );
$limitations     = get_field( 'tool_limitations', $post_id );
$tool_status     = get_field( 'tool_status_field', $post_id );

$permalink = esc_url( get_permalink() );
$title_esc = esc_attr( get_the_title() );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-tool-article' ); ?> style="padding-bottom: var(--space-16);">

    <!-- ============================================================
         1. COVER BANNER (Ambient Gradient Theme Backdrop)
         ============================================================ -->
    <div class="watch-cover-banner-wrap" style="position: relative; height: 260px; overflow: hidden; background-color: #020617; border-bottom: 1px solid var(--border);">
        <div class="watch-cover-fallback" style="width: 100%; height: 100%; background: linear-gradient(135deg, #022c22 0%, #064e3b 50%, #020617 100%);"></div>
        
        <!-- Overlays -->
        <div style="position: absolute; inset: 0; background: linear-gradient(to top, #0b0f19 0%, rgba(11,15,25,0.4) 100%); pointer-events: none;"></div>
        <div style="position: absolute; inset: 0; background: radial-gradient(circle at 30% 30%, rgba(34, 197, 94, 0.1) 0%, rgba(0,0,0,0) 60%); pointer-events: none;"></div>
    </div>

    <!-- Main Container -->
    <div class="container container-laptop" style="margin-top: -80px; position: relative; z-index: 10;">

        <!-- Breadcrumbs (SEO Requirement) -->
        <nav class="breadcrumbs mb-6" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>" style="font-size: 13px; color: rgba(255, 255, 255, 0.7); text-shadow: 0 2px 4px rgba(0,0,0,0.8);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'tools' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Tools', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary); font-weight: 600;"><?php echo esc_html( $tool_name ); ?></span>
        </nav>

        <!-- ============================================================
             2. HERO / DETAILS HEADER CARD
             ============================================================ -->
        <header class="glass-card p-6 md:p-8 mb-8" style="background: rgba(11, 15, 25, 0.75); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.08); box-shadow: var(--shadow-lg);">
            <div style="display: flex; flex-wrap: wrap; gap: var(--space-6); align-items: center;">
                
                <!-- Icon Frame -->
                <div class="tool-card-icon-wrap" style="width: 80px; height: 80px; border-radius: var(--radius-md); border: 2px solid var(--primary); background: var(--bg-primary); overflow: hidden; display: flex; align-items: center; justify-content: center; box-shadow: var(--shadow-md); flex-shrink: 0;">
                    <?php if ( ! empty( $icon_id ) ) : ?>
                        <?php echo wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'eager' ) ); ?>
                    <?php elseif ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'thumbnail', array( 'style' => 'width: 100%; height: 100%; object-fit: cover;', 'loading' => 'eager' ) ); ?>
                    <?php else : ?>
                        <div style="font-size: 40px; color: var(--primary);">⚙️</div>
                    <?php endif; ?>
                </div>

                <!-- Info Details -->
                <div style="flex: 1; min-width: 280px;">
                    <div style="display: flex; gap: var(--space-2); flex-wrap: wrap; margin-bottom: var(--space-2);">
                        <?php if ( ! empty( $access_type ) ) : ?><span class="badge badge-success"><?php echo esc_html( $access_type ); ?></span><?php endif; ?>
                        <?php if ( ! empty( $tool_cat ) ) : ?><span class="badge badge-primary"><?php echo esc_html( $tool_cat ); ?></span><?php endif; ?>
                        <?php if ( ! empty( $tool_status ) ) : ?>
                            <span class="badge <?php echo $tool_status === 'Active' ? 'badge-success' : 'badge-warning'; ?>" style="font-size: 9px; padding: 2px 8px;"><?php echo esc_html( $tool_status ); ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- One H1 Only (SEO Requirement) -->
                    <h1 class="hero-title" style="font-size: 28px; margin: 0 0 var(--space-2); font-weight: 800; color: var(--text-main);"><?php echo esc_html( $tool_name ); ?></h1>
                    
                    <?php if ( ! empty( $short_desc ) ) : ?>
                        <p style="font-size: 14px; color: var(--text-muted); line-height: 1.5; margin: 0; max-width: 720px;"><?php echo esc_html( $short_desc ); ?></p>
                    <?php endif; ?>
                </div>

            </div>
        </header>

        <!-- ============================================================
             3. TWO-COLUMN UTILITY GRID
             ============================================================ -->
        <div class="grid grid-cols-12 gap-6 md:gap-8">
            
            <!-- Left Workspace Area (8 Columns) -->
            <main class="col-span-12 lg:col-span-8" style="display: flex; flex-direction: column; gap: var(--space-8);">

                <!-- Workspace Module if Built-in Tool -->
                <?php if ( $access_type === 'Built-in Tool' ) : ?>
                    <section id="built-in-tool-sandbox" aria-label="<?php esc_attr_e( 'Tool Sandbox Workspace', 'quantum-mentor-world' ); ?>">
                        <?php get_template_part( 'template-parts/tools/tool-built-in-placeholder' ); ?>
                    </section>
                <?php else : ?>
                    <!-- Launch action box for external/downloadable CPTs on mobile/main area -->
                    <section class="lg:hidden">
                        <?php get_template_part( 'template-parts/tools/tool-action-box' ); ?>
                    </section>
                <?php endif; ?>

                <!-- Description / Documentation content -->
                <section class="glass-card p-6 md:p-8" aria-label="<?php esc_attr_e( 'Tool Details', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-4" style="font-size: 20px;">
                        <?php esc_html_e( 'About This Tool', 'quantum-mentor-world' ); ?>
                    </h2>
                    <div class="entry-content body-text text-muted" style="line-height: 1.7; color: var(--text-muted);">
                        <?php 
                        while ( have_posts() ) : the_post();
                            the_content();
                        endwhile; 
                        ?>
                    </div>
                </section>

                <!-- Features list -->
                <?php if ( ! empty( $features ) ) : ?>
                    <section class="glass-card p-6 md:p-8" style="border-left: 4px solid var(--success);" aria-label="<?php esc_attr_e( 'Key Features', 'quantum-mentor-world' ); ?>">
                        <h3 class="card-title mb-4" style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-top: 0; display: flex; align-items: center; gap: 8px;">
                            <span>✅</span> <?php esc_html_e( 'Key Features & Capabilities', 'quantum-mentor-world' ); ?>
                        </h3>
                        <div style="font-size: 14px; line-height: 1.7; color: var(--text-muted); white-space: pre-line;"><?php echo esc_html( $features ); ?></div>
                    </section>
                <?php endif; ?>

                <!-- Instructions WYSIWYG -->
                <?php if ( ! empty( $instructions ) ) : ?>
                    <section class="glass-card p-6 md:p-8" style="border-left: 4px solid var(--primary);" aria-label="<?php esc_attr_e( 'Instructions', 'quantum-mentor-world' ); ?>">
                        <h3 class="card-title mb-4" style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-top: 0; display: flex; align-items: center; gap: 8px;">
                            <span>📝</span> <?php esc_html_e( 'How to Use & Guide', 'quantum-mentor-world' ); ?>
                        </h3>
                        <div style="font-size: 14px; line-height: 1.7; color: var(--text-muted);" class="entry-content">
                            <?php echo wp_kses_post( wpautop( $instructions ) ); ?>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Limitations list -->
                <?php if ( ! empty( $limitations ) ) : ?>
                    <section class="glass-card p-6 md:p-8" style="border-left: 4px solid var(--warning);" aria-label="<?php esc_attr_e( 'Known Limitations', 'quantum-mentor-world' ); ?>">
                        <h3 class="card-title mb-4" style="font-size: 16px; font-weight: 700; color: var(--text-main); margin-top: 0; display: flex; align-items: center; gap: 8px;">
                            <span>⚠️</span> <?php esc_html_e( 'Known Limitations', 'quantum-mentor-world' ); ?>
                        </h3>
                        <div style="font-size: 14px; line-height: 1.7; color: var(--text-muted); white-space: pre-line;"><?php echo esc_html( $limitations ); ?></div>
                    </section>
                <?php endif; ?>

                <!-- Social share buttons block -->
                <div class="watch-social-share-wrap glass-card p-6" style="border-color: var(--border);">
                    <span style="font-size: 13px; font-weight: 700; color: var(--text-main); display: block; margin-bottom: var(--space-3);"><?php esc_html_e( 'Share this Utility:', 'quantum-mentor-world' ); ?></span>
                    <div style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $permalink; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);" aria-label="Share on Facebook">
                            📘 Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?php echo $permalink; ?>&text=<?php echo $title_esc; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);" aria-label="Share on Twitter">
                            🐦 Twitter (X)
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $permalink; ?>" target="_blank" rel="noopener noreferrer" class="btn btn-secondary" style="padding: 6px 14px; font-size: 12px; border-color: rgba(255,255,255,0.06); background: rgba(255,255,255,0.02);" aria-label="Share on LinkedIn">
                            🔗 LinkedIn
                        </a>
                    </div>
                </div>

                <!-- Discussion reviews comments -->
                <section class="glass-card p-6 md:p-8" aria-label="<?php esc_attr_e( 'Comments & Feedback', 'quantum-mentor-world' ); ?>">
                    <h2 class="section-title mb-6" style="font-size: 22px;">
                        💬 <?php esc_html_e( 'Discussion & Feedback', 'quantum-mentor-world' ); ?>
                    </h2>
                    <?php 
                    if ( comments_open() || get_comments_number() ) {
                        comments_template();
                    }
                    ?>
                </section>

            </main>

            <!-- Right Column Sidebar (4 Columns) -->
            <aside class="col-span-12 lg:col-span-4" style="display: flex; flex-direction: column; gap: var(--space-6);">

                <!-- Launch Action Box (only shown in desktop sidebar for external/downloadable tools) -->
                <?php if ( $access_type !== 'Built-in Tool' ) : ?>
                    <div class="hidden lg:block">
                        <?php get_template_part( 'template-parts/tools/tool-action-box' ); ?>
                    </div>
                <?php endif; ?>

                <!-- Metadata specs specifications list -->
                <?php get_template_part( 'template-parts/tools/tool-meta' ); ?>

            </aside>

        </div>

        <!-- ============================================================
             4. RELATED TOOLS GRID
             ============================================================ -->
        <?php get_template_part( 'template-parts/tools/tool-related' ); ?>

    </div>
</article>

<?php
get_footer();
