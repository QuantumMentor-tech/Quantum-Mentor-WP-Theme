#!/bin/bash
# ════════════════════════════════════════════════════════════════════════
# Quantum Mentor World — Plugin Installation via WP-CLI
# ════════════════════════════════════════════════════════════════════════
#
# HOW TO USE:
#   1. SSH into your server
#   2. Navigate to WordPress root: cd /path/to/wordpress
#   3. Make executable: chmod +x qmw-plugins-install.sh
#   4. Run: bash qmw-plugins-install.sh
#
# REQUIREMENTS:
#   - WP-CLI installed: https://wp-cli.org/
#   - WordPress already installed and configured
#   - Run as the web server user (e.g., www-data) or the owner
#
# NOTE: ACF Pro cannot be installed via WP-CLI free tier.
#       See manual installation note below.
#
# ════════════════════════════════════════════════════════════════════════

echo "🚀 Quantum Mentor World — Plugin Installation Starting..."
echo ""

# ── 1. Advanced Custom Fields (Free version — upgrade to Pro separately) ──────
echo "📦 Installing: Advanced Custom Fields..."
wp plugin install advanced-custom-fields --activate
echo ""

# ── 2. Custom Post Type UI ─────────────────────────────────────────────────────
# Used as a GUI backup to the programmatic CPTs in inc/custom-post-types.php
echo "📦 Installing: Custom Post Type UI..."
wp plugin install custom-post-type-ui --activate
echo ""

# ── 3. Rank Math SEO ──────────────────────────────────────────────────────────
echo "📦 Installing: Rank Math SEO..."
wp plugin install seo-by-rank-math --activate
echo ""

# ── 4. LiteSpeed Cache (use WP Rocket if on non-LiteSpeed hosting) ────────────
echo "📦 Installing: LiteSpeed Cache..."
wp plugin install litespeed-cache --activate
# Alternative: wp plugin install wp-rocket --activate (paid plugin)
echo ""

# ── 5. Wordfence Security ─────────────────────────────────────────────────────
echo "📦 Installing: Wordfence Security..."
wp plugin install wordfence --activate
echo ""

# ── 6. UpdraftPlus — Backup & Restore ─────────────────────────────────────────
echo "📦 Installing: UpdraftPlus..."
wp plugin install updraftplus --activate
echo ""

# ── 7. WP Mail SMTP ───────────────────────────────────────────────────────────
echo "📦 Installing: WP Mail SMTP..."
wp plugin install wp-mail-smtp --activate
echo ""

# ── 8. Fluent Forms (contact forms) ───────────────────────────────────────────
echo "📦 Installing: Fluent Forms..."
wp plugin install fluentform --activate
echo ""

# ── 9. Redirection ────────────────────────────────────────────────────────────
echo "📦 Installing: Redirection..."
wp plugin install redirection --activate
echo ""

# ── 10. Enable Media Replace ──────────────────────────────────────────────────
echo "📦 Installing: Enable Media Replace..."
wp plugin install enable-media-replace --activate
echo ""

# ── 11. ShortPixel Image Optimizer ────────────────────────────────────────────
echo "📦 Installing: ShortPixel Image Optimizer..."
wp plugin install shortpixel-image-optimiser --activate
echo ""

# ── 12. Code Snippets ─────────────────────────────────────────────────────────
echo "📦 Installing: Code Snippets..."
wp plugin install code-snippets --activate
echo ""

# ── Optional: Relevanssi (Better Search) ──────────────────────────────────────
# Uncomment to install:
# echo "📦 Installing: Relevanssi..."
# wp plugin install relevanssi --activate
# echo ""

# ── Optional: Members (Role Management) ───────────────────────────────────────
# Uncomment to install:
# echo "📦 Installing: Members..."
# wp plugin install members --activate
# echo ""

echo "════════════════════════════════════════════════════════════════════════"
echo "✅ Plugin installation complete!"
echo ""
echo "⚠️  MANUAL STEPS REQUIRED:"
echo ""
echo "1. ACF Pro (if purchased): Upload the zip via Plugins → Add New → Upload"
echo "   Download from: https://www.advancedcustomfields.com/pro/"
echo ""
echo "2. Rank Math SEO: Complete the setup wizard at:"
echo "   WordPress Admin → Rank Math → Setup Wizard"
echo ""
echo "3. LiteSpeed Cache: Configure at:"
echo "   WordPress Admin → LiteSpeed Cache → Settings"
echo ""
echo "4. Wordfence: Set up firewall at:"
echo "   WordPress Admin → Wordfence → Firewall"
echo ""
echo "5. UpdraftPlus: Configure backup schedule at:"
echo "   WordPress Admin → Settings → UpdraftPlus"
echo ""
echo "6. WP Mail SMTP: Configure email at:"
echo "   WordPress Admin → WP Mail SMTP → Settings"
echo ""
echo "7. ShortPixel: Enter API key at:"
echo "   WordPress Admin → Settings → ShortPixel"
echo "   Get free API key at: https://shortpixel.com"
echo ""
echo "════════════════════════════════════════════════════════════════════════"
