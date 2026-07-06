<?php
/**
 * Single GitHub Repository Detail Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

global $post;
$post_id     = get_the_ID();
$repo_name   = get_field( 'repo_name', $post_id ) ?: get_the_title();
$repo_desc   = get_field( 'repo_short_description', $post_id ) ?: get_the_excerpt();
$install_cmd = get_field( 'repo_install_cmd', $post_id );
$use_case    = get_field( 'repo_use_case', $post_id );
$stars       = get_field( 'repo_stars_count', $post_id );
$forks       = get_field( 'repo_forks_count', $post_id );
$owner       = get_field( 'repo_owner_name', $post_id );
$lang        = get_field( 'repo_language_field', $post_id );
$license     = get_field( 'repo_license_field', $post_id );
?>

<!-- ============================================================
     Repository details Hero / Gradient Header
     ============================================================ -->
<div class="single-resource-hero" style="background: linear-gradient(135deg, rgba(124, 58, 237, 0.15) 0%, rgba(0, 212, 255, 0.08) 100%), var(--bg-primary); padding: var(--space-12) 0 var(--space-8); border-bottom: 1px solid var(--border); position: relative;">
    
    <!-- Decorative background shape -->
    <div style="position: absolute; right: 10%; top: 10%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(124, 58, 237, 0.12) 0%, rgba(0,0,0,0) 70%); filter: blur(40px); z-index: 1;"></div>

    <div class="container container-laptop" style="position: relative; z-index: 2;">
        
        <!-- Breadcrumbs -->
        <nav class="breadcrumbs mb-6" aria-label="<?php esc_attr_e( 'Breadcrumb', 'quantum-mentor-world' ); ?>" style="font-size: 13px; color: var(--text-muted);">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'Home', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'github_repos' ) ); ?>" style="color: inherit; text-decoration: none;"><?php esc_html_e( 'GitHub Repos', 'quantum-mentor-world' ); ?></a>
            <span style="margin: 0 var(--space-2);">&rsaquo;</span>
            <span style="color: var(--primary); font-weight: 600;"><?php echo esc_html( wp_trim_words( $repo_name, 5, '...' ) ); ?></span>
        </nav>

        <!-- Topic Tags -->
        <div style="display: flex; gap: var(--space-2); margin-bottom: var(--space-4); flex-wrap: wrap;">
            <span class="badge badge-secondary" style="background-color: rgba(124, 58, 237, 0.1); border-color: rgba(124, 58, 237, 0.2);"><?php esc_html_e( 'Open Source', 'quantum-mentor-world' ); ?></span>
            <?php if ( ! empty( $lang ) ) : ?>
                <span class="badge badge-primary" style="background-color: rgba(0, 212, 255, 0.1); border-color: rgba(0, 212, 255, 0.2);"><?php echo esc_html( $lang ); ?></span>
            <?php endif; ?>
        </div>

        <!-- Single H1 Title -->
        <h1 class="hero-title" style="font-size: 36px; margin-bottom: var(--space-4); text-transform: none; text-shadow: var(--glow-primary);">
            <?php echo esc_html( $repo_name ); ?>
        </h1>

        <!-- Short Description -->
        <p class="body-text" style="color: var(--text-muted); max-width: 720px; margin: 0; font-size: 15px; line-height: 1.6;">
            <?php echo esc_html( $repo_desc ); ?>
        </p>

    </div>
</div>

<div class="single-resource-content-wrap" style="padding: var(--space-12) 0;">
    <div class="container container-laptop">
        <div class="grid grid-cols-12 gap-8">

            <!-- ==========================================
                 LEFT COLUMN: Specs & Guides
                 ========================================== -->
            <main class="col-span-12 lg:col-span-8" style="min-width: 0;">

                <!-- 1. Stats Counter Row -->
                <div class="grid grid-cols-12 gap-4" style="margin-bottom: var(--space-8);">
                    
                    <div class="col-span-4 glass-card" style="padding: var(--space-4); text-align: center; border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01);">
                        <span style="font-size: 22px; font-weight: 800; color: var(--warning); display: block;">★ <?php echo ! empty( $stars ) ? number_format_i18n( $stars ) : '0'; ?></span>
                        <span style="font-size: 10px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;"><?php esc_html_e( 'Stars', 'quantum-mentor-world' ); ?></span>
                    </div>

                    <div class="col-span-4 glass-card" style="padding: var(--space-4); text-align: center; border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01);">
                        <span style="font-size: 22px; font-weight: 800; color: var(--text-main); display: block;">🍴 <?php echo ! empty( $forks ) ? number_format_i18n( $forks ) : '0'; ?></span>
                        <span style="font-size: 10px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;"><?php esc_html_e( 'Forks', 'quantum-mentor-world' ); ?></span>
                    </div>

                    <div class="col-span-4 glass-card" style="padding: var(--space-4); text-align: center; border-color: rgba(255,255,255,0.04); background: rgba(255,255,255,0.01);">
                        <span style="font-size: 15px; font-weight: 700; color: var(--primary); display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; padding: 4px 0 6px;" title="<?php echo esc_attr( $owner ); ?>">
                            <?php echo ! empty( $owner ) ? esc_html( $owner ) : 'Organization'; ?>
                        </span>
                        <span style="font-size: 10px; text-transform: uppercase; color: var(--text-muted); font-weight: 600;"><?php esc_html_e( 'Owner', 'quantum-mentor-world' ); ?></span>
                    </div>

                </div>

                <!-- 2. Use Case Section -->
                <?php if ( ! empty( $use_case ) ) : ?>
                    <div class="glass-card p-6" style="margin-bottom: var(--space-8); background: rgba(0, 212, 255, 0.01); border-color: rgba(0, 212, 255, 0.15);">
                        <h2 style="font-size: 14px; font-weight: 700; text-transform: uppercase; color: var(--primary); letter-spacing: 0.05em; margin: 0 0 var(--space-3);"><?php esc_html_e( 'Primary Use Case', 'quantum-mentor-world' ); ?></h2>
                        <p style="margin: 0; font-size: 14px; line-height: 1.6; color: var(--text-main);"><?php echo esc_html( $use_case ); ?></p>
                    </div>
                <?php endif; ?>

                <!-- 3. Terminal Installation Command Box -->
                <?php if ( ! empty( $install_cmd ) ) : ?>
                    <div class="glass-card p-6" style="margin-bottom: var(--space-8);">
                        <h2 style="font-size: 14px; font-weight: 700; text-transform: uppercase; color: var(--text-muted); letter-spacing: 0.05em; margin: 0 0 var(--space-3);"><?php esc_html_e( 'Installation / Clone Command', 'quantum-mentor-world' ); ?></h2>
                        
                        <!-- Pseudo Console -->
                        <div style="background: #000000; border: 1px solid var(--border); border-radius: var(--radius-sm); padding: var(--space-3) var(--space-4); display: flex; align-items: center; justify-content: space-between; gap: var(--space-4);">
                            <span style="font-size: 12px; color: var(--success); font-weight: 700; pointer-events: none; margin-right: 4px;">$</span>
                            <input 
                                type="text" 
                                id="repo-clone-cmd-input" 
                                readonly 
                                value="<?php echo esc_attr( $install_cmd ); ?>" 
                                style="background: transparent; border: 0; outline: none; font-family: monospace; font-size: 13px; color: #FFFFFF; flex: 1; min-width: 0;"
                            >
                            <button 
                                type="button" 
                                id="repo-clone-cmd-copy-btn" 
                                class="btn btn-secondary" 
                                style="padding: 4px 12px; font-size: 11px; min-height: auto; border-color: rgba(255,255,255,0.15);"
                            >
                                <?php esc_html_e( 'Copy', 'quantum-mentor-world' ); ?>
                            </button>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- 4. Full Review / Description Details -->
                <div class="watch-description-box glass-card p-6 md:p-8" style="margin-bottom: var(--space-8);">
                    <h2 style="font-size: 18px; font-weight: 700; margin: 0 0 var(--space-4); color: var(--text-main); border-bottom: 1px solid var(--border); padding-bottom: var(--space-2);"><?php esc_html_e( 'Repository Review & Overview', 'quantum-mentor-world' ); ?></h2>
                    
                    <div class="body-text" style="font-size: 15px; line-height: 1.7; color: var(--text-main);">
                        <?php if ( ! empty( $post->post_content ) ) : ?>
                            <?php the_content(); ?>
                        <?php else : ?>
                            <p style="color: var(--text-muted); font-style: italic;">
                                <?php esc_html_e( 'Detailed software guides, dependency analysis, and setup specifications are currently being updated by our engineering editors.', 'quantum-mentor-world' ); ?>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 5. Social Sharing wrapper -->
                <div class="glass-card p-4" style="margin-bottom: var(--space-8); display: flex; align-items: center; justify-content: space-between; gap: var(--space-4); flex-wrap: wrap;">
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted); text-transform: uppercase;"><?php esc_html_e( 'Share Project:', 'quantum-mentor-world' ); ?></span>
                    <div style="display: flex; gap: var(--space-2);">
                        <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode( $repo_name ); ?>&url=<?php echo urlencode( get_permalink() ); ?>" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; min-height: auto;" target="_blank" rel="noopener noreferrer">Twitter</a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; min-height: auto;" target="_blank" rel="noopener noreferrer">Facebook</a>
                        <a href="https://t.me/share/url?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( $repo_name ); ?>" class="btn btn-secondary" style="padding: 6px 12px; font-size: 11px; min-height: auto;" target="_blank" rel="noopener noreferrer">Telegram</a>
                    </div>
                </div>

                <!-- 6. Discussion Comments template -->
                <div class="glass-card p-6 md:p-8">
                    <?php if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif; ?>
                </div>

            </main>

            <!-- ==========================================
                 RIGHT COLUMN: Outbound redirects & specs
                 ========================================== -->
            <aside class="col-span-12 lg:col-span-4">
                
                <!-- Links Action Box (View on GitHub / Read Docs) -->
                <?php get_template_part( 'template-parts/github/github-link-box' ); ?>

                <!-- Metadata Specification List -->
                <?php get_template_part( 'template-parts/github/github-meta' ); ?>

            </aside>

        </div>

        <!-- ==========================================
             BOTTOM ROW: Related repositories Row
             ========================================== -->
        <?php get_template_part( 'template-parts/github/github-related' ); ?>

    </div>
</div>

<?php
get_footer();
