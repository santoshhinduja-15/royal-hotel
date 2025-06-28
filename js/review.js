document.addEventListener('DOMContentLoaded', function () {
  const reviewForm = document.getElementById('reviewForm');
  const alertContainer = document.getElementById('alertContainer');

  reviewForm.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(reviewForm);

    fetch('submit_review.php', {
      method: 'POST',
      body: formData
    })
      .then(response => response.json())
      .then(data => {
        let alertHTML = "";
        if (data.success) {
          alertHTML = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              Thank you for your review!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
          reviewForm.reset();
        } else {
          alertHTML = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              Something went wrong. Please try again.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`;
        }
        alertContainer.innerHTML = alertHTML;
      })
      .catch(error => {
        alertContainer.innerHTML = `
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Error: ${error}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>`;
      });
  });
});
