<?php
/**
 * Games Archive — FAQ Section with Schema-Ready Markup
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$faqs = array(
    array(
        'question' => __( 'Are the games listed on Quantum Mentor World legal?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. Quantum Mentor World exclusively lists legal and properly licensed games. Every game featured in our directory is either freeware, open-source, an official demo, freemium, or a paid official link from the developer or a trusted distributor. We perform verification checks on all resources before publication to ensure they comply with applicable copyright and licensing laws.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Do you provide cracked games, repacks, or pirated downloads?', 'quantum-mentor-world' ),
        'answer'   => __( 'Absolutely not. Quantum Mentor World enforces a strict zero-piracy policy. We do not provide, link to, support, or promote cracked games, illegal key generators, repacks, bypasses, cheats, hacks, or any unauthorized game files. All links on this platform route exclusively to official developer websites, official stores, or verified open-source repositories.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Are the download links safe to use?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes. All download links on Quantum Mentor World are manually verified to point to official sources — the game developer\'s official website, trusted platforms such as Steam, itch.io, Epic Games, GitHub, or verified open-source repositories. We regularly audit our listings to ensure they remain active and safe. However, as always, we recommend you also scan downloaded files with a trusted antivirus before installation.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Can I suggest a free or open-source game to be listed?', 'quantum-mentor-world' ),
        'answer'   => __( 'Yes, absolutely. We welcome community suggestions for legal, free, open-source, educational, or properly licensed games. Please use the contact page to submit your suggestion. Include the official game name, developer, license type, and an official download link. Our editorial team will review the submission and add it to the directory if it meets our quality and legal standards.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'Why should I use official game sources instead of third-party sites?', 'quantum-mentor-world' ),
        'answer'   => __( 'Official game sources guarantee you receive the authentic, unmodified version of the game — free from malware, trojans, unwanted bundled software, or illegal modifications. Third-party or unofficial sources often distribute tampered files that may harm your device, steal personal data, or violate the developer\'s intellectual property rights. Quantum Mentor World is committed to protecting both you and game developers by only directing you to verified, legitimate sources.', 'quantum-mentor-world' ),
    ),
    array(
        'question' => __( 'What platforms do you cover in the Games Directory?', 'quantum-mentor-world' ),
        'answer'   => __( 'Our Games Directory covers a wide range of platforms including Windows, Mac, Linux, Android, iPhone/iOS, Browser-based games, and Web platforms. We feature PC games, mobile games, browser-playable games, open-source games, and educational games. Use the platform and genre filter chips at the top of the page to quickly find games for your specific platform.', 'quantum-mentor-world' ),
    ),
);
?>

<!-- ============================================================
     GAMES FAQ SECTION
     ============================================================ -->
<section class="games-faq-section" aria-label="<?php esc_attr_e( 'Frequently Asked Questions about Games', 'quantum-mentor-world' ); ?>">
    <div class="container container-laptop">

        <div class="section-header mb-8" style="text-align: center; display: block;">
            <span class="badge badge-secondary" style="margin-bottom: var(--space-3); display: inline-block;">FAQ</span>
            <h2 class="section-title" style="font-size: 32px;">
                <?php esc_html_e( 'Frequently Asked Questions', 'quantum-mentor-world' ); ?>
            </h2>
            <p style="color: var(--text-muted); max-width: 560px; margin: var(--space-4) auto 0; font-size: 15px;">
                <?php esc_html_e( 'Everything you need to know about our Games Directory.', 'quantum-mentor-world' ); ?>
            </p>
        </div>

        <!-- FAQ Accordion — schema-ready via itemscope/itemtype -->
        <div class="games-faq-list" itemscope itemtype="https://schema.org/FAQPage">

            <?php foreach ( $faqs as $i => $faq ) :
                $item_id = 'games-faq-' . ( $i + 1 );
                $panel_id = $item_id . '-panel';
            ?>
            <div class="games-faq-item glass-card" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">

                <button
                    class="faq-question games-faq-btn"
                    id="<?php echo esc_attr( $item_id ); ?>"
                    aria-expanded="false"
                    aria-controls="<?php echo esc_attr( $panel_id ); ?>"
                    type="button"
                >
                    <span class="games-faq-q-text" itemprop="name">
                        <?php echo esc_html( $faq['question'] ); ?>
                    </span>
                    <span class="faq-icon games-faq-icon" aria-hidden="true">+</span>
                </button>

                <div
                    class="faq-answer games-faq-answer"
                    id="<?php echo esc_attr( $panel_id ); ?>"
                    role="region"
                    aria-labelledby="<?php echo esc_attr( $item_id ); ?>"
                    itemscope
                    itemprop="acceptedAnswer"
                    itemtype="https://schema.org/Answer"
                >
                    <div class="games-faq-answer-inner" itemprop="text">
                        <?php echo esc_html( $faq['answer'] ); ?>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>

        </div>

    </div>
</section>
