<?php
/**
 * Template Name: Login Page
 *
 * @package Quantum_Mentor_World
 */

if ( is_user_logged_in() ) {
    wp_safe_redirect( home_url( '/profile/' ) );
    exit;
}

$login_errors = array();

// Process login form post request
if ( isset( $_POST['qmw_login_submit'] ) ) {
    if ( ! isset( $_POST['qmw_login_nonce'] ) || ! wp_verify_nonce( $_POST['qmw_login_nonce'], 'qmw_login_action' ) ) {
        $login_errors[] = 'Security verification failed. Please try again.';
    } else {
        $creds = array(
            'user_login'    => sanitize_text_field( $_POST['log'] ?? '' ),
            'user_password' => $_POST['pwd'] ?? '',
            'remember'      => isset( $_POST['rememberme'] ) ? true : false,
        );

        // Standard WP Signon
        $user = wp_signon( $creds, false );

        if ( is_wp_error( $user ) ) {
            $login_errors[] = $user->get_error_message();
        } else {
            wp_safe_redirect( home_url( '/profile/' ) );
            exit;
        }
    }
}

get_header();
?>

<div class="qmw-auth-page-container">
    <div class="container container-desktop qmw-auth-inner">
        <div class="qmw-glass-card qmw-auth-card">
            
            <div class="qmw-auth-header">
                <h2>Welcome Back</h2>
                <p>Log in to access your Quantum Mentor World profile, view watch history, and manage contributions.</p>
            </div>

            <?php if ( ! empty( $login_errors ) ) : ?>
                <div class="qmw-auth-error-box">
                    <ul>
                        <?php foreach ( $login_errors as $error ) : ?>
                            <li><?php echo wp_kses_post( $error ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="" method="post" id="qmw-login-form" class="qmw-auth-form">
                <?php wp_nonce_field( 'qmw_login_action', 'qmw_login_nonce' ); ?>
                
                <div class="qmw-form-group">
                    <label for="log">Username or Email Address</label>
                    <input type="text" name="log" id="log" class="qmw-form-input" required autocomplete="username" placeholder="e.g. quantum_mentor">
                </div>

                <div class="qmw-form-group">
                    <label for="pwd">Password</label>
                    <input type="password" name="pwd" id="pwd" class="qmw-form-input" required autocomplete="current-password" placeholder="••••••••">
                </div>

                <div class="qmw-form-group qmw-form-row">
                    <label class="qmw-checkbox-label">
                        <input type="checkbox" name="rememberme" id="rememberme" value="forever">
                        <span>Remember Me</span>
                    </label>
                    <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>" class="qmw-forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" name="qmw_login_submit" class="qmw-btn qmw-btn-primary qmw-auth-submit">Sign In</button>
            </form>

            <div class="qmw-auth-footer">
                <p>Don't have an account? <a href="<?php echo esc_url( home_url( '/register/' ) ); ?>">Create one here</a></p>
            </div>

        </div>
    </div>
</div>

<?php
get_footer();
