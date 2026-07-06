This directory contains reusable partial template files for single post detail pages.

File naming convention:
  {cpt-slug}-header.php   → Hero section (title, badges, featured image)
  {cpt-slug}-meta.php     → Metadata row (platform, version, date, etc.)
  {cpt-slug}-actions.php  → Action buttons (download, watch, GitHub)

Usage in single templates:
  get_template_part( 'template-parts/single/software-header' );
  get_template_part( 'template-parts/single/software-meta' );
  get_template_part( 'template-parts/single/software-actions' );

Note: As of v1.0.0, single page template logic is embedded directly in
the single-{cpt}.php root templates for simplicity. This directory is
reserved for Step 4+ refactoring when templates are modularized.
