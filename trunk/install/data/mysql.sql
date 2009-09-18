--
-- 数据库: 'phpb2b' 2008-9-27 11:23
--

-- --------------------------------------------------------

--
-- Table 'pb_accesses'
--

DROP TABLE IF EXISTS pb_accesses;
CREATE TABLE pb_accesses (
  id tinyint(2) NOT NULL auto_increment,
  name varchar(25) default NULL,
  membertype_id tinyint(2) default NULL,
  max_sell tinyint(2) default '3',
  max_buy tinyint(2) default '3',
  max_product tinyint(2) default '3',
  max_job tinyint(2) default '3',
  max_news tinyint(2) default '3',
  max_producttype tinyint(2) default '3',
  max_of_rs_eday tinyint(2) default '3',
  check_trade_update tinyint(1) default '1',
  check_company_reg tinyint(1) default '1',
  check_company_update tinyint(1) default '1',
  check_product_update tinyint(1) default '1',
  check_job_update tinyint(1) default '1',
  check_news_update tinyint(1) default '1',
  check_keyword_update tinyint(1) default NULL,
  new_user_time smallint(6) default '0',
  max_room_favor tinyint(2) default '3',
  can_organize_groupbuy tinyint(1) default NULL,
  if_googlemap tinyint(1) default '0',
  default_livetime tinyint(2) default NULL,
  after_livetime tinyint(2) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_adminers'
--

DROP TABLE IF EXISTS pb_adminers;
CREATE TABLE pb_adminers (
  id tinyint(2) NOT NULL auto_increment,
  depart_id tinyint(2) default NULL,
  user_name varchar(25) default NULL,
  user_pass varchar(50) default NULL,
  first_name varchar(25) default NULL,
  last_name varchar(25) default NULL,
  email varchar(25) default NULL,
  level tinyint(1) default NULL,
  last_login int(11) default NULL,
  last_ip varchar(25) default NULL,
  created int(11) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY user_name (user_name)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_adminlogs'
--

DROP TABLE IF EXISTS pb_adminlogs;
CREATE TABLE pb_adminlogs (
  id int(10) NOT NULL auto_increment,
  adminer_id tinyint(2) default NULL,
  action_description tinytext,
  ip_address int(10) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_adminmodules'
--

DROP TABLE IF EXISTS pb_adminmodules;
CREATE TABLE pb_adminmodules (
  id int(5) NOT NULL auto_increment,
  parent_id int(5) default '0',
  name varchar(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_adminprivileges'
--

DROP TABLE IF EXISTS pb_adminprivileges;
CREATE TABLE pb_adminprivileges (
  id int(5) NOT NULL auto_increment,
  adminmodule_id int(5) default NULL,
  name varchar(25) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_adminroles'
--

DROP TABLE IF EXISTS pb_adminroles;
CREATE TABLE pb_adminroles (
  id tinyint(2) NOT NULL auto_increment,
  name varchar(25) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_adses'
--

DROP TABLE IF EXISTS pb_adses;
CREATE TABLE pb_adses (
  id int(5) NOT NULL auto_increment,
  adzone_id int(2) default NULL,
  member_id int(10) default NULL,
  title varchar(50) default NULL,
  description text,
  keywords varchar(50) default NULL,
  source_url varchar(100) default NULL,
  target_url varchar(100) default NULL,
  source_type varchar(20) default NULL,
  width smallint(6) default NULL,
  height smallint(6) default NULL,
  source_name varchar(50) default NULL,
  alt_words varchar(50) default NULL,
  start_date int(10) default NULL,
  end_date int(10) default NULL,
  priority tinyint(2) default NULL,
  status tinyint(1) default NULL,
  clicked smallint(6) default '1',
  target enum('_parent','_self','_blank') not null default '_blank',
  seq smallint(3) not null default '0',
  state tinyint(1) not null default '1',
  modified int(10) not null default '0',
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_adzones'
--

DROP TABLE IF EXISTS pb_adzones;
CREATE TABLE pb_adzones (
  id smallint(6) NOT NULL auto_increment,
  ua_zone_name varchar(15) default NULL,
  what varchar(10) default NULL,
  name varchar(100) default NULL,
  description text,
  additional_adwords text,
  price varchar(50) default NULL,
  file_name varchar(100) default NULL,
  width smallint(6) default NULL,
  height smallint(6) default NULL,
  wrap smallint(6) default '0',
  max_ad smallint(6) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------
--
-- Table 'pb_announcements'
--
DROP TABLE IF EXISTS pb_announcements;
CREATE TABLE pb_announcements (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `id_type` tinyint(1) NOT NULL default '0',
  `author` varchar(15) NOT NULL default '',
  `subject` varchar(255) NOT NULL default '',
  `message` text NOT NULL,
  `is_bold` tinyint(1) default '0',
  `is_highlight` tinyint(1) default '0',
  `member_group` varchar(255) NOT NULL default '',
  `displayorder` tinyint(3) NOT NULL default '0',
  `created` int(10) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL,
  `starttime` int(10) unsigned NOT NULL default '0',
  `endtime` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `timespan` (`starttime`,`endtime`)
) TYPE=MyISAM;

-- --------------------------------------------------------

-- 
-- 表的结构 pb_announcementtypes
-- 

DROP TABLE IF EXISTS pb_announcementtypes;
CREATE TABLE pb_announcementtypes (
  `id` smallint(3) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM COMMENT='公告类型' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------
--
-- Table 'pb_areas'
--

DROP TABLE IF EXISTS pb_areas;
CREATE TABLE pb_areas (
  id int(9) NOT NULL auto_increment,
  spelling varchar(15) default NULL,
  name varchar(50) default NULL,
  code_id int(9) default NULL,
  brief_name varchar(15) default NULL,
  english_name varchar(100) default NULL,
  tel_code varchar(15) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_attachments'
--

DROP TABLE IF EXISTS pb_attachments;
CREATE TABLE pb_attachments (
  id int(10) NOT NULL auto_increment,
  member_id int(10) default NULL,
  company_id int(10) default NULL,
  file_name char(100) default NULL,
  title char(50) default NULL,
  description char(100) default NULL,
  file_type char(50) default NULL,
  file_size mediumint(8) default NULL,
  attachment varchar(100) default NULL,
  remote varchar(100) default NULL,
  is_image tinyint(1) default NULL,
  type_id tinyint(2) default NULL,
  status tinyint(1) default '0',
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_companies'
--

DROP TABLE IF EXISTS pb_companies;
CREATE TABLE pb_companies (
  id int(9) NOT NULL auto_increment,
  member_id int(9) default NULL,
  industry_id int(3) default NULL,
  style_id tinyint(2) default '1',
  type_id tinyint(2) default '0',
  name char(100) default NULL,
  english_name char(100) default NULL,
  keywords varchar(50) default NULL,
  boss_name varchar(25) default NULL,
  manage_type varchar(25) default NULL,
  year_annual tinyint(2) default NULL,
  property tinyint(2) default NULL,
  description text,
  configs text,
  bank_from varchar(50) default NULL,
  bank_account varchar(50) default NULL,
  main_prod varchar(100) default NULL,
  employee_amount varchar(25) default NULL,
  found_date int(11) default NULL,
  reg_fund tinyint(2) default NULL,
  reg_address varchar(200) default NULL,
  country_id char(6) default NULL,
  province_code_id char(6) default NULL,
  city_code_id char(6) default NULL,
  address varchar(200) default NULL,
  zipcode varchar(15) default NULL,
  main_brand varchar(100) default NULL,
  main_market varchar(200) default NULL,
  main_biz_place varchar(50) default NULL,
  main_customer varchar(200) default NULL,
  link_man varchar(25) default NULL,
  link_man_gender tinyint(1) default NULL,
  position int(5) default NULL,
  telcode varchar(8) default NULL,
  telzone varchar(8) default NULL,
  tel varchar(25) default NULL,
  faxcode varchar(8) default NULL,
  faxzone varchar(8) default NULL,
  fax varchar(25) default NULL,
  mobile varchar(25) default NULL,
  email varchar(100) default NULL,
  site_url varchar(100) default NULL,
  picture varchar(50) default NULL,
  status tinyint(1) default '0',
  first_letter char(2) default NULL,
  if_commend tinyint(1) default null default '0',
  clicked int(5) default '1',
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id),
  KEY member_id (member_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_companydeparts'
--

DROP TABLE IF EXISTS pb_companydeparts;
CREATE TABLE pb_companydeparts (
  id int(10) NOT NULL auto_increment,
  member_id int(10) default NULL,
  company_id int(10) default NULL,
  name varchar(50) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_companyemployees'
--

DROP TABLE IF EXISTS pb_companyemployees;
CREATE TABLE pb_companyemployees (
  id int(10) NOT NULL auto_increment,
  company_id int(10) default NULL,
  login_name varchar(25) default NULL,
  true_name varchar(50) default NULL,
  position varchar(50) default NULL,
  attachment_id int(10) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_companylinks'
--

DROP TABLE IF EXISTS pb_companylinks;
CREATE TABLE pb_companylinks (
  id int(11) NOT NULL auto_increment,
  member_id int(11) default NULL,
  user_name varchar(25) default NULL,
  companyid1 int(9) default NULL,
  companyid2 int(9) default NULL,
  friendlogo varchar(100) default NULL,
  created int(11) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY my_company_link (member_id,companyid1,companyid2)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_companymessages'
--

DROP TABLE IF EXISTS pb_companymessages;
CREATE TABLE pb_companymessages (
  id int(11) NOT NULL auto_increment,
  from_member_id varchar(25) default NULL,
  to_member_id int(11) default NULL,
  title varchar(25) default NULL,
  content varchar(250) default NULL,
  grade tinyint(1) default '0',
  status tinyint(1) default '0',
  created int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_companynewses'
--

DROP TABLE IF EXISTS pb_companynewses;
CREATE TABLE pb_companynewses (
  id int(11) NOT NULL auto_increment,
  member_id int(11) default NULL,
  company_id int(11) default NULL,
  title varchar(100) default NULL,
  content text,
  picture varchar(100) default NULL,
  status tinyint(1) default '0',
  clicked int(5) default '1',
  created int(11) default NULL,
  modified int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_companyoutlinks'
--

DROP TABLE IF EXISTS pb_companyoutlinks;
CREATE TABLE pb_companyoutlinks (
  id int(11) NOT NULL auto_increment,
  member_id int(11) default NULL,
  company_id int(11) default NULL,
  name varchar(25) default NULL,
  url varchar(100) default NULL,
  created int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_companystyles'
--

DROP TABLE IF EXISTS pb_companystyles;
CREATE TABLE pb_companystyles (
  id tinyint(2) NOT NULL auto_increment,
  name varchar(50) default NULL,
  preview_pic varchar(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_companytypes'
--

DROP TABLE IF EXISTS pb_companytypes;
CREATE TABLE pb_companytypes (
  id tinyint(2) auto_increment,
  name varchar(50) default NULL,
  avaliable tinyint(1) NOT NULL default '1' ,
  picture varchar(50) default NULL,
  description text not null default '',
  status tinyint(1) not null default '1',
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_expoes'
--

DROP TABLE IF EXISTS pb_expoes;
CREATE TABLE pb_expoes (
  id int(10) NOT NULL auto_increment,
  ea varchar(100) default NULL,
  eb varchar(10) default NULL,
  country_id varchar(50) default NULL,
  province_id varchar(50) default NULL,
  city_id varchar(50) default NULL,
  ec varchar(150) default NULL,
  ed varchar(25) default NULL,
  ef varchar(25) default NULL,
  eg varchar(25) default NULL,
  eh varchar(50) default NULL,
  ei varchar(150) default NULL,
  ej varchar(100) default NULL,
  ek varchar(100) default NULL,
  el text,
  em varchar(100) default NULL,
  eo varchar(15) default NULL,
  ep varchar(25) default NULL,
  eq varchar(25) default NULL,
  email varchar(50) default NULL,
  er varchar(25) default NULL,
  es varchar(100) default NULL,
  et varchar(100) default NULL,
  eu varchar(100) default NULL,
  ev varchar(100) default NULL,
  ew text,
  ex varchar(100) default NULL,
  ey varchar(100) default NULL,
  picture varchar(50) default NULL,
  if_show_picture tinyint(1) default NULL,
  if_recommend tinyint(1) default NULL,
  type_id tinyint(2) default NULL,
  status tinyint(1) default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_expostadiums'
--

DROP TABLE IF EXISTS pb_expostadiums;
CREATE TABLE pb_expostadiums (
  id smallint(6) NOT NULL auto_increment,
  sa varchar(100) default NULL,
  country_id smallint(6) default NULL,
  province_id smallint(6) default NULL,
  city_id smallint(6) default NULL,
  sb varchar(200) default NULL,
  sc varchar(150) default NULL,
  sd varchar(150) default NULL,
  se varchar(150) default NULL,
  sf varchar(150) default NULL,
  sg text,
  sh smallint(6) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_expotypes'
--

DROP TABLE IF EXISTS pb_expotypes;
CREATE TABLE pb_expotypes (
  id int(5) NOT NULL auto_increment,
  name varchar(50) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_favorites'
--

DROP TABLE IF EXISTS pb_favorites;
CREATE TABLE pb_favorites (
  `id` int(10) NOT NULL auto_increment,
  `member_id` int(10) NOT NULL default '-1' COMMENT '会员编号',
  `target_id` int(10) default NULL,
  `type_id` tinyint(2) default NULL,
  `created` int(10) default NULL,
  `modified` int(10) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `member_favor` (`member_id`,`target_id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_forms'
--

DROP TABLE IF EXISTS pb_forms;
CREATE TABLE pb_forms (
  id smallint(6) NOT NULL auto_increment,
  field_title varchar(100) default NULL,
  field_type varchar(100) default NULL,
  field_size varchar(11) default NULL,
  field_maxlength varchar(11) default NULL,
  field_name varchar(50) default NULL,
  field_value varchar(50) default NULL,
  field_empty tinyint(1) default NULL,
  field_repeat tinyint(1) default NULL,
  field_intro varchar(100) default NULL,
  status tinyint(1) default NULL,
  priority tinyint(2) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_friendlinks'
--

DROP TABLE IF EXISTS pb_friendlinks;
CREATE TABLE pb_friendlinks (
  id int(5) NOT NULL auto_increment,
  title varchar(50) default NULL,
  logo varchar(100) default NULL,
  url varchar(50) default NULL,
  priority smallint(5) default '0',
  status tinyint(1) default '1',
  created int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_helps'
--

DROP TABLE IF EXISTS pb_helps;
CREATE TABLE pb_helps (
  `id` int(5) NOT NULL auto_increment,
  `helptype_id` int(5) default NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL default '1',
  `keywords` varchar(100) NOT NULL,
  `created` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_helptypes'
--

DROP TABLE IF EXISTS pb_helptypes;
CREATE TABLE pb_helptypes (
  `id` int(5) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `description` varchar(100) NOT NULL,
  `parent_id` smallint(3) NOT NULL default '0',
  `status` tinyint(1) NOT NULL default '1',
  `alias_name` varchar(100) NOT NULL,
  `created` int(10) NOT NULL,
  `modified` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_htmlcaches'
--

DROP TABLE IF EXISTS pb_htmlcaches;
CREATE TABLE pb_htmlcaches (
  `id` int(5) NOT NULL auto_increment,
  `page_name` varchar(100) NOT NULL,
  `last_cached_time` int(10) NOT NULL default '0',
  `cache_cycle_time` int(10) NOT NULL default '86400',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_indreccompanies'
--

DROP TABLE IF EXISTS pb_indreccompanies;
CREATE TABLE pb_indreccompanies (
  id int(10) NOT NULL auto_increment,
  industry_id int(10) default NULL,
  member_id int(10) default NULL,
  company_id int(10) default NULL,
  user_name varchar(25) default NULL,
  priority smallint(6) default '0',
  PRIMARY KEY  (id),
  KEY industry_id (industry_id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_industries'
--

DROP TABLE IF EXISTS pb_industries;
CREATE TABLE pb_industries (
  id int(5) NOT NULL auto_increment,
  name varchar(50) default NULL,
  parentid int(5) default NULL default '0',
  buy_amount int(9) default '0',
  sell_amount int(9) default '0',
  product_amount int(9) default '0',
  company_amount int(9) default '0',
  if_show_module tinyint(1) default '1',
  if_setby_market tinyint(1) default '1',
  level tinyint(2) default NULL,
  priority tinyint(2) default '0',
  created char(10) default 0,
  modified char(10) default 0,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_inqueries'
--

DROP TABLE IF EXISTS pb_inqueries;
CREATE TABLE pb_inqueries (
  id int(10) NOT NULL auto_increment,
  to_member_id int(10) default NULL,
  to_company_id int(10) default NULL,
  title varchar(50) default NULL,
  content tinytext,
  send_achive tinyint(1) default NULL,
  know_more varchar(50) default NULL,
  exp_quantity varchar(15) default NULL,
  exp_price varchar(15) default NULL,
  contacts tinytext,
  user_ip varchar(11) default NULL,
  created int(10) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_ipbanned'
--

DROP TABLE IF EXISTS pb_ipbanned;
CREATE TABLE pb_ipbanned (
  id smallint(6) default NULL,
  ip1 smallint(3) default NULL,
  ip2 smallint(3) default NULL,
  ip3 smallint(3) default NULL,
  ip4 smallint(3) default NULL,
  created int(10) default NULL,
  expiration int(10) default NULL
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_jobs'
--

DROP TABLE IF EXISTS pb_jobs;
CREATE TABLE pb_jobs (
  id int(10) NOT NULL auto_increment,
  member_id int(10) default NULL,
  company_id int(10) default NULL,
  name varchar(150) default NULL,
  work_station varchar(50) default NULL,
  content text,
  require_gender_id tinyint(1) default NULL,
  peoples varchar(5) default NULL,
  require_education_id tinyint(2) default NULL,
  require_age varchar(10) default NULL,
  salary_id tinyint(2) default NULL,
  worktype_id tinyint(1) default NULL,
  status tinyint(1) default '0',
  clicked int(5) default '0',
  created int(10) default NULL,
  expire_time int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_keywords'
--

DROP TABLE IF EXISTS pb_keywords;
CREATE TABLE pb_keywords (
  id int(5) NOT NULL auto_increment,
  primary_id TEXT default NULL,
  member_id int(10) default NULL,
  title varchar(25) default NULL,
  clicked smallint(6) default '1',
  numbers smallint(6) default NULL,
  status enum('1','0') default '0',
  type enum('index','trades','companies','newses','markets','expoes','products') default 'index',
  rank tinyint(1) default '0',
  created datetime default NULL,
  PRIMARY KEY  (id),
  KEY title (title)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_keywordships'
--

DROP TABLE IF EXISTS pb_keywordships;
CREATE TABLE pb_keywordships (
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

-- --------------------------------------------------------

--
-- Table 'pb_leavewords'
--

DROP TABLE IF EXISTS pb_leavewords;
CREATE TABLE pb_leavewords (
  id int(10) NOT NULL auto_increment,
  primary_id int(10) default NULL,
  member_id int(10) default NULL,
  title varchar(50) default NULL,
  content tinytext,
  type_id tinyint(1) default NULL,
  ip_address varchar(25) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_marketprice'
--

DROP TABLE IF EXISTS pb_marketprice;
CREATE TABLE pb_marketprice (
  id int(10) NOT NULL auto_increment,
  product_id int(10) default NULL,
  units varchar(25) default NULL,
  max_price smallint(6) default NULL,
  min_price smallint(6) default NULL,
  av_price smallint(6) default NULL,
  content tinytext,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_markets'
--

DROP TABLE IF EXISTS pb_markets;
CREATE TABLE pb_markets (
  id int(10) NOT NULL auto_increment,
  name varchar(200) binary NOT NULL,
  content text,
  industry_id int(5) default NULL,
  country_id int(5) default NULL,
  province_id int(5) default NULL,
  city_id int(5) default NULL,
  picture varchar(50) default NULL,
  area_id smallint(3) not null default '0',
  submit_ip int(10) not null default '0',
  mc tinyint(1) default NULL,
  md varchar(25) default NULL,
  status tinyint(1) default '0',
  clicked int(5) default '1',
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_maskwords'
--

DROP TABLE IF EXISTS pb_maskwords;
CREATE TABLE pb_maskwords (
  id smallint(6) NOT NULL auto_increment,
  title varchar(50) default NULL,
  replace_to varchar(50) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_memberlinks'
--

DROP TABLE IF EXISTS pb_memberlinks;
CREATE TABLE pb_memberlinks (
  id int(11) NOT NULL auto_increment,
  member_id int(11) default NULL,
  company_id int(11) default NULL,
  friend_company_id int(11) default NULL,
  logo varchar(25) default NULL,
  created int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_memberlogs'
--

DROP TABLE IF EXISTS pb_memberlogs;
CREATE TABLE pb_memberlogs (
  id int(11) NOT NULL auto_increment,
  member_id int(11) default NULL,
  type_id tinyint(1) default NULL,
  login_time varchar(11) default NULL,
  login_ip varchar(11) default NULL,
  description tinytext,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_members'
--

DROP TABLE IF EXISTS pb_members;
CREATE TABLE pb_members (
  id int(9) NOT NULL auto_increment,
  country_id int(5) default '0',
  province_code_id char(6) default '0',
  city_code_id char(6) default NULL,
  username varchar(25) default NULL,
  userpass varchar(50) default NULL,
  firstname varchar(25) default NULL,
  lastname varchar(25) default NULL,
  depart varchar(25) default NULL,
  position varchar(25) default '8',
  gender tinyint(1) default '0',
  tel varchar(25) default NULL,
  fax varchar(25) default NULL,
  mobile varchar(25) default NULL,
  qq varchar(12) default NULL,
  msn varchar(50) default NULL,
  icq varchar(12) default NULL,
  yahoo varchar(50) default NULL,
  address varchar(50) default NULL,
  zipcode varchar(16) default NULL,
  email varchar(100) default NULL,
  site_url varchar(100) default NULL,
  last_login varchar(11) default '0',
  today_logins int(5) default '0',
  total_logins int(10) default NULL,
  credit_level tinyint(1) default '0',
  credit_point smallint(6) default NULL,
  rank tinyint(2) default '0',
  status enum('3','2','1','0') default '0',
  photo varchar(100) NOT NULL default '',
  resume_status tinyint(1) NOT NULL default '0',
  max_education smallint(3) NOT NULL default '0',
  user_type tinyint(1) default '1',
  user_level tinyint(2) default '1',
  question varchar(50) default NULL,
  answer varchar(50) default NULL,
  reg_ip varchar(25) default NULL,
  last_ip varchar(25) default NULL,
  created varchar(11) default NULL,
  modified varchar(11) default NULL,
  service_start_date varchar(11) default NULL,
  service_end_date varchar(11) default NULL,
  office_redirect smallint(6) default '0',
  PRIMARY KEY  (id),
  UNIQUE KEY username (username)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_membertypes'
--

DROP TABLE IF EXISTS pb_membertypes;
CREATE TABLE pb_membertypes (
  id tinyint(2) NOT NULL auto_increment,
  access_id tinyint(2) default NULL,
  name varchar(50) default NULL,
  picture varchar(50) default 'default.gif',
  if_default tinyint(1) default NULL,
  if_index tinyint(1) default '0',
  price_every_year varchar(10) default NULL,
  status tinyint(1) default NULL,
  description text default NULL,
  mb tinyint(1) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_messages'
--

DROP TABLE IF EXISTS pb_messages;
CREATE TABLE pb_messages (
  id int(11) NOT NULL,
  trade_id int(11) default NULL,
  msg_content text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_newses'
--

DROP TABLE IF EXISTS pb_newses;
CREATE TABLE pb_newses (
  id int(9) NOT NULL auto_increment,
  type_id int(5) default NULL,
  html_file_id varchar(50) default NULL,
  title varchar(255) default NULL,
  content text,
  source varchar(25) default NULL,
  keywords varchar(100) default NULL,
  picture varchar(50) default NULL,
  if_focus tinyint(1) default '0',
  clicked int(10) default '1',
  status tinyint(1) default '1',
  require_membertype varchar(15) default '0',
  created int(10) default NULL,
  `create_time` datetime NOT NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_newstypes'
--

DROP TABLE IF EXISTS pb_newstypes;
CREATE TABLE pb_newstypes (
  id int(5) NOT NULL auto_increment,
  name varchar(25) NOT NULL,
  level_id tinyint(1) default '1',
  if_focus tinyint(1) default '0',
  status tinyint(1) default '1',
  parent_id smallint(3) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_offers'
--

DROP TABLE IF EXISTS pb_offers;
CREATE TABLE pb_offers (
  id int(10) NOT NULL auto_increment,
  trade_id int(10) default NULL,
  country_name varchar(50) default NULL,
  province_name varchar(50) default NULL,
  city_name varchar(50) default NULL,
  address varchar(100) default NULL,
  industry_name varchar(100) default NULL,
  user_name varchar(50) default NULL,
  company_name varchar(100) default NULL,
  link_man varchar(25) default NULL,
  gender tinyint(2) default NULL,
  prim_tel varchar(11) default NULL,
  prim_telnumber varchar(15) default NULL,
  prim_im varchar(11) default NULL,
  prim_imaccount varchar(25) default NULL,
  picture_remote varchar(50) default NULL,
  email varchar(50) default NULL,
  oa text,
  ob text,
  PRIMARY KEY  (id),
  UNIQUE KEY trade_id (trade_id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_orders'
--

DROP TABLE IF EXISTS pb_orders;
CREATE TABLE pb_orders (
  id int(10) NOT NULL auto_increment,
  product_id int(10) default NULL,
  member_id varchar(25) default NULL,
  company_id varchar(25) default NULL,
  year_option tinyint(2) default NULL,
  tel varchar(25) default NULL,
  email varchar(50) default NULL,
  content tinytext,
  status tinyint(1) default '0',
  oa tinyint(1) default NULL,
  ob tinyint(1) default NULL,
  oc tinyint(1) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_params'
--

DROP TABLE IF EXISTS pb_params;
CREATE TABLE pb_params (
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

-- --------------------------------------------------------

--
-- Table 'pb_paramtypes'
--

DROP TABLE IF EXISTS pb_paramtypes;
CREATE TABLE pb_paramtypes (
  id smallint(6) NOT NULL auto_increment,
  title varchar(25) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_pricequotes'
--

DROP TABLE IF EXISTS pb_pricequotes;
CREATE TABLE pb_pricequotes (
  id int(10) NOT NULL auto_increment,
  trade_id int(10) default NULL,
  member_id int(10) default NULL,
  price varchar(5) default NULL,
  content tinytext,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_products'
--

DROP TABLE IF EXISTS pb_products;
CREATE TABLE pb_products (
  id int(10) NOT NULL auto_increment,
  company_id int(10) default NULL default '0',
  member_id int(10) default NULL,
  industry_id int(5) default NULL,
  sort_id tinyint(1) default '1',
  html_file_id varchar(100) default NULL,
  province_id varchar(5) default NULL,
  city_id varchar(5) default NULL,
  name varchar(255) default NULL,
  sn varchar(20) default NULL,
  spec varchar(20) default NULL,
  produce_area varchar(50) default NULL,
  price varchar(15) default '0',
  packing_content varchar(100) default NULL,
  picture varchar(50) default NULL,
  picture_remote varchar(50) default NULL,
  content text,
  producttype_id int(5) default '0',
  status tinyint(2) default '0',
  state tinyint(2) default '1',
  ifnew tinyint(2) default '0',
  ifcommend tinyint(2) default '0',
  priority tinyint(2) default '0',
  keywords varchar(50) default NULL,
  clicked int(9) default '1',
  created int(11) default NULL,
  modified int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_producttypes'
--

DROP TABLE IF EXISTS pb_producttypes;
CREATE TABLE pb_producttypes (
  id int(11) NOT NULL auto_increment,
  member_id int(11) default NULL,
  company_id int(11) default NULL,
  name varchar(25) default NULL,
  level int(2) default '0',
  created int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_ranks'
--

DROP TABLE IF EXISTS pb_ranks;
CREATE TABLE pb_ranks (
  id int(10) NOT NULL auto_increment,
  from_member_id int(10) default NULL,
  to_member_id int(10) default NULL,
  rank tinyint(2) default '1',
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_roleadminers'
--

DROP TABLE IF EXISTS pb_roleadminers;
CREATE TABLE pb_roleadminers (
  id int(5) NOT NULL auto_increment,
  adminrole_id int(2) default NULL,
  adminer_id int(2) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_roleprivileges'
--

DROP TABLE IF EXISTS pb_roleprivileges;
CREATE TABLE pb_roleprivileges (
  id int(5) NOT NULL auto_increment,
  adminrole_id int(2) default NULL,
  adminprivilege_id int(2) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_services'
--

DROP TABLE IF EXISTS pb_services;
CREATE TABLE pb_services (
  id int(5) NOT NULL auto_increment,
  title varchar(25) default NULL,
  content text,
  nick_name varchar(25) default NULL,
  email varchar(25) default NULL,
  revert_content varchar(200) default NULL,
  adminer_user_name varchar(25) default NULL,
  type_id tinyint(2) default '0',
  status tinyint(2) default '0',
  user_ip varchar(11) default NULL,
  created int(11) default NULL,
  revert_date int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_sessions'
--

DROP TABLE IF EXISTS pb_sessions;
CREATE TABLE pb_sessions (
  id int(11) NOT NULL auto_increment,
  SESSKEY char(32) default NULL,
  EXPIRY int(11) default NULL,
  EXPIREREF char(64) default NULL,
  DATA text default NULL,
  PRIMARY KEY  (id),
  KEY sess2_expiry (EXPIRY),
  KEY sess2_expireref (EXPIREREF)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_settings'
--

DROP TABLE IF EXISTS pb_settings;
CREATE TABLE pb_settings (
  id int(11) NOT NULL auto_increment,
  variable varchar(150) default NULL,
  valued text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'pb_stats'
--  id smallint(6) NOT NULL auto_increment,
--  stat_type varchar(25) default NULL,
--  type_sign varchar(50) default NULL,
--  description varchar(50) default NULL,
--  amount int(10) default NULL,
--  last_stat_time int(10) default NULL,
--  created smallint(6) default NULL,
--  PRIMARY KEY  (id)


DROP TABLE IF EXISTS pb_stats;
CREATE TABLE pb_stats (
  id smallint(6) NOT NULL auto_increment,
  sa varchar(25) default NULL,
  sb varchar(50) default NULL,
  description varchar(50) default NULL,
  sc int(10) default NULL,
  sd int(10) default NULL,
  se smallint(6) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_templets'
--

DROP TABLE IF EXISTS pb_templets;
CREATE TABLE pb_templets (
  id int(5) NOT NULL auto_increment,
  title varchar(100) default NULL,
  description varchar(200) default NULL,
  picture varchar(100) default NULL,
  status tinyint(1) default '1',
  require_membertype varchar(25) NOT NULL default '',
  created int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_terminologies'
--

DROP TABLE IF EXISTS pb_terminologies;
CREATE TABLE pb_terminologies (
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

-- --------------------------------------------------------

--
-- Table 'pb_trades'
--

DROP TABLE IF EXISTS pb_trades;
CREATE TABLE pb_trades (
  id int(10) NOT NULL auto_increment,
  industry_id int(5) default '0',
  area_id int(5) default '0',
  member_id int(9) default '0',
  company_id int(5) default NULL,
  product_id int(5) default NULL,
  type_id enum('8','7','6','5','4','3','2','1') default '1',
  province_id int(5) default NULL,
  city_id int(5) default NULL,
  topic varchar(100) default NULL,
  content text,
  packing varchar(150) default NULL,
  price varchar(25) default NULL,
  quantity varchar(25) default NULL,
  offer_expire int(11) default '0',
  spec varchar(200) default NULL,
  sn varchar(25) default NULL,
  picture varchar(50) default NULL,
  keywords varchar(50) default NULL,
  status tinyint(2) default '0',
  submit_time varchar(10) default NULL,
  expire_time varchar(10) default NULL,
  expire_days int(3) default NULL,
  html_file_id varchar(50) default NULL,
  if_commend tinyint(1) default '0',
  if_urgent enum('0','1') default '0',
  if_locked enum('0','1') default '0',
  require_point smallint(6) default '0',
  require_membertype smallint(6) default '0',
  require_freedate int(10) default NULL,
  ip_addr varchar(18) default NULL,
  clicked int(10) default '1',
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'pb_userpages'
--

DROP TABLE IF EXISTS pb_userpages;
CREATE TABLE pb_userpages (
  id int(5) NOT NULL auto_increment,
  ua varchar(50) default NULL,
  ub varchar(50) default NULL,
  uc text,
  ud tinyint(2) default NULL,
  uf varchar(25) default NULL,
  ug varchar(50) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

DROP TABLE IF EXISTS pb_visitlogs;
CREATE TABLE pb_visitlogs (
  id smallint(6) NOT NULL auto_increment,
  salt varchar(32) default NULL,
  date_line varchar(15) default NULL,
  type_name varchar(15) default NULL,
  PRIMARY KEY  (id),
  KEY salt (salt)
) TYPE=MyISAM;