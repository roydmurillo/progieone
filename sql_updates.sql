ALTER TABLE `watch_users` ADD `user_phone` VARCHAR(15) NOT NULL DEFAULT '' AFTER `user_email`;
ALTER TABLE `watch_users` ADD `is_show` TINYINT(2) NOT NULL DEFAULT '0' AFTER `user_listprice_id`;