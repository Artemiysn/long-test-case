-- формат date занимает меньше объема (3 байта), чем тот что необходим для unixtime (5 байтов для типа int)

CREATE TABLE `users` (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
   `gender` enum('0','m','f') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '0 - неопределено m - мужчина f - женщина',
   `birth_date` date NOT NULL,
   PRIMARY KEY (`id`)
);

create INDEX `birth_date_index`	on `users` (birth_date);