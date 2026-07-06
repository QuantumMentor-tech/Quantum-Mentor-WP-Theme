<?php
/**
 * Quantum Mentor World — Analytics & Tracking Integrations
 *
 * Implements a dynamic settings page in Settings > Tracking Codes
 * to manage tracking IDs (GA4, GTM, Clarity, Facebook Pixel) securely.
 *
 * @package Quantum_Mentor_World
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ── 1. Register Tracking Codes Settings Page ──
add_action( 'admin_menu', 'qmw_register_tracking_settings_page' );

function qmw_register_tracking_settings_page() {
    add_options_page(
        'Quantum Tracking Settings',
        'Tracking Codes',
        'manage_options',
        'qmw-tracking-settings',
        'qmw_render_tracking_settings_page'
    );
}

// Register Settings & Fields
add_action( 'admin_init', 'qmw_register_tracking_settings_fields' );

function qmw_register_tracking_settings_fields() {
    register_setting( 'qmw-tracking-group', 'qmw_ga4_id', 'sanitize_text_field' );
    register_setting( 'qmw-tracking-group', 'qmw_gtm_id', 'sanitize_text_field' );
    register_setting( 'qmw-tracking-group', 'qmw_clarity_id', 'sanitize_text_field' );
    register_setting( 'qmw-tracking-group', 'qmw_fb_pixel_id', 'sanitize_text_field' );
}

function qmw_render_tracking_settings_page() {
    ?>
    <div class="wrap">
        <h1>📊 Analytics & Tracking Integrations</h1>
        <p class="description">Enter tracking IDs to dynamically inject snippets for analytics platforms. Do not enter raw code scripts here; use IDs only.</p>
        
        <form method="post" action="options.php" style="margin-top: 20px;">
            <?php settings_fields( 'qmw-tracking-group' ); ?>
            <?php do_settings_sections( 'qmw-tracking-group' ); ?>
            
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Google Analytics 4 Measurement ID</th>
                    <td>
                        <input type="text" name="qmw_ga4_id" value="<?php echo esc_attr( get_option( 'qmw_ga4_id' ) ); ?>" class="regular-text" placeholder="e.g. G-XXXXXXXXXX" />
                        <p class="description">Required for standard Google Analytics tracking.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Google Tag Manager Container ID</th>
                    <td>
                        <input type="text" name="qmw_gtm_id" value="<?php echo esc_attr( get_option( 'qmw_gtm_id' ) ); ?>" class="regular-text" placeholder="e.g. GTM-XXXXXXX" />
                        <p class="description">Loads the main Tag Manager container and noscript fallback inside body.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Microsoft Clarity Project ID</th>
                    <td>
                        <input type="text" name="qmw_clarity_id" value="<?php echo esc_attr( get_option( 'qmw_clarity_id' ) ); ?>" class="regular-text" placeholder="e.g. xxxxxxxxxx" />
                        <p class="description">Clarity ID for heatmap analytics and user session recordings.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Facebook Pixel ID</th>
                    <td>
                        <input type="text" name="qmw_fb_pixel_id" value="<?php echo esc_attr( get_option( 'qmw_fb_pixel_id' ) ); ?>" class="regular-text" placeholder="e.g. XXXXXXXXXXXXXXX" />
                        <p class="description">Injects the standard Meta pixel code.</p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// ── 2. Inject Tracking Scripts on Frontend Headers ──
add_action( 'wp_head', 'qmw_inject_tracking_header_scripts', 1 );

function qmw_inject_tracking_header_scripts() {
    if ( is_admin() ) {
        return;
    }

    $ga4_id = get_option( 'qmw_ga4_id' );
    $gtm_id = get_option( 'qmw_gtm_id' );
    $clarity_id = get_option( 'qmw_clarity_id' );
    $fb_pixel_id = get_option( 'qmw_fb_pixel_id' );

    // A. Google Tag Manager
    if ( ! empty( $gtm_id ) ) {
        ?>
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','<?php echo esc_js( $gtm_id ); ?>');</script>
        <!-- End Google Tag Manager -->
        <?php
    }

    // B. Google Analytics 4 (gtag.js)
    if ( ! empty( $ga4_id ) ) {
        ?>
        <!-- Google Analytics 4 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga4_id ); ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '<?php echo esc_js( $ga4_id ); ?>');
        </script>
        <!-- End Google Analytics 4 -->
        <?php
    }

    // C. Microsoft Clarity
    if ( ! empty( $clarity_id ) ) {
        ?>
        <!-- Microsoft Clarity -->
        <script type="text/javascript">
            (function(c,l,a,r,i,t,y){
                c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
                t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
                y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
            })(window, document, "clarity", "script", "<?php echo esc_js( $clarity_id ); ?>");
        </script>
        <!-- End Microsoft Clarity -->
        <?php
    }

    // D. Facebook Pixel
    if ( ! empty( $fb_pixel_id ) ) {
        ?>
        <!-- Meta Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '<?php echo esc_js( $fb_pixel_id ); ?>');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=<?php echo esc_attr( $fb_pixel_id ); ?>&ev=PageView&noscript=1"/></noscript>
        <!-- End Meta Pixel Code -->
        <?php
    }
}

// ── 3. Inject GTM Noscript in Body Open ──
add_action( 'wp_body_open', 'qmw_inject_tracking_body_scripts', 1 );

function qmw_inject_tracking_body_scripts() {
    if ( is_admin() ) {
        return;
    }

    $gtm_id = get_option( 'qmw_gtm_id' );

    if ( ! empty( $gtm_id ) ) {
        ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <?php
    }
}
