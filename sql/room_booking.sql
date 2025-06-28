CREATE TABLE `room_bookings` (
  `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `room_type` ENUM('single', 'double', 'deluxe', 'suite') NOT NULL,
  `check_in` DATE NOT NULL,
  `check_out` DATE NOT NULL,
  `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `booking_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
