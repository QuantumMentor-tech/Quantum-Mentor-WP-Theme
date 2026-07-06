<?php
/**
 * Tools Archive — FAQ Section with Schema-Ready Markup
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = array(
    array(
        'question' => __( 'Are the tools on Quantum Mentor World free?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. Every tool cataloged in our directory is completely free of charge. We index official freeware, open-source browser extensions, public web utilities, and our own built-in browser-based sandboxed tools.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Are external tools safe to use?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes, we perform rigorous safety and link integrity checks at catalog time to ensure all links lead to official, non-malicious, and developer-verified websites. When opening external links, please note you are subject to the external site’s cookie and privacy policies.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Do you host cracked tools?', 'quantum-mentor-world' ),
        'answer'   => __( 'No. We strictly prohibit the indexing, hosting, or linking of cracked tools, bypassed software, key generators, patched files, or pirated developer resources. We respect developer intellectual property and support legal download chains.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Will Quantum Mentor World have built-in tools?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. We are building lightweight developer and editor utilities directly inside the browser sandbox (e.g. Word Counter, JSON Formatter, Text Case Converter, Image Compressor). Because these tools run locally in your browser session, no text or image files are uploaded to any server, guaranteeing absolute file privacy.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Can I suggest a useful tool?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. We welcome submissions of legal, open-source, freeware, or official free web utilities. Please reach out to us via our contact form with details. Our safety team will review the licensing and safety profile before index approval.', 'quantum-mentor-world' ),
    ),
);
?>

<!-- ============================================================
     TOOLS FAQ SECTION
     ============================================================ -->
<section class="watch-faq-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions about Tools', 'quantum-mentor-world' ); ?>">
    <div class="container container-laptop">

        <div class="section-header mb-8" style="text-align: center; display: block;">
            <span class="badge badge-primary" style="margin-bottom: var(--space-3); display: inline-block; border-color: var(--primary);"><?php esc_html_e( 'FAQ', 'quantum-mentor-world' ); ?></span>
            <h2 class="section-title" style="font-size: 32px; margin: 0;">
                <?php esc_html_e( 'Frequently Asked Questions', 'quantum-mentor-world' ); ?>
            </h2>
            <p style="color: var(--text-muted); max-width: 560px; margin: var(--space-4) auto 0; font-size: 15px;">
                <?php esc_html_e( 'Find out about the safety, privacy, and development policies of our tools directory.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <!-- FAQ Accordion — schema-ready via itemscope/itemtype -->
        <div class="watch-faq-list" itemscope itemtype="https://schema.org/FAQPage">

            <?php foreach ( $faqs as $i => $faq ) :
                $item_id = 'tools-faq-' . ( $i + 1 );
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
