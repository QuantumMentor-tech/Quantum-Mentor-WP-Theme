<?php
/**
 * News Archive — Filter Controls
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$archive_url    = get_post_type_archive_link( 'news' );
$current_cat    = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';
$current_sort   = isset( $_GET['sort'] )     ? sanitize_text_field( $_GET['sort'] )     : 'latest';
$current_search = isset( $_GET['news_search'] ) ? sanitize_text_field( $_GET['news_search'] ) : '';

$has_active_filters = ( $current_cat || $current_search );

// Get news category terms dynamically
$news_categories = get_terms( array(
    'taxonomy'   => 'news_category',
    'hide_empty' => false,
) );

$sort_options = array(
    'latest'   => 'Latest Added',
    'featured' => 'Featured First',
    'popular'  => 'Most Popular',
    'a-z'      => 'Headline (A – Z)',
);
?>

<section class="tools-filter-section" aria-label="<?php esc_attr_e( 'Filter and Search News', 'quantum-mentor-world' ); ?>" style="margin-bottom: var(--space-8);">

    <!-- Search + Sort Row -->
    <form method="GET" action="<?php echo esc_url( $archive_url ); ?>" class="tools-search-row" role="search">

        <!-- Search input -->
        <div class="tools-search-input-wrap">
            <label for="news-search-field" class="sr-only"><?php esc_html_e( 'Search news', 'quantum-mentor-world' ); ?></label>
            <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 16px; color: var(--text-muted); pointer-events: none;">🔍</span>
            <input
                type="search"
                id="news-search-field"
                name="news_search"
                class="tools-search-input"
                placeholder="<?php esc_attr_e( 'Search news articles by headline, keywords...', 'quantum-mentor-world' ); ?>"
                value="<?php echo esc_attr( $current_search ); ?>"
                autocomplete="off"
            >
        </div>

        <!-- Sort dropdown -->
        <div class="tools-sort-wrap">
            <label for="news-sort-select" class="sr-only"><?php esc_html_e( 'Sort news', 'quantum-mentor-world' ); ?></label>
            <select id="news-sort-select" name="sort" class="tools-sort-select" onchange="this.form.submit()">
                <?php foreach ( $sort_options as $val => $label ) : ?>
                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Hidden carry-over fields -->
        <?php if ( $current_cat ) : ?>
            <input type="hidden" name="category" value="<?php echo esc_attr( $current_cat ); ?>">
        <?php endif; ?>

        <button type="submit" class="btn btn-primary tools-search-btn">
            <?php esc_html_e( 'Search', 'quantum-mentor-world' ); ?>
        </button>
    </form>

    <!-- Filter Chips Wrapper -->
    <div class="tools-filter-chips-wrapper">
        <div class="tools-filter-row">
            <span class="tools-filter-label"><?php esc_html_e( 'Category:', 'quantum-mentor-world' ); ?></span>
            <div class="tools-chips-row" role="group" aria-label="<?php esc_attr_e( 'News Category filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'category', add_query_arg( array( 'sort' => $current_sort ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_cat ) ? 'active' : ''; ?>">
                    <?php esc_html_e( 'All news', 'quantum-mentor-world' ); ?>
                </a>
                
                <?php
                if ( ! is_wp_error( $news_categories ) && ! empty( $news_categories ) ) :
                    foreach ( $news_categories as $term ) :
                        $url = esc_url( add_query_arg( array(
                            'category' => $term->slug,
                            'sort'     => $current_sort,
                        ), $archive_url ) );
                        $is_active = ( $current_cat === $term->slug );
                ?>
                    <a href="<?php echo $url; ?>" class="filter-chip <?php echo $is_active ? 'active' : ''; ?>">
                        <?php echo esc_html( $term->name ); ?>
                    </a>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </div>

    <!-- Active Filters Bar -->
    <?php if ( $has_active_filters ) : ?>
    <div class="tools-active-filters-bar">
        <span class="tools-filter-label" style="color: var(--text-muted); font-size: 12px; padding: 0; min-width: auto; margin-right: var(--space-2);">
            <?php esc_html_e( 'Active filters:', 'quantum-mentor-world' ); ?>
        </span>
        <?php if ( $current_cat ) :
            $active_term = get_term_by( 'slug', $current_cat, 'news_category' );
        ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Category:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $active_term ? $active_term->name : $current_cat ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_search ) : ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Search:', 'quantum-mentor-world' ); ?> "<?php echo esc_html( $current_search ); ?>"
            </span>
        <?php endif; ?>
        <a href="<?php echo esc_url( $archive_url ); ?>" class="tools-clear-filters-btn" aria-label="<?php esc_attr_e( 'Clear all news filters', 'quantum-mentor-world' ); ?>">
            ✕ <?php esc_html_e( 'Clear All', 'quantum-mentor-world' ); ?>
        </a>
    </div>
    <?php endif; ?>

</section>
