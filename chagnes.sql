ALTER TABLE `offerings` ADD `is_check` BOOLEAN NOT NULL DEFAULT FALSE AFTER `serial_no`, ADD `check_no` INT NULL DEFAULT NULL AFTER `is_check`, ADD `check_amount` INT NULL DEFAULT NULL AFTER `check_no`;

ALTER TABLE `offerings` DROP `is_check`;