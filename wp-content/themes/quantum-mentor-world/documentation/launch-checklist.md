# Production Launch Checklist — Quantum Mentor World

This document contains the deployment readiness checks and launch instructions for the website owner.

---

## 1. Pre-Deployment Configuration Checklist

- [ ] **SSL (TLS) Certificate**: Ensure SSL is active on the hosting panel (e.g. Let's Encrypt).
- [ ] **HTTPS Enforcer**: Verify that `.htaccess` or Nginx configuration forces all HTTP traffic to redirects to HTTPS.
- [ ] **Tracking IDs**: Visit **Settings > Tracking Codes** and enter the production container IDs for:
  - Google Analytics 4
  - Google Tag Manager
  - Microsoft Clarity
  - Facebook Pixel
- [ ] **robots.txt**: Verify the root directory has the `robots.txt` file and handles indexing blocks.

---

## 2. Server & Cloudflare DNS Setup

1. **DNS Mapping**: Update nameservers to Cloudflare.
2. **Cloudflare Settings**:
   - SSL/TLS mode: Set to **Full (Strict)**.
   - Always Use HTTPS: **Enabled**.
   - Auto Minify: Enable HTML, CSS, and JS compression.
   - Brotli: **Enabled**.
   - Rocket Loader: Keep disabled initially to test compatibility.
3. **CDN Setup**: Ensure asset cache headers (`Cache-Control`) are set to 1 year for images, scripts, and stylesheets.

---

## 3. Post-Deployment QA Checks

- [ ] **Dynamic Sitemap Route**: Ensure visiting `/sitemap/` renders the HTML sitemap grid without error.
- [ ] **XML Sitemap Submission**: Submit `https://quantummentorworld.com/sitemap_index.xml` inside Google Search Console.
- [ ] **Resource Suggest Form**: Perform a test suggestion on `/submit-resource/` to confirm that:
  - The suggest creates a pending post type.
  - The admin receives a notification email.
- [ ] **Security failed logins**: Try typing a bad password on `/login/` and check the Admin > Security Logs panel to ensure the failed login is recorded.
- [ ] **Comments Audits**: Verify users can write comments and that spam/trash rules apply.
- [ ] **Broken Links Crawl**: Run a broken link checking tool to verify all internal and archive redirections resolve to 200 OK.
