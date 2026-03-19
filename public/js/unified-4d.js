(function () {
    const canvases = Array.from(document.querySelectorAll('canvas[data-fx-network]'));

    const initNetwork = function (canvas) {
        if (!canvas) return;
        const context = canvas.getContext('2d');
        if (!context) return;

        const state = {
            particles: [],
            pointerX: null,
            pointerY: null
        };

        const resize = function () {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        };

        const createParticles = function () {
            const count = window.innerWidth > 1200 ? 110 : (window.innerWidth > 700 ? 80 : 55);
            state.particles = Array.from({ length: count }, function () {
                return {
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    vx: (Math.random() - 0.5) * 0.55,
                    vy: (Math.random() - 0.5) * 0.55,
                    radius: Math.random() * 1.8 + 0.6,
                    alpha: Math.random() * 0.45 + 0.18
                };
            });
        };

        const render = function () {
            context.clearRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < state.particles.length; i++) {
                const p = state.particles[i];
                p.x += p.vx;
                p.y += p.vy;

                if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
                if (p.y < 0 || p.y > canvas.height) p.vy *= -1;

                if (state.pointerX !== null && state.pointerY !== null) {
                    const dxPointer = state.pointerX - p.x;
                    const dyPointer = state.pointerY - p.y;
                    const pointerDist = Math.sqrt(dxPointer * dxPointer + dyPointer * dyPointer);
                    if (pointerDist < 140 && pointerDist > 0) {
                        p.vx -= (dxPointer / pointerDist) * 0.012;
                        p.vy -= (dyPointer / pointerDist) * 0.012;
                    }
                }

                context.beginPath();
                context.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                context.fillStyle = 'rgba(126, 214, 255, ' + p.alpha + ')';
                context.fill();

                for (let j = i + 1; j < state.particles.length; j++) {
                    const o = state.particles[j];
                    const dx = p.x - o.x;
                    const dy = p.y - o.y;
                    const dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 145) {
                        context.strokeStyle = 'rgba(45, 145, 255, ' + (0.16 * (1 - dist / 145)) + ')';
                        context.lineWidth = 0.7;
                        context.beginPath();
                        context.moveTo(p.x, p.y);
                        context.lineTo(o.x, o.y);
                        context.stroke();
                    }
                }
            }

            requestAnimationFrame(render);
        };

        resize();
        createParticles();
        render();

        window.addEventListener('resize', function () {
            resize();
            createParticles();
        });

        document.addEventListener('mousemove', function (event) {
            state.pointerX = event.clientX;
            state.pointerY = event.clientY;
        });

        document.addEventListener('mouseleave', function () {
            state.pointerX = null;
            state.pointerY = null;
        });
    };

    canvases.forEach(initNetwork);

    const addFocusEffects = function () {
        const focusable = document.querySelectorAll('input, select, textarea');
        focusable.forEach(function (field) {
            field.addEventListener('focus', function () {
                field.classList.add('focus-4d');
            });
            field.addEventListener('blur', function () {
                field.classList.remove('focus-4d');
            });
        });
    };

    const initTilt = function () {
        if (window.innerWidth < 992) return;

        const nodes = document.querySelectorAll('.fx-tilt, .hero, .login-box, .hero-content, .metric, .module-card');
        const applyTilt = function (node, event) {
            const rect = node.getBoundingClientRect();
            const localX = event.clientX - rect.left;
            const localY = event.clientY - rect.top;
            const centerX = rect.width / 2;
            const centerY = rect.height / 2;
            const rotateY = ((localX - centerX) / centerX) * 4.5;
            const rotateX = -((localY - centerY) / centerY) * 4.5;
            node.style.transform = 'perspective(920px) rotateX(' + rotateX.toFixed(2) + 'deg) rotateY(' + rotateY.toFixed(2) + 'deg) translateY(-2px)';
        };

        nodes.forEach(function (node) {
            node.addEventListener('mousemove', function (event) {
                applyTilt(node, event);
            });
            node.addEventListener('mouseleave', function () {
                node.style.transform = '';
            });
        });
    };

    const initAppearAnimations = function () {
        const animated = document.querySelectorAll('.hero-content, .login-box, .hero, .glass, .module-card, .metric, .chart-card');
        animated.forEach(function (node, idx) {
            if (!node.classList.contains('fx-appear')) {
                node.classList.add('fx-appear');
                node.style.animationDelay = (Math.min(idx, 12) * 0.05).toFixed(2) + 's';
            }
        });
    };

    addFocusEffects();
    initTilt();
    initAppearAnimations();
})();
