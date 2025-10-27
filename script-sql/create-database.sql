CREATE TABLE `company` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(50),
  `email` varchar(50) UNIQUE,
  `phone` varchar(13),
  `web` varchar(20)
);

CREATE TABLE `vehicle` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `type` varchar(255),
  `capacity` integer,
  `plaque` varchar(255),
  `company_id` integer
);

CREATE TABLE `path` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `distance` integer,
  `duration` integer,
  `origin` varchar(255),
  `destination` varchar(255)
);

CREATE TABLE `schedule` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `departure_time` integer,
  `arrival_time` integer,
  `days` varchar(255)
);

CREATE TABLE `client` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255),
  `last_name` varchar(255),
  `document_type` integer UNIQUE,
  `document_number` integer,
  `email` varchar(255) UNIQUE,
  `phone` varchar(255)
);

CREATE TABLE `quotes` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `date` timestamp,
  `client_id` integer,
  `travel_id` integer
);

CREATE TABLE `tiquet` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `date` timestamp,
  `seat` integer,
  `final_price` varchar(255),
  `payment_method` varchar(255),
  `travel_id` integer,
  `client_id` integer
);

CREATE TABLE `travel` (
  `id` integer PRIMARY KEY AUTO_INCREMENT,
  `vehicle_id` integer,
  `path_id` integer,
  `schedule_id` integer,
  `value` varchar(255),
  `status` varchar(10)
);

ALTER TABLE `vehicle` ADD FOREIGN KEY (`company_id`) REFERENCES `company` (`id`);

ALTER TABLE `quotes` ADD FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

ALTER TABLE `quotes` ADD FOREIGN KEY (`travel_id`) REFERENCES `travel` (`id`);

ALTER TABLE `tiquet` ADD FOREIGN KEY (`travel_id`) REFERENCES `travel` (`id`);

ALTER TABLE `tiquet` ADD FOREIGN KEY (`client_id`) REFERENCES `client` (`id`);

ALTER TABLE `travel` ADD FOREIGN KEY (`vehicle_id`) REFERENCES `vehicle` (`id`);

ALTER TABLE `travel` ADD FOREIGN KEY (`path_id`) REFERENCES `path` (`id`);

ALTER TABLE `travel` ADD FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`);
