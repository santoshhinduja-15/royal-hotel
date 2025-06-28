document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("contactForm");
  const alertContainer = document.getElementById("alertContainer");

  // Handle validation on submit
  form.addEventListener("submit", function (e) {
    alertContainer.innerHTML = ""; // Clear previous alerts

    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message").value.trim();

    let errorMessage = "";

    if (name.length < 3) {
      errorMessage = "Name must be at least 3 characters.";
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
      errorMessage = "Please enter a valid email address.";
    } else if (message.length < 10) {
      errorMessage = "Message must be at least 10 characters.";
    }

    if (errorMessage !== "") {
      e.preventDefault(); // Stop form submission
      alertContainer.innerHTML = `
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          ${errorMessage}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      `;
    }
  });

  // Show success alert from URL query param
  const params = new URLSearchParams(window.location.search);
  if (params.has("success")) {
    alertContainer.innerHTML = `
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        Your message was sent successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    `;

    // Remove the success param so alert doesn't show again on refresh
    history.replaceState(null, "", window.location.pathname);
  }
});
