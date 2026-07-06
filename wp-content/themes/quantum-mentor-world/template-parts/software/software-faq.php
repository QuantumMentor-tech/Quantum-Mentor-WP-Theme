<?php
/**
 * Software Archive FAQ Accordions Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$faqs = array(
    array(
        'q' => esc_html__( 'Is the software listed on Quantum Mentor World legal?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Yes, absolutely. We strictly only list software that is open-source, freeware, public domain, or official licensed links. We do not support, host, or link to unauthorized software distributions.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Do you host cracked software?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'No. Quantum Mentor World does not host, share, or promote cracked software, key generators, patches, activators, or pirated downloads of any kind. All links redirect directly to the official developers, verified mirrors, or authorized release repositories.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Are download links safe?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Yes. Every download link listed in our directory points directly to official developer websites or verified open-source host systems (such as GitHub). We continuously perform checks to ensure that all destinations remain clean and malware-free.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Can I suggest software?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Yes, suggestions are welcome! If you know of a legal, open-source, or freeware program that fits our categories, you can submit it through our support page. Our team reviews all suggestions to verify compliance with our strict security and licensing guidelines.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Why should I use official sources?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Downloading from official sources ensures you get the clean, unaltered software version. Third-party sites often bundle software with adware or tracking modules. Using official links also respects the intellectual property and efforts of the software developers.', 'quantum-mentor-world' )
    )
);

// Construct JSON-LD schema
$schema_items = array();
foreach ( $faqs as $faq ) {
    $schema_items[] = array(
        '@type' => 'Question',
        'name'  => $faq['q'],
        'acceptedAnswer' => array(
            '@type' => 'Answer',
            'text'  => $faq['a']
        )
    );
}

$faq_schema = array(
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => $schema_items
);
?>

<section class="software-faq-section py-12 mb-8 border-top-divider" style="border-top: 1px solid var(--border); padding-top: var(--space-12);">
    <div class="container container-laptop">
        <h2 class="section-title mb-8 text-center" style="margin-bottom: var(--space-8); text-align: center;">
            <?php esc_html_e( 'Frequently Asked Questions', 'quantum-mentor-world' ); ?>
        </h2>
        
        <div class="faq-accordion-wrapper" style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: var(--space-4);">
            <?php foreach ( $faqs as $index => $faq ) : ?>
                <div class="faq-item glass-card" style="padding: 0; overflow: hidden; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                    <button class="faq-question" aria-expanded="false" aria-controls="faq-answer-<?php echo esc_attr( $index ); ?>" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: var(--space-4) var(--space-6); background: transparent; border: none; outline: none; text-align: left; cursor: pointer; color: var(--text-main); font-family: var(--font-display); font-size: 16px; font-weight: 600; gap: var(--space-4);">
                        <span><?php echo esc_html( $faq['q'] ); ?></span>
                        <span class="faq-icon" style="font-size: 18px; transition: transform var(--transition-speed); color: var(--primary);">+</span>
                    </button>
                    <div id="faq-answer-<?php echo esc_attr( $index ); ?>" class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height var(--transition-speed) var(--transition-timing); color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                        <div class="faq-answer-content" style="padding: 0 var(--space-6) var(--space-4) var(--space-6);">
                            <p><?php echo esc_html( $faq['a'] ); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Inject FAQ Page Schema -->
<script type="application/ld+json">
<?php echo json_encode( $faq_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ); ?>
</script>
