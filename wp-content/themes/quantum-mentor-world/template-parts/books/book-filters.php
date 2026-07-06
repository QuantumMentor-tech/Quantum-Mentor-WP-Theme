<?php
/**
 * Books Archive — Filter Controls
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$archive_url      = get_post_type_archive_link( 'books' );
$current_category = isset( $_GET['category'] ) ? sanitize_text_field( $_GET['category'] ) : '';
$current_type     = isset( $_GET['type'] )     ? sanitize_text_field( $_GET['type'] )     : '';
$current_format   = isset( $_GET['format'] )   ? sanitize_text_field( $_GET['format'] )   : '';
$current_lang     = isset( $_GET['language'] ) ? sanitize_text_field( $_GET['language'] ) : '';
$current_sort     = isset( $_GET['sort'] )     ? sanitize_text_field( $_GET['sort'] )     : 'latest';
$current_search   = isset( $_GET['book_search'] ) ? sanitize_text_field( $_GET['book_search'] ) : '';

$has_active_filters = ( $current_category || $current_type || $current_format || $current_lang || $current_search );

$categories = array(
    'educational' => 'Educational',
    'religious'   => 'Religious',
    'programming' => 'Programming',
    'business'    => 'Business',
    'novels'      => 'Novels',
    'ai'          => 'AI',
    'freelancing' => 'Freelancing',
    'marketing'   => 'Marketing',
    'history'     => 'History',
    'science'     => 'Science',
);

$types = array(
    'free'               => 'Free Access',
    'public-domain'      => 'Public Domain',
    'open-access'        => 'Open Access',
    'creative-commons'   => 'Creative Commons',
    'paid-official'      => 'Paid Official Link',
);

$formats = array(
    'pdf'         => 'PDF',
    'epub'        => 'EPUB',
    'mobi'        => 'MOBI',
    'docx'        => 'DOCX',
    'online-read' => 'Online Read',
    'audio'       => 'Audiobook',
);

$languages = array(
    'english' => 'English',
    'urdu'    => 'Urdu',
    'arabic'  => 'Arabic',
    'spanish' => 'Spanish',
    'french'  => 'French',
    'german'  => 'German',
    'chinese' => 'Chinese',
    'hindi'   => 'Hindi',
    'other'   => 'Other',
);

$sort_options = array(
    'latest'   => 'Latest First',
    'featured' => 'Featured First',
    'popular'  => 'Most Reviewed',
    'a-z'      => 'Title (A – Z)',
);
?>

<!-- ============================================================
     BOOKS FILTER BAR
     ============================================================ -->
<section class="books-filter-section" aria-label="<?php esc_attr_e( 'Filter and Search Books', 'quantum-mentor-world' ); ?>">

    <!-- Search + Sort Row -->
    <form method="GET" action="<?php echo esc_url( $archive_url ); ?>" class="books-search-row" role="search">

        <!-- Search input -->
        <div class="books-search-input-wrap">
            <label for="books-search-field" class="sr-only"><?php esc_html_e( 'Search books', 'quantum-mentor-world' ); ?></label>
            <svg class="books-search-icon" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
                type="search"
                id="books-search-field"
                name="book_search"
                class="books-search-input"
                placeholder="<?php esc_attr_e( 'Search books by title, author, publisher...', 'quantum-mentor-world' ); ?>"
                value="<?php echo esc_attr( $current_search ); ?>"
                autocomplete="off"
            >
        </div>

        <!-- Sort dropdown -->
        <div class="books-sort-wrap">
            <label for="books-sort-select" class="sr-only"><?php esc_html_e( 'Sort books', 'quantum-mentor-world' ); ?></label>
            <select id="books-sort-select" name="sort" class="books-sort-select" onchange="this.form.submit()">
                <?php foreach ( $sort_options as $val => $label ) : ?>
                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Hidden carry-over fields -->
        <?php if ( $current_category ) : ?><input type="hidden" name="category" value="<?php echo esc_attr( $current_category ); ?>"><?php endif; ?>
        <?php if ( $current_type )     : ?><input type="hidden" name="type"     value="<?php echo esc_attr( $current_type ); ?>"><?php endif; ?>
        <?php if ( $current_format )   : ?><input type="hidden" name="format"   value="<?php echo esc_attr( $current_format ); ?>"><?php endif; ?>
        <?php if ( $current_lang )     : ?><input type="hidden" name="language" value="<?php echo esc_attr( $current_lang ); ?>"><?php endif; ?>

        <button type="submit" class="btn btn-primary books-search-btn">
            <?php esc_html_e( 'Search', 'quantum-mentor-world' ); ?>
        </button>
    </form>

    <!-- Filter Chip Rows -->
    <div class="books-filter-chips-wrapper">

        <!-- Category Chips -->
        <div class="books-filter-row">
            <span class="books-filter-label"><?php esc_html_e( 'Subject:', 'quantum-mentor-world' ); ?></span>
            <div class="books-chips-row" role="group" aria-label="<?php esc_attr_e( 'Category filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'category', add_query_arg( array(
                    'type'     => $current_type,
                    'format'   => $current_format,
                    'language' => $current_lang,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_category ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_category ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $categories as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'category' => $slug,
                        'type'     => $current_type,
                        'format'   => $current_format,
                        'language' => $current_lang,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_category === $slug );
                ?>
                <a href="<?php echo $url; ?>"
                   class="filter-chip <?php echo $is_active ? 'active' : ''; ?>"
                   aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Access Type Chips -->
        <div class="books-filter-row">
            <span class="books-filter-label"><?php esc_html_e( 'Access:', 'quantum-mentor-world' ); ?></span>
            <div class="books-chips-row" role="group" aria-label="<?php esc_attr_e( 'Access type filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'type', add_query_arg( array(
                    'category' => $current_category,
                    'format'   => $current_format,
                    'language' => $current_lang,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_type ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_type ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $types as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'category' => $current_category,
                        'type'     => $slug,
                        'format'   => $current_format,
                        'language' => $current_lang,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_type === $slug );
                ?>
                <a href="<?php echo $url; ?>"
                   class="filter-chip <?php echo $is_active ? 'active' : ''; ?>"
                   aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Format Chips -->
        <div class="books-filter-row">
            <span class="books-filter-label"><?php esc_html_e( 'Format:', 'quantum-mentor-world' ); ?></span>
            <div class="books-chips-row" role="group" aria-label="<?php esc_attr_e( 'Format filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'format', add_query_arg( array(
                    'category' => $current_category,
                    'type'     => $current_type,
                    'language' => $current_lang,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_format ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_format ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $formats as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'category' => $current_category,
                        'type'     => $current_type,
                        'format'   => $slug,
                        'language' => $current_lang,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_format === $slug );
                ?>
                <a href="<?php echo $url; ?>"
                   class="filter-chip <?php echo $is_active ? 'active' : ''; ?>"
                   aria-pressed="<?php echo $is_active ? 'true' : 'false'; ?>">
                    <?php echo esc_html( $label ); ?>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Language Chips -->
        <div class="books-filter-row">
            <span class="books-filter-label"><?php esc_html_e( 'Language:', 'quantum-mentor-world' ); ?></span>
            <div class="books-chips-row" role="group" aria-label="<?php esc_attr_e( 'Language filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'language', add_query_arg( array(
                    'category' => $current_category,
                    'type'     => $current_type,
                    'format'   => $current_format,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_lang ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_lang ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $languages as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'category' => $current_category,
                        'type'     => $current_type,
                        'format'   => $current_format,
                        'language' => $slug,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_lang === $slug );
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

    <!-- Active filters bar + Clear button -->
    <?php if ( $has_active_filters ) : ?>
    <div class="books-active-filters-bar">
        <span class="books-filter-label" style="color: var(--text-muted); font-size: 12px; padding: 0;">
            <?php esc_html_e( 'Active filters:', 'quantum-mentor-world' ); ?>
        </span>
        <?php if ( $current_category ) : ?>
            <span class="books-active-chip">
                <?php esc_html_e( 'Subject:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $categories[ $current_category ] ?? $current_category ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_type ) : ?>
            <span class="books-active-chip">
                <?php esc_html_e( 'Access:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $types[ $current_type ] ?? $current_type ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_format ) : ?>
            <span class="books-active-chip">
                <?php esc_html_e( 'Format:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $formats[ $current_format ] ?? $current_format ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_lang ) : ?>
            <span class="books-active-chip">
                <?php esc_html_e( 'Language:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $languages[ $current_lang ] ?? $current_lang ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_search ) : ?>
            <span class="books-active-chip">
                <?php esc_html_e( 'Search:', 'quantum-mentor-world' ); ?> "<?php echo esc_html( $current_search ); ?>"
            </span>
        <?php endif; ?>
        <a href="<?php echo esc_url( $archive_url ); ?>" class="books-clear-filters-btn" aria-label="<?php esc_attr_e( 'Clear all filters', 'quantum-mentor-world' ); ?>">
            ✕ <?php esc_html_e( 'Clear All', 'quantum-mentor-world' ); ?>
        </a>
    </div>
    <?php endif; ?>

</section>
