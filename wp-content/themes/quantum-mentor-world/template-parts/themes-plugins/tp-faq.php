<?php
/**
 * Themes & Plugins Archive FAQ Accordion Component
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$faqs = array(
    array(
        'q' => esc_html__( 'Are these themes and plugins legal?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Yes. We strictly only index and list themes, plugins, and templates that are released under open-source licenses, the GNU General Public License (GPL), or verified direct developer distribution channels.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Do you provide nulled themes or cracked plugins?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'No. Quantum Mentor World has a strict zero-piracy policy. We do not provide, host, or distribute nulled themes, cracked plugins, leaked premium files, or bypassed license keys of any kind.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Are GPL themes and plugins safe?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Resources licensed under the GPL are completely legal to modify and distribute. However, third-party sites often distribute "nulled" versions that contain hidden backdoors, malware, or adware. To keep your website safe, Quantum Mentor World only redirects users to official release repositories or verified developers.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Should I download from official sources?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Yes, absolutely. Downloading directly from the official repositories (like WordPress.org) or authentic developer websites guarantees that you receive clean, unmodified code. This ensures maximum safety, stability, and compatibility for your website.', 'quantum-mentor-world' )
    ),
    array(
        'q' => esc_html__( 'Can I suggest a theme or plugin?', 'quantum-mentor-world' ),
        'a' => esc_html__( 'Yes! We welcome suggestions. If you know of an open-source, GPL-compliant, or free resource that would benefit the community, you can submit it through our support form. Our team verifies its licensing and security code before listing.', 'quantum-mentor-world' )
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

<section class="tp-faq-section py-12 mb-8 border-top-divider" style="border-top: 1px solid var(--border); padding-top: var(--space-12);">
    <div class="container container-laptop">
        <h2 class="section-title mb-8 text-center" style="margin-bottom: var(--space-8); text-align: center;">
            <?php esc_html_e( 'Frequently Asked Questions', 'quantum-mentor-world' ); ?>
        </h2>
        
        <div class="faq-accordion-wrapper" style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: var(--space-4);">
            <?php foreach ( $faqs as $index => $faq ) : ?>
                <div class="faq-item glass-card" style="padding: 0; overflow: hidden; border-radius: var(--radius-sm); border: 1px solid var(--border);">
                    <button class="faq-question" aria-expanded="false" aria-controls="tp-faq-answer-<?php echo esc_attr( $index ); ?>" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: var(--space-4) var(--space-6); background: transparent; border: none; outline: none; text-align: left; cursor: pointer; color: var(--text-main); font-family: var(--font-display); font-size: 16px; font-weight: 600; gap: var(--space-4);">
                        <span><?php echo esc_html( $faq['q'] ); ?></span>
                        <span class="faq-icon" style="font-size: 18px; transition: transform var(--transition-speed); color: var(--primary);">+</span>
                    </button>
                    <div id="tp-faq-answer-<?php echo esc_attr( $index ); ?>" class="faq-answer" style="max-height: 0; overflow: hidden; transition: max-height var(--transition-speed) var(--transition-timing); color: var(--text-muted); font-size: 14px; line-height: 1.6;">
                        <div class="faq-answer-content" style="padding: 0 var(--space-6) var(--space-4) var(--space-6);">
                            <p><?php echo esc_html( $faq['a'] ); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Inject FAQ Schema -->
<script type="application/ld+json">
<?php echo json_encode( $faq_schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ); ?>
</script>
