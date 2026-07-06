<?php
/**
 * The template for displaying search forms
 *
 * @package Quantum_Mentor_World
 */
?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div class="search-input-wrapper" style="position: relative; display: flex; width: 100%;">
        <label for="qmw-search-field" class="sr-only">
            <?php echo esc_html_x( 'Search for:', 'label', 'quantum-mentor-world' ); ?>
        </label>
        
        <input type="search" id="qmw-search-field" class="search-large-input" 
               placeholder="<?php echo esc_attr_x( 'Search verified resources...', 'placeholder', 'quantum-mentor-world' ); ?>" 
               value="<?php echo get_search_query(); ?>" name="s" 
               autocomplete="off" required />
               
        <button type="submit" class="btn btn-primary" style="position: absolute; right: 6px; top: 6px; bottom: 6px; padding: 0 16px; min-height: auto; height: calc(100% - 12px); border-radius: calc(var(--radius-btn) - 4px);" aria-label="Submit Search">
            <svg style="width: 18px; height: 18px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </button>
    </div>
</form>
