CREATE TABLE `oauth_users` (
 `user_email` varchar(50) COLLATE utf8_bin NOT NULL,
 `oauth_id` varchar(50) COLLATE utf8_bin NOT NULL,
 `oauth_uname` varchar(75) COLLATE utf8_bin NOT NULL,
 `oauth_provider` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'facebook',
 PRIMARY KEY (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin

CREATE TABLE `user_auth_method` (
 `user_id` int(20) NOT NULL,
 `auth_method` varchar(25) COLLATE utf8_bin NOT NULL DEFAULT 'db',
 PRIMARY KEY (`user_id`),
 CONSTRAINT `user_auth_method_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin