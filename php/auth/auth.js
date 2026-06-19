document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');
    const simplepushKeyInput = document.getElementById('simplepush_key');

    usernameInput.addEventListener('input', function() {
        if (usernameInput.value.length > 12) {
            usernameInput.setCustomValidity('Username must be up to 12 characters');
        } else {
            usernameInput.setCustomValidity('');
        }
    });

    passwordInput.addEventListener('input', function() {
        if (passwordInput.value.length > 16) {
            passwordInput.setCustomValidity('Password must be up to 16 characters');
        } else {
            passwordInput.setCustomValidity('');
        }
    });

    simplepushKeyInput.addEventListener('input', function() {
        if (simplepushKeyInput.value.length != 6) {
            simplepushKeyInput.setCustomValidity('The Simplepush.io Key must be exactly 6 characters');
        } else {
            simplepushKeyInput.setCustomValidity('');
        }
    });

    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault(); 
        }
    });
});

windows.onload=function() {
    const err_msg = document.querySelector('.err_msg');
    err_msg.style.display = 'none';
}