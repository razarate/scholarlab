CREATE TABLE IF NOT EXISTS `#__scholarlab_sensor_measurement` (
  `id` bigint NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `sensor_id` varchar(100) NOT NULL,
  `data` json NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp,
  `published` int(11) NOT NULL DEFAULT '0',
  CHECK (JSON_VALID(data))
);
