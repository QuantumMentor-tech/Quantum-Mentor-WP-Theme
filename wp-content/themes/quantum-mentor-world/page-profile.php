<?php
/**
 * Template Name: Profile / Account Page
 *
 * @package Quantum_Mentor_World
 */

if ( ! is_user_logged_in() ) {
    wp_safe_redirect( home_url( '/login/' ) );
    exit;
}

$current_user = wp_get_current_user();
$user_email = $current_user->user_email;

// Query actual submissions made by this user
$user_subs_query = new WP_Query( array(
    'post_type'      => 'user_submissions',
    'post_status'    => 'any', // Show pending, draft, published
    'posts_per_page' => 10,
    'meta_query'     => array(
        array(
            'key'     => 'submission_user_email',
            'value'   => $user_email,
            'compare' => '=',
        ),
    ),
) );

get_header();
?>

<div class="qmw-profile-page-container">
    <div class="container container-desktop qmw-profile-inner">
        
        <div class="qmw-profile-layout">
            
            <!-- Left Panel: User Profile Card -->
            <aside class="qmw-profile-sidebar">
                <?php get_template_part( 'template-parts/user/profile-card' ); ?>
            </aside>

            <!-- Right Panel: Tabs Content -->
            <main class="qmw-profile-main-content">
                <div class="qmw-glass-card qmw-profile-tabs-wrapper">
                    
                    <!-- Tabs Navigation -->
                    <ul class="qmw-tabs-nav" role="tablist">
                        <li class="qmw-tab-item active" data-tab="profile-info" role="presentation">
                            <button role="tab" aria-selected="true" aria-controls="profile-info">Profile Info</button>
                        </li>
                        <li class="qmw-tab-item" data-tab="favorites" role="presentation">
                            <button role="tab" aria-selected="false" aria-controls="favorites">Favorites</button>
                        </li>
                        <li class="qmw-tab-item" data-tab="watch-history" role="presentation">
                            <button role="tab" aria-selected="false" aria-controls="watch-history">Watch History</button>
                        </li>
                        <li class="qmw-tab-item" data-tab="download-history" role="presentation">
                            <button role="tab" aria-selected="false" aria-controls="download-history">Downloads</button>
                        </li>
                        <li class="qmw-tab-item" data-tab="submissions" role="presentation">
                            <button role="tab" aria-selected="false" aria-controls="submissions">My Submissions</button>
                        </li>
                    </ul>

                    <!-- Tabs Content Panels -->
                    <div class="qmw-tabs-content">
                        
                        <!-- Panel 1: Profile Info -->
                        <div class="qmw-tab-panel active" id="profile-info" role="tabpanel">
                            <h3>Account Information</h3>
                            <div class="qmw-profile-details-grid">
                                <div class="qmw-detail-item">
                                    <span class="qmw-detail-label">Username</span>
                                    <span class="qmw-detail-value"><?php echo esc_html( $current_user->user_login ); ?></span>
                                </div>
                                <div class="qmw-detail-item">
                                    <span class="qmw-detail-label">Email Address</span>
                                    <span class="qmw-detail-value"><?php echo esc_html( $current_user->user_email ); ?></span>
                                </div>
                                <div class="qmw-detail-item">
                                    <span class="qmw-detail-label">Display Name</span>
                                    <span class="qmw-detail-value"><?php echo esc_html( $current_user->display_name ); ?></span>
                                </div>
                                <div class="qmw-detail-item">
                                    <span class="qmw-detail-label">Registered Since</span>
                                    <span class="qmw-detail-value"><?php echo esc_html( date_i18n( get_option( 'date_format' ), strtotime( $current_user->user_registered ) ) ); ?></span>
                                </div>
                            </div>
                            
                            <div class="qmw-profile-actions" style="margin-top: 30px; border-top: 1px solid var(--border); padding-top: 20px;">
                                <a href="<?php echo esc_url( wp_logout_url( home_url( '/login/' ) ) ); ?>" class="qmw-btn qmw-btn-secondary">Log Out</a>
                                <?php if ( current_user_can( 'edit_posts' ) ) : ?>
                                    <a href="<?php echo esc_url( admin_url() ); ?>" class="qmw-btn qmw-btn-primary" style="margin-left: 10px;">Go to Admin Panel</a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Panel 2: Favorites Placeholder -->
                        <div class="qmw-tab-panel" id="favorites" role="tabpanel" style="display:none;">
                            <h3>Saved Resources</h3>
                            <p class="description">Keep track of your favorite tools, software, games, and books.</p>
                            
                            <div class="qmw-placeholder-box">
                                <span class="dashicons dashicons-star-filled qmw-placeholder-icon"></span>
                                <h4>No Favorites Saved Yet</h4>
                                <p>Start browsing our resources directory and click "Add to Favorites" to save them here.</p>
                                <a href="<?php echo esc_url( home_url( '/software/' ) ); ?>" class="qmw-btn qmw-btn-primary btn-sm">Explore Software</a>
                            </div>
                        </div>

                        <!-- Panel 3: Watch History Placeholder -->
                        <div class="qmw-tab-panel" id="watch-history" role="tabpanel" style="display:none;">
                            <h3>Course & Video Watch History</h3>
                            <p class="description">Resume courses, tutorials, and documentaries from where you left off.</p>
                            
                            <div class="qmw-placeholder-box">
                                <span class="dashicons dashicons-video-alt3 qmw-placeholder-icon"></span>
                                <h4>No Watch History</h4>
                                <p>You haven't watched any video lectures or courses yet. Check out the watch section to start learning.</p>
                                <a href="<?php echo esc_url( home_url( '/watch/' ) ); ?>" class="qmw-btn qmw-btn-primary btn-sm">Explore Watch Section</a>
                            </div>
                        </div>

                        <!-- Panel 4: Download History Placeholder -->
                        <div class="qmw-tab-panel" id="download-history" role="tabpanel" style="display:none;">
                            <h3>Download Log</h3>
                            <p class="description">Access and redownload resources you have previously acquired.</p>
                            
                            <div class="qmw-placeholder-box">
                                <span class="dashicons dashicons-download qmw-placeholder-icon"></span>
                                <h4>No Downloads Recorded</h4>
                                <p>Your downloaded items log is currently empty. Get legal downloads instantly from our dashboard directories.</p>
                            </div>
                        </div>

                        <!-- Panel 5: Submissions -->
                        <div class="qmw-tab-panel" id="submissions" role="tabpanel" style="display:none;">
                            <div class="qmw-panel-header-row" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px;">
                                <h3>Suggested Resources</h3>
                                <a href="<?php echo esc_url( home_url( '/submit-resource/' ) ); ?>" class="qmw-btn qmw-btn-primary btn-sm">+ Suggest Resource</a>
                            </div>
                            
                            <?php if ( $user_subs_query->have_posts() ) : ?>
                                <ul class="qmw-profile-submissions-list">
                                    <?php while ( $user_subs_query->have_posts() ) : $user_subs_query->the_post(); ?>
                                        <?php 
                                        $type = get_post_meta( get_the_ID(), 'submission_type', true );
                                        $status = get_post_status();
                                        $status_label = 'Pending Review';
                                        $status_class = 'pending';
                                        if ( 'publish' === $status ) {
                                            $status_label = 'Approved / Live';
                                            $status_class = 'approved';
                                        }
                                        ?>
                                        <li>
                                            <div class="qmw-sub-info">
                                                <span class="qmw-badge qmw-badge-<?php echo esc_attr( $type ); ?>"><?php echo esc_html( ucfirst( $type ) ); ?></span>
                                                <strong><?php the_title(); ?></strong>
                                                <span class="qmw-sub-date"><?php echo esc_html( get_the_date() ); ?></span>
                                            </div>
                                            <span class="qmw-status-tag qmw-status-tag-<?php echo esc_attr( $status_class ); ?>">
                                                <?php echo esc_html( $status_label ); ?>
                                            </span>
                                        </li>
                                    <?php endwhile; wp_reset_postdata(); ?>
                                </ul>
                            <?php else : ?>
                                <div class="qmw-placeholder-box">
                                    <span class="dashicons dashicons-upload qmw-placeholder-icon"></span>
                                    <h4>No Submissions Yet</h4>
                                    <p>Help the community grow by suggesting legal, official, or open-source resources.</p>
                                    <a href="<?php echo esc_url( home_url( '/submit-resource/' ) ); ?>" class="qmw-btn qmw-btn-primary btn-sm">Suggest Your First Resource</a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </main>

        </div>

    </div>
</div>

<?php
get_footer();
