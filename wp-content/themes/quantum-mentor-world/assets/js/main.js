/**
 * Quantum Mentor World - Interactive Design System Engine
 * Supports Responsive Drawers, Search Overlays, Accessibility Focus Traps, and Theme Settings
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Helper function to set theme cookie
    function setThemeCookie(themeValue) {
        const expirationDate = new Date();
        expirationDate.setFullYear(expirationDate.getFullYear() + 1); // 1 year expiry
        document.cookie = "qmw_theme=" + themeValue + "; path=/; expires=" + expirationDate.toUTCString() + "; SameSite=Lax";
    }

    // --- 1. THEME SWITCHER (Dark/Light Mode Sync) ---
    const themeToggle = document.getElementById('theme-toggle');
    const themeDot = document.getElementById('theme-toggle-dot');

    // Retrieve initial theme preference from localStorage or fallback to dark
    let currentTheme = localStorage.getItem('theme');
    if (!currentTheme) {
        currentTheme = document.body.classList.contains('qmw-light') ? 'light' : 'dark';
    }

    // Dynamically update the toggle icon based on the active theme
    function updateThemeToggleIcon(theme) {
        if (!themeToggle) return;
        const moonSvg = `<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>`;
        const sunSvg = `<svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"></path></svg>`;
        
        if (theme === 'light') {
            themeToggle.innerHTML = sunSvg + `<span id="theme-toggle-dot" style="display:none;"></span>`;
            themeToggle.setAttribute('aria-label', 'Switch to dark theme');
            themeToggle.setAttribute('title', 'Switch to dark theme');
        } else {
            themeToggle.innerHTML = moonSvg + `<span id="theme-toggle-dot" style="display:none;"></span>`;
            themeToggle.setAttribute('aria-label', 'Switch to light theme');
            themeToggle.setAttribute('title', 'Switch to light theme');
        }
    }

    // Initialize state
    document.body.classList.remove('qmw-dark', 'qmw-light');
    document.body.classList.add('qmw-' + currentTheme);
    setThemeCookie(currentTheme);
    updateThemeToggleIcon(currentTheme);

    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const isLight = document.body.classList.contains('qmw-light');
            const nextTheme = isLight ? 'dark' : 'light';
            
            document.body.classList.remove('qmw-dark', 'qmw-light');
            document.body.classList.add('qmw-' + nextTheme);
            
            localStorage.setItem('theme', nextTheme);
            setThemeCookie(nextTheme);
            updateThemeToggleIcon(nextTheme);
        });
    }


    // --- 2. STICKY HEADER SCROLL CLASS ---
    const header = document.querySelector('.sticky-header-container');
    
    function checkHeaderScroll() {
        if (header) {
            if (window.scrollY > 50) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        }
    }

    window.addEventListener('scroll', checkHeaderScroll);
    checkHeaderScroll(); // Call once on load

    // --- 3. MOBILE DRAWER NAVIGATION (Hamburger Menu) ---
    const hamburgerBtn = document.getElementById('hamburger-btn');
    const mobileDrawer = document.getElementById('mobile-drawer');
    const drawerCloseBtn = document.getElementById('mobile-drawer-close');
    const backdropOverlay = document.getElementById('backdrop-blur-overlay');

    function toggleMobileMenu(forceClose = false) {
        if (hamburgerBtn && mobileDrawer && backdropOverlay) {
            const isOpen = hamburgerBtn.classList.contains('active') && !forceClose;
            if (isOpen || forceClose) {
                hamburgerBtn.classList.remove('active');
                mobileDrawer.classList.remove('active');
                backdropOverlay.classList.remove('active');
                hamburgerBtn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = ''; // Scroll unlock
            } else {
                hamburgerBtn.classList.add('active');
                mobileDrawer.classList.add('active');
                backdropOverlay.classList.add('active');
                hamburgerBtn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden'; // Scroll lock
            }
        }
    }

    if (hamburgerBtn) {
        hamburgerBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleMobileMenu();
        });
    }

    if (drawerCloseBtn) {
        drawerCloseBtn.addEventListener('click', () => toggleMobileMenu(true));
    }

    if (backdropOverlay) {
        backdropOverlay.addEventListener('click', () => toggleMobileMenu(true));
    }

    // --- 4. GLOBAL SEARCH OVERLAY & SUGGESTIONS ---
    const searchTrigger = document.getElementById('search-trigger');
    const searchMobileTrigger = document.getElementById('search-mobile-trigger');
    const searchOverlay = document.getElementById('search-overlay');
    const searchClose = document.getElementById('search-close');
    const searchInput = document.getElementById('qmw-search-field');
    const resultsBox = document.getElementById('search-suggestions-dropdown');

    function openSearchOverlay() {
        if (searchOverlay) {
            searchOverlay.classList.add('active');
            document.body.style.overflow = 'hidden'; // Scroll lock body
            if (searchInput) {
                setTimeout(() => searchInput.focus(), 150);
            }
        }
    }

    function closeSearchOverlay() {
        if (searchOverlay) {
            searchOverlay.classList.remove('active');
            document.body.style.overflow = ''; // Scroll unlock body
            if (resultsBox) {
                resultsBox.classList.remove('active');
            }
        }
    }

    if (searchTrigger) searchTrigger.addEventListener('click', openSearchOverlay);
    if (searchMobileTrigger) searchMobileTrigger.addEventListener('click', openSearchOverlay);
    if (searchClose) searchClose.addEventListener('click', closeSearchOverlay);

    // --- 5. ACCESSIBILITY KEYBOARD CONTROLS (ESC & Focus Trapping) ---
    document.addEventListener('keydown', function(e) {
        // ESC key closes active drawers and overlays
        if (e.key === 'Escape') {
            closeSearchOverlay();
            toggleMobileMenu(true);
        }

        // Focus trap inside search modal overlay
        if (searchOverlay && searchOverlay.classList.contains('active')) {
            const focusableElements = searchOverlay.querySelectorAll('button, [href], input, [tabindex="0"]');
            if (focusableElements.length > 0) {
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                if (e.key === 'Tab') {
                    if (e.shiftKey) { // Shift + Tab
                        if (document.activeElement === firstElement) {
                            lastElement.focus();
                            e.preventDefault();
                        }
                    } else { // Tab
                        if (document.activeElement === lastElement) {
                            firstElement.focus();
                            e.preventDefault();
                        }
                    }
                }
            }
        }

        // Focus trap inside mobile drawer
        if (mobileDrawer && mobileDrawer.classList.contains('active')) {
            const focusableElements = mobileDrawer.querySelectorAll('button, [href], input, [tabindex="0"]');
            if (focusableElements.length > 0) {
                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                if (e.key === 'Tab') {
                    if (e.shiftKey) { // Shift + Tab
                        if (document.activeElement === firstElement) {
                            lastElement.focus();
                            e.preventDefault();
                        }
                    } else { // Tab
                        if (document.activeElement === lastElement) {
                            firstElement.focus();
                            e.preventDefault();
                        }
                    }
                }
            }
        }
    });

    // --- 6. AJAX LIVE SEARCH SUGGESTIONS CLIENT ---
    if (searchInput && resultsBox) {
        let debounceTimer;

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim();
            clearTimeout(debounceTimer);

            if (query.length < 2) {
                resultsBox.innerHTML = '';
                resultsBox.classList.remove('active');
                return;
            }

            debounceTimer = setTimeout(function() {
                if (typeof quantum_search_params === 'undefined') return;

                const formData = new FormData();
                formData.append('action', 'quantum_live_search');
                formData.append('nonce', quantum_search_params.nonce);
                formData.append('query', query);

                // Add visual loading state placeholder
                resultsBox.innerHTML = '<div class="p-4 text-center text-xs text-slate-500">Searching verified database...</div>';
                resultsBox.classList.add('active');

                fetch(quantum_search_params.ajax_url, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultsBox.innerHTML = '';

                        if (data.data.length === 0) {
                            resultsBox.innerHTML = '<div class="p-4 text-center text-xs text-slate-500">No verified resources found matching your search.</div>';
                            return;
                        }

                        data.data.forEach(item => {
                            resultsBox.insertAdjacentHTML('beforeend', `
                                <a href="${item.url}" class="autocomplete-item">
                                    <img src="${item.thumbnail}" alt="" class="autocomplete-thumb">
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2px;">
                                            <h4 class="card-title text-sm" style="margin: 0; color: var(--text-main); text-overflow: ellipsis; overflow: hidden; white-space: nowrap; font-size: 14px;">${item.title}</h4>
                                            <span class="badge badge-primary" style="font-size: 9px; flex-shrink: 0;">${item.type}</span>
                                        </div>
                                        <p class="small-text" style="font-size: 11px; margin: 0;">Verified Safe Resource</p>
                                    </div>
                                </a>
                            `);
                        });
                    }
                })
                .catch(err => {
                    console.error('Autocomplete search retrieval failed:', err);
                    resultsBox.innerHTML = '<div class="p-4 text-center text-xs text-red-500">Error retrieving search results.</div>';
                });
            }, 300);
        });

        // Close results when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !resultsBox.contains(e.target)) {
                resultsBox.classList.remove('active');
            }
        });
    }

    // --- 7. BACK-TO-TOP BUTTON TRIGGER ---
    const backToTopBtn = document.createElement('button');
    backToTopBtn.id = 'back-to-top';
    backToTopBtn.innerHTML = '▲';
    backToTopBtn.setAttribute('aria-label', 'Scroll back to top');
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 50%;
        background: var(--primary);
        border: none;
        color: #0F172A;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 90;
        box-shadow: var(--glow-primary);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    `;
    document.body.appendChild(backToTopBtn);

    window.addEventListener('scroll', function() {
        if (window.scrollY > 400) {
            backToTopBtn.style.display = 'flex';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });

    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    backToTopBtn.addEventListener('mouseenter', () => {
        backToTopBtn.style.transform = 'scale(1.1) translateY(-2px)';
    });
    backToTopBtn.addEventListener('mouseleave', () => {
        backToTopBtn.style.transform = 'scale(1) translateY(0)';
    });

    // --- 8. FAQ ACCORDIONS ---
    const faqQuestions = document.querySelectorAll('.faq-question');
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // Close all other FAQs first for accordion behavior
            document.querySelectorAll('.faq-question').forEach(q => {
                if (q !== this) {
                    q.setAttribute('aria-expanded', 'false');
                    q.classList.remove('active');
                    q.nextElementSibling.style.maxHeight = null;
                }
            });

            this.setAttribute('aria-expanded', !isExpanded ? 'true' : 'false');
            this.classList.toggle('active');

            if (!isExpanded) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
            } else {
                answer.style.maxHeight = null;
            }
        });
    });

    // --- 9. LIGHTBOX MEDIA VIEWER ---
    const lightboxTriggers = document.querySelectorAll('.lightbox-trigger');
    if (lightboxTriggers.length > 0) {
        // Create lightbox elements if they don't exist
        let lightbox = document.querySelector('.qmw-lightbox');
        let lightboxImg, lightboxClose;
        
        if (!lightbox) {
            lightbox = document.createElement('div');
            lightbox.className = 'qmw-lightbox';
            lightbox.setAttribute('role', 'dialog');
            lightbox.setAttribute('aria-modal', 'true');
            lightbox.setAttribute('aria-label', 'Image preview');
            
            lightboxClose = document.createElement('button');
            lightboxClose.className = 'qmw-lightbox-close';
            lightboxClose.innerHTML = '&times;';
            lightboxClose.setAttribute('aria-label', 'Close image preview');
            
            lightboxImg = document.createElement('img');
            lightboxImg.className = 'qmw-lightbox-content';
            lightboxImg.setAttribute('alt', 'Preview screenshot');
            
            lightbox.appendChild(lightboxClose);
            lightbox.appendChild(lightboxImg);
            document.body.appendChild(lightbox);
            
            // Event handlers for closing
            const closeLightbox = () => {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            };
            
            lightboxClose.addEventListener('click', closeLightbox);
            lightbox.addEventListener('click', (e) => {
                if (e.target === lightbox || e.target === lightboxClose) {
                    closeLightbox();
                }
            });
            
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && lightbox.classList.contains('active')) {
                    closeLightbox();
                }
            });
        } else {
            lightboxImg = lightbox.querySelector('.qmw-lightbox-content');
        }
        
        lightboxTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                const fullUrl = this.getAttribute('href');
                if (fullUrl && lightboxImg) {
                    lightboxImg.setAttribute('src', fullUrl);
                    lightbox.classList.add('active');
                    document.body.style.overflow = 'hidden';
                }
            });
        });
    }

    // Homepage specific script events enqueued
});

/* ============================================================
   STEP 4 EXTENSION — Interactive Design System Engine
   Quantum Mentor World v1.0.0
   ============================================================ */

