document.addEventListener('DOMContentLoaded', function () {
    const roomTypeSelect = document.getElementById('roomType');
    const checkInDate = document.getElementById('checkIn');
    const checkOutDate = document.getElementById('checkOut');
    const priceField = document.getElementById('price');
    
    // Room price data (you can adjust the prices)
    const roomPrices = {
      single: 50,
      double: 80,
      deluxe: 120,
      suite: 200,
      "mountain-view": 150
    };
  
    // Function to calculate the price based on room type and dates
    function calculatePrice() {
      const roomType = roomTypeSelect.value;
      const checkIn = new Date(checkInDate.value);
      const checkOut = new Date(checkOutDate.value);
      
      if (!checkIn || !checkOut || checkIn >= checkOut) {
        return; // Return if dates are invalid
      }
  
      const nights = (checkOut - checkIn) / (1000 * 3600 * 24); // Calculate nights
      const pricePerNight = roomPrices[roomType];
      
      if (pricePerNight) {
        const totalPrice = pricePerNight * nights;
        priceField.value = totalPrice.toFixed(2); // Set the price field
      }
    }
  
    // Event listeners for calculating the price when the user changes the room type or dates
    roomTypeSelect.addEventListener('change', calculatePrice);
    checkInDate.addEventListener('change', calculatePrice);
    checkOutDate.addEventListener('change', calculatePrice);
  
    // Trigger the initial price calculation if the form is pre-filled
    calculatePrice();
  
    // Enable the cost field and submit the form on button click
    document.getElementById('submitBtn').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent form submission
      document.getElementById('price').disabled = false; // Enable the price field
      document.getElementById('bookingForm').submit(); // Submit the form
    });
  });
  