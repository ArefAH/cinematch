document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");
    const registerForm = document.getElementById("registerForm");
    const registerBtn = document.getElementById("registerBtn");
    const backLoginBtn = document.getElementById("back-login-Btn");

    if (loginForm) {
        loginForm.addEventListener("submit", async function (event) {
            event.preventDefault();
            handleLogin();
        });
    }

    if (registerForm) {
        registerForm.addEventListener("submit", async function (event) {
            event.preventDefault();
            handleRegister();
        });
    }

    if (registerBtn) {
        registerBtn.addEventListener("click", function () {
            window.location.href = "pages/register.html";
        });
    }
    if (backLoginBtn) {
        backLoginBtn.addEventListener("click", function () {
            window.location.href = "../index.html";
            console.log("Back to login");
        });
    }
});

let username;
let password;

