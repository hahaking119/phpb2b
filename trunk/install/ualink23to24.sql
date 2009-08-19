ALTER TABLE eos_companies ADD `if_commend` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `clicked` ;
ALTER TABLE eos_trades ADD `ip_addr` VARCHAR( 11 ) NOT NULL DEFAULT '0';
ALTER TABLE eos_newses ADD `require_membertype` VARCHAR( 15 ) NOT NULL AFTER `status` ;
ALTER TABLE eos_members ADD `office_redirect` SMALLINT( 6 ) NOT NULL DEFAULT '0';
ALTER TABLE eos_companylinks ADD `user_name` VARCHAR( 25 ) NOT NULL DEFAULT '0' AFTER `member_id` ;
ALTER TABLE eos_expoes ADD `if_recommend` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE eos_keywords CHANGE `type` `type` ENUM( 'index', 'trades', 'companies', 'newses', 'markets', 'expoes', 'products' ) NOT NULL DEFAULT 'index';
ALTER TABLE eos_keywords CHANGE `primary_id` `primary_id` TEXT NOT NULL;

DROP TABLE IF EXISTS eos_visitlogs;
CREATE TABLE eos_visitlogs (
  id smallint(6) NOT NULL auto_increment,
  salt varchar(32) default NULL,
  date_line varchar(15) default NULL,
  type_name varchar(15) default NULL,
  PRIMARY KEY  (id),
  KEY salt (salt)
) TYPE=MyISAM;