<?php
/**
 * Template Name: Submit Resource Page
 *
 * @package Quantum_Mentor_World
 */

get_header();
?>

<div class="qmw-page-header-section" style="padding: 60px 0 30px; background: radial-gradient(circle at top, rgba(var(--accent-rgb), 0.12) 0%, transparent 60%); text-align: center;">
    <div class="container container-desktop">
        <h1 style="font-family: var(--font-display); font-weight: 800; font-size: var(--font-4xl); color: var(--text-main); margin-bottom: 12px; letter-spacing: -0.01em;">
            Suggest a Resource
        </h1>
        <p style="color: var(--text-muted); max-width: 600px; margin: 0 auto; line-height: 1.6; font-size: 15px;">
            Help the Quantum Mentor World library grow. Submit free, open-source, public-domain, or creator-approved educational resources. All suggestions are manually audited.
        </p>
    </div>
</div>

<div class="qmw-submission-form-container" style="padding-bottom: 80px;">
    <div class="container container-desktop">
        <div style="max-width: 700px; margin: 0 auto;">
            <?php get_template_part( 'template-parts/forms/resource-submit-form' ); ?>
        </div>
    </div>
</div>

<?php
get_footer();
