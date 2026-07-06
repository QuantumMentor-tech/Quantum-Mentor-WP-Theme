<?php
/**
 * News Archive — FAQ Section with Schema-Ready Markup
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = array(
    array(
        'question' => __( 'What type of news does Quantum Mentor World publish?', 'quantum-mentor-world' ),
        'answer'   => __( 'We publish high-quality news updates, releases, and guides covering Artificial Intelligence (AI), software updates, legal gaming news, operating systems, custom developer tools, and programming framework announcements.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Do you copy news from other websites?', 'quantum-mentor-world' ),
        'answer'   => __( 'No. We strictly prohibit the copying of full-text articles from external sites. We value original content and write independent summaries, overviews, and technical reviews.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'How do you credit original sources?', 'quantum-mentor-world' ),
        'answer'   => __( 'We enforce a strict citation policy. If an article summarizes or discusses reporting from another publication, we display a verified source attribution badge linking directly to the original publisher URL.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Can users suggest news?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes! If you have tech, AI, software, or gaming news that you believe our editorial staff should cover, please contact us. We review all submissions for factual accuracy and developer interest.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Is the news updated regularly?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes, our tech news feeds are updated on a weekly basis as significant developer changes, releases, and open-source updates happen.', 'quantum-mentor-world' ),
    ),
);
?>

<!-- ============================================================
     NEWS FAQ SECTION
     ============================================================ -->
<section class="watch-faq-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions about News', 'quantum-mentor-world' ); ?>">
    <div class="container container-laptop">

        <div class="section-header mb-8" style="text-align: center; display: block;">
            <span class="badge badge-primary" style="margin-bottom: var(--space-3); display: inline-block; border-color: var(--primary);"><?php esc_html_e( 'FAQ', 'quantum-mentor-world' ); ?></span>
            <h2 class="section-title" style="font-size: 32px; margin: 0;">
                <?php esc_html_e( 'News Platform FAQ', 'quantum-mentor-world' ); ?>
            </h2>
            <p style="color: var(--text-muted); max-width: 560px; margin: var(--space-4) auto 0; font-size: 15px;">
                <?php esc_html_e( 'Find out about our editorial guidelines, plagiarism policies, and content sources.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <!-- FAQ Accordion — schema-ready via itemscope/itemtype -->
        <div class="watch-faq-list" itemscope itemtype="https://schema.org/FAQPage">

            <?php foreach ( $faqs as $i => $faq ) :
                $item_id = 'news-faq-' . ( $i + 1 );
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
