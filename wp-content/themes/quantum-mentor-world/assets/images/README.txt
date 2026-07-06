This directory stores theme image assets.

Contents:
- placeholder-thumbnail.webp  → Default card thumbnail when no featured image is set
- og-default.jpg              → Default Open Graph / social share image
- logo-placeholder.png        → Placeholder until the owner's logo is uploaded via Customizer
- icon-placeholder.png        → Default software/tool icon
- book-placeholder.png        → Default book cover
- poster-placeholder.png      → Default movie/anime poster

Instructions:
- Upload the owner's logo via WordPress Admin → Appearance → Customize → Site Identity → Logo
- Do NOT replace the owner's existing logo
- Images in this folder are referenced as fallback defaults in PHP templates

Path reference in PHP:
  get_template_directory_uri() . '/assets/images/placeholder-thumbnail.webp'