(function() {
    'use strict';

    /* --------------------------------------------------
       TOAST NOTIFICATION MANAGER
       Usage: QMW.toast('Message', 'success'|'error'|'warning'|'info')
       -------------------------------------------------- */
    const QMW = window.QMW = window.QMW || {};

    QMW.toast = function(message, type = 'info', duration = 4000) {
        let container = document.getElementById('qmw-toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'qmw-toast-container';
            container.className = 'toast-container';
            container.setAttribute('aria-live', 'polite');
            document.body.appendChild(container);
        }

        const icons = { success: '✅', error: '❌', warning: '⚠️', info: 'ℹ️' };

        const toast = document.createElement('div');
        toast.className = `toast toast--${type}`;
        toast.setAttribute('role', 'status');
        toast.innerHTML = `
            <span class="toast-icon" aria-hidden="true">${icons[type] || icons.info}</span>
            <span class="toast-msg">${message}</span>
            <button class="toast-close" aria-label="Dismiss notification">×</button>
        `;

        const closeBtn = toast.querySelector('.toast-close');
        const removeToast = () => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(30px)';
            toast.style.transition = 'opacity 0.3s, transform 0.3s';
            setTimeout(() => toast.remove(), 300);
        };
        closeBtn.addEventListener('click', removeToast);

        container.appendChild(toast);
        const timer = setTimeout(removeToast, duration);
        closeBtn.addEventListener('click', () => clearTimeout(timer));
    };

    /* --------------------------------------------------
       COPY TO CLIPBOARD
       Add data-copy="text to copy" or data-copy-target="#selector"
       -------------------------------------------------- */
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('[data-copy], [data-copy-target], .copy-btn');
        if (!btn) return;

        let text = '';
        if (btn.dataset.copyTarget) {
            const target = document.querySelector(btn.dataset.copyTarget);
            text = target ? (target.value || target.textContent).trim() : '';
        } else if (btn.dataset.copy) {
            text = btn.dataset.copy;
        } else {
            // .copy-btn next to code block
            const codeBlock = btn.closest('.code-block');
            if (codeBlock) {
                const pre = codeBlock.querySelector('pre');
                text = pre ? pre.textContent.trim() : '';
            }
            const installCmd = btn.closest('.install-cmd');
            if (installCmd) {
                const cmdText = installCmd.querySelector('.install-cmd-text');
                text = cmdText ? cmdText.textContent.trim() : '';
            }
        }

        if (!text) return;

        navigator.clipboard.writeText(text).then(() => {
            const original = btn.innerHTML;
            btn.classList.add('copied');
            btn.innerHTML = btn.innerHTML.replace(/copy/gi, 'Copied!');
            QMW.toast('Copied to clipboard!', 'success', 2000);
            setTimeout(() => {
                btn.classList.remove('copied');
                btn.innerHTML = original;
            }, 2500);
        }).catch(() => {
            QMW.toast('Copy failed. Please copy manually.', 'error');
        });
    });

    /* --------------------------------------------------
       TABS COMPONENT
       HTML: <div class="tabs-wrapper">
               <div class="tab-nav">
                 <button class="tab-btn active" data-tab="tab1">Tab 1</button>
                 <button class="tab-btn" data-tab="tab2">Tab 2</button>
               </div>
               <div id="tab1" class="tab-panel active">...</div>
               <div id="tab2" class="tab-panel">...</div>
             </div>
       -------------------------------------------------- */
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const wrapper = this.closest('.tabs-wrapper');
            if (!wrapper) return;
            const targetId = this.dataset.tab;

            wrapper.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            wrapper.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            const panel = document.getElementById(targetId);
            if (panel) panel.classList.add('active');
        });
    });

    /* --------------------------------------------------
       SERVER TAB SWITCHER (for Watch / Multi-server content)
       -------------------------------------------------- */
    document.querySelectorAll('.server-tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const group = this.closest('[data-server-group]') || this.closest('.server-tab-group');
            if (!group) return;
            const server = this.dataset.server;

            group.querySelectorAll('.server-tab-btn').forEach(b => b.classList.remove('active'));
            group.querySelectorAll('[data-server-panel]').forEach(p => {
                p.style.display = p.dataset.serverPanel === server ? 'block' : 'none';
            });
            this.classList.add('active');
        });
    });

    /* --------------------------------------------------
       MODAL SYSTEM
       Open: data-modal-open="#modal-id"
       Close: data-modal-close (inside modal) or click backdrop
       -------------------------------------------------- */
    document.addEventListener('click', function(e) {
        // Open modal
        const openTrigger = e.target.closest('[data-modal-open]');
        if (openTrigger) {
            const modalId = openTrigger.dataset.modalOpen;
            const backdrop = document.querySelector(modalId);
            if (backdrop) {
                backdrop.classList.add('active');
                document.body.style.overflow = 'hidden';
                const firstFocusable = backdrop.querySelector('button, [href], input, [tabindex="0"]');
                if (firstFocusable) setTimeout(() => firstFocusable.focus(), 100);
            }
            return;
        }

        // Close modal via button
        const closeTrigger = e.target.closest('[data-modal-close], .qmw-modal-close');
        if (closeTrigger) {
            const backdrop = closeTrigger.closest('.qmw-modal-backdrop');
            if (backdrop) {
                backdrop.classList.remove('active');
                document.body.style.overflow = '';
            }
            return;
        }

        // Close modal by clicking backdrop
        if (e.target.classList.contains('qmw-modal-backdrop')) {
            e.target.classList.remove('active');
            document.body.style.overflow = '';
        }
    });

    // ESC closes modals
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.qmw-modal-backdrop.active').forEach(m => {
                m.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
    });

    /* --------------------------------------------------
       SCROLL REVEAL (Intersection Observer)
       Add class="reveal" to elements. Optionally add delay-100 .. delay-500
       -------------------------------------------------- */
    if ('IntersectionObserver' in window) {
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
    } else {
        // Fallback — show all
        document.querySelectorAll('.reveal').forEach(el => el.classList.add('revealed'));
    }

    /* --------------------------------------------------
       VIEW TOGGLE (grid/list view for archive pages)
       -------------------------------------------------- */
    document.querySelectorAll('.view-toggle-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const container = document.querySelector(this.dataset.target || '.archive-grid');
            if (!container) return;
            const view = this.dataset.view;

            document.querySelectorAll('.view-toggle-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            if (view === 'list') {
                container.classList.add('list-view');
            } else {
                container.classList.remove('list-view');
            }

            // Save preference
            try { localStorage.setItem('qmw-archive-view', view); } catch(e) {}
        });
    });

    // Restore saved view preference
    const savedView = (() => { try { return localStorage.getItem('qmw-archive-view'); } catch(e) { return null; } })();
    if (savedView === 'list') {
        const grid = document.querySelector('.archive-grid');
        if (grid) {
            grid.classList.add('list-view');
            const listBtn = document.querySelector('.view-toggle-btn[data-view="list"]');
            if (listBtn) listBtn.classList.add('active');
        }
    }

    /* --------------------------------------------------
       ANIMATED STAT COUNTER
       Add data-count="1234" to .stat-number elements
       -------------------------------------------------- */
    function animateCounter(el) {
        const target = parseInt(el.dataset.count || el.textContent.replace(/\D/g, ''), 10);
        if (isNaN(target)) return;

        const suffix = el.dataset.suffix || '';
        const prefix = el.dataset.prefix || '';
        const duration = 1800;
        const start = performance.now();

        function step(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
            const current = Math.floor(eased * target);
            el.textContent = prefix + current.toLocaleString() + suffix;
            if (progress < 1) requestAnimationFrame(step);
        }

        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !entry.target.dataset.counted) {
                    entry.target.dataset.counted = 'true';
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-number[data-count]').forEach(el => {
            counterObserver.observe(el);
        });
    }

    /* --------------------------------------------------
       PROGRESS BAR ANIMATION
       Add data-progress="75" to .progress-bar-fill elements
       -------------------------------------------------- */
    if ('IntersectionObserver' in window) {
        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const fill = entry.target;
                    const pct = fill.dataset.progress || '0';
                    fill.style.width = pct + '%';
                    progressObserver.unobserve(fill);
                }
            });
        }, { threshold: 0.3 });

        document.querySelectorAll('.progress-bar-fill[data-progress]').forEach(el => {
            el.style.width = '0%';
            progressObserver.observe(el);
        });
    }

    /* --------------------------------------------------
       SHARE BUTTONS (Web Share API + clipboard fallback)
       -------------------------------------------------- */
    document.querySelectorAll('.share-btn[data-share]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.dataset.share === 'native' && navigator.share) {
                e.preventDefault();
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(() => {});
            }
        });
    });

    /* --------------------------------------------------
       FILTER CHIPS (URL-based or AJAX)
       Add data-filter-group to wrapper, data-filter-value to chips
       -------------------------------------------------- */
    document.querySelectorAll('[data-filter-group]').forEach(group => {
        group.querySelectorAll('.filter-chip').forEach(chip => {
            chip.addEventListener('click', function() {
                group.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                // Emit custom event for theme to hook into
                group.dispatchEvent(new CustomEvent('qmw:filter', {
                    detail: { value: this.dataset.filterValue, label: this.textContent.trim() },
                    bubbles: true
                }));
            });
        });
    });

    /* --------------------------------------------------
       ANNOUNCEMENT BAR DISMISS
       -------------------------------------------------- */
    const annBar = document.querySelector('.announcement-bar');
    const annClose = annBar ? annBar.querySelector('[data-dismiss]') : null;
    if (annBar && annClose) {
        annClose.addEventListener('click', () => {
            annBar.style.maxHeight = annBar.scrollHeight + 'px';
            requestAnimationFrame(() => {
                annBar.style.transition = 'max-height 0.3s ease, opacity 0.3s ease';
                annBar.style.maxHeight = '0';
                annBar.style.opacity = '0';
                setTimeout(() => annBar.remove(), 350);
            });
            try { sessionStorage.setItem('qmw-ann-dismissed', '1'); } catch(e) {}
        });
        // Keep hidden if dismissed this session
        try { if (sessionStorage.getItem('qmw-ann-dismissed')) annBar.style.display = 'none'; } catch(e) {}
    }

    /* --------------------------------------------------
       SMOOTH NAV ANCHOR SCROLL
       -------------------------------------------------- */
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const id = this.getAttribute('href');
            if (id === '#') return;
            const target = document.querySelector(id);
            if (!target) return;
            e.preventDefault();
            const offset = 96; // header height
            const top = target.getBoundingClientRect().top + window.scrollY - offset;
            window.scrollTo({ top, behavior: 'smooth' });
        });
    });

    /* --------------------------------------------------
       KEYBOARD ACCESSIBILITY: Tab Navigation for Cards
       -------------------------------------------------- */
    document.querySelectorAll('.glass-card, .category-card, .card-repo-compact').forEach(card => {
        if (!card.querySelector('a, button')) {
            card.setAttribute('tabindex', '0');
            card.addEventListener('keypress', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    const link = this.querySelector('a');
                    if (link) link.click();
                }
            });
        }
    });

    // --- 6. Tools Platform: Built-in Sandboxed Tools Logic ---
    const toolWorkspace = document.getElementById('built-in-tool-workspace');
    if (toolWorkspace) {
        const toolSlug = toolWorkspace.getAttribute('data-tool-slug') || '';
        const loader = document.getElementById('tool-workspace-loader');
        const loaderMsg = document.getElementById('tool-loader-msg');
        const errorAlert = document.getElementById('tool-workspace-error');
        const errorMsg = document.getElementById('tool-error-msg');
        const errorClose = document.getElementById('tool-error-close');

        // Helper to show/hide loading states
        function showLoader(message = 'Processing data locally...') {
            if (loaderMsg) loaderMsg.textContent = message;
            if (loader) loader.style.display = 'flex';
        }
        function hideLoader() {
            if (loader) loader.style.display = 'none';
        }

        // Helper to show/hide error alerts
        function showError(message) {
            if (errorMsg) errorMsg.textContent = message;
            if (errorAlert) errorAlert.style.display = 'flex';
            hideLoader();
        }
        function hideError() {
            if (errorAlert) errorAlert.style.display = 'none';
        }

        if (errorClose) {
            errorClose.addEventListener('click', hideError);
        }

        // Helper to copy text to clipboard with micro-feedback
        function copyText(text, btn) {
            if (!text || !btn) return;
            navigator.clipboard.writeText(text).then(() => {
                const originalText = btn.textContent;
                btn.textContent = 'Copied!';
                btn.style.borderColor = 'var(--success)';
                btn.style.color = 'var(--success)';
                setTimeout(() => {
                    btn.textContent = originalText;
                    btn.style.borderColor = '';
                    btn.style.color = '';
                }, 2000);
            }).catch(err => {
                showError('Failed to copy text: ' + err.message);
            });
        }

        // CASE 1: Word Counter Logic
        if (toolSlug.includes('word-counter')) {
            const input = document.getElementById('word-counter-input');
            const statWords = document.getElementById('stat-words');
            const statChars = document.getElementById('stat-chars');
            const statParagraphs = document.getElementById('stat-paragraphs');
            const statReadingTime = document.getElementById('stat-reading-time');
            const resetBtn = document.getElementById('word-counter-reset');

            if (input) {
                input.addEventListener('input', function() {
                    const text = input.value;
                    
                    // Characters
                    const chars = text.length;
                    statChars.textContent = chars;

                    // Words
                    const trimmed = text.trim();
                    const words = trimmed === '' ? 0 : trimmed.split(/\s+/).length;
                    statWords.textContent = words;

                    // Paragraphs
                    const paras = trimmed === '' ? 0 : trimmed.split(/\n+/).filter(p => p.trim() !== '').length;
                    statParagraphs.textContent = paras;

                    // Reading time (average 200 words per minute)
                    const minutes = words === 0 ? 0 : Math.ceil(words / 200);
                    statReadingTime.textContent = minutes + 'm';
                });
            }

            if (resetBtn && input) {
                resetBtn.addEventListener('click', function() {
                    input.value = '';
                    statWords.textContent = '0';
                    statChars.textContent = '0';
                    statParagraphs.textContent = '0';
                    statReadingTime.textContent = '0m';
                    hideError();
                });
            }
        }

        // CASE 2: Text Case Converter Logic
        else if (toolSlug.includes('case-converter')) {
            const input = document.getElementById('case-input');
            const output = document.getElementById('case-output');
            const btnUpper = document.getElementById('case-btn-upper');
            const btnLower = document.getElementById('case-btn-lower');
            const btnTitle = document.getElementById('case-btn-title');
            const btnReset = document.getElementById('case-btn-reset');
            const btnCopy = document.getElementById('case-btn-copy');

            if (btnUpper && input && output) {
                btnUpper.addEventListener('click', function() {
                    output.value = input.value.toUpperCase();
                });
            }

            if (btnLower && input && output) {
                btnLower.addEventListener('click', function() {
                    output.value = input.value.toLowerCase();
                });
            }

            if (btnTitle && input && output) {
                btnTitle.addEventListener('click', function() {
                    const text = input.value;
                    const titleCased = text.toLowerCase().split(' ').map(word => {
                        return word.charAt(0).toUpperCase() + word.slice(1);
                    }).join(' ');
                    output.value = titleCased;
                });
            }

            if (btnReset && input && output) {
                btnReset.addEventListener('click', function() {
                    input.value = '';
                    output.value = '';
                    hideError();
                });
            }

            if (btnCopy && output) {
                btnCopy.addEventListener('click', function() {
                    copyText(output.value, btnCopy);
                });
            }
        }

        // CASE 3: JSON Formatter & Minifier Logic
        else if (toolSlug.includes('json-formatter')) {
            const input = document.getElementById('json-input');
            const output = document.getElementById('json-output');
            const btnFormat = document.getElementById('json-btn-format');
            const btnMinify = document.getElementById('json-btn-minify');
            const btnReset = document.getElementById('json-btn-reset');
            const btnCopy = document.getElementById('json-btn-copy');

            if (btnFormat && input && output) {
                btnFormat.addEventListener('click', function() {
                    const rawText = input.value.trim();
                    if (!rawText) {
                        showError('Please enter some JSON text to format.');
                        return;
                    }
                    hideError();
                    showLoader('Formatting and validating JSON...');
                    setTimeout(() => {
                        try {
                            const parsed = JSON.parse(rawText);
                            output.value = JSON.stringify(parsed, null, 4);
                            hideLoader();
                        } catch (err) {
                            showError('Invalid JSON: ' + err.message);
                        }
                    }, 400);
                });
            }

            if (btnMinify && input && output) {
                btnMinify.addEventListener('click', function() {
                    const rawText = input.value.trim();
                    if (!rawText) {
                        showError('Please enter some JSON text to minify.');
                        return;
                    }
                    hideError();
                    showLoader('Minifying JSON...');
                    setTimeout(() => {
                        try {
                            const parsed = JSON.parse(rawText);
                            output.value = JSON.stringify(parsed);
                            hideLoader();
                        } catch (err) {
                            showError('Invalid JSON: ' + err.message);
                        }
                    }, 400);
                });
            }

            if (btnReset && input && output) {
                btnReset.addEventListener('click', function() {
                    input.value = '';
                    output.value = '';
                    hideError();
                });
            }

            if (btnCopy && output) {
                btnCopy.addEventListener('click', function() {
                    copyText(output.value, btnCopy);
                });
            }
        }

        // CASE 4: Image Compressor / Converter Logic (Real Client-Side Canvas compression)
        else if (toolSlug.includes('compressor') || toolSlug.includes('image')) {
            const dragArea = document.getElementById('image-drag-area');
            const fileInput = document.getElementById('image-file-input');
            const qualityRange = document.getElementById('image-quality-range');
            const qualityVal = document.getElementById('image-quality-val');
            const optionsPanel = document.getElementById('image-tool-options');
            const btnCompress = document.getElementById('image-btn-compress');
            const btnReset = document.getElementById('image-btn-reset');
            const btnDownload = document.getElementById('image-btn-download');
            const outputPanel = document.getElementById('image-tool-output');
            const outputPreview = document.getElementById('image-output-preview');
            const outputName = document.getElementById('image-output-name');
            const origSize = document.getElementById('image-orig-size');
            const compSize = document.getElementById('image-comp-size');

            let activeFile = null;

            // Sync quality slider
            if (qualityRange && qualityVal) {
                qualityRange.addEventListener('input', function() {
                    qualityVal.textContent = qualityRange.value + '%';
                });
            }

            // Drag/Drop visual highlights
            if (dragArea) {
                ['dragenter', 'dragover'].forEach(eventName => {
                    dragArea.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        dragArea.style.borderColor = 'var(--primary)';
                        dragArea.style.background = 'rgba(0, 212, 255, 0.05)';
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dragArea.addEventListener(eventName, (e) => {
                        e.preventDefault();
                        dragArea.style.borderColor = '';
                        dragArea.style.background = '';
                    }, false);
                });

                dragArea.addEventListener('drop', (e) => {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    if (files.length) {
                        handleImageSelection(files[0]);
                    }
                });
            }

            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    if (fileInput.files.length) {
                        handleImageSelection(fileInput.files[0]);
                    }
                });
            }

            function handleImageSelection(file) {
                hideError();
                if (!file.type.startsWith('image/')) {
                    showError('Please upload a valid image file (PNG, JPG, WebP, GIF).');
                    return;
                }
                if (file.size > 5 * 1024 * 1024) {
                    showError('Image size exceeds the 5 MB safety limit.');
                    return;
                }

                activeFile = file;
                if (optionsPanel) optionsPanel.style.display = 'block';
                if (outputPanel) outputPanel.style.display = 'none';
            }

            if (btnCompress) {
                btnCompress.addEventListener('click', function() {
                    if (!activeFile) return;
                    hideError();
                    showLoader('Compressing image locally using WebGL/Canvas...');

                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const img = new Image();
                        img.onload = function() {
                            // Setup canvas dimensions (cap at max 1600px for memory & speed)
                            const canvas = document.createElement('canvas');
                            let width = img.width;
                            let height = img.height;
                            const maxDim = 1600;

                            if (width > maxDim || height > maxDim) {
                                if (width > height) {
                                    height = Math.round((height * maxDim) / width);
                                    width = maxDim;
                                } else {
                                    width = Math.round((width * maxDim) / height);
                                    height = maxDim;
                                }
                            }

                            canvas.width = width;
                            canvas.height = height;

                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(img, 0, 0, width, height);

                            // Compress
                            const quality = parseInt(qualityRange.value, 10) / 100;
                            const compressedDataUrl = canvas.toDataURL('image/jpeg', quality);

                            // Calculate sizes
                            const sizeBytes = Math.round((compressedDataUrl.length - 22) * 3 / 4);
                            
                            setTimeout(() => {
                                // Display details
                                if (outputPreview) outputPreview.src = compressedDataUrl;
                                if (outputName) outputName.textContent = 'compressed-' + activeFile.name.replace(/\.[^/.]+$/, "") + '.jpg';
                                if (origSize) origSize.textContent = (activeFile.size / 1024).toFixed(1) + ' KB';
                                if (compSize) {
                                    const percent = Math.max(0, Math.round((1 - sizeBytes / activeFile.size) * 100));
                                    compSize.textContent = (sizeBytes / 1024).toFixed(1) + ' KB (' + percent + '% saved)';
                                }

                                if (btnDownload) {
                                    btnDownload.href = compressedDataUrl;
                                    btnDownload.download = 'compressed-' + activeFile.name.replace(/\.[^/.]+$/, "") + '.jpg';
                                }

                                if (outputPanel) outputPanel.style.display = 'block';
                                hideLoader();
                            }, 500);
                        };
                        img.src = event.target.result;
                    };
                    reader.readAsDataURL(activeFile);
                });
            }

            if (btnReset) {
                btnReset.addEventListener('click', function() {
                    activeFile = null;
                    if (fileInput) fileInput.value = '';
                    if (optionsPanel) optionsPanel.style.display = 'none';
                    if (outputPanel) outputPanel.style.display = 'none';
                    if (qualityRange) {
                        qualityRange.value = 80;
                        qualityVal.textContent = '80%';
                    }
                    hideError();
                });
            }
        }

        // CASE 5: Generic Default Fallback Simulation
        else {
            const btnRun = document.getElementById('generic-tool-run-mock');
            const outputPanel = document.getElementById('generic-tool-output');
            const outputField = document.getElementById('generic-output-field');
            const btnCopy = document.getElementById('generic-btn-copy');

            if (btnRun && outputPanel && outputField) {
                btnRun.addEventListener('click', function() {
                    hideError();
                    showLoader('Initializing workspace simulation...');
                    setTimeout(() => {
                        const date = new Date().toISOString();
                        outputField.value = `[SYSTEM OK] - Simulated Sandbox Execution Successful\n` +
                                            `Timestamp: ${date}\n` +
                                            `Status: Sandbox active, local thread listening.\n` +
                                            `Result: Ready for future processing API integration.`;
                        outputPanel.style.display = 'block';
                        hideLoader();
                    }, 600);
                });
            }

            if (btnCopy && outputField) {
                btnCopy.addEventListener('click', function() {
                    copyText(outputField.value, btnCopy);
                });
            }
        }
    }


    // --- 7. GitHub Repositories: Copy Installation Command ---
    const copyCloneBtn = document.getElementById('repo-clone-cmd-copy-btn');
    const cloneInput = document.getElementById('repo-clone-cmd-input');
    if (copyCloneBtn && cloneInput) {
        copyCloneBtn.addEventListener('click', function() {
            const text = cloneInput.value.trim();
            if (!text) return;
            navigator.clipboard.writeText(text).then(() => {
                const originalText = copyCloneBtn.textContent;
                copyCloneBtn.textContent = 'Copied!';
                copyCloneBtn.style.borderColor = 'var(--success)';
                copyCloneBtn.style.color = 'var(--success)';
                setTimeout(() => {
                    copyCloneBtn.textContent = originalText;
                    copyCloneBtn.style.borderColor = '';
                    copyCloneBtn.style.color = '';
                }, 2000);
            }).catch(err => {
                console.error('Could not copy command: ', err);
            });
        });
    }

    // --- 10. PROFILE TABS SWITCHER ---
    const qmwTabItems = document.querySelectorAll('.qmw-tab-item');
    if (qmwTabItems.length > 0) {
        qmwTabItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const tabId = this.getAttribute('data-tab');
                
                // Remove active classes from all tab list items and panels
                document.querySelectorAll('.qmw-tab-item').forEach(el => el.classList.remove('active'));
                document.querySelectorAll('.qmw-tab-panel').forEach(el => {
                    el.classList.remove('active');
                    el.style.display = 'none';
                });
                
                // Add active classes to the clicked tab list item and its panel
                this.classList.add('active');
                const activePanel = document.getElementById(tabId);
                if (activePanel) {
                    activePanel.classList.add('active');
                    activePanel.style.display = 'block';
                }
            });
        });
    }

    // --- 11. RESOURCE SUGGESTION FORM SUBMISSION ---
    const qmwSubForm = document.getElementById('qmw-resource-submit-form');
    const qmwMsgBox = document.querySelector('.qmw-form-message-box');
    const qmwSubBtn = document.getElementById('qmw-resource-submit-btn');

    if (qmwSubForm && qmwMsgBox && qmwSubBtn) {
        qmwSubForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validate legal confirmation checkbox
            const legalChecked = document.getElementById('legal_confirm').checked;
            if (!legalChecked) {
                qmwMsgBox.textContent = 'You must confirm that this resource is legal and licensed.';
                qmwMsgBox.className = 'qmw-form-message-box error';
                qmwMsgBox.style.display = 'block';
                return;
            }

            qmwSubBtn.disabled = true;
            qmwSubBtn.textContent = 'Submitting...';
            qmwMsgBox.style.display = 'none';

            const formData = new FormData(qmwSubForm);

            // Fetch AJAX POST
            fetch(qmwSubForm.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                qmwSubBtn.disabled = false;
                qmwSubBtn.textContent = 'Submit Suggestion';
                
                if (data.success) {
                    qmwMsgBox.textContent = data.data.message;
                    qmwMsgBox.className = 'qmw-form-message-box success';
                    qmwMsgBox.style.display = 'block';
                    qmwSubForm.reset();
                } else {
                    qmwMsgBox.textContent = data.data.message || 'An error occurred during submission. Please try again.';
                    qmwMsgBox.className = 'qmw-form-message-box error';
                    qmwMsgBox.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Submission error:', error);
                qmwSubBtn.disabled = false;
                qmwSubBtn.textContent = 'Submit Suggestion';
                qmwMsgBox.textContent = 'A network error occurred. Please verify your connection and try again.';
                qmwMsgBox.className = 'qmw-form-message-box error';
                qmwMsgBox.style.display = 'block';
            });
        });
    }

});


