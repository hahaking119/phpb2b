--
-- Update for SP2
--
ALTER TABLE `eos_favorites` ADD `member_id` INT( 10 ) NOT NULL DEFAULT '-1' AFTER `id` ;
ALTER TABLE `eos_favorites` ADD UNIQUE `member_favor` ( `member_id` , `target_id` );