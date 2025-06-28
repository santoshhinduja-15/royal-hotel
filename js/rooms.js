document.addEventListener("DOMContentLoaded", () => {
    fetch("get_rooms.php")
      .then(response => response.json())
      .then(data => {
        const roomsContainer = document.getElementById("roomsContainer");
        data.forEach(room => {
          const roomHTML = `
            <div class="col-md-4">
              <div class="card room-card">
                <img src="${room.image}" class="card-img-top" alt="Room Image">
                <div class="card-body">
                  <h5 class="card-title">${room.room_type}</h5>
                  <p class="card-text">${room.description}</p>
                  <p><strong>Price:</strong> ₹${room.price_per_night} / night</p>
                </div>
              </div>
            </div>`;
          roomsContainer.innerHTML += roomHTML;
        });
      })
      .catch(error => console.error("Error fetching rooms:", error));
  });
  