# Performance & Speed Optimization Audit — Quantum Mentor World

This audit reports the site loading speeds, image scaling rules, database hygiene crons, and caching recommendations designed to achieve optimal PageSpeed performance.

---

## 1. Speed Targets & Benchmarks

Our optimizations target the following Core Web Vitals scores:

| Device Category | Target PageSpeed Score | LCP (Largest Contentful Paint) | CLS (Cumulative Layout Shift) |
| :--- | :--- | :--- | :--- |
| **Desktop** | **90+** | < 1.2s | < 0.05 |
| **Mobile** | **85+** | < 2.0s | < 0.08 |

---

## 2. Image Scaling & WebP Compression

All theme-injected and user-uploaded images must strictly follow these rules:

1. **WebP Format**: Ensure all media is uploaded in `.webp` format (reduces size by 30% compared to PNG/JPG).
2. **Lazy Loading**: Active sitewide via `wp_lazy_loading_enabled` and a fallback regex parser injecting `loading="lazy"` + `decoding="async"` on all in-page content images.
3. **Custom Image Sizes**: The theme registers specific image sizes to prevent browser scaling overhead:
   - `qmw-card` (400x260px) — Archive page thumbnail cards.
   - `qmw-icon` (160x160px) — Software/Tool icon files.
   - `qmw-cover` (300x450px) — Book portrait covers.
   - `qmw-poster` (300x440px) — Watch vertical overlays.
   - `qmw-banner` (1280x480px) — Hero banner blocks.
   - `qmw-screenshot` (600x400px) — Game/App galleries.

---

## 3. Database Housekeeping & Cron Automation

Database accumulation is resolved weekly using a programmatic WordPress event scheduler (`qmw_database_clean_cron`).

### Automated Cleanups Completed:
1. **Revisions Limiting**: Revisions are restricted to `5` copies max per resource. Any older revisions are deleted.
2. **Spam & Trash comments**: Cleared out automatically.
3. **Orphaned Metadata**: Purges meta lines missing parent associations in `postmeta`, `usermeta`, and `commentmeta` tables.
4. **Expired Transients**: Deletes expired timeout options.
5. **Table Defragmentation**: Runs `OPTIMIZE TABLE` weekly across all tables.

---

## 4. Cache & Asset Optimization Guidelines

To ensure the fastest load times, configure a caching plugin (e.g. **LiteSpeed Cache** or **WP Rocket**) with these settings:

### A. Caching Rules
- **Page Caching**: Enable.
- **Browser Caching**: Enable. Set static resources (fonts, CSS, JS, images) cache lifespan to 31,536,000 seconds (1 year).
- **Object Caching**: Enable **Redis** or **Memcached** on the hosting provider panel to accelerate database queries.

### B. Minification & Deferral
- **CSS Minification**: Enable.
- **JavaScript Minification**: Enable.
- **Defer JS**: Enforce `defer` on non-critical scripts. The theme's `main.js` is programmatically deferred via `qmw_defer_scripts`.
- **Preconnect Tagging**: Hooked `qmw_add_preconnect_tags` in header, adding preconnects for Google Fonts APIs and YouTube domains.
