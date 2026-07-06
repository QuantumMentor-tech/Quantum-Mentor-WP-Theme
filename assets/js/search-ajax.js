/**
 * Quantum Mentor Theme - AJAX Live Search Client Script
 */

document.addEventListener('DOMContentLoaded', function() {
    
    const searchInput = document.getElementById('quantum-search-input');
    const resultsBox  = document.getElementById('ajax-search-results');

    if (!searchInput || !resultsBox) return;

    let debounceTimer;

    // Listen to user keystrokes
    searchInput.addEventListener('input', function() {
        const query = searchInput.value.trim();

        // Clear previous timer
        clearTimeout(debounceTimer);

        if (query.length < 2) {
            resultsBox.innerHTML = '';
            resultsBox.classList.remove('active');
            return;
        }

        // Set debounce timer to 300ms
        debounceTimer = setTimeout(function() {
            fetchSearchResults(query);
        }, 300);
    });

    // Close results box when user clicks outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
            resultsBox.classList.remove('active');
        }
    });

    // Fetch call to WordPress admin-ajax.php
    function fetchSearchResults(query) {
        // Prepare FormData parameters
        const formData = new FormData();
        formData.append('action', 'quantum_live_search');
        formData.append('nonce', quantum_search_params.nonce);
        formData.append('query', query);

        fetch(quantum_search_params.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderResults(data.data);
            } else {
                console.error('AJAX Search Query Failed:', data.data);
            }
        })
        .catch(err => {
            console.error('Network error requesting live search results:', err);
        });
    }

    // Render results dynamically
    function renderResults(results) {
        resultsBox.innerHTML = '';

        if (!Array.isArray(results) || results.length === 0) {
            resultsBox.innerHTML = `
                <div class="p-4 text-center text-xs text-slate-500">
                    No resources found matching your query.
                </div>
            `;
            resultsBox.classList.add('active');
            return;
        }

        // Build list elements
        results.forEach(item => {
            resultsBox.insertAdjacentHTML('beforeend', `
                <a href="${item.url}" class="search-result-item">
                    <img src="${item.thumbnail}" alt="Thumbnail">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-0.5">
                            <h4 class="text-xs font-bold font-display text-white truncate pr-2">${item.title}</h4>
                            <span class="badge badge-primary text-[9px] font-semibold flex-shrink-0">${item.type}</span>
                        </div>
                        <p class="text-[10px] text-slate-400">Verified resource available</p>
                    </div>
                </a>
            `);
        });

        resultsBox.classList.add('active');
    }

});
