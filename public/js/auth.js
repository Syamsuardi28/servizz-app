// js/auth.js

document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const btnToggle = document.getElementById('btnTogglePassword');
    const txtPassword = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    if (btnToggle && txtPassword && eyeIcon) {
        btnToggle.addEventListener('click', function () {
            if (txtPassword.type === 'password') {
                txtPassword.type = 'text';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            } else {
                txtPassword.type = 'password';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            }
        });
    }
});
