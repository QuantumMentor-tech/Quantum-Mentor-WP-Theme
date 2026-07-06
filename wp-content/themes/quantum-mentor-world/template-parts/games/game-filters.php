<?php
/**
 * Games Archive — Filter Controls
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$archive_url     = get_post_type_archive_link( 'games' );
$current_platform = isset( $_GET['platform'] ) ? sanitize_text_field( $_GET['platform'] ) : '';
$current_genre    = isset( $_GET['genre'] )    ? sanitize_text_field( $_GET['genre'] )    : '';
$current_license  = isset( $_GET['license'] )  ? sanitize_text_field( $_GET['license'] )  : '';
$current_sort     = isset( $_GET['sort'] )     ? sanitize_text_field( $_GET['sort'] )     : 'latest';
$current_search   = isset( $_GET['game_search'] ) ? sanitize_text_field( $_GET['game_search'] ) : '';

$has_active_filters = ( $current_platform || $current_genre || $current_license || $current_search );

$platforms = array(
    'windows' => 'Windows',
    'mac'     => 'Mac',
    'linux'   => 'Linux',
    'android' => 'Android',
    'iphone'  => 'iPhone',
    'browser' => 'Browser',
    'web'     => 'Web',
);

$genres = array(
    'action'      => 'Action',
    'adventure'   => 'Adventure',
    'puzzle'      => 'Puzzle',
    'racing'      => 'Racing',
    'strategy'    => 'Strategy',
    'simulation'  => 'Simulation',
    'educational' => 'Educational',
    'open-source' => 'Open Source',
);

$licenses = array(
    'freeware'          => 'Freeware',
    'open-source'       => 'Open Source',
    'demo'              => 'Demo',
    'freemium'          => 'Freemium',
    'paid-official'     => 'Paid Official Link',
    'public-domain'     => 'Public Domain',
);

$sort_options = array(
    'latest'   => 'Latest First',
    'featured' => 'Featured',
    'popular'  => 'Most Popular',
    'a-z'      => 'A – Z',
);
?>

<!-- ============================================================
     GAMES FILTER BAR
     ============================================================ -->
<section class="games-filter-section" aria-label="<?php esc_attr_e( 'Filter and Search Games', 'quantum-mentor-world' ); ?>">

    <!-- Search + Sort Row -->
    <form method="GET" action="<?php echo esc_url( $archive_url ); ?>" class="games-search-row" role="search">

        <!-- Search input -->
        <div class="games-search-input-wrap">
            <label for="games-search-field" class="sr-only"><?php esc_html_e( 'Search games', 'quantum-mentor-world' ); ?></label>
            <svg class="games-search-icon" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
                type="search"
                id="games-search-field"
                name="game_search"
                class="games-search-input"
                placeholder="<?php esc_attr_e( 'Search games by title, developer, genre...', 'quantum-mentor-world' ); ?>"
                value="<?php echo esc_attr( $current_search ); ?>"
                autocomplete="off"
            >
        </div>

        <!-- Sort dropdown -->
        <div class="games-sort-wrap">
            <label for="games-sort-select" class="sr-only"><?php esc_html_e( 'Sort games', 'quantum-mentor-world' ); ?></label>
            <select id="games-sort-select" name="sort" class="games-sort-select" onchange="this.form.submit()">
                <?php foreach ( $sort_options as $val => $label ) : ?>
                    <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
                        <?php echo esc_html( $label ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Hidden carry-over fields -->
        <?php if ( $current_platform ) : ?><input type="hidden" name="platform" value="<?php echo esc_attr( $current_platform ); ?>"><?php endif; ?>
        <?php if ( $current_genre )    : ?><input type="hidden" name="genre"    value="<?php echo esc_attr( $current_genre ); ?>"><?php endif; ?>
        <?php if ( $current_license )  : ?><input type="hidden" name="license"  value="<?php echo esc_attr( $current_license ); ?>"><?php endif; ?>

        <button type="submit" class="btn btn-primary games-search-btn">
            <?php esc_html_e( 'Search', 'quantum-mentor-world' ); ?>
        </button>
    </form>

    <!-- Filter Chip Rows -->
    <div class="games-filter-chips-wrapper">

        <!-- Platform Chips -->
        <div class="games-filter-row">
            <span class="games-filter-label"><?php esc_html_e( 'Platform:', 'quantum-mentor-world' ); ?></span>
            <div class="games-chips-row" role="group" aria-label="<?php esc_attr_e( 'Platform filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'platform', add_query_arg( array(
                    'genre'   => $current_genre,
                    'license' => $current_license,
                    'sort'    => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_platform ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_platform ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $platforms as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'platform' => $slug,
                        'genre'    => $current_genre,
                        'license'  => $current_license,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_platform === $slug );
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
        <div class="games-filter-row">
            <span class="games-filter-label"><?php esc_html_e( 'Genre:', 'quantum-mentor-world' ); ?></span>
            <div class="games-chips-row" role="group" aria-label="<?php esc_attr_e( 'Genre filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'genre', add_query_arg( array(
                    'platform' => $current_platform,
                    'license'  => $current_license,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_genre ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_genre ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $genres as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'platform' => $current_platform,
                        'genre'    => $slug,
                        'license'  => $current_license,
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

        <!-- License Chips -->
        <div class="games-filter-row">
            <span class="games-filter-label"><?php esc_html_e( 'License:', 'quantum-mentor-world' ); ?></span>
            <div class="games-chips-row" role="group" aria-label="<?php esc_attr_e( 'License filter', 'quantum-mentor-world' ); ?>">
                <a href="<?php echo esc_url( remove_query_arg( 'license', add_query_arg( array(
                    'platform' => $current_platform,
                    'genre'    => $current_genre,
                    'sort'     => $current_sort,
                ), $archive_url ) ) ); ?>"
                   class="filter-chip <?php echo empty( $current_license ) ? 'active' : ''; ?>"
                   aria-pressed="<?php echo empty( $current_license ) ? 'true' : 'false'; ?>">
                    <?php esc_html_e( 'All', 'quantum-mentor-world' ); ?>
                </a>
                <?php foreach ( $licenses as $slug => $label ) :
                    $url = esc_url( add_query_arg( array(
                        'platform' => $current_platform,
                        'genre'    => $current_genre,
                        'license'  => $slug,
                        'sort'     => $current_sort,
                    ), $archive_url ) );
                    $is_active = ( $current_license === $slug );
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
    <div class="games-active-filters-bar">
        <span class="games-filter-label" style="color: var(--text-muted); font-size: 12px;">
            <?php esc_html_e( 'Active filters:', 'quantum-mentor-world' ); ?>
        </span>
        <?php if ( $current_platform ) : ?>
            <span class="games-active-chip">
                <?php esc_html_e( 'Platform:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $platforms[ $current_platform ] ?? $current_platform ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_genre ) : ?>
            <span class="games-active-chip">
                <?php esc_html_e( 'Genre:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $genres[ $current_genre ] ?? $current_genre ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_license ) : ?>
            <span class="games-active-chip">
                <?php esc_html_e( 'License:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $licenses[ $current_license ] ?? $current_license ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_search ) : ?>
            <span class="games-active-chip">
                <?php esc_html_e( 'Search:', 'quantum-mentor-world' ); ?> "<?php echo esc_html( $current_search ); ?>"
            </span>
        <?php endif; ?>
        <a href="<?php echo esc_url( $archive_url ); ?>" class="games-clear-filters-btn" aria-label="<?php esc_attr_e( 'Clear all filters', 'quantum-mentor-world' ); ?>">
            ✕ <?php esc_html_e( 'Clear All', 'quantum-mentor-world' ); ?>
        </a>
    </div>
    <?php endif; ?>

</section>
