CREATE TABLE `phone_numbers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
  `user_id` int(11) NOT NULL COMMENT 'FOREIGN KEY for users',
  PRIMARY KEY (`id`)
);

alter table `phone_numbers`
	add constraint phone_numbers__fk
		foreign key (user_id) references users (id)
			on delete cascade;
