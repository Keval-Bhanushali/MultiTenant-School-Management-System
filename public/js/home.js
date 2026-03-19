(function () {
    const ctaButton = document.querySelector('.login-button');

    if (!ctaButton) {
        return;
    }

    ctaButton.addEventListener('pointerdown', function () {
        ctaButton.style.transform = 'translateY(-1px) scale(0.99)';
    });

    ctaButton.addEventListener('pointerup', function () {
        ctaButton.style.transform = '';
    });

    ctaButton.addEventListener('pointerleave', function () {
        ctaButton.style.transform = '';
    });
})();
