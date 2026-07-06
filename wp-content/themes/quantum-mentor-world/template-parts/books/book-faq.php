<?php
/**
 * Books Archive — FAQ Section with Schema-Ready Markup
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = array(
    array(
        'question' => __( 'Are the books listed in the library legal to read and download?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. Quantum Mentor World strictly lists only legal, public-domain, open-access, Creative Commons, or creator-approved books. We also catalog paid publications with official links to their respective publisher websites. We enforce a zero-piracy policy and verify all digital links prior to listing them.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Do you host pirated PDFs or leaked course books?', 'quantum-mentor-world' ),
        'answer'   => __( 'No. Quantum Mentor World does not host or link to pirated copies, leaked PDFs, textbook cracks, or copyrighted material without permission. All of our listed e-books point directly to verified open-access repositories (like Google Books, Internet Archive), the author\'s distribution channels, or legitimate retail websites.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'What formats are the e-books available in?', 'quantum-mentor-world' ),
        'answer'   => __( 'Depending on the source, books are available in multiple formats, including PDF, EPUB, MOBI, DOCX, Audiobook, or as an Online Read directly in the browser. You can check the available formats under the specifications card on each book\'s page or filter by your preferred format on the library main page.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Can I suggest a free or open-access book to be added?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes, we welcome community recommendations! If you know of a legal, free, or open-licensed book or guide, please reach out to us via our contact page. Please include the book title, author, the publisher or license information (e.g. Creative Commons), and the official link. Our team will verify and catalog it.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'What is the difference between Public Domain and Open Access?', 'quantum-mentor-world' ),
        'answer'   => __( 'Public Domain books are titles whose copyright has expired or has been voluntarily surrendered, making them free for anyone to use, share, and modify legally. Open Access books are copyrighted works that are made available for free download or online reading by the authors or publishers under permissive licenses (such as Creative Commons) to spread knowledge.', 'quantum-mentor-world' ),
    ),
);
?>

<!-- ============================================================
     BOOKS FAQ SECTION
     ============================================================ -->
<section class="books-faq-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions about Books', 'quantum-mentor-world' ); ?>">
    <div class="container container-laptop">

        <div class="section-header mb-8" style="text-align: center; display: block;">
            <span class="badge badge-warning" style="margin-bottom: var(--space-3); display: inline-block;">FAQ</span>
            <h2 class="section-title" style="font-size: 32px;">
                <?php esc_html_e( 'Frequently Asked Questions', 'quantum-mentor-world' ); ?>
            </h2>
            <p style="color: var(--text-muted); max-width: 560px; margin: var(--space-4) auto 0; font-size: 15px;">
                <?php esc_html_e( 'Everything you need to know about our Digital Books Library.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <!-- FAQ Accordion — schema-ready via itemscope/itemtype -->
        <div class="books-faq-list" itemscope itemtype="https://schema.org/FAQPage">

            <?php foreach ( $faqs as $i => $faq ) :
                $item_id = 'books-faq-' . ( $i + 1 );
                $panel_id = $item_id . '-panel';
            ?>
            <div class="books-faq-item glass-card" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">

                <button
                    class="faq-question books-faq-btn"
                    id="<?php echo esc_attr( $item_id ); ?>"
                    aria-expanded="false"
                    aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                    type="button"
                >
                    <span class="books-faq-q-text" itemprop="name">
                        <?php echo esc_html( $faq['question'] ); ?>
                    </span>
                    <span class="faq-icon books-faq-icon" aria-hidden="true">+</span>
                </button>

                <div
                    class="faq-answer books-faq-answer"
                    id="<?php echo esc_attr( $panel_id ); ?>"
                    role="region"
                    aria-labelledby="<?php echo esc_attr( $item_id ); ?>"
                    itemscope
                    itemprop="acceptedAnswer"
                    itemtype="https://schema.org/Answer"
                >
                    <div class="books-faq-answer-inner" itemprop="text">
                        <?php echo esc_html( $faq['answer'] ); ?>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>
