document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("login-Form");
    const registerForm = document.getElementById("register-Form");
    const registerBtn = document.getElementById("register-btn");
    const backLoginBtn = document.getElementById("back-login-btn");

    if (loginForm) {
        loginForm.addEventListener("submit", async function (event) {
            event.preventDefault();
            handleLogin();
        });
    }

    if (registerBtn) {
        registerBtn.addEventListener("click", function () {
            window.location.href = "register.html";
        });
    }
    
    if (registerForm) {
        registerForm.addEventListener("submit", async function (event) {
            event.preventDefault();
            handleRegister();
        });
    }
    
    
    if (backLoginBtn) {
        backLoginBtn.addEventListener("click", function () {
            window.location.href = "login.html";
            console.log("Back to login");
        });
    }
});

let username;
let password;


async function handleLogin() {
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;

    axios({
        method: "post",
        url: "http://localhost/cinematch/backend/login.php",
        data: new URLSearchParams({
            username: username,
            password: password,
        }),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    })
        .then((response) => {
            console.log(response.data);

            if (response.data.status === "Login Successful") {
                localStorage.setItem("username", username);
                localStorage.setItem("user_id", response.data.id);
                if (response.data.user_type_id === 1) {
                    window.location.href = "admin.html";
                } else {
                    window.location.href = "index.html";
                } 

            } else {
                document.getElementById("incorrect-password").innerHTML = '<p class="message-red">Invalid username or password.</p>'
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });
};


async function handleRegister() {
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;


    axios({
        method: "post",
        url: "http://localhost/cinematch/backend/register.php",
        data: new URLSearchParams({
            username: username,
            password: password,
        }),
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
    })
        .then((response) => {
            console.log(response.data);

            if (response.data.status === "Successful") {
                alert("Registration successful! You can now log in.");
                window.location.href = "login.html";
            } else {
                document.getElementById("register-status").innerHTML = '<p class="message-red">Registration failed. Please try again.</p>';
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });
}