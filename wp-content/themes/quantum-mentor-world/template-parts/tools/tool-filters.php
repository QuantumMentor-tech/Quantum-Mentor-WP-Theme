<?php
/**
 * Tools Archive — Filter Controls
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$archive_url    = get_post_type_archive_link( 'tools' );
$current_cat    = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';
$current_access = isset( $_GET['access'] )   ? sanitize_text_field( $_GET['access'] )   : '';
$current_sort   = isset( $_GET['sort'] )     ? sanitize_text_field( $_GET['sort'] )     : 'latest';
$current_search = isset( $_GET['tools_search'] ) ? sanitize_text_field( $_GET['tools_search'] ) : '';

$has_active_filters = ( $current_cat || $current_access || $current_search );

$categories = array(
    'file-converter'  => 'File Converter',
    'pdf-tools'       => 'PDF Tools',
    'image-tools'     => 'Image Tools',
    'video-tools'     => 'Video Tools',
    'text-tools'      => 'Text Tools',
    'ai-tools'        => 'AI Tools',
    'seo-tools'       => 'SEO Tools',
    'developer-tools' => 'Developer Tools',
);

$access_types = array(
    'built-in-tool'     => 'Built-in Tool',
    'external-tool'     => 'External Tool',
    'downloadable-tool' => 'Downloadable Tool',
);

$sort_options = array(
    'latest'   => 'Latest Added',
    'featured' => 'Featured First',
    'popular'  => 'Most Discussed',
    'a-z'      => 'Title (A – Z)',
);
?>

<section class="tools-filter-section" aria-label="<?php esc_attr_e( 'Filter and Search Tools', 'quantum-mentor-world' ); ?>">

    <!-- Search + Sort Row -->
    <form method="GET" action="<?php echo esc_url( $archive_url ); ?>" class="tools-search-row" role="search">

        <!-- Search input -->
        <div class="tools-search-input-wrap">
            <label for="tools-search-field" class="sr-only"><?php esc_html_e( 'Search tools', 'quantum-mentor-world' ); ?></label>
            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 16px; color: var(--text-muted); pointer-events: none;">🔍</span>
            <input
                type="search"
                id="tools-search-field"
                name="tools_search"
                class="tools-search-input"
                placeholder="<?php esc_attr_e( 'Search tools by name, features, category...', 'quantum-mentor-world' ); ?>"
                value="<?php echo esc_attr( $current_search ); ?>"
                autocomplete="off"
            >
        </div>

        <!-- Sort dropdown -->
        <div class="tools-sort-wrap">
            <label for="tools-sort-select" class="sr-only"><?php esc_html_e( 'Sort tools', 'quantum-mentor-world' ); ?></label>
            <select id="tools-sort-select" name="sort" class="tools-sort-select" onchange="this.form.submit()">
                <?php foreach ( $sort_options as $val => $label ) : ?>
                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Hidden carry-over fields -->
        <?php if ( $current_cat )    : ?><input type="hidden" name="category" value="<?php echo esc_attr( $current_cat ); ?>"><?php endif; ?>
        <?php if ( $current_access ) : ?><input type="hidden" name="access"   value="<?php echo esc_attr( $current_access ); ?>"><?php endif; ?>

        <button type="submit" class="btn btn-primary tools-search-btn">
            <?php esc_html_e( 'Search', 'quantum-mentor-world' ); ?>
        </button>
    </form>

    <!-- Filter Chips Wrapper -->
    <div class="tools-filter-chips-wrapper">

        <!-- Category Row -->
        <div class="tools-filter-row">
            <span class="tools-filter-label"><?php esc_html_e( 'Category:', 'quantum-mentor-world' ); ?></span>
            <div class="tools-chips-row" role="group" aria-label="<?php esc_attr_e( 'Tool Category filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'category', add_query_arg( array(
                    'access' => $current_access,
                    'sort'   => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_cat ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_cat ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $categories as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'category' => $slug,
                        'access'   => $current_access,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_cat === $slug );
                ?>
                <a href="<?php echo $url; ?>"
                   class="filter-chip <?php echo $is_active ? 'active' : ''; ?>"
                   aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Access Type Row -->
        <div class="tools-filter-row" style="margin-top: var(--space-2);">
            <span class="tools-filter-label"><?php esc_html_e( 'Access:', 'quantum-mentor-world' ); ?></span>
            <div class="tools-chips-row" role="group" aria-label="<?php esc_attr_e( 'Access Type filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'access', add_query_arg( array(
                    'category' => $current_cat,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_access ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_access ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $access_types as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'category' => $current_cat,
                        'access'   => $slug,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_access === $slug );
                ?>
                <a href="<?php echo $url; ?>"
                   class="filter-chip <?php echo $is_active ? 'active' : ''; ?>"
                   aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- Active Filters Bar -->
    <?php if ( $has_active_filters ) : ?>
    <div class="tools-active-filters-bar">
        <span class="tools-filter-label" style="color: var(--text-muted); font-size: 12px; padding: 0; min-width: auto; margin-right: var(--space-2);">
            <?php esc_html_e( 'Active filters:', 'quantum-mentor-world' ); ?>
        </span>
        <?php if ( $current_cat ) : ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Category:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $categories[ $current_cat ] ?? $current_cat ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_access ) : ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Access:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $access_types[ $current_access ] ?? $current_access ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_search ) : ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Search:', 'quantum-mentor-world' ); ?> "<?php echo esc_html( $current_search ); ?>"
            </span>
        <?php endif; ?>
        <a href="<?php echo esc_url( $archive_url ); ?>" class="tools-clear-filters-btn" aria-label="<?php esc_attr_e( 'Clear all filters', 'quantum-mentor-world' ); ?>">
            ✕ <?php esc_html_e( 'Clear All', 'quantum-mentor-world' ); ?>
        </a>
    </div>
    <?php endif; ?>

</section>
