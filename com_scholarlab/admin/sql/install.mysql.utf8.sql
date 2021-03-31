CREATE TABLE IF NOT EXISTS `#__scholarlab_sensor_measurement` (
  `id` bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `sensor_type` varchar(100) NOT NULL,
  `sensorid` bigint NOT NULL,
  `data` json NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp,
  `published` tinyint(4) NOT NULL DEFAULT '1',
  CHECK (JSON_VALID(data))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `#__scholarlab_sensor_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `sensor_type` varchar(100) NOT NULL,
  `sensor_id` varchar(100) NOT NULL,
  `catid` int(11) NOT NULL DEFAULT 0,
  `published` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 DEFAULT COLLATE=utf8mb4_unicode_ci;