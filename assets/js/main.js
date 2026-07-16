(() => {
    const navigationLinks = Array.from(document.querySelectorAll('.sidebar__nav a[href^="#"]'));

    if (navigationLinks.length === 0) {
        return;
    }

    const navigationItems = navigationLinks
        .map((link) => ({
            link,
            section: document.querySelector(link.hash),
        }))
        .filter((item) => item.section !== null);

    if (navigationItems.length === 0) {
        return;
    }

    let animationFrame = null;

    const setActiveLink = (activeLink) => {
        navigationItems.forEach(({ link }) => {
            const isActive = link === activeLink;
            link.classList.toggle('is-active', isActive);

            if (isActive) {
                link.setAttribute('aria-current', 'location');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    };

    const updateActiveSection = () => {
        animationFrame = null;

        const referenceLine = window.innerHeight * 0.35;
        let activeItem = navigationItems[0];

        navigationItems.forEach((item) => {
            if (item.section.getBoundingClientRect().top <= referenceLine) {
                activeItem = item;
            }
        });

        const pageBottomReached = window.scrollY + window.innerHeight
            >= document.documentElement.scrollHeight - 2;

        if (pageBottomReached) {
            activeItem = navigationItems[navigationItems.length - 1];
        }

        setActiveLink(activeItem.link);
    };

    const scheduleUpdate = () => {
        if (animationFrame !== null) {
            return;
        }

        animationFrame = window.requestAnimationFrame(updateActiveSection);
    };

    window.addEventListener('scroll', scheduleUpdate, { passive: true });
    window.addEventListener('resize', scheduleUpdate);
    window.addEventListener('hashchange', scheduleUpdate);
    updateActiveSection();
})();
