function updateDashboard() {
  const params = new URLSearchParams(window.location.search);

  const totalBookings = params.get("bookings") || "0";
  const registeredUsers = params.get("users") || "0";
  const availableRooms = params.get("rooms") || "0";

  document.getElementById("totalBookings").textContent = totalBookings;
  document.getElementById("registeredUsers").textContent = registeredUsers;
  document.getElementById("availableRooms").textContent = availableRooms;
}
