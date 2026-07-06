<?php
/**
 * Template Name: Register Page
 *
 * @package Quantum_Mentor_World
 */

if ( is_user_logged_in() ) {
    wp_safe_redirect( home_url( '/profile/' ) );
    exit;
}

$register_errors = array();
$register_success = false;

// Process POST registration request
if ( isset( $_POST['qmw_register_submit'] ) ) {
    if ( ! get_option( 'users_can_register' ) ) {
        $register_errors[] = 'User registration is currently disabled by the site administrator.';
    } elseif ( ! isset( $_POST['qmw_register_nonce'] ) || ! wp_verify_nonce( $_POST['qmw_register_nonce'], 'qmw_register_action' ) ) {
        $register_errors[] = 'Security token expired. Please try again.';
    } else {
        $username = sanitize_user( $_POST['user_login'] ?? '' );
        $email    = sanitize_email( $_POST['user_email'] ?? '' );
        $pass1    = $_POST['pass1'] ?? '';
        $pass2    = $_POST['pass2'] ?? '';

        // Validation checks
        if ( empty( $username ) || empty( $email ) || empty( $pass1 ) || empty( $pass2 ) ) {
            $register_errors[] = 'All fields are required.';
        }
        if ( ! is_email( $email ) ) {
            $register_errors[] = 'The email address is not valid.';
        }
        if ( email_exists( $email ) ) {
            $register_errors[] = 'This email address is already registered.';
        }
        if ( username_exists( $username ) ) {
            $register_errors[] = 'This username is already taken.';
        }
        if ( $pass1 !== $pass2 ) {
            $register_errors[] = 'Passwords do not match.';
        }

        // Apply password strength validation rules
        if ( strlen( $pass1 ) < 8 ) {
            $register_errors[] = 'Password must be at least 8 characters long.';
        }
        if ( ! preg_match( '/[A-Z]/', $pass1 ) ) {
            $register_errors[] = 'Password must include at least one uppercase letter.';
        }
        if ( ! preg_match( '/[0-9]/', $pass1 ) ) {
            $register_errors[] = 'Password must include at least one number.';
        }
        if ( ! preg_match( '/[^A-Za-z0-9]/', $pass1 ) ) {
            $register_errors[] = 'Password must include at least one special character.';
        }

        // Register if no errors
        if ( empty( $register_errors ) ) {
            $user_id = wp_create_user( $username, $pass1, $email );
            if ( is_wp_error( $user_id ) ) {
                $register_errors[] = $user_id->get_error_message();
            } else {
                // Set custom role (Quantum Subscriber)
                $user = new WP_User( $user_id );
                $user->set_role( 'qmw_subscriber' );
                $register_success = true;
            }
        }
    }
}

get_header();
?>

<div class="qmw-auth-page-container">
    <div class="container container-desktop qmw-auth-inner">
        <div class="qmw-glass-card qmw-auth-card">
            
            <div class="qmw-auth-header">
                <h2>Create Account</h2>
                <p>Register to save favorites, submit resource suggestions, and join the Quantum Mentor World library.</p>
            </div>

            <?php if ( ! get_option( 'users_can_register' ) ) : ?>
                <div class="qmw-auth-error-box">
                    <p>⚠️ User registration is currently disabled on this site. Please contact the administrator.</p>
                </div>
            <?php elseif ( $register_success ) : ?>
                <div class="qmw-auth-success-box">
                    <p>🎉 Registration successful! You can now <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>" style="text-decoration: underline;">log in to your account</a>.</p>
                </div>
            <?php else : ?>

                <?php if ( ! empty( $register_errors ) ) : ?>
                    <div class="qmw-auth-error-box">
                        <ul>
                            <?php foreach ( $register_errors as $error ) : ?>
                                <li><?php echo wp_kses_post( $error ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="" method="post" id="qmw-register-form" class="qmw-auth-form">
                    <?php wp_nonce_field( 'qmw_register_action', 'qmw_register_nonce' ); ?>
                    
                    <div class="qmw-form-group">
                        <label for="user_login">Username</label>
                        <input type="text" name="user_login" id="user_login" class="qmw-form-input" required autocomplete="username" value="<?php echo isset( $_POST['user_login'] ) ? esc_attr( $_POST['user_login'] ) : ''; ?>" placeholder="e.g. quantum_learner">
                    </div>

                    <div class="qmw-form-group">
                        <label for="user_email">Email Address</label>
                        <input type="email" name="user_email" id="user_email" class="qmw-form-input" required autocomplete="email" value="<?php echo isset( $_POST['user_email'] ) ? esc_attr( $_POST['user_email'] ) : ''; ?>" placeholder="e.g. user@example.com">
                    </div>

                    <div class="qmw-form-group">
                        <label for="pass1">Password</label>
                        <input type="password" name="pass1" id="pass1" class="qmw-form-input" required autocomplete="new-password" placeholder="••••••••">
                        <small class="qmw-input-hint" style="color:var(--text-muted); font-size:11px; margin-top:4px; display:block;">
                            Min. 8 characters. Must contain 1 uppercase letter, 1 number, and 1 special symbol.
                        </small>
                    </div>

                    <div class="qmw-form-group">
                        <label for="pass2">Confirm Password</label>
                        <input type="password" name="pass2" id="pass2" class="qmw-form-input" required autocomplete="new-password" placeholder="••••••••">
                    </div>

                    <button type="submit" name="qmw_register_submit" class="qmw-btn qmw-btn-primary qmw-auth-submit">Register</button>
                </form>

            <?php endif; ?>

            <div class="qmw-auth-footer">
                <p>Already have an account? <a href="<?php echo esc_url( home_url( '/login/' ) ); ?>">Sign in here</a></p>
            </div>

        </div>
    </div>
</div>

<?php
get_footer();
