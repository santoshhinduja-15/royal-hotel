CREATE TABLE `room_inventory` (
  `room_type` ENUM('single', 'double', 'deluxe', 'suite') PRIMARY KEY,
  `total_rooms` INT NOT NULL
);

INSERT INTO `room_inventory` (`room_type`, `total_rooms`) VALUES
('single', 10),
('double', 8),
('deluxe', 5),
('suite', 3);
