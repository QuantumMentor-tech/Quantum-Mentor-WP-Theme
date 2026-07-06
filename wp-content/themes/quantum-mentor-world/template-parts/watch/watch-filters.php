<?php
/**
 * Watch Archive — Filter Controls
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$archive_url    = get_post_type_archive_link( 'watch' );
$current_type   = isset( $_GET['type'] )     ? sanitize_text_field( $_GET['type'] )     : '';
$current_genre  = isset( $_GET['genre'] )    ? sanitize_text_field( $_GET['genre'] )    : '';
$current_lang   = isset( $_GET['language'] ) ? sanitize_text_field( $_GET['language'] ) : '';
$current_status = isset( $_GET['status'] )   ? sanitize_text_field( $_GET['status'] )   : '';
$current_sort   = isset( $_GET['sort'] )     ? sanitize_text_field( $_GET['sort'] )     : 'latest';
$current_search = isset( $_GET['watch_search'] ) ? sanitize_text_field( $_GET['watch_search'] ) : '';

$has_active_filters = ( $current_type || $current_genre || $current_lang || $current_status || $current_search );

$types = array(
    'movie'       => 'Movie',
    'course'      => 'Course',
    'anime'       => 'Anime',
    'donghua'     => 'Donghua',
    'tutorial'    => 'Tutorial',
    'documentary' => 'Documentary',
);

$genres = array(
    'education'     => 'Education',
    'technology'    => 'Technology',
    'ai'            => 'AI',
    'programming'   => 'Programming',
    'business'      => 'Business',
    'entertainment' => 'Entertainment',
    'history'       => 'History',
    'science'       => 'Science',
);

$languages = array(
    'english'  => 'English',
    'urdu'     => 'Urdu',
    'hindi'    => 'Hindi',
    'arabic'   => 'Arabic',
    'japanese' => 'Japanese',
    'chinese'  => 'Chinese',
    'other'    => 'Other',
);

$statuses = array(
    'ongoing'   => 'Ongoing',
    'completed' => 'Completed',
    'upcoming'  => 'Upcoming',
);

$sort_options = array(
    'latest'   => 'Latest Uploads',
    'featured' => 'Featured First',
    'popular'  => 'Most Discussed',
    'a-z'      => 'Title (A – Z)',
);
?>

<!-- ============================================================
     WATCH FILTER BAR
     ============================================================ -->
<section class="watch-filter-section" aria-label="<?php esc_attr_e( 'Filter and Search Watch Content', 'quantum-mentor-world' ); ?>">

    <!-- Search + Sort Row -->
    <form method="GET" action="<?php echo esc_url( $archive_url ); ?>" class="watch-search-row" role="search">

        <!-- Search input -->
        <div class="watch-search-input-wrap">
            <label for="watch-search-field" class="sr-only"><?php esc_html_e( 'Search content', 'quantum-mentor-world' ); ?></label>
            <svg class="watch-search-icon" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
                type="search"
                id="watch-search-field"
                name="watch_search"
                class="watch-search-input"
                placeholder="<?php esc_attr_e( 'Search content by title, genre, language...', 'quantum-mentor-world' ); ?>"
                value="<?php echo esc_attr( $current_search ); ?>"
                autocomplete="off"
            >
        </div>

        <!-- Sort dropdown -->
        <div class="watch-sort-wrap">
            <label for="watch-sort-select" class="sr-only"><?php esc_html_e( 'Sort content', 'quantum-mentor-world' ); ?></label>
            <select id="watch-sort-select" name="sort" class="watch-sort-select" onchange="this.form.submit()">
                <?php foreach ( $sort_options as $val => $label ) : ?>
                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Hidden carry-over fields -->
        <?php if ( $current_type )   : ?><input type="hidden" name="type"     value="<?php echo esc_attr( $current_type ); ?>"><?php endif; ?>
        <?php if ( $current_genre )  : ?><input type="hidden" name="genre"    value="<?php echo esc_attr( $current_genre ); ?>"><?php endif; ?>
        <?php if ( $current_lang )   : ?><input type="hidden" name="language" value="<?php echo esc_attr( $current_lang ); ?>"><?php endif; ?>
        <?php if ( $current_status ) : ?><input type="hidden" name="status"   value="<?php echo esc_attr( $current_status ); ?>"><?php endif; ?>

        <button type="submit" class="btn btn-primary watch-search-btn">
            <?php esc_html_e( 'Search', 'quantum-mentor-world' ); ?>
        </button>
    </form>

    <!-- Filter Chip Rows -->
    <div class="watch-filter-chips-wrapper">

        <!-- Content Type Chips -->
        <div class="watch-filter-row">
            <span class="watch-filter-label"><?php esc_html_e( 'Type:', 'quantum-mentor-world' ); ?></span>
            <div class="watch-chips-row" role="group" aria-label="<?php esc_attr_e( 'Content Type filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'type', add_query_arg( array(
                    'genre'    => $current_genre,
                    'language' => $current_lang,
                    'status'   => $current_status,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_type ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_type ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $types as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'type'     => $slug,
                        'genre'    => $current_genre,
                        'language' => $current_lang,
                        'status'   => $current_status,
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

        <!-- Genre Chips -->
        <div class="watch-filter-row">
            <span class="watch-filter-label"><?php esc_html_e( 'Genre:', 'quantum-mentor-world' ); ?></span>
            <div class="watch-chips-row" role="group" aria-label="<?php esc_attr_e( 'Genre filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'genre', add_query_arg( array(
                    'type'     => $current_type,
                    'language' => $current_lang,
                    'status'   => $current_status,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_genre ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_genre ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $genres as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'type'     => $current_type,
                        'genre'    => $slug,
                        'language' => $current_lang,
                        'status'   => $current_status,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_genre === $slug );
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
        <div class="watch-filter-row">
            <span class="watch-filter-label"><?php esc_html_e( 'Language:', 'quantum-mentor-world' ); ?></span>
            <div class="watch-chips-row" role="group" aria-label="<?php esc_attr_e( 'Language filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'language', add_query_arg( array(
                    'type'   => $current_type,
                    'genre'  => $current_genre,
                    'status' => $current_status,
                    'sort'   => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_lang ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_lang ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $languages as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'type'     => $current_type,
                        'genre'    => $current_genre,
                        'language' => $slug,
                        'status'   => $current_status,
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

        <!-- Status Chips -->
        <div class="watch-filter-row">
            <span class="watch-filter-label"><?php esc_html_e( 'Status:', 'quantum-mentor-world' ); ?></span>
            <div class="watch-chips-row" role="group" aria-label="<?php esc_attr_e( 'Status filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'status', add_query_arg( array(
                    'type'     => $current_type,
                    'genre'    => $current_genre,
                    'language' => $current_lang,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_status ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_status ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $statuses as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'type'     => $current_type,
                        'genre'    => $current_genre,
                        'language' => $current_lang,
                        'status'   => $slug,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_status === $slug );
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
    <div class="watch-active-filters-bar">
        <span class="watch-filter-label" style="color: var(--text-muted); font-size: 12px; padding: 0;">
            <?php esc_html_e( 'Active filters:', 'quantum-mentor-world' ); ?>
        </span>
        <?php if ( $current_type ) : ?>
            <span class="watch-active-chip">
                <?php esc_html_e( 'Type:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $types[ $current_type ] ?? $current_type ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_genre ) : ?>
            <span class="watch-active-chip">
                <?php esc_html_e( 'Genre:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $genres[ $current_genre ] ?? $current_genre ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_lang ) : ?>
            <span class="watch-active-chip">
                <?php esc_html_e( 'Language:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $languages[ $current_lang ] ?? $current_lang ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_status ) : ?>
            <span class="watch-active-chip">
                <?php esc_html_e( 'Status:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $statuses[ $current_status ] ?? $current_status ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_search ) : ?>
            <span class="watch-active-chip">
                <?php esc_html_e( 'Search:', 'quantum-mentor-world' ); ?> "<?php echo esc_html( $current_search ); ?>"
            </span>
        <?php endif; ?>
        <a href="<?php echo esc_url( $archive_url ); ?>" class="watch-clear-filters-btn" aria-label="<?php esc_attr_e( 'Clear all filters', 'quantum-mentor-world' ); ?>">
            ✕ <?php esc_html_e( 'Clear All', 'quantum-mentor-world' ); ?>
        </a>
    </div>
    <?php endif; ?>

</section>
