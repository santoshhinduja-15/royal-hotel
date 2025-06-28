CREATE TABLE cancelled_bookings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  email VARCHAR(100),
  room_type VARCHAR(50),
  check_in DATE,
  check_out DATE,
  price DECIMAL(10,2),
  booking_date DATETIME,
  cancelled_at DATETIME
);
