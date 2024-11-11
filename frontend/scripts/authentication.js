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
                localStorage.setItem("username", response.data.username);
                localStorage.setItem("user_id", response.data.user_id);
                alert("Login successful! Redirecting...");
                // window.location.href = "/pages/home.html"; 
                console.log("worked");

            } else {
                document.getElementById("incorrect-password").innerHTML = '<p class="message-red">Invalid username or password.</p>'
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("An error occurred. Please try again.");
        });
};
