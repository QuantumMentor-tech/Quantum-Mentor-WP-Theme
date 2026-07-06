/**
 * Quantum Mentor Theme - Main UI Interactions JS
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. Mobile Menu Drawer Navigation ---
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const sidebar = document.getElementById('sidebar-navigation');
    const overlay = document.getElementById('sidebar-overlay');
    const hamburgerIcon = document.getElementById('hamburger-icon');

    if (menuToggle && sidebar && overlay) {
        menuToggle.addEventListener('click', function() {
            const isHidden = sidebar.classList.contains('-translate-x-full');
            if (isHidden) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                // Change hamburger to X
                hamburgerIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                // Change X to hamburger
                hamburgerIcon.setAttribute('d', 'M4 6h16M4 12h16m-7 6h7');
            }
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            hamburgerIcon.setAttribute('d', 'M4 6h16M4 12h16m-7 6h7');
        });
    }

    // --- 2. Light / Dark Mode Toggle ---
    const themeToggle = document.getElementById('theme-toggle');
    const themeDot = document.getElementById('theme-toggle-dot');

    // Retrieve previous theme preference from localStorage
    if (localStorage.getItem('theme') === 'light') {
        document.body.classList.add('light-mode');
        if (themeToggle && themeDot) {
            themeToggle.classList.replace('bg-[#7C3AED]', 'bg-slate-300');
            themeDot.classList.replace('right-0.5', 'left-0.5');
        }
    }

    if (themeToggle && themeDot) {
        themeToggle.addEventListener('click', function() {
            const isLight = document.body.classList.toggle('light-mode');
            if (isLight) {
                localStorage.setItem('theme', 'light');
                themeToggle.classList.replace('bg-[#7C3AED]', 'bg-slate-300');
                themeDot.classList.replace('right-0.5', 'left-0.5');
            } else {
                localStorage.setItem('theme', 'dark');
                themeToggle.classList.replace('bg-slate-300', 'bg-[#7C3AED]');
                themeDot.classList.replace('left-0.5', 'right-0.5');
            }
        });
    }

    // --- 3. Watch Player: Safe Embed Switcher & Episode Selector ---
    const playerApp = document.getElementById('watch-player-app');
    if (playerApp) {
        const iframe = document.getElementById('main-video-player');
        const loader = document.getElementById('player-loader');
        const errorBlock = document.getElementById('player-error');
        const serverSelector = document.getElementById('watch-server-selector');
        const isEpisodic = playerApp.getAttribute('data-is-episodic') === 'true';

        // Function to load a stream URL into the iframe with a loader state
        function loadStream(url) {
            if (!url) {
                if (iframe) iframe.style.display = 'none';
                if (errorBlock) errorBlock.style.display = 'flex';
                if (loader) loader.style.display = 'none';
                return;
            }

            if (errorBlock) errorBlock.style.display = 'none';
            if (iframe) {
                iframe.style.display = 'block';
                // Show loader spinner
                if (loader) loader.style.display = 'flex';
                iframe.src = url;
            }
        }

        // Handle iframe loaded event to hide spinner
        if (iframe) {
            iframe.addEventListener('load', function() {
                if (loader) loader.style.display = 'none';
            });
        }

        // Helper to update server buttons dynamically for episodes
        function updateServerSelectorForEpisode(item) {
            if (!serverSelector) return;
            serverSelector.innerHTML = '';

            const srv1 = item.getAttribute('data-srv1');
            const srv2 = item.getAttribute('data-srv2');
            const srv3 = item.getAttribute('data-srv3');

            let buttonsHTML = '';
            let defaultUrl = '';

            if (srv1) {
                buttonsHTML += `<button class="server-btn active" data-server-idx="1" data-url="${srv1}">Server 1</button> `;
                defaultUrl = srv1;
            }
            if (srv2) {
                const activeClass = !defaultUrl ? 'active' : '';
                buttonsHTML += `<button class="server-btn ${activeClass}" data-server-idx="2" data-url="${srv2}">Server 2</button> `;
                if (!defaultUrl) defaultUrl = srv2;
            }
            if (srv3) {
                const activeClass = !defaultUrl ? 'active' : '';
                buttonsHTML += `<button class="server-btn ${activeClass}" data-server-idx="3" data-url="${srv3}">Server 3</button> `;
                if (!defaultUrl) defaultUrl = srv3;
            }

            if (buttonsHTML) {
                serverSelector.innerHTML = buttonsHTML;
                loadStream(defaultUrl);
            } else {
                serverSelector.innerHTML = `<span style="font-size:12px; color:var(--text-muted);">No servers configured for this episode.</span>`;
                loadStream('');
            }
        }

        // Initialize server selectors on page load
        if (isEpisodic) {
            const firstActiveEp = document.querySelector('.watch-ep-item.active');
            if (firstActiveEp) {
                updateServerSelectorForEpisode(firstActiveEp);
            } else {
                const firstEp = document.querySelector('.watch-ep-item');
                if (firstEp) {
                    firstEp.classList.add('active');
                    updateServerSelectorForEpisode(firstEp);
                } else {
                    loadStream('');
                }
            }
        }

        // Event delegation for server buttons
        if (serverSelector) {
            serverSelector.addEventListener('click', function(e) {
                const btn = e.target.closest('.server-btn');
                if (!btn) return;

                // Remove active class from other buttons
                const siblings = serverSelector.querySelectorAll('.server-btn');
                siblings.forEach(s => s.classList.remove('active'));

                // Set active
                btn.classList.add('active');

                // Load URL
                const url = btn.getAttribute('data-url');
                loadStream(url);
            });
        }

        // Event listener for Episode switching
        const epItems = document.querySelectorAll('.watch-ep-item');
        epItems.forEach(item => {
            const btn = item.querySelector('.watch-ep-btn');
            if (btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Remove active from all items
                    epItems.forEach(x => x.classList.remove('active'));

                    // Add active to current
                    item.classList.add('active');

                    // Rebuild server selector
                    updateServerSelectorForEpisode(item);
                });
            }
        });
    }

    // --- 5. Watch FAQ Accordion Toggle ---
    const faqBtns = document.querySelectorAll('.watch-faq-btn');
    faqBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const isExpanded = btn.getAttribute('aria-expanded') === 'true';
            const panel = document.getElementById(btn.getAttribute('aria-controls'));
            
            // Toggle state
            btn.setAttribute('aria-expanded', !isExpanded);
            if (panel) {
                if (!isExpanded) {
                    panel.style.maxHeight = panel.scrollHeight + 'px';
                } else {
                    panel.style.maxHeight = '0';
                }
            }
        });
    });

});
