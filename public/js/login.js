(function () {
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');
    const loginBox = document.querySelector('.login-box');

    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', function () {
            loginBtn.classList.add('loading');
            loginBtn.disabled = true;
        });
    }

    if (loginBox) {
        window.addEventListener('scroll', function () {
            loginBox.style.transform = '';
        }, { passive: true });
    }
})();
