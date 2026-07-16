(() => {
    const navigationLinks = Array.from(document.querySelectorAll('.sidebar__nav a[href^="#"]'));

    if (navigationLinks.length === 0 || !('IntersectionObserver' in window)) {
        return;
    }

    const sections = navigationLinks
        .map((link) => document.querySelector(link.hash))
        .filter((section) => section !== null);

    if (sections.length === 0) {
        return;
    }

    const setActiveSection = (sectionId) => {
        navigationLinks.forEach((link) => {
            const isActive = link.hash === `#${sectionId}`;
            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'location');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    const observer = new IntersectionObserver(
        (entries) => {
            const visibleSection = entries
                .filter((entry) => entry.isIntersecting)
                .sort((first, second) => second.intersectionRatio - first.intersectionRatio)[0];

            if (visibleSection) {
                setActiveSection(visibleSection.target.id);
            }
        },
        {
            rootMargin: '-20% 0px -55% 0px',
            threshold: [0.1, 0.35, 0.6],
        }
    );

    sections.forEach((section) => observer.observe(section));
})();
