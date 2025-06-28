function checkLogin(roomType) {
  fetch('auth.php')
    .then(response => response.json())
    .then(data => {
      if (data.isLoggedIn) {
        window.location.href = `booking.php?room=${roomType}`;
      } else {
        window.location.href = "login.php";
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert("An error occurred while checking login status.");
    });
}
