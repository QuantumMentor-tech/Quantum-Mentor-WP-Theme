<?php
/**
 * GitHub Archive — Multi-faceted Filters Template
 *
 * @package Quantum_Mentor_World
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$archive_url    = get_post_type_archive_link( 'github_repos' );
$current_cat    = isset( $_GET['category'] )   ? sanitize_text_field( $_GET['category'] )   : '';
$current_lang   = isset( $_GET['language'] )   ? sanitize_text_field( $_GET['language'] )   : '';
$current_diff   = isset( $_GET['difficulty'] ) ? sanitize_text_field( $_GET['difficulty'] ) : '';
$current_lic    = isset( $_GET['license'] )    ? sanitize_text_field( $_GET['license'] )    : '';
$current_sort   = isset( $_GET['sort'] )       ? sanitize_text_field( $_GET['sort'] )       : 'latest';
$current_search = isset( $_GET['repo_search'] ) ? sanitize_text_field( $_GET['repo_search'] ) : '';

$has_active_filters = ( $current_cat || $current_lang || $current_diff || $current_lic || $current_search );

// Get repo categories
$repo_categories = get_terms( array(
    'taxonomy'   => 'repo_category',
    'hide_empty' => false,
) );

$languages = array(
    'Python'     => 'Python',
    'JavaScript' => 'JavaScript',
    'TypeScript' => 'TypeScript',
    'C++'        => 'C++',
    'Rust'       => 'Rust',
    'Go'         => 'Go',
    'PHP'        => 'PHP',
    'Shell'      => 'Shell / Bash',
    'Multiple'   => 'Multiple Languages',
);

$difficulties = array(
    'Beginner'     => '🟢 Beginner',
    'Intermediate' => '🟡 Intermediate',
    'Advanced'     => '🔴 Advanced',
);

$licenses = array(
    'MIT'          => 'MIT License',
    'Apache 2.0'   => 'Apache 2.0',
    'GPL v3'       => 'GNU GPL v3',
    'CC0'          => 'CC0 (Public Domain)',
    'Other'        => 'Other Open Source',
);

$sort_options = array(
    'latest'   => 'Latest Added',
    'featured' => 'Featured First',
    'stars'    => 'Most Stars ⭐',
    'forks'    => 'Most Forks 🍴',
    'popular'  => 'Most Discussed',
    'a-z'      => 'Repo Name (A – Z)',
);
?>

<section class="tools-filter-section" aria-label="<?php esc_attr_e( 'Filter and Search Repositories', 'quantum-mentor-world' ); ?>" style="margin-bottom: var(--space-8);">

    <form method="GET" action="<?php echo esc_url( $archive_url ); ?>" class="github-filter-form">

        <!-- Search + Sort Row -->
        <div class="tools-search-row">
            <!-- Search field -->
            <div class="tools-search-input-wrap">
                <label for="repo-search-field" class="sr-only"><?php esc_html_e( 'Search repositories', 'quantum-mentor-world' ); ?></label>
                <span style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 16px; color: var(--text-muted); pointer-events: none;">🔍</span>
                <input
                    type="search"
                    id="repo-search-field"
                    name="repo_search"
                    class="tools-search-input"
                    placeholder="<?php esc_attr_e( 'Search open-source repositories by name, keywords...', 'quantum-mentor-world' ); ?>"
                    value="<?php echo esc_attr( $current_search ); ?>"
                    autocomplete="off"
                >
            </div>

            <!-- Sort Select -->
            <div class="tools-sort-wrap">
                <label for="repo-sort-select" class="sr-only"><?php esc_html_e( 'Sort repositories', 'quantum-mentor-world' ); ?></label>
                <select id="repo-sort-select" name="sort" class="tools-sort-select" onchange="this.form.submit()">
                    <?php foreach ( $sort_options as $val => $label ) : ?>
                        <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_sort, $val ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary tools-search-btn">
                <?php esc_html_e( 'Filter', 'quantum-mentor-world' ); ?>
            </button>
        </div>

        <!-- Facets Dropdown Row -->
        <div class="grid grid-cols-12 gap-4" style="margin-top: var(--space-4); margin-bottom: var(--space-4);">
            
            <!-- Language Facet -->
            <div class="col-span-12 md:col-span-4">
                <label for="repo-lang-select" style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; display: block; margin-bottom: 6px;"><?php esc_html_e( 'Programming Language', 'quantum-mentor-world' ); ?></label>
                <select id="repo-lang-select" name="language" class="tools-sort-select" style="width: 100%;" onchange="this.form.submit()">
                    <option value=""><?php esc_html_e( 'All Languages', 'quantum-mentor-world' ); ?></option>
                    <?php foreach ( $languages as $val => $label ) : ?>
                        <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_lang, $val ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Difficulty Facet -->
            <div class="col-span-12 md:col-span-4">
                <label for="repo-diff-select" style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; display: block; margin-bottom: 6px;"><?php esc_html_e( 'Difficulty Level', 'quantum-mentor-world' ); ?></label>
                <select id="repo-diff-select" name="difficulty" class="tools-sort-select" style="width: 100%;" onchange="this.form.submit()">
                    <option value=""><?php esc_html_e( 'All Difficulties', 'quantum-mentor-world' ); ?></option>
                    <?php foreach ( $difficulties as $val => $label ) : ?>
                        <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_diff, $val ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- License Facet -->
            <div class="col-span-12 md:col-span-4">
                <label for="repo-license-select" style="font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; display: block; margin-bottom: 6px;"><?php esc_html_e( 'License Type', 'quantum-mentor-world' ); ?></label>
                <select id="repo-license-select" name="license" class="tools-sort-select" style="width: 100%;" onchange="this.form.submit()">
                    <option value=""><?php esc_html_e( 'All Licenses', 'quantum-mentor-world' ); ?></option>
                    <?php foreach ( $licenses as $val => $label ) : ?>
                        <option value="<?php echo esc_attr( $val ); ?>" <?php selected( $current_lic, $val ); ?>>
                            <?php echo esc_html( $label ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>

        <!-- Category Chips Wrapper -->
        <div class="tools-filter-chips-wrapper">
            <div class="tools-filter-row">
                <span class="tools-filter-label"><?php esc_html_e( 'Topic:', 'quantum-mentor-world' ); ?></span>
                <div class="tools-chips-row" role="group" aria-label="<?php esc_attr_e( 'GitHub Repo Category filter', 'quantum-mentor-world' ); ?>">
                    <a href="<?php echo esc_url( remove_query_arg( 'category', add_query_arg( array(
                        'language'   => $current_lang,
                        'difficulty' => $current_diff,
                        'license'    => $current_lic,
                        'sort'       => $current_sort,
                        'repo_search'=> $current_search,
                    ), $archive_url ) ) ); ?>"
                       class="filter-chip <?php echo empty( $current_cat ) ? 'active' : ''; ?>">
                        <?php esc_html_e( 'All Topics', 'quantum-mentor-world' ); ?>
                    </a>
                    
                    <?php
                    if ( ! is_wp_error( $repo_categories ) && ! empty( $repo_categories ) ) :
                        foreach ( $repo_categories as $term ) :
                            $url = esc_url( add_query_arg( array(
                                'category'   => $term->slug,
                                'language'   => $current_lang,
                                'difficulty' => $current_diff,
                                'license'    => $current_lic,
                                'sort'       => $current_sort,
                                'repo_search'=> $current_search,
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

    </form>

    <!-- Active Filters Bar -->
    <?php if ( $has_active_filters ) : ?>
    <div class="tools-active-filters-bar">
        <span class="tools-filter-label" style="color: var(--text-muted); font-size: 12px; padding: 0; min-width: auto; margin-right: var(--space-2);">
            <?php esc_html_e( 'Active filters:', 'quantum-mentor-world' ); ?>
        </span>
        <?php if ( $current_cat ) :
            $active_term = get_term_by( 'slug', $current_cat, 'repo_category' );
        ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Topic:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $active_term ? $active_term->name : $current_cat ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_lang ) : ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Language:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $current_lang ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_diff ) : ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'Difficulty:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $current_diff ); ?>
            </span>
        <?php endif; ?>
        <?php if ( $current_lic ) : ?>
            <span class="tools-active-chip">
                <?php esc_html_e( 'License:', 'quantum-mentor-world' ); ?> <?php echo esc_html( $licenses[$current_lic] ?? $current_lic ); ?>
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
