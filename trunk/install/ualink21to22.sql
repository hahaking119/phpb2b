--
-- Table 'eos_htmlcaches'
--

DROP TABLE IF EXISTS eos_htmlcaches;
CREATE TABLE eos_htmlcaches (
  id int(5) NOT NULL auto_increment,
  h_n varchar(50) NOT NULL,
  h_l int(10) default NULL,
  h_r varchar(15) default '86400',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_expotypes'
--

DROP TABLE IF EXISTS eos_expotypes;
CREATE TABLE eos_expotypes (
  id int(5) NOT NULL auto_increment,
  name varchar(50) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

--
-- Table 'eos_keywordships'
--

DROP TABLE IF EXISTS eos_keywordships;
CREATE TABLE eos_keywordships (
  id int(10) NOT NULL auto_increment,
  ka int(10) default NULL,
  ki int(10) default NULL,
  kb int(10) default NULL,
  kc int(10) default NULL,
  kd int(10) default NULL,
  ke int(10) default NULL,
  kf tinyint(2) default '0',
  kg int(10) default NULL,
  kh int(10) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_pricequotes'
--

DROP TABLE IF EXISTS eos_pricequotes;
CREATE TABLE eos_pricequotes (
  id int(10) NOT NULL auto_increment,
  trade_id int(10) default NULL,
  member_id int(10) default NULL,
  price varchar(5) default NULL,
  content tinytext,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_attachments'
--

DROP TABLE IF EXISTS eos_attachments;
CREATE TABLE eos_attachments (
  id int(10) NOT NULL auto_increment,
  member_id int(10) default NULL,
  company_id int(10) default NULL,
  file_name char(100) default NULL,
  title char(50) default NULL,
  description char(100) default NULL,
  file_type char(50) default NULL,
  file_size smallint(6) default NULL,
  attachment varchar(100) default NULL,
  remote varchar(100) default NULL,
  is_image tinyint(1) default NULL,
  type_id tinyint(2) default NULL,
  status tinyint(1) default '0',
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

--
-- Table 'eos_stats'
--

DROP TABLE IF EXISTS eos_stats;
CREATE TABLE eos_stats (
  id smallint(6) NOT NULL auto_increment,
  sa varchar(25) default NULL,
  sb varchar(50) default NULL,
  description varchar(50) default NULL,
  sc int(10) default NULL,
  sd int(10) default NULL,
  se smallint(6) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

--
-- Table 'eos_ipbanned'
--

DROP TABLE IF EXISTS eos_ipbanned;
CREATE TABLE eos_ipbanned (
  id smallint(6) default NULL,
  ip1 smallint(3) default NULL,
  ip2 smallint(3) default NULL,
  ip3 smallint(3) default NULL,
  ip4 smallint(3) default NULL,
  created int(10) NOT NULL,
  expiration int(10) NOT NULL
) TYPE=MyISAM;

--
-- Table 'eos_maskwords'
--

DROP TABLE IF EXISTS eos_maskwords;
CREATE TABLE eos_maskwords (
  id smallint(6) NOT NULL auto_increment,
  title varchar(50) NOT NULL,
  replace_to varchar(50) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_terminologies'
--

DROP TABLE IF EXISTS eos_terminologies;
CREATE TABLE eos_terminologies (
  id int(10) NOT NULL,
  en_name varchar(100) default NULL,
  cn_name varchar(100) default NULL,
  pinyin varchar(100) default NULL,
  alias_name1 varchar(50) default NULL,
  alias_name2 varchar(50) default NULL,
  description tinytext,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_params'
--

DROP TABLE IF EXISTS eos_params;
CREATE TABLE eos_params (
  id smallint(6) NOT NULL auto_increment,
  paramtype_id smallint(6) default NULL,
  input_title varchar(50) default NULL,
  input_name varchar(25) default NULL,
  field_type tinyint(1) default NULL,
  input_size smallint(3) default NULL,
  input_maxlength smallint(3) default NULL,
  input_description varchar(50) default NULL,
  use_common tinyint(1) default NULL,
  priority smallint(3) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_paramtypes'
--

DROP TABLE IF EXISTS eos_paramtypes;
CREATE TABLE eos_paramtypes (
  id smallint(6) NOT NULL auto_increment,
  title varchar(25) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_expostadiums'
--

DROP TABLE IF EXISTS eos_expostadiums;
CREATE TABLE eos_expostadiums (
  id smallint(6) NOT NULL auto_increment,
  sa varchar(100) NOT NULL,
  country_id smallint(6) default NULL,
  province_id smallint(6) default NULL,
  city_id smallint(6) default NULL,
  sb varchar(200) default NULL,
  sc varchar(150) default NULL,
  sd varchar(150) default NULL,
  se varchar(150) default NULL,
  sf varchar(150) default NULL,
  sg mediumtext,
  sh smallint(6) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Table 'eos_companydeparts'
--

DROP TABLE IF EXISTS eos_companydeparts;
CREATE TABLE eos_companydeparts (
  id int(10) NOT NULL auto_increment,
  member_id int(10) NOT NULL,
  company_id int(10) NOT NULL,
  name varchar(50) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_companyemployees'
--

DROP TABLE IF EXISTS eos_companyemployees;
CREATE TABLE eos_companyemployees (
  id int(10) NOT NULL,
  company_id int(10) NOT NULL,
  login_name varchar(25) default NULL,
  true_name varchar(50) default NULL,
  position varchar(50) default NULL,
  attachment_id int(10) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

ALTER TABLE eos_trades ADD require_point SMALLINT( 6 ) NOT NULL DEFAULT '0',
ADD require_membertype SMALLINT( 6 ) NOT NULL DEFAULT '0',
ADD require_freedate INT( 10 ) NULL ;

ALTER TABLE eos_members ADD credit_point SMALLINT( 6 ) NOT NULL ;

ALTER TABLE eos_accesses ADD check_keyword_update TINYINT( 1 ) NOT NULL ,
ADD can_organize_groupbuy TINYINT( 1 ) NOT NULL ,
ADD default_livetime TINYINT( 2 ) NOT NULL ,
ADD after_livetime TINYINT( 2 ) NOT NULL ;

ALTER TABLE eos_companies ADD configs MEDIUMTEXT NOT NULL ;

ALTER TABLE eos_offers ADD user_name VARCHAR( 50 ) NOT NULL ,
ADD picture_remote VARCHAR( 50 ) NOT NULL ;

ALTER TABLE eos_indreccompanies ADD member_id INT( 10 ) NOT NULL ,
ADD user_name VARCHAR( 50 ) NOT NULL ;

ALTER TABLE eos_expos ADD if_recommend TINYINT( 1 ) NOT NULL,
CHANGE ew ew MEDIUMTEXT NOT NULL ;

ALTER TABLE eos_industries ADD priority TINYINT( 2 ) NOT NULL ,
ADD level TINYINT( 2 ) NOT NULL ;

ALTER TABLE eos_keywords ADD numbers SMALLINT( 6 ) NOT NULL ;

ALTER TABLE eos_adminlogs ADD PRIMARY KEY ( id ) ,
CHANGE id id INT( 10 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE eos_areas ADD english_name VARCHAR( 100 ) NOT NULL ;

ALTER TABLE eos_inqueries ADD exp_quantity VARCHAR( 15 ) NOT NULL ,
ADD exp_price VARCHAR( 15 ) NOT NULL ,
ADD ia TINYTEXT NOT NULL;

RENAME TABLE ualink_dbname.eos_logs TO ualink_dbname.eos_memberlogs ;

INSERT INTO eos_stats (`id`, `sa`, `sb`, `description`, `sc`, `sd`, `se`) VALUES
(1, 'total', 'buy', '求购总数', 1, NULL, NULL),
(2, 'total', 'buy_today', '今日求购总数', 1, NULL, NULL),
(3, 'total', 'sell', '供应总数', 1, NULL, NULL),
(4, 'total', 'sell_today', '今日供应数量', 1, NULL, NULL),
(5, 'total', 'product', '产品总数', 0, NULL, NULL),
(6, 'total', 'product_today', '今日新增产品', 0, NULL, NULL),
(7, 'total', 'company', '企业库总数', 0, NULL, NULL),
(8, 'total', 'company_today', '今日新增企业', 0, NULL, NULL),
(9, 'total', 'member', '会员总数', 0, NULL, NULL),
(10, 'total', 'member_today', '今日新增会员', 0, NULL, NULL);
