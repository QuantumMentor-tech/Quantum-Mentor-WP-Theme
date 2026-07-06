<?php
/**
 * The template for displaying the footer
 *
 * @package Quantum_Mentor_Theme
 */
?>
    
    <!-- Footer Section -->
    <footer class="mt-auto bg-[#1E293B] border-t border-white/10 py-12 px-6 lg:px-12 text-[#94A3B8]">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
            
            <!-- Branding & License Mission -->
            <div class="space-y-4">
                <div class="flex items-center space-x-2">
                    <div class="logo-box w-8 h-8 rounded-lg bg-gradient-to-tr from-[#00D4FF] to-[#7C3AED] flex items-center justify-center font-display font-extrabold text-sm text-[#0F172A]">QM</div>
                    <span class="font-display font-bold text-lg text-white">Quantum Mentor World</span>
                </div>
                <p class="text-xs leading-relaxed max-w-sm">
                    A premium tech resource platform dedicated exclusively to open-source software, public domain media, creative commons tutorials, and creator-authorized digital assets. Safety, verification, and legal licensing is our core standard.
                </p>
            </div>

            <!-- Site Footer Navigation -->
            <div class="space-y-4">
                <h3 class="font-display text-sm font-semibold text-white uppercase tracking-wider">Company</h3>
                <ul class="space-y-2 text-xs">
                    <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>" class="hover:text-[#00D4FF] transition-colors">About Us</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="hover:text-[#00D4FF] transition-colors">Contact Us</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/disclaimer/' ) ); ?>" class="hover:text-[#00D4FF] transition-colors">Legal Disclaimer</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="hover:text-[#00D4FF] transition-colors">Privacy Policy</a></li>
                </ul>
            </div>

            <!-- Social Ecosystem Links -->
            <div class="space-y-4">
                <h3 class="font-display text-sm font-semibold text-white uppercase tracking-wider">Join The Community</h3>
                <div class="flex flex-wrap gap-3">
                    <?php 
                    $socials = array(
                        'github'    => 'GitHub',
                        'youtube'   => 'YouTube',
                        'telegram'  => 'Telegram',
                        'whatsapp'  => 'WhatsApp',
                        'discord'   => 'Discord',
                        'facebook'  => 'Facebook',
                        'tiktok'    => 'TikTok',
                        'instagram' => 'Instagram',
                    );

                    foreach ( $socials as $slug => $name ) :
                    ?>
                    <a href="#" class="px-3 py-1.5 rounded bg-[#0F172A] hover:bg-[#00D4FF]/10 hover:text-[#00D4FF] border border-white/5 hover:border-[#00D4FF]/30 text-xs font-medium transition-all duration-300" title="<?php echo esc_attr( $name ); ?>">
                        <?php echo esc_html( $name ); ?>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="max-w-7xl mx-auto border-t border-white/5 pt-8 flex flex-col md:flex-row items-center justify-between text-xs space-y-4 md:space-y-0">
            <p>&copy; <?php echo date( 'Y' ); ?> Quantum Mentor World. All rights reserved.</p>
            <div class="flex items-center space-x-2 bg-[#0F172A] border border-white/5 py-1 px-3 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-[#22C55E]"></span>
                <span class="text-[10px] text-slate-300 font-semibold">Protected by Secure Shield Architecture</span>
            </div>
        </div>
    </footer>

    </div> <!-- End of .flex-1 -->
</div> <!-- End of .site-container -->

<?php wp_footer(); ?>
</body>
</html>
