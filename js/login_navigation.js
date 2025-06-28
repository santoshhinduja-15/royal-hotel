document.getElementById("loginForm").addEventListener("submit", function (e) {
    e.preventDefault();
  
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
  
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "login.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
    xhr.onload = function () {
      if (this.status === 200) {
        try {
          const response = JSON.parse(this.responseText);
          if (response.success) {
            // Check the role via session
            const roleCheck = new XMLHttpRequest();
            roleCheck.open("GET", "check_role.php", true);
            roleCheck.onload = function () {
              const role = this.responseText.trim();
              if (role === "admin") {
                window.location.href = "admin_dashboard.html";
              } else {
                window.location.href = "index.php";
              }
            };
            roleCheck.send();
          }
        } catch (err) {
          console.error("Parsing error", err);
        }
      }
    };
  
    xhr.send(`email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`);
  });
  