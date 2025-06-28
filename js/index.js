document.addEventListener("DOMContentLoaded", function () {
  fetch("auth.php")
    .then(response => response.json())
    .then(data => {
      if (data.isLoggedIn) {
        document.getElementById("dashboard-link").style.display = "inline-block";
        document.getElementById("review-link").style.display = "inline-block";
        document.getElementById("logout-link").style.display = "inline-block";
        document.getElementById("login-link").style.display = "none";
        document.getElementById("register-link").style.display = "none";
      } else {
        // reset to logged-out state
        document.getElementById("dashboard-link").style.display = "none";
        document.getElementById("review-link").style.display = "none";
        document.getElementById("logout-link").style.display = "none";
        document.getElementById("login-link").style.display = "inline-block";
        document.getElementById("register-link").style.display = "inline-block";
      }
    })
    .catch(err => console.error("Error checking login status:", err));
});
