<?php
/**
 * GitHub Archive — FAQ Section with Schema-Ready Markup
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = array(
    array(
        'question' => __( 'Are the GitHub repositories legal to use?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. We only index repositories that publish code under verified, legal open-source licenses (such as MIT, Apache 2.0, or GPL). We do not list or link to repositories containing cracked tools, bypassed software, or copyrighted material.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Do you own these repositories?', 'quantum-mentor-world' ),
        'answer'   => __( 'No. All listed repositories are owned and maintained by their respective creator organizations or independent developers. We credit the original owners and provide direct links back to their official GitHub repositories.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Can I suggest a GitHub repo?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. We encourage submissions of helpful, legal open-source projects. Please contact us with details about the project. Our editorial team will review the repository\'s safety, activity, and licensing before approval.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Are all repositories beginner-friendly?', 'quantum-mentor-world' ),
        'answer'   => __( 'No. We index repositories of varying difficulties. Each repository card and detail page displays a clear difficulty badge (Beginner, Intermediate, or Advanced) to help you choose repositories that match your experience level.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Should I check the license before using a repo?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. Although we display the repository\'s primary open-source license, you should always consult the LICENSE file inside the repository itself to check for specific terms, conditions, and copyright details.', 'quantum-mentor-world' ),
    ),
);
?>

<!-- ============================================================
     GITHUB FAQ SECTION
     ============================================================ -->
<section class="watch-faq-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions about GitHub Repositories', 'quantum-mentor-world' ); ?>">
    <div class="container container-laptop">

        <div class="section-header mb-8" style="text-align: center; display: block;">
            <span class="badge badge-primary" style="margin-bottom: var(--space-3); display: inline-block; border-color: var(--primary);"><?php esc_html_e( 'FAQ', 'quantum-mentor-world' ); ?></span>
            <h2 class="section-title" style="font-size: 32px; margin: 0;">
                <?php esc_html_e( 'Repositories FAQ', 'quantum-mentor-world' ); ?>
            </h2>
            <p style="color: var(--text-muted); max-width: 560px; margin: var(--space-4) auto 0; font-size: 15px;">
                <?php esc_html_e( 'Find out about the licensing, safety, ownership, and contribution guidelines of our repository directory.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <!-- FAQ Accordion — schema-ready via itemscope/itemtype -->
        <div class="watch-faq-list" itemscope itemtype="https://schema.org/FAQPage">

            <?php foreach ( $faqs as $i => $faq ) :
                $item_id = 'github-faq-' . ( $i + 1 );
                $panel_id = $item_id . '-panel';
            ?>
            <div class="watch-faq-item glass-card" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">

                <button
                    class="faq-question watch-faq-btn"
                    id="<?php echo esc_attr( $item_id ); ?>"
                    aria-expanded="false"
                    aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                    type="button"
                    style="border: 0; background: transparent; width: 100%; display: flex; justify-content: space-between; align-items: center; color: var(--text-main); font-weight: 600; cursor: pointer; text-align: left; padding: var(--space-4) var(--space-5);"
                >
                    <span class="watch-faq-q-text" itemprop="name">
                        <?php echo esc_html( $faq['question'] ); ?>
                    </span>
                    <span class="faq-icon watch-faq-icon" aria-hidden="true" style="color: var(--primary); transition: transform 0.25s;">+</span>
                </button>

                <div
                    class="faq-answer watch-faq-answer"
                    id="<?php echo esc_attr( $panel_id ); ?>"
                    role="region"
                    aria-labelledby="<?php echo esc_attr( $item_id ); ?>"
                    itemscope
                    itemprop="acceptedAnswer"
                    itemtype="https://schema.org/Answer"
                    style="max-height: 0; overflow: hidden; transition: max-height 0.25s ease-out;"
                >
                    <div class="watch-faq-answer-inner" itemprop="text" style="padding: 0 var(--space-5) var(--space-4); font-size: 13px; color: var(--text-muted); line-height: 1.6;">
                        <?php echo esc_html( $faq['answer'] ); ?>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>
