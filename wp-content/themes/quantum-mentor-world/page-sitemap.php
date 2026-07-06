<?php
/**
 * Template Name: HTML Sitemap Page
 *
 * Displays a clean, structured visual site directory for SEO crawling and manual navigation.
 *
 * @package Quantum_Mentor_World
 */

get_header();

// Helper to query and list post links for a CPT
function qmw_sitemap_list_cpt_posts( $post_type, $title, $icon ) {
    $posts = get_posts( array(
        'post_type'      => $post_type,
        'post_status'    => 'publish',
        'posts_per_page' => 100,
        'orderby'        => 'title',
        'order'          => 'ASC',
        'no_found_rows'  => true,
    ) );

    echo '<div class="qmw-sitemap-section qmw-glass-card">';
    echo '  <h3><span class="dashicons ' . esc_attr( $icon ) . '"></span> ' . esc_html( $title ) . ' (' . count( $posts ) . ')</h3>';
    if ( ! empty( $posts ) ) {
        echo '<ul class="qmw-sitemap-list">';
        foreach ( $posts as $p ) {
            printf(
                '<li><a href="%s" target="_blank" rel="noopener noreferrer">%s</a></li>',
                esc_url( get_permalink( $p->ID ) ),
                esc_html( $p->post_title )
            );
        }
        echo '</ul>';
    } else {
        echo '<p class="qmw-sitemap-empty">No resources listed yet.</p>';
    }
    echo '</div>';
}
?>

<div class="qmw-sitemap-page-hero" style="padding: 60px 0 30px; background: radial-gradient(circle at top, rgba(var(--accent-rgb), 0.12) 0%, transparent 60%); text-align: center;">
    <div class="container container-desktop">
        <h1 style="font-family: var(--font-display); font-weight: 800; font-size: var(--font-4xl); color: var(--text-main); margin-bottom: 8px;">
            Sitemap Directory
        </h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto; line-height: 1.6;">
            A complete indices of all pages, directories, tools, and digital resources available on Quantum Mentor World.
        </p>
    </div>
</div>

<div class="qmw-sitemap-page-content" style="padding-bottom: 80px;">
    <div class="container container-desktop">
        
        <div class="qmw-sitemap-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
            
            <!-- Column Item: Core Pages -->
            <div class="qmw-sitemap-section qmw-glass-card">
                <h3><span class="dashicons dashicons-admin-generic"></span> Main Directories</h3>
                <ul class="qmw-sitemap-list">
                    <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home Page</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/software/' ) ); ?>">Software Index</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/themes-plugins/' ) ); ?>">Themes & Plugins Index</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/games/' ) ); ?>">Games Library</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/books/' ) ); ?>">Books Directory</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/watch/' ) ); ?>">Watch Video Hub</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/tools/' ) ); ?>">Built-in & Web Tools</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">Technology & AI News</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/github-repos/' ) ); ?>">GitHub Repositories Index</a></li>
                </ul>
                <h3 style="margin-top: 20px;"><span class="dashicons dashicons-admin-users"></span> Account & Action Pages</h3>
                <ul class="qmw-sitemap-list">
                    <li><a href="<?php echo esc_url( home_url( '/login/' ) ); ?>">Account Sign In</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Account Registration</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/profile/' ) ); ?>">User Dashboard</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/submit-resource/' ) ); ?>">Suggest a Resource</a></li>
                </ul>
            </div>

            <!-- CPT listings -->
            <?php 
            qmw_sitemap_list_cpt_posts( 'software', 'Software List', 'dashicons-desktop' );
            qmw_sitemap_list_cpt_posts( 'themes_plugins', 'Themes & Plugins', 'dashicons-admin-plugins' );
            qmw_sitemap_list_cpt_posts( 'games', 'Games Catalogue', 'dashicons-games' );
            qmw_sitemap_list_cpt_posts( 'books', 'Books Library', 'dashicons-book-alt' );
            qmw_sitemap_list_cpt_posts( 'tools', 'Online Tools', 'dashicons-admin-tools' );
            qmw_sitemap_list_cpt_posts( 'watch', 'Watch & Stream Content', 'dashicons-video-alt3' );
            qmw_sitemap_list_cpt_posts( 'news', 'AI & Tech News Articles', 'dashicons-megaphone' );
            qmw_sitemap_list_cpt_posts( 'github_repos', 'GitHub Repositories', 'dashicons-networking' );
            ?>

        </div>

    </div>
</div>

<?php
get_footer();
