<?php
/**
 * Template part for the frontend resource submission form
 *
 * @package Quantum_Mentor_World
 */

$current_user = is_user_logged_in() ? wp_get_current_user() : null;
$default_name = $current_user ? $current_user->display_name : '';
$default_email = $current_user ? $current_user->user_email : '';
?>

<div class="qmw-glass-card qmw-form-card" id="qmw-resource-submit-wrapper">
    
    <!-- Submission messages container -->
    <div class="qmw-form-message-box" style="display: none;"></div>

    <form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" method="post" id="qmw-resource-submit-form">
        <!-- Action hook and Nonce -->
        <input type="hidden" name="action" value="qmw_submit_resource">
        <?php wp_nonce_field( 'qmw_submit_resource_action', 'qmw_nonce' ); ?>

        <div class="qmw-form-grid-2">
            <div class="qmw-form-group">
                <label for="res_title">Resource Title <span class="qmw-required">*</span></label>
                <input type="text" name="res_title" id="res_title" class="qmw-form-input" required placeholder="e.g. VLC Media Player">
            </div>

            <div class="qmw-form-group">
                <label for="res_type">Resource Type <span class="qmw-required">*</span></label>
                <select name="res_type" id="res_type" class="qmw-form-input" required>
                    <option value="">— Select Type —</option>
                    <option value="software">Software</option>
                    <option value="books">Book</option>
                    <option value="tools">Tool</option>
                    <option value="github_repos">GitHub Repository</option>
                    <option value="news">News Tip</option>
                    <option value="watch">Legal Watch Content</option>
                </select>
            </div>
        </div>

        <div class="qmw-form-grid-2">
            <div class="qmw-form-group">
                <label for="res_category">Category / Genre</label>
                <input type="text" name="res_category" id="res_category" class="qmw-form-input" placeholder="e.g. Media Player, Algorithms, AI Tool">
            </div>

            <div class="qmw-form-group">
                <label for="res_url">Official / Source URL <span class="qmw-required">*</span></label>
                <input type="url" name="res_url" id="res_url" class="qmw-form-input" required placeholder="https://">
            </div>
        </div>

        <div class="qmw-form-group">
            <label for="res_desc">Short Description / Excerpt</label>
            <textarea name="res_desc" id="res_desc" class="qmw-form-input" rows="4" placeholder="Describe the resource in 2-3 sentences..."></textarea>
        </div>

        <div class="qmw-form-grid-2" style="margin-top: 20px; border-top: 1px solid var(--border); padding-top: 20px;">
            <div class="qmw-form-group">
                <label for="user_name">Your Name <span class="qmw-required">*</span></label>
                <input type="text" name="user_name" id="user_name" class="qmw-form-input" required value="<?php echo esc_attr( $default_name ); ?>" placeholder="e.g. John Doe" <?php echo $current_user ? 'readonly' : ''; ?>>
            </div>

            <div class="qmw-form-group">
                <label for="user_email">Your Email Address <span class="qmw-required">*</span></label>
                <input type="email" name="user_email" id="user_email" class="qmw-form-input" required value="<?php echo esc_attr( $default_email ); ?>" placeholder="e.g. email@example.com" <?php echo $current_user ? 'readonly' : ''; ?>>
            </div>
        </div>

        <div class="qmw-form-group">
            <label for="notes">Additional Audit Notes</label>
            <textarea name="notes" id="notes" class="qmw-form-input" rows="3" placeholder="Add licensing permissions details, instructions, or direct download links if any..."></textarea>
        </div>

        <div class="qmw-form-group qmw-legal-confirm-group" style="margin-top: 25px;">
            <label class="qmw-checkbox-label" style="align-items: flex-start; display: flex; gap: 10px;">
                <input type="checkbox" name="legal_confirm" id="legal_confirm" value="1" required style="margin-top: 4px;">
                <span style="font-size: 13px; line-height: 1.5; color: var(--text-muted);">
                    I confirm this resource is legal, official, open-source, public-domain, creator-approved, or properly licensed. <span class="qmw-required">*</span>
                </span>
            </label>
        </div>

        <div class="qmw-form-actions" style="margin-top: 30px; text-align: right;">
            <button type="submit" id="qmw-resource-submit-btn" class="qmw-btn qmw-btn-primary">Submit Suggestion</button>
        </div>

    </form>
</div>
