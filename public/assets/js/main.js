/* public/assets/js/main.js */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Initialize Lenis Smooth Scroll
    const lenis = new Lenis({
        duration: 1.2,
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
        direction: 'vertical',
        gestureDirection: 'vertical',
        smooth: true,
        mouseMultiplier: 1,
        smoothTouch: false,
        touchMultiplier: 2,
        infinite: false,
    });

    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }
    requestAnimationFrame(raf);

    // Expose lenis globally if needed
    window.lenis = lenis;

    // 2. Spotlight Hover Effect Mouse Tracker
    const updateSpotlight = (e) => {
        const cards = document.querySelectorAll('.spotlight-card');
        cards.forEach(card => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);
        });
    };
    window.addEventListener('mousemove', updateSpotlight);

    // 3. Navbar Dynamic Scroll Styling
    const header = document.querySelector('header');
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('bg-black/85', 'backdrop-blur-md', 'border-b', 'border-white/10', 'py-4');
                header.classList.remove('bg-transparent', 'py-6', 'border-transparent');
            } else {
                header.classList.add('bg-transparent', 'py-6', 'border-transparent');
                header.classList.remove('bg-black/85', 'backdrop-blur-md', 'border-b', 'border-white/10', 'py-4');
            }
        });
    }

    // 4. Custom Cinematic Canvas Particles
    initCinematicParticles();

    // 5. Setup Interactive Page Transitions (Overlay Trigger)
    setupPageTransitions();
});

/**
 * High-performance HTML5 Canvas floating particles
 */
function initCinematicParticles() {
    const canvas = document.getElementById('particles-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let particlesArray = [];
    let width = canvas.width = canvas.parentElement.offsetWidth;
    let height = canvas.height = canvas.parentElement.offsetHeight;

    window.addEventListener('resize', () => {
        if (canvas.parentElement) {
            width = canvas.width = canvas.parentElement.offsetWidth;
            height = canvas.height = canvas.parentElement.offsetHeight;
        }
    });

    class Particle {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.size = Math.random() * 1.5 + 0.5;
            this.speedX = Math.random() * 0.2 - 0.1;
            this.speedY = Math.random() * -0.4 - 0.1; // Float upwards slowly
            this.alpha = Math.random() * 0.5 + 0.2;
            this.decay = Math.random() * 0.002 + 0.001;
            this.color = Math.random() > 0.85 ? '#ED1C24' : '#FFFFFF'; // Mix in occasional red sparks
        }

        update() {
            this.x += this.speedX;
            this.y += this.speedY;

            // Fade in/out subtly
            if (this.y < 0) {
                this.y = height;
                this.x = Math.random() * width;
            }
            if (this.x < 0 || this.x > width) {
                this.speedX = -this.speedX;
            }
        }

        draw() {
            ctx.save();
            ctx.globalAlpha = this.alpha;
            ctx.fillStyle = this.color;
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        }
    }

    const init = () => {
        particlesArray = [];
        const numberOfParticles = Math.floor((width * height) / 15000);
        for (let i = 0; i < Math.min(numberOfParticles, 120); i++) {
            particlesArray.push(new Particle());
        }
    };

    const animate = () => {
        ctx.clearRect(0, 0, width, height);
        particlesArray.forEach(particle => {
            particle.update();
            particle.draw();
        });
        requestAnimationFrame(animate);
    };

    init();
    animate();
}

/**
 * Prepares smooth page transition triggers
 */
function setupPageTransitions() {
    const links = document.querySelectorAll('a:not([target="_blank"]):not([href^="#"]):not([href^="javascript:"]):not([href^="mailto:"])');
    const overlay = document.querySelector('.page-transition-overlay');
    if (!overlay) return;

    links.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            // If it is just an empty link or dashboard button triggering modal
            if (!href || href === '#' || href.includes('logout')) return;

            e.preventDefault();
            
            // GSAP page transition trigger
            gsap.to(overlay, {
                scaleY: 1,
                duration: 0.6,
                ease: 'power4.inOut',
                onComplete: () => {
                    window.location.href = href;
                }
            });
        });
    });

    // Animate transition out on load
    gsap.fromTo(overlay, { scaleY: 1 }, {
        scaleY: 0,
        duration: 0.6,
        ease: 'power4.inOut',
        transformOrigin: 'bottom'
    });
}
