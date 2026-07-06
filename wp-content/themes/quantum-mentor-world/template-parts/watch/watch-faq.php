<?php
/**
 * Watch Archive — FAQ Section with Schema-Ready Markup
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = array(
    array(
        'question' => __( 'Is the watch content on Quantum Mentor World legal?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. Quantum Mentor World exclusively indexes and embeds legal, public, creator-approved, official, or properly licensed video content. Every stream is sourced directly from verified platforms, and we enforce a strict zero-piracy review process.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Do you host videos on your server?', 'quantum-mentor-world' ),
        'answer'   => __( 'No. We do not host, store, upload, or transmit any video files on our local servers. All watch streams are displayed using legal iframe embeds hosted on trusted third-party video networks (such as YouTube, Vimeo, Dailymotion, Facebook Video, Internet Archive, and official creator URLs).', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Can I watch paid courses for free here?', 'quantum-mentor-world' ),
        'answer'   => __( 'No. We respect intellectual property and content creators. We do not host or embed pirated movies, premium anime, leaked paid courses, or copyrighted streams. Only videos officially published by the copyright holder for public access are indexed.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Why are there multiple video servers?', 'quantum-mentor-world' ),
        'answer'   => __( 'Providing multiple server options (e.g. Server 1, Server 2) helps ensure streaming availability. If a primary host experiences loading delays or is restricted in your region, you can switch servers to load the video from alternative legal channels.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Can I suggest legal educational videos?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes, we encourage suggestions for legal, educational, open-access tutorials, or documentaries. Please submit recommendations through our contact form. Our team will verify the license and official source before cataloging them.', 'quantum-mentor-world' ),
    ),
);
?>

<!-- ============================================================
     WATCH FAQ SECTION
     ============================================================ -->
<section class="watch-faq-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions about Videos', 'quantum-mentor-world' ); ?>">
    <div class="container container-laptop">

        <div class="section-header mb-8" style="text-align: center; display: block;">
            <span class="badge badge-primary" style="margin-bottom: var(--space-3); display: inline-block;">FAQ</span>
            <h2 class="section-title" style="font-size: 32px;">
                <?php esc_html_e( 'Frequently Asked Questions', 'quantum-mentor-world' ); ?>
            </h2>
            <p style="color: var(--text-muted); max-width: 560px; margin: var(--space-4) auto 0; font-size: 15px;">
                <?php esc_html_e( 'Everything you need to know about our legal watch platform.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <!-- FAQ Accordion — schema-ready via itemscope/itemtype -->
        <div class="watch-faq-list" itemscope itemtype="https://schema.org/FAQPage">

            <?php foreach ( $faqs as $i => $faq ) :
                $item_id = 'watch-faq-' . ( $i + 1 );
                $panel_id = $item_id . '-panel';
            ?>
            <div class="watch-faq-item glass-card" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">

                <button
                    class="faq-question watch-faq-btn"
                    id="<?php echo esc_attr( $item_id ); ?>"
                    aria-expanded="false"
                    aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                    type="button"
                >
                    <span class="watch-faq-q-text" itemprop="name">
                        <?php echo esc_html( $faq['question'] ); ?>
                    </span>
                    <span class="faq-icon watch-faq-icon" aria-hidden="true">+</span>
                </button>

                <div
                    class="faq-answer watch-faq-answer"
                    id="<?php echo esc_attr( $panel_id ); ?>"
                    role="region"
                    aria-labelledby="<?php echo esc_attr( $item_id ); ?>"
                    itemscope
                    itemprop="acceptedAnswer"
                    itemtype="https://schema.org/Answer"
                >
                    <div class="watch-faq-answer-inner" itemprop="text">
                        <?php echo esc_html( $faq['answer'] ); ?>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>
