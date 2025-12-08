/**
 * NSheth Portfolio 2026
 * Parallax • Scroll Effects • Interactions
 */

(() => {
    'use strict';

    // Initialize loader immediately (before DOMContentLoaded)
    initLoader();

    document.addEventListener('DOMContentLoaded', () => {
        initTheme();
        initNav();
        initHeader();
        initParallax();
        initReveal();
        initSmoothScroll();
        initProjectModal();
        initResumeAnimations();
    });

    // ==================== Loading Screen ====================
    function initLoader() {
        const loader = document.getElementById('loader');
        const particlesContainer = document.getElementById('loaderParticles');

        if (!loader || !particlesContainer) return;

        // Apply theme immediately for loader
        const stored = localStorage.getItem('theme');
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (stored === 'dark' || (!stored && prefersDark)) {
            document.body.classList.add('dark-mode');
        }

        // Create particles
        const particleCount = 30;
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'loader-particle';

            // Random positioning
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 3 + 's';
            particle.style.animationDuration = (2 + Math.random() * 2) + 's';

            particlesContainer.appendChild(particle);
        }

        // Hide loader when page is fully loaded
        window.addEventListener('load', () => {
            // Minimum display time of 1.5s (matches progress bar animation)
            setTimeout(() => {
                loader.classList.add('hidden');

                // Remove from DOM after transition
                setTimeout(() => {
                    loader.remove();
                }, 600);
            }, 1500);
        });
    }

    // ==================== Theme Toggle ====================
    function initTheme() {
        const toggle = document.getElementById('themeToggle');
        const toggleMobile = document.getElementById('themeToggleMobile');
        const body = document.body;

        // Check system preference
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)');

        // Get initial theme: user preference > system preference
        function getInitialTheme() {
            const stored = localStorage.getItem('theme');
            if (stored) return stored;
            return prefersDark.matches ? 'dark' : 'light';
        }

        // Apply theme
        function applyTheme(theme) {
            if (theme === 'dark') {
                body.classList.add('dark-mode');
            } else {
                body.classList.remove('dark-mode');
            }
            updateIcon(theme === 'dark');
        }

        // Initialize
        applyTheme(getInitialTheme());

        // Manual toggle handler
        function handleToggle() {
            const isDark = body.classList.toggle('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            updateIcon(isDark);
        }

        toggle?.addEventListener('click', handleToggle);
        toggleMobile?.addEventListener('click', handleToggle);

        // Listen for system preference changes (only if no user preference set)
        prefersDark.addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                applyTheme(e.matches ? 'dark' : 'light');
            }
        });

        function updateIcon(dark) {
            document.querySelectorAll('.theme-toggle i, .theme-toggle-mobile i').forEach(i => {
                i.className = dark ? 'fas fa-sun' : 'fas fa-moon';
            });
        }
    }

    // ==================== Mobile Navigation ====================
    function initNav() {
        const toggle = document.getElementById('navToggle');
        const nav = document.getElementById('navMobile');

        if (!toggle || !nav) return;

        const close = () => {
            toggle.classList.remove('active');
            nav.classList.remove('active');
            document.body.classList.remove('nav-open');
            document.body.style.overflow = '';
        };

        toggle.addEventListener('click', () => {
            const isOpen = nav.classList.contains('active');
            if (isOpen) {
                close();
            } else {
                toggle.classList.add('active');
                nav.classList.add('active');
                document.body.classList.add('nav-open');
                document.body.style.overflow = 'hidden';
            }
        });

        nav.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
        document.addEventListener('keydown', e => e.key === 'Escape' && close());
    }

    // ==================== Header Scroll ====================
    function initHeader() {
        const header = document.getElementById('header');
        if (!header) return;

        let ticking = false;

        function update() {
            header.classList.toggle('scrolled', window.scrollY > 100);
            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        });

        update();
    }

    // ==================== Hero Scroll Effects ====================
    function initParallax() {
        const heroContent = document.querySelector('.hero-content');
        const heroSocial = document.querySelector('.hero-social');
        const heroScroll = document.querySelector('.hero-scroll');
        const heroName = document.querySelector('.hero-name-side');

        if (!heroContent) return;

        let ticking = false;

        function update() {
            const scrolled = window.scrollY;
            const heroHeight = window.innerHeight;

            // Fade out hero elements on scroll
            if (scrolled < heroHeight) {
                const opacity = 1 - (scrolled / (heroHeight * 0.6));
                const translateY = scrolled * 0.3;

                heroContent.style.opacity = Math.max(0, opacity);
                heroContent.style.transform = `translateY(${translateY}px)`;

                if (heroSocial) heroSocial.style.opacity = Math.max(0, opacity);
                if (heroScroll) heroScroll.style.opacity = Math.max(0, opacity);
                if (heroName) heroName.style.opacity = Math.max(0, opacity * 0.5);
            }

            ticking = false;
        }

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(update);
                ticking = true;
            }
        });
    }

    // ==================== Reveal Animations ====================
    function initReveal() {
        const elements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');

        if (!elements.length) return;

        if (!('IntersectionObserver' in window)) {
            elements.forEach(el => el.classList.add('visible'));
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '0px 0px -80px 0px',
            threshold: 0.1
        });

        elements.forEach(el => observer.observe(el));
    }

    // ==================== Smooth Scroll ====================
    function initSmoothScroll() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (!href || href === '#') return;

                const target = document.querySelector(href);
                if (!target) return;

                e.preventDefault();

                const offset = 80;
                const top = target.getBoundingClientRect().top + window.scrollY - offset;

                window.scrollTo({ top, behavior: 'smooth' });
                history.pushState(null, '', href);
            });
        });
    }

    // ==================== Project Modal ====================
    function initProjectModal() {
        const modal = document.getElementById('projectModal');
        const modalClose = document.getElementById('modalClose');
        const modalTitle = document.getElementById('modalTitle');
        const modalImage = document.getElementById('modalImage');
        const modalDesc = document.getElementById('modalDesc');
        const modalYear = document.getElementById('modalYear');
        const modalCategory = document.getElementById('modalCategory');

        if (!modal) return;

        // Open modal on project click
        document.querySelectorAll('.project-card').forEach(card => {
            card.addEventListener('click', () => {
                const title = card.dataset.title;
                const image = card.dataset.image;
                const desc = card.dataset.desc;
                const year = card.dataset.year;
                const category = card.dataset.category;

                modalTitle.textContent = title;
                modalImage.src = image;
                modalImage.alt = title;
                modalDesc.textContent = desc;
                modalYear.textContent = year;
                modalCategory.textContent = category;

                modal.classList.add('active');
                document.body.classList.add('modal-open');
            });
        });

        // Close modal
        const closeModal = () => {
            modal.classList.remove('active');
            document.body.classList.remove('modal-open');
        };

        modalClose?.addEventListener('click', closeModal);

        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.classList.contains('active')) {
                closeModal();
            }
        });
    }

    // ==================== Resume Section Animations ====================
    function initResumeAnimations() {
        // Elements to animate
        const resumeItems = document.querySelectorAll('.resume-item');
        const skillTags = document.querySelectorAll('.skill-tag');
        const headers = document.querySelectorAll('.resume-block-header, .skills-section-header');

        if (!('IntersectionObserver' in window)) {
            // Fallback: show all immediately
            resumeItems.forEach(el => el.classList.add('visible'));
            skillTags.forEach(el => el.classList.add('visible'));
            headers.forEach(el => el.classList.add('visible'));
            return;
        }

        // Observer for resume items (staggered)
        const itemObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    itemObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -50px 0px', threshold: 0.1 });

        resumeItems.forEach(item => itemObserver.observe(item));
        headers.forEach(header => itemObserver.observe(header));

        // Observer for skill tags (wave effect with delays)
        const tagObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate all tags with staggered delay
                    const tags = entry.target.querySelectorAll('.skill-tag');
                    tags.forEach((tag, index) => {
                        setTimeout(() => {
                            tag.classList.add('visible');
                        }, index * 40); // 40ms stagger
                    });
                    tagObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -30px 0px', threshold: 0.1 });

        const skillsSection = document.querySelector('.skills-section');
        if (skillsSection) tagObserver.observe(skillsSection);

        // Observer for intro section elements
        const introElements = document.querySelectorAll('.intro-text, .intro-desc, .intro-btn');
        const introObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Staggered delay based on element type
                    const delay = entry.target.classList.contains('intro-text') ? 0 :
                        entry.target.classList.contains('intro-desc') ? 200 : 400;
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, delay);
                    introObserver.unobserve(entry.target);
                }
            });
        }, { rootMargin: '0px 0px -80px 0px', threshold: 0.1 });

        introElements.forEach(el => introObserver.observe(el));
    }

})();
