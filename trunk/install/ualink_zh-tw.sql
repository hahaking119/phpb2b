--
-- 數據庫: 'ualink'2008-9-27 11:23
--

-- --------------------------------------------------------

--
-- Table 'eos_accesses'
--

DROP TABLE IF EXISTS eos_accesses;
CREATE TABLE eos_accesses (
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
-- Table 'eos_adminers'
--

DROP TABLE IF EXISTS eos_adminers;
CREATE TABLE eos_adminers (
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
-- Table 'eos_adminlogs'
--

DROP TABLE IF EXISTS eos_adminlogs;
CREATE TABLE eos_adminlogs (
  id int(10) NOT NULL auto_increment,
  adminer_id tinyint(2) default NULL,
  action_description tinytext,
  ip_address int(10) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_adminmodules'
--

DROP TABLE IF EXISTS eos_adminmodules;
CREATE TABLE eos_adminmodules (
  id int(5) NOT NULL auto_increment,
  parent_id int(5) default '0',
  name varchar(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_adminprivileges'
--

DROP TABLE IF EXISTS eos_adminprivileges;
CREATE TABLE eos_adminprivileges (
  id int(5) NOT NULL auto_increment,
  adminmodule_id int(5) default NULL,
  name varchar(25) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_adminroles'
--

DROP TABLE IF EXISTS eos_adminroles;
CREATE TABLE eos_adminroles (
  id tinyint(2) NOT NULL auto_increment,
  name varchar(25) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_adses'
--

DROP TABLE IF EXISTS eos_adses;
CREATE TABLE eos_adses (
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
  da enum('_parent','_self','_blank') default '_blank',
  db tinyint(1) default NULL,
  dc tinyint(1) default NULL,
  de tinyint(1) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_adzones'
--

DROP TABLE IF EXISTS eos_adzones;
CREATE TABLE eos_adzones (
  id smallint(6) NOT NULL auto_increment,
  ua_zone_name varchar(15) default NULL,
  what varchar(10) default NULL,
  name varchar(100) default NULL,
  description text,
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
-- Table 'eos_areas'
--

DROP TABLE IF EXISTS eos_areas;
CREATE TABLE eos_areas (
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

-- --------------------------------------------------------

--
-- Table 'eos_companies'
--

DROP TABLE IF EXISTS eos_companies;
CREATE TABLE eos_companies (
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
-- Table 'eos_companydeparts'
--

DROP TABLE IF EXISTS eos_companydeparts;
CREATE TABLE eos_companydeparts (
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
-- Table 'eos_companyemployees'
--

DROP TABLE IF EXISTS eos_companyemployees;
CREATE TABLE eos_companyemployees (
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
-- Table 'eos_companylinks'
--

DROP TABLE IF EXISTS eos_companylinks;
CREATE TABLE eos_companylinks (
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
-- Table 'eos_companymessages'
--

DROP TABLE IF EXISTS eos_companymessages;
CREATE TABLE eos_companymessages (
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
-- Table 'eos_companynewses'
--

DROP TABLE IF EXISTS eos_companynewses;
CREATE TABLE eos_companynewses (
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
-- Table 'eos_companyoutlinks'
--

DROP TABLE IF EXISTS eos_companyoutlinks;
CREATE TABLE eos_companyoutlinks (
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
-- Table 'eos_companystyles'
--

DROP TABLE IF EXISTS eos_companystyles;
CREATE TABLE eos_companystyles (
  id tinyint(2) NOT NULL auto_increment,
  name varchar(50) default NULL,
  preview_pic varchar(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_companytypes'
--

DROP TABLE IF EXISTS eos_companytypes;
CREATE TABLE eos_companytypes (
  id tinyint(2) auto_increment,
  name varchar(50) default NULL,
  avaliable tinyint(1) NOT NULL default '1' ,
  picture varchar(50) default NULL,
  ca text default NULL,
  cb tinyint(1) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_expoes'
--

DROP TABLE IF EXISTS eos_expoes;
CREATE TABLE eos_expoes (
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
-- Table 'eos_expostadiums'
--

DROP TABLE IF EXISTS eos_expostadiums;
CREATE TABLE eos_expostadiums (
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
-- Table 'eos_expotypes'
--

DROP TABLE IF EXISTS eos_expotypes;
CREATE TABLE eos_expotypes (
  id int(5) NOT NULL auto_increment,
  name varchar(50) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_favorites'
--

DROP TABLE IF EXISTS eos_favorites;
CREATE TABLE eos_favorites (
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
-- Table 'eos_forms'
--

DROP TABLE IF EXISTS eos_forms;
CREATE TABLE eos_forms (
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
-- Table 'eos_friendlinks'
--

DROP TABLE IF EXISTS eos_friendlinks;
CREATE TABLE eos_friendlinks (
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
-- Table 'eos_helps'
--

DROP TABLE IF EXISTS eos_helps;
CREATE TABLE eos_helps (
  id int(5) NOT NULL auto_increment,
  helptype_id int(5) default NULL,
  ha varchar(100) default NULL,
  hb text,
  hd tinyint(1) default NULL,
  hk varchar(50) default NULL,
  he int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_helptypes'
--

DROP TABLE IF EXISTS eos_helptypes;
CREATE TABLE eos_helptypes (
  id int(5) NOT NULL auto_increment,
  ha varchar(100) default NULL,
  hb varchar(100) default NULL,
  hc int(5) default NULL,
  hd tinyint(1) default '1',
  he tinyint(1) default NULL,
  hf tinyint(1) default NULL,
  hg tinyint(1) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_htmlcaches'
--

DROP TABLE IF EXISTS eos_htmlcaches;
CREATE TABLE eos_htmlcaches (
  id int(5) NOT NULL auto_increment,
  h_n varchar(50) default NULL,
  h_l int(10) default NULL,
  h_r varchar(15) default '86400',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_indreccompanies'
--

DROP TABLE IF EXISTS eos_indreccompanies;
CREATE TABLE eos_indreccompanies (
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
-- Table 'eos_industries'
--

DROP TABLE IF EXISTS eos_industries;
CREATE TABLE eos_industries (
  id int(5) NOT NULL auto_increment,
  name varchar(50) default NULL,
  parentid int(5) default NULL default '0',
  buy_amount int(9) default '0',
  sell_amount int(9) default '0',
  product_amount int(9) default '0',
  company_amount int(9) default '0',
  ia tinyint(1) default '0',
  ib tinyint(1) default '0',
  level tinyint(2) default NULL,
  priority tinyint(2) default '0',
  created char(10) default 0,
  modified char(10) default 0,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_inqueries'
--

DROP TABLE IF EXISTS eos_inqueries;
CREATE TABLE eos_inqueries (
  id int(10) NOT NULL auto_increment,
  to_member_id int(10) default NULL,
  to_company_id int(10) default NULL,
  title varchar(50) default NULL,
  content tinytext,
  send_achive tinyint(1) default NULL,
  know_more varchar(50) default NULL,
  exp_quantity varchar(15) default NULL,
  exp_price varchar(15) default NULL,
  ia tinytext,
  user_ip varchar(11) default NULL,
  created int(10) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

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
  created int(10) default NULL,
  expiration int(10) default NULL
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_jobs'
--

DROP TABLE IF EXISTS eos_jobs;
CREATE TABLE eos_jobs (
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
  clicked int(5) default NULL,
  created int(10) default NULL,
  expire_time int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_keywords'
--

DROP TABLE IF EXISTS eos_keywords;
CREATE TABLE eos_keywords (
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

-- --------------------------------------------------------

--
-- Table 'eos_leavewords'
--

DROP TABLE IF EXISTS eos_leavewords;
CREATE TABLE eos_leavewords (
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
-- Table 'eos_marketprice'
--

DROP TABLE IF EXISTS eos_marketprice;
CREATE TABLE eos_marketprice (
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
-- Table 'eos_markets'
--

DROP TABLE IF EXISTS eos_markets;
CREATE TABLE eos_markets (
  id int(10) NOT NULL auto_increment,
  name varchar(200) binary NOT NULL,
  content text,
  industry_id int(5) default NULL,
  country_id int(5) default NULL,
  province_id int(5) default NULL,
  city_id int(5) default NULL,
  picture varchar(50) default NULL,
  ma tinyint(2) default NULL,
  mb tinyint(1) default NULL,
  mc tinyint(1) default NULL,
  md varchar(25) default NULL,
  status tinyint(1) default '0',
  clicked int(5) default '1',
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_maskwords'
--

DROP TABLE IF EXISTS eos_maskwords;
CREATE TABLE eos_maskwords (
  id smallint(6) NOT NULL auto_increment,
  title varchar(50) default NULL,
  replace_to varchar(50) default NULL,
  created int(10) default NULL,
  modified int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_memberlinks'
--

DROP TABLE IF EXISTS eos_memberlinks;
CREATE TABLE eos_memberlinks (
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
-- Table 'eos_memberlogs'
--

DROP TABLE IF EXISTS eos_memberlogs;
CREATE TABLE eos_memberlogs (
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
-- Table 'eos_members'
--

DROP TABLE IF EXISTS eos_members;
CREATE TABLE eos_members (
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
-- Table 'eos_membertypes'
--

DROP TABLE IF EXISTS eos_membertypes;
CREATE TABLE eos_membertypes (
  id tinyint(2) NOT NULL auto_increment,
  access_id tinyint(2) default NULL,
  name varchar(50) default NULL,
  picture varchar(50) default 'default.gif',
  if_default tinyint(1) default NULL,
  if_index tinyint(1) default '0',
  price_every_year varchar(10) default NULL,
  status tinyint(1) default NULL,
  ma text default NULL,
  mb tinyint(1) default NULL,
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_messages'
--

DROP TABLE IF EXISTS eos_messages;
CREATE TABLE eos_messages (
  id int(11) NOT NULL,
  trade_id int(11) default NULL,
  msg_content text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_newses'
--

DROP TABLE IF EXISTS eos_newses;
CREATE TABLE eos_newses (
  id int(9) NOT NULL auto_increment,
  type_id int(5) default NULL,
  html_file_id varchar(50) default NULL,
  title varchar(50) default NULL,
  content text,
  source varchar(25) default NULL,
  keywords varchar(100) default NULL,
  picture varchar(50) default NULL,
  if_focus tinyint(1) default '0',
  clicked int(11) default '1',
  status tinyint(1) default '1',
  require_membertype varchar(15) default '0',
  created int(11) default NULL,
  modified int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_newstypes'
--

DROP TABLE IF EXISTS eos_newstypes;
CREATE TABLE eos_newstypes (
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
-- Table 'eos_offers'
--

DROP TABLE IF EXISTS eos_offers;
CREATE TABLE eos_offers (
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
-- Table 'eos_orders'
--

DROP TABLE IF EXISTS eos_orders;
CREATE TABLE eos_orders (
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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table 'eos_products'
--

DROP TABLE IF EXISTS eos_products;
CREATE TABLE eos_products (
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
  content tinytext,
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
-- Table 'eos_producttypes'
--

DROP TABLE IF EXISTS eos_producttypes;
CREATE TABLE eos_producttypes (
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
-- Table 'eos_ranks'
--

DROP TABLE IF EXISTS eos_ranks;
CREATE TABLE eos_ranks (
  id int(10) NOT NULL auto_increment,
  from_member_id int(10) default NULL,
  to_member_id int(10) default NULL,
  rank tinyint(2) default '1',
  created int(10) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

--
-- Table 'eos_roleadminers'
--

DROP TABLE IF EXISTS eos_roleadminers;
CREATE TABLE eos_roleadminers (
  id int(5) NOT NULL auto_increment,
  adminrole_id int(2) default NULL,
  adminer_id int(2) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_roleprivileges'
--

DROP TABLE IF EXISTS eos_roleprivileges;
CREATE TABLE eos_roleprivileges (
  id int(5) NOT NULL auto_increment,
  adminrole_id int(2) default NULL,
  adminprivilege_id int(2) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- Table 'eos_services'
--

DROP TABLE IF EXISTS eos_services;
CREATE TABLE eos_services (
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
-- Table 'eos_sessions'
--

DROP TABLE IF EXISTS eos_sessions;
CREATE TABLE eos_sessions (
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
-- Table 'eos_settings'
--

DROP TABLE IF EXISTS eos_settings;
CREATE TABLE eos_settings (
  id int(11) NOT NULL auto_increment,
  aa varchar(50) default NULL,
  ab text,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table 'eos_templets'
--

DROP TABLE IF EXISTS eos_templets;
CREATE TABLE eos_templets (
  id int(5) NOT NULL auto_increment,
  title varchar(100) default NULL,
  description varchar(200) default NULL,
  picture varchar(100) default NULL,
  status tinyint(1) default '1',
  created int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM ;

-- --------------------------------------------------------

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

-- --------------------------------------------------------

--
-- Table 'eos_trades'
--

DROP TABLE IF EXISTS eos_trades;
CREATE TABLE eos_trades (
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
  if_urgent enum('0','1') default '0',
  if_locked enum('0','1') default '0',
  if_commend tinyint(1) default '0',
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
-- Table 'eos_userpages'
--

DROP TABLE IF EXISTS eos_userpages;
CREATE TABLE eos_userpages (
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

DROP TABLE IF EXISTS eos_visitlogs;
CREATE TABLE eos_visitlogs (
  id smallint(6) NOT NULL auto_increment,
  salt varchar(32) default NULL,
  date_line varchar(15) default NULL,
  type_name varchar(15) default NULL,
  PRIMARY KEY  (id),
  KEY salt (salt)
) TYPE=MyISAM;

INSERT INTO eos_industries (`id`, `name`, `parentid`, `buy_amount`, `sell_amount`, `product_amount`, `company_amount`, `ia`, `ib`) VALUES
(1, '紡織、皮革', 0, 0, 0, 0, 489, 1, 0),
(2, '服裝、服飾', 0, 0, 0, 0, 0, 1, 0),
(3, '機械及工業制品', 0, 0, 0, 0, 0, 1, 0),
(4, '禮品、工藝品', 0, 0, 0, 0, 0, 1, 0),
(5, '化工', 0, 0, 0, 0, 0, 1, 0),
(6, '家用電器', 0, 0, 0, 0, 0, 1, 0),
(7, '包裝、紙', 0, 0, 0, 0, 0, 1, 0),
(8, '電子電工', 0, 0, 0, 0, 0, 1, 0),
(9, '建築、房地産', 0, 0, 0, 0, 0, 1, 0),
(10, '農業', 0, 0, 0, 0, 0, 1, 0),
(11, '冶金、礦産', 0, 0, 0, 0, 0, 1, 0),
(12, '醫藥、保養', 0, 0, 0, 0, 0, 1, 0),
(13, '安全、防護', 0, 0, 0, 0, 0, 1, 0),
(14, '汽摩及配件', 0, 0, 0, 0, 0, 1, 0),
(15, '印刷、出版', 0, 0, 0, 0, 0, 1, 0),
(16, '食品、飲料', 0, 0, 0, 0, 0, 1, 0),
(17, '電腦、軟件', 0, 0, 0, 0, 0, 1, 0),
(18, '家居用品', 0, 0, 0, 0, 0, 1, 0),
(19, '辦公、文教及光儀', 0, 0, 0, 0, 0, 1, 0),
(20, '能源', 0, 0, 0, 0, 0, 1, 0),
(21, '環保', 0, 0, 0, 0, 0, 1, 0),
(22, '通訊産品', 0, 0, 0, 0, 0, 1, 0),
(23, '運動、休閑', 0, 0, 0, 0, 0, 1, 0),
(24, '商務服務', 0, 0, 0, 0, 0, 1, 0),
(25, '交通運輸', 0, 0, 0, 0, 0, 1, 0),
(26, '玩具', 0, 0, 0, 0, 0, 1, 0),
(27, '庫存商品', 0, 0, 0, 0, 0, 1, 0),
(101, '廚房用紡織品', 1, 1, 2, 3, 4, 1, 1),
(102, '床上用品', 1, 0, 0, 0, 0, 1, 1),
(103, '紡織、皮革加工', 1, 0, 0, 0, 0, 1, 0),
(104, '紡織廢料', 1, 0, 0, 0, 0, NULL, 1),
(105, '紡織輔料', 1, 0, 0, 0, 0, NULL, 1),
(106, '紡織工藝品', 1, 0, 0, 0, 0, NULL, 1),
(107, '紡織皮革相關項目合作', 1, 0, 0, 0, 0, NULL, 1),
(108, '紡織設備和器材', 1, 0, 0, 0, 0, NULL, 1),
(109, '非織造及工業用布', 1, 0, 0, 0, 0, NULL, 1),
(110, '化纖面料、裏料', 1, 0, 0, 0, 0, NULL, 1),
(111, '化學纖維', 1, 0, 0, 0, 0, NULL, 1),
(112, '混紡、交織類面料', 1, 0, 0, 0, 0, NULL, 1),
(113, '庫存紡織品', 1, 0, 0, 0, 0, NULL, 1),
(114, '麻類系列面料', 1, 0, 0, 0, 0, NULL, 1),
(115, '毛紡系列面料', 1, 0, 0, 0, 0, NULL, 0),
(116, '毛巾', 1, 0, 0, 0, 0, NULL, 0),
(117, '棉類系列面料', 1, 0, 0, 0, 0, NULL, 0),
(118, '坯布', 1, 0, 0, 0, 0, NULL, 0),
(119, '皮革廢料', 1, 0, 0, 0, 0, NULL, 0),
(120, '皮革及人造皮革', 1, 0, 0, 0, 0, NULL, 0),
(121, '皮革加工設備', 1, 0, 0, 0, 0, NULL, 0),
(122, '皮革助劑', 1, 0, 0, 0, 0, NULL, 0),
(123, '其他', 1, 0, 0, 0, 0, NULL, 0),
(124, '其他面料', 1, 0, 0, 0, 0, NULL, 0),
(125, '色織、紮染、印花布', 1, 0, 0, 0, 0, NULL, 0),
(126, '紗線', 1, 0, 0, 0, 0, NULL, 0),
(127, '生皮、毛皮（皮革原料）', 1, 0, 0, 0, 0, NULL, 0),
(128, '絲綢系列面料', 1, 0, 0, 0, 0, NULL, 0),
(129, '毯子', 1, 0, 0, 0, 0, NULL, 0),
(130, '天然紡織原料', 1, 0, 0, 0, 0, NULL, 0),
(131, '箱包、袋、皮具', 1, 0, 0, 0, 0, NULL, 0),
(132, '針織面料', 1, 0, 0, 0, 0, NULL, 0),
(133, '裝飾用紡織品', 1, 0, 0, 0, 0, NULL, 0),
(134, '服裝輔料', 2, 0, 0, 0, 0, 1, 0),
(135, '時尚飾品', 2, 0, 0, 0, 0, 1, 0),
(136, '內衣', 2, 0, 0, 0, 0, 1, 0),
(137, '女裝', 2, 0, 0, 0, 0, NULL, 0),
(138, '女包系列', 2, 0, 0, 0, 0, NULL, 0),
(139, '手套', 2, 0, 0, 0, 0, NULL, 0),
(140, 'T恤', 2, 0, 0, 0, 0, NULL, 0),
(141, '襯衣', 2, 0, 0, 0, 0, NULL, 0),
(142, '襪子', 2, 0, 0, 0, 0, NULL, 0),
(143, '牛仔服裝', 2, 0, 0, 0, 0, NULL, 0),
(144, '休閑服裝', 2, 0, 0, 0, 0, NULL, 0),
(145, '毛衣', 2, 0, 0, 0, 0, NULL, 0),
(146, '腰包', 2, 0, 0, 0, 0, NULL, 0),
(147, '庫存鞋及鞋材', 2, 0, 0, 0, 0, NULL, 0),
(148, '領帶', 2, 0, 0, 0, 0, NULL, 0),
(149, '羽絨服裝、防寒服', 2, 0, 0, 0, 0, NULL, 0),
(150, '整熨洗滌設備', 2, 0, 0, 0, 0, NULL, 0),
(151, '服裝鞋帽代理', 2, 0, 0, 0, 0, NULL, 0),
(152, '梭織服裝', 2, 0, 0, 0, 0, NULL, 0),
(153, '嬰兒服裝', 2, 0, 0, 0, 0, NULL, 0),
(154, '夾克', 2, 0, 0, 0, 0, NULL, 0),
(155, '鞋加工及修理設備', 2, 0, 0, 0, 0, NULL, 0),
(156, '婚紗、禮服', 2, 0, 0, 0, 0, NULL, 0),
(157, '外衣、外套', 2, 0, 0, 0, 0, NULL, 0),
(158, '鞋及鞋材', 2, 0, 0, 0, 0, NULL, 0),
(159, '庫存服飾', 2, 0, 0, 0, 0, NULL, 0),
(160, '圍巾、頭巾', 2, 0, 0, 0, 0, NULL, 0),
(161, '兒童服裝', 2, 0, 0, 0, 0, NULL, 0),
(162, '針織服裝', 2, 0, 0, 0, 0, NULL, 0),
(163, '帽子', 2, 0, 0, 0, 0, NULL, 0),
(164, '服飾鞋帽加工', 2, 0, 0, 0, 0, NULL, 0),
(165, '服裝加工設備', 2, 0, 0, 0, 0, NULL, 0),
(166, '工作服、制服', 2, 0, 0, 0, 0, NULL, 0),
(167, '品牌服裝', 2, 0, 0, 0, 0, NULL, 0),
(168, '運動服裝', 2, 0, 0, 0, 0, NULL, 0),
(169, '褲子', 2, 0, 0, 0, 0, NULL, 0),
(170, '皮革、毛皮服裝', 2, 0, 0, 0, 0, NULL, 0),
(171, '睡衣、浴衣', 2, 0, 0, 0, 0, NULL, 0),
(172, '羊毛、羊絨衫', 2, 0, 0, 0, 0, NULL, 0),
(173, '男裝', 2, 0, 0, 0, 0, NULL, 0),
(174, '服飾鞋帽項目合作', 2, 0, 0, 0, 0, NULL, 0),
(175, '特制服裝', 2, 0, 0, 0, 0, NULL, 0),
(176, '絲綢服裝', 2, 0, 0, 0, 0, NULL, 0),
(177, '民族服裝', 2, 0, 0, 0, 0, NULL, 0),
(178, '西服', 2, 0, 0, 0, 0, NULL, 0),
(179, '大衣、風衣', 2, 0, 0, 0, 0, NULL, 0),
(180, '其他', 2, 0, 0, 0, 0, NULL, 0),
(181, '行業專用機械及設備', 3, 0, 0, 0, 0, NULL, 0),
(182, '五金工具', 3, 0, 0, 0, 0, NULL, 0),
(183, '泵及真空設備', 3, 0, 0, 0, 0, NULL, 0),
(184, '機械加工', 3, 0, 0, 0, 0, NULL, 0),
(185, '焊接、切割設備與材料', 3, 0, 0, 0, 0, 1, 0),
(186, '通用零部件', 3, 0, 0, 0, 0, 1, 0),
(187, '儀器、儀表', 3, 0, 0, 0, 0, NULL, 0),
(188, '發電機、發電機組', 3, 0, 0, 0, 0, NULL, 0),
(189, '磨具、磨料', 3, 0, 0, 0, 0, NULL, 0),
(190, '模具', 3, 0, 0, 0, 0, NULL, 0),
(191, '液壓機械及部件', 3, 0, 0, 0, 0, NULL, 0),
(192, '電動工具', 3, 0, 0, 0, 0, NULL, 0),
(193, '換熱、制冷空調設備', 3, 0, 0, 0, 0, NULL, 0),
(194, '壓縮、分離設備', 3, 0, 0, 0, 0, NULL, 0),
(195, '風機、排風設備', 3, 0, 0, 0, 0, NULL, 0),
(196, '鍋爐及配件裝置', 3, 0, 0, 0, 0, NULL, 0),
(197, '氣動工具', 3, 0, 0, 0, 0, NULL, 0),
(198, '減速機、變速機', 3, 0, 0, 0, 0, NULL, 0),
(199, '節能裝置', 3, 0, 0, 0, 0, NULL, 0),
(200, '機械制品代理', 3, 0, 0, 0, 0, NULL, 0),
(201, '機械及工業制品項目合作', 3, 0, 0, 0, 0, NULL, 0),
(202, '內燃機', 3, 0, 0, 0, 0, NULL, 0),
(203, '工業用量器量具', 3, 0, 0, 0, 0, NULL, 0),
(204, '其他', 3, 0, 0, 0, 0, NULL, 0),
(205, '寶石玉石工藝品', 4, 0, 0, 0, 0, NULL, 0),
(206, '殡葬用品', 4, 0, 0, 0, 0, NULL, 0),
(207, '玻璃工藝品', 4, 0, 0, 0, 0, NULL, 0),
(208, '打火機、煙具', 4, 0, 0, 0, 0, NULL, 0),
(209, '雕刻工藝品', 4, 0, 0, 0, 0, NULL, 0),
(210, '雕塑', 4, 0, 0, 0, 0, 1, 0),
(211, '仿古工藝品', 4, 0, 0, 0, 0, 1, 0),
(212, '仿生工藝品', 4, 0, 0, 0, 0, 1, 0),
(213, '紡織工藝品', 4, 0, 0, 0, 0, NULL, 0),
(214, '工藝禮品', 4, 0, 0, 0, 0, NULL, 0),
(215, '古董和收藏品', 4, 0, 0, 0, 0, NULL, 0),
(216, '廣告禮品', 4, 0, 0, 0, 0, NULL, 0),
(217, '婚慶、節日用品', 4, 0, 0, 0, 0, NULL, 0),
(218, '紀念品', 4, 0, 0, 0, 0, NULL, 0),
(219, '金屬工藝品', 4, 0, 0, 0, 0, NULL, 0),
(220, '蠟燭及燭台', 4, 0, 0, 0, 0, NULL, 0),
(221, '禮品、工藝品代理', 4, 0, 0, 0, 0, NULL, 0),
(222, '禮品、工藝品項目合作', 4, 0, 0, 0, 0, NULL, 0),
(223, '禮品袋', 4, 0, 0, 0, 0, NULL, 0),
(224, '禮品工藝品加工', 4, 0, 0, 0, 0, NULL, 0),
(225, '民間工藝品', 4, 0, 0, 0, 0, NULL, 0),
(226, '泥塑工藝品', 4, 0, 0, 0, 0, NULL, 0),
(227, '盆景', 4, 0, 0, 0, 0, NULL, 0),
(228, '其他未分類', 4, 0, 0, 0, 0, NULL, 0),
(229, '旗幟', 4, 0, 0, 0, 0, NULL, 0),
(230, '石料工藝品', 4, 0, 0, 0, 0, NULL, 0),
(231, '時尚飾品', 4, 0, 0, 0, 0, NULL, 0),
(232, '樹脂工藝品', 4, 0, 0, 0, 0, NULL, 0),
(233, '水晶工藝品', 4, 0, 0, 0, 0, NULL, 0),
(234, '塑料工藝品', 4, 0, 0, 0, 0, NULL, 0),
(235, '陶瓷工藝品', 4, 0, 0, 0, 0, NULL, 0),
(236, '天然工藝品', 4, 0, 0, 0, 0, NULL, 0),
(237, '玩具', 4, 0, 0, 0, 0, NULL, 0),
(238, '相框、畫框', 4, 0, 0, 0, 0, NULL, 0),
(239, '熏香及熏香爐', 4, 0, 0, 0, 0, NULL, 0),
(240, '鑰匙扣、鏈', 4, 0, 0, 0, 0, NULL, 0),
(241, '針鈎及編結工藝品', 4, 0, 0, 0, 0, NULL, 0),
(242, '植物編織工藝品', 4, 0, 0, 0, 0, NULL, 0),
(243, '紙制工藝品', 4, 0, 0, 0, 0, NULL, 0),
(244, '鍾表', 4, 0, 0, 0, 0, NULL, 0),
(245, '珠寶首飾、金銀器', 4, 0, 0, 0, 0, NULL, 0),
(246, '竹木工藝品', 4, 0, 0, 0, 0, NULL, 0),
(247, '裝飾盒', 4, 0, 0, 0, 0, NULL, 0),
(248, '字畫', 4, 0, 0, 0, 0, NULL, 0),
(249, '宗教工藝品', 4, 0, 0, 0, 0, NULL, 0),
(250, '無機化工原料', 5, 0, 0, 0, 0, 0, 0),
(251, '有機化工原料', 5, 0, 0, 0, 0, 0, 0),
(252, '塑料原料', 5, 0, 0, 0, 0, 0, 0),
(253, '橡膠原料', 5, 0, 0, 0, 0, 0, 0),
(254, '其他樹脂', 5, 0, 0, 0, 0, 1, 0),
(255, '醫藥原料、中間體', 5, 0, 0, 0, 0, 1, 0),
(256, '石油及制品', 5, 0, 0, 0, 0, 1, 0),
(257, '化工助劑', 5, 0, 0, 0, 0, 1, 0),
(258, '食品添加劑', 5, 0, 0, 0, 0, 0, 0),
(259, '飼料添加劑', 5, 0, 0, 0, 0, 0, 0),
(260, '催化劑', 5, 0, 0, 0, 0, 0, 0),
(261, '化學試劑', 5, 0, 0, 0, 0, 0, 0),
(262, '玻璃', 5, 0, 0, 0, 0, 0, 0),
(263, '油墨', 5, 0, 0, 0, 0, 0, 0),
(264, '肥料', 5, 0, 0, 0, 0, 0, 0),
(265, '農藥', 5, 0, 0, 0, 0, 0, 0),
(266, '生物化工', 5, 0, 0, 0, 0, 0, 0),
(267, '陶瓷', 5, 0, 0, 0, 0, 0, 0),
(268, '實驗室用品', 5, 0, 0, 0, 0, 0, 0),
(269, '火工産品', 5, 0, 0, 0, 0, 0, 0),
(270, '其他聚合物', 5, 0, 0, 0, 0, 0, 0),
(271, '塑料制品', 5, 0, 0, 0, 0, 0, 0),
(272, '橡膠制品', 5, 0, 0, 0, 0, 0, 0),
(273, '日用化學品', 5, 0, 0, 0, 0, 0, 0),
(274, '聚氨脂', 5, 0, 0, 0, 0, 0, 0),
(275, '膠粘劑', 5, 0, 0, 0, 0, 0, 0),
(276, '化學纖維', 5, 0, 0, 0, 0, 0, 0),
(277, '染料', 5, 0, 0, 0, 0, 0, 0),
(278, '塗料', 5, 0, 0, 0, 0, 0, 0),
(279, '顔料', 5, 0, 0, 0, 0, 0, 0),
(280, '香料、香精', 5, 0, 0, 0, 0, 0, 0),
(281, '化工設備', 5, 0, 0, 0, 0, 0, 0),
(282, '塑料生産加工設備', 5, 0, 0, 0, 0, 0, 0),
(283, '化工廢料', 5, 0, 0, 0, 0, 0, 0),
(284, '庫存化工品', 5, 0, 0, 0, 0, 0, 0),
(285, '化工産品加工', 5, 0, 0, 0, 0, 0, 0),
(286, '化工産品代理', 5, 0, 0, 0, 0, 0, 0),
(287, '化工項目合作', 5, 0, 0, 0, 0, 0, 0),
(288, '其他', 5, 0, 0, 0, 0, 0, 0),
(289, '視聽器材', 6, 0, 0, 0, 0, 0, 0),
(290, '冰箱、冷櫃', 6, 0, 0, 0, 0, 0, 0),
(291, '飲水機', 6, 0, 0, 0, 0, 0, 0),
(292, '電扇、排氣扇', 6, 0, 0, 0, 0, 1, 0),
(293, '電熱壺、電熱杯', 6, 0, 0, 0, 0, 1, 0),
(294, '熱水器', 6, 0, 0, 0, 0, 1, 0),
(295, '濕度調節器', 6, 0, 0, 0, 0, 0, 0),
(296, '電驅蟲器', 6, 0, 0, 0, 0, 0, 0),
(297, '庫存家用電器', 6, 0, 0, 0, 0, 0, 0),
(298, '消毒櫃', 6, 0, 0, 0, 0, 0, 0),
(299, '家用電器産品代理', 6, 0, 0, 0, 0, 0, 0),
(300, '榨汁機', 6, 0, 0, 0, 0, 0, 0),
(301, '抽油煙機', 6, 0, 0, 0, 0, 0, 0),
(302, '家電項目合作', 6, 0, 0, 0, 0, 0, 0),
(303, '空氣淨化器', 6, 0, 0, 0, 0, 0, 0),
(304, '空調', 6, 0, 0, 0, 0, 0, 0),
(305, '取暖電器', 6, 0, 0, 0, 0, 0, 0),
(306, '淨水器', 6, 0, 0, 0, 0, 0, 0),
(307, '電炊具', 6, 0, 0, 0, 0, 0, 0),
(308, '遙控器', 6, 0, 0, 0, 0, 0, 0),
(309, '電吹風', 6, 0, 0, 0, 0, 0, 0),
(310, '吸塵器', 6, 0, 0, 0, 0, 0, 0),
(311, '咖啡機、豆漿機、面包機', 6, 0, 0, 0, 0, 0, 0),
(312, '洗衣、幹衣設備', 6, 0, 0, 0, 0, 0, 0),
(313, '電熨鬥', 6, 0, 0, 0, 0, 0, 0),
(314, '幹手機、給皂液機', 6, 0, 0, 0, 0, 0, 0),
(315, '攪拌機', 6, 0, 0, 0, 0, 0, 0),
(316, '家電制造設備', 6, 0, 0, 0, 0, 0, 0),
(317, '氧氣機', 6, 0, 0, 0, 0, 0, 0),
(318, '微波爐', 6, 0, 0, 0, 0, 0, 0),
(319, '家用電器加工', 6, 0, 0, 0, 0, 0, 0),
(320, '洗碗機', 6, 0, 0, 0, 0, 0, 0),
(321, '其他', 6, 0, 0, 0, 0, 0, 0),
(322, '塑料包裝用品', 7, 0, 0, 0, 0, 0, 0),
(323, '紙制包裝用品', 7, 0, 0, 0, 0, 0, 0),
(324, '膠帶', 7, 0, 0, 0, 0, 0, 0),
(325, '包裝用紙', 7, 0, 0, 0, 0, 0, 0),
(326, '金屬包裝用品', 7, 0, 0, 0, 0, 0, 0),
(327, '家用紙品', 7, 0, 0, 0, 0, 0, 0),
(328, '木制包裝用品', 7, 0, 0, 0, 0, 0, 0),
(329, '文化用紙', 7, 0, 0, 0, 0, 0, 0),
(330, '廢紙', 7, 0, 0, 0, 0, 0, 0),
(331, '包裝、紙品加工', 7, 0, 0, 0, 0, 0, 0),
(332, '複合材料包裝用品', 7, 0, 0, 0, 0, 1, 0),
(333, '壁紙', 7, 0, 0, 0, 0, 1, 0),
(334, '包裝、紙品代理', 7, 0, 0, 0, 0, 0, 0),
(335, '包裝相關設備', 7, 0, 0, 0, 0, 0, 0),
(336, '包裝材料', 7, 0, 0, 0, 0, 0, 0),
(337, '標簽、標牌', 7, 0, 0, 0, 0, 0, 0),
(338, '其他用途紙', 7, 0, 0, 0, 0, 0, 0),
(339, '紙品加工機械', 7, 0, 0, 0, 0, 0, 0),
(340, '托盤', 7, 0, 0, 0, 0, 0, 0),
(341, '玻璃包裝用品', 7, 0, 0, 0, 0, 0, 0),
(342, '造紙設備', 7, 0, 0, 0, 0, 0, 0),
(343, '造紙助劑', 7, 0, 0, 0, 0, 0, 0),
(344, '索具', 7, 0, 0, 0, 0, 0, 0),
(345, '造紙原料', 7, 0, 0, 0, 0, 0, 0),
(346, '麻制包裝用品', 7, 0, 0, 0, 0, 0, 0),
(347, '包裝品、紙品相關項目合作', 7, 0, 0, 0, 0, 0, 0),
(348, '其他', 7, 0, 0, 0, 0, 0, 0),
(349, '電子元器件、組件', 8, 0, 0, 0, 0, 0, 0),
(350, '儀器、儀表', 8, 0, 0, 0, 1, 0, 0),
(351, '電線電纜', 8, 0, 0, 0, 0, 0, 0),
(352, '電動機', 8, 0, 0, 0, 0, 0, 0),
(353, '工業自動化裝置', 8, 0, 0, 0, 0, 0, 0),
(354, '電熱設備', 8, 0, 0, 0, 0, 0, 0),
(355, '電子電工産品制造設備', 8, 0, 0, 0, 0, 0, 0),
(356, '充電器', 8, 0, 0, 0, 0, 0, 0),
(357, '廣電、電信設備', 8, 0, 0, 0, 0, 0, 0),
(358, '電子電工産品加工', 8, 0, 0, 0, 0, 1, 0),
(359, '光電子、激光儀器', 8, 0, 0, 0, 0, 1, 0),
(360, '天線', 8, 0, 0, 0, 0, 0, 0),
(361, '電子工業用助劑', 8, 0, 0, 0, 0, 0, 0),
(362, '光儀及配件', 8, 0, 0, 0, 0, 0, 0),
(363, '電子電工項目合作', 8, 0, 0, 0, 0, 0, 0),
(364, '照明與燈具', 8, 0, 0, 0, 0, 0, 0),
(365, '電池', 8, 0, 0, 0, 0, 0, 0),
(366, '發電機、發電機組', 8, 0, 0, 0, 0, 0, 0),
(367, '插頭、插座', 8, 0, 0, 0, 0, 0, 0),
(368, '電動工具', 8, 0, 0, 0, 0, 0, 0),
(369, '磁性材料', 8, 0, 0, 0, 0, 0, 0),
(370, '絕緣材料', 8, 0, 0, 0, 0, 0, 0),
(371, '配電裝置、開關櫃、照明箱', 8, 0, 0, 0, 0, 0, 0),
(372, '開關電源', 8, 0, 0, 0, 0, 0, 0),
(373, '庫存電子産品', 8, 0, 0, 0, 0, 0, 0),
(374, '顯示設備', 8, 0, 0, 0, 0, 0, 0),
(375, '半導體材料', 8, 0, 0, 0, 0, 0, 0),
(376, '電工陶瓷材料', 8, 0, 0, 0, 0, 0, 0),
(377, '輸電設備及材料', 8, 0, 0, 0, 0, 0, 0),
(378, '電子電工産品代理', 8, 0, 0, 0, 0, 0, 0),
(379, '雷達及無線導航', 8, 0, 0, 0, 0, 0, 0),
(380, '其他', 8, 0, 0, 0, 0, 0, 0),
(381, '衛浴設施', 9, 0, 0, 0, 0, 0, 0),
(382, '管件管材', 9, 0, 0, 0, 0, 0, 0),
(383, '石材石料', 9, 0, 0, 0, 0, 0, 0),
(384, '木材板材', 9, 0, 0, 0, 0, 0, 0),
(385, '作業保護', 9, 0, 0, 0, 0, 0, 0),
(386, '陶瓷、搪瓷及制品', 9, 0, 0, 0, 0, 0, 0),
(387, '地板', 9, 0, 0, 0, 0, 0, 0),
(388, '絕緣材料', 9, 0, 0, 0, 0, 0, 0),
(389, '堆垛搬運機械', 9, 0, 0, 0, 0, 0, 0),
(390, '塑料建材', 9, 0, 0, 0, 0, 0, 0),
(391, '防水、防潮材料', 9, 0, 0, 0, 0, 0, 0),
(392, '牆體材料、天花板', 9, 0, 0, 0, 0, 0, 0),
(393, '隔熱、吸聲材料', 9, 0, 0, 0, 0, 0, 0),
(394, '廚房設施', 9, 0, 0, 0, 0, 1, 0),
(395, '磚、瓦及砌塊', 9, 0, 0, 0, 0, 1, 0),
(396, '裝潢設計', 9, 0, 0, 0, 0, 0, 0),
(397, '活動房', 9, 0, 0, 0, 0, 0, 0),
(398, '石灰、石膏', 9, 0, 0, 0, 0, 0, 0),
(399, '混凝土及制品', 9, 0, 0, 0, 0, 0, 0),
(400, '陶瓷、搪瓷生産加工機械', 9, 0, 0, 0, 0, 0, 0),
(401, '建材加工', 9, 0, 0, 0, 0, 0, 0),
(402, '壁紙', 9, 0, 0, 0, 0, 0, 0),
(403, '塗料', 9, 0, 0, 0, 0, 0, 0),
(404, '膠粘劑', 9, 0, 0, 0, 0, 0, 0),
(405, '建築及相關設備', 9, 0, 0, 0, 0, 0, 0),
(406, '建築裝飾五金', 9, 0, 0, 0, 0, 0, 0),
(407, '門窗', 9, 0, 0, 0, 0, 0, 0),
(408, '鎖具', 9, 0, 0, 0, 0, 0, 0),
(409, '不動産', 9, 0, 0, 0, 0, 0, 0),
(410, '耐火、防火材料', 9, 0, 0, 0, 0, 0, 0),
(411, '金屬建材', 9, 0, 0, 0, 0, 0, 0),
(412, '特種建材', 9, 0, 0, 0, 0, 0, 0),
(413, '建築玻璃', 9, 0, 0, 0, 0, 0, 0),
(414, '木材加工、家具制造機械', 9, 0, 0, 0, 0, 0, 0),
(415, '工程承包', 9, 0, 0, 0, 0, 0, 0),
(416, '水泥及制品', 9, 0, 0, 0, 0, 0, 0),
(417, '施工材料', 9, 0, 0, 0, 0, 0, 0),
(418, '建築項目合作', 9, 0, 0, 0, 0, 0, 0),
(419, '裝飾建材代理', 9, 0, 0, 0, 0, 0, 0),
(420, '其他未分類', 9, 0, 0, 0, 0, 0, 0),
(421, '動植物種苗', 10, 0, 0, 0, 0, 0, 0),
(422, '水果及制品', 10, 0, 0, 0, 0, 0, 0),
(423, '茶葉及制品', 10, 0, 0, 0, 0, 0, 0),
(424, '花木', 10, 0, 0, 0, 0, 0, 0),
(425, '園藝用具', 10, 0, 0, 0, 0, 0, 0),
(426, '植物提取物', 10, 0, 0, 0, 0, 0, 0),
(427, '食用菌', 10, 0, 0, 0, 0, 1, 0),
(428, '牲畜', 10, 0, 0, 0, 0, 1, 0),
(429, '飼料添加劑', 10, 0, 0, 0, 0, 0, 0),
(430, '生皮、毛皮（皮革原料）', 10, 0, 0, 0, 0, 0, 0),
(431, '動植物油', 10, 0, 0, 0, 0, 0, 0),
(432, '棉類', 10, 0, 0, 0, 0, 0, 0),
(433, '漁業設備及用具', 10, 0, 0, 0, 0, 0, 0),
(434, '畜牧養殖業設備及用具', 10, 0, 0, 0, 0, 0, 0),
(435, '羽毛、羽絨', 10, 0, 0, 0, 0, 0, 0),
(436, '竹木、藤葦、幹草', 10, 0, 0, 0, 0, 0, 0),
(437, '禽蛋', 10, 0, 0, 0, 0, 0, 0),
(438, '毛絨', 10, 0, 0, 0, 0, 0, 0),
(439, '蠶繭、蠶絲', 10, 0, 0, 0, 0, 0, 0),
(440, '麻類', 10, 0, 0, 0, 0, 0, 0),
(441, '動物提取物', 10, 0, 0, 0, 0, 0, 0),
(442, '腸衣', 10, 0, 0, 0, 0, 0, 0),
(443, '蔬菜及制品', 10, 0, 0, 0, 0, 0, 0),
(444, '糧食', 10, 0, 0, 0, 0, 1, 0),
(445, '水産及制品', 10, 0, 0, 0, 0, 0, 0),
(446, '農藥', 10, 0, 0, 0, 0, 0, 0),
(447, '肥料', 10, 0, 0, 0, 0, 0, 0),
(448, '農用品、農用機械', 10, 0, 0, 0, 0, 0, 0),
(449, '含油子仁、果仁、籽', 10, 0, 0, 0, 0, 0, 0),
(450, '農林牧漁項目合作', 10, 0, 0, 0, 0, 0, 0),
(451, '飼料', 10, 0, 0, 0, 0, 0, 0),
(452, '木炭', 10, 0, 0, 0, 0, 0, 0),
(453, '咖啡、可可及制品', 10, 0, 0, 0, 0, 0, 0),
(454, '糧油加工機械', 10, 0, 0, 0, 0, 0, 0),
(455, '養殖動物', 10, 0, 0, 0, 0, 0, 0),
(456, '林業設備及用具', 10, 0, 0, 0, 0, 0, 0),
(457, '農副産品加工', 10, 0, 0, 0, 0, 0, 0),
(458, '原棉、麻、毛、絲初加工設備', 10, 0, 0, 0, 0, 0, 0),
(459, '屠宰及肉類初加工設備', 10, 0, 0, 0, 0, 0, 0),
(460, '飼料加工機械', 10, 0, 0, 0, 0, 0, 0),
(461, '家禽', 10, 0, 0, 0, 0, 0, 0),
(462, '動物毛鬃', 10, 0, 0, 0, 0, 0, 0),
(463, '農副産品代理', 10, 0, 0, 0, 0, 0, 0),
(464, '煙草', 10, 0, 0, 0, 0, 0, 0),
(465, '其他未分類', 10, 0, 0, 0, 0, 0, 0),
(466, '鋼鐵及制品', 11, 0, 0, 0, 0, 0, 0),
(467, '非金屬礦産', 11, 0, 0, 0, 0, 0, 0),
(468, '鑄鍛件', 11, 0, 0, 0, 0, 0, 0),
(469, '金屬礦産', 11, 0, 0, 0, 0, 0, 0),
(470, '有色金屬', 11, 0, 0, 0, 0, 0, 0),
(471, '廢金屬', 11, 0, 0, 0, 0, 0, 0),
(472, '冶金設備', 11, 0, 0, 0, 0, 0, 0),
(473, '非金屬礦物制品', 11, 0, 0, 0, 0, 0, 0),
(474, '鐵合金及制品', 11, 0, 0, 0, 0, 0, 0),
(475, '黑色金屬及制品', 11, 0, 0, 0, 0, 0, 0),
(476, '冶煉加工', 11, 0, 0, 0, 0, 0, 0),
(477, '金屬絲網', 11, 0, 0, 0, 0, 0, 0),
(478, '有色金屬制品', 11, 0, 0, 0, 0, 1, 0),
(479, '礦業設備', 11, 0, 0, 0, 0, 1, 0),
(480, '磁性材料', 11, 0, 0, 0, 0, 0, 0),
(481, '粉末冶金', 11, 0, 0, 0, 0, 0, 0),
(482, '石墨及碳素産品', 11, 0, 0, 0, 0, 0, 0),
(483, '有色金屬合金', 11, 0, 0, 0, 0, 0, 0),
(484, '金屬線、管、板制造設備', 11, 0, 0, 0, 0, 0, 0),
(485, '有色金屬合金制品', 11, 0, 0, 0, 0, 0, 0),
(486, '稀土及稀土制品', 11, 0, 0, 0, 0, 0, 0),
(487, '冶金礦産項目合作', 11, 0, 0, 0, 0, 0, 0),
(488, '爐料、熔劑', 11, 0, 0, 0, 0, 0, 0),
(489, '冶金礦産代理', 11, 0, 0, 0, 0, 0, 0),
(490, '其他未分類', 11, 0, 0, 0, 0, 0, 0),
(491, '醫藥原料、中間體', 12, 0, 0, 0, 0, 0, 0),
(492, '保健食（藥）品', 12, 0, 0, 0, 0, 0, 0),
(493, '藥材', 12, 0, 0, 0, 0, 0, 0),
(494, '制藥設備', 12, 0, 0, 0, 0, 0, 0),
(495, '康複産品', 12, 0, 0, 0, 0, 0, 0),
(496, '醫藥、保健品代理', 12, 0, 0, 0, 0, 0, 0),
(497, '藥酒、保健酒', 12, 0, 0, 0, 0, 0, 0),
(498, '減肥增重産品', 12, 0, 0, 0, 0, 0, 0),
(499, '中成藥', 12, 0, 0, 0, 0, 0, 0),
(500, '功能飲料', 12, 0, 0, 0, 0, 0, 0),
(501, '化學藥', 12, 0, 0, 0, 0, 0, 0),
(502, '醫療設備', 12, 0, 0, 0, 0, 0, 0),
(503, '酶(酵素)制劑', 12, 0, 0, 0, 0, 0, 0),
(504, '個人保養', 12, 0, 0, 0, 0, 0, 0),
(505, '醫用材料', 12, 0, 0, 0, 0, 1, 0),
(506, '保健用品', 12, 0, 0, 0, 0, 1, 0),
(507, '保健茶', 12, 0, 0, 0, 0, 0, 0),
(508, '消毒産品', 12, 0, 0, 0, 0, 0, 0),
(509, '醫療器械', 12, 0, 0, 0, 0, 0, 0),
(510, '醫藥、保健項目合作', 12, 0, 0, 0, 0, 0, 0),
(511, '生物制品', 12, 0, 0, 0, 0, 0, 0),
(512, '性用品', 12, 0, 0, 0, 0, 0, 0),
(513, '醫療服務', 12, 0, 0, 0, 0, 0, 0),
(514, '畜用藥', 12, 0, 0, 0, 0, 0, 0),
(515, '中藥飲片', 12, 0, 0, 0, 0, 0, 0),
(516, '醫療器械制造設備', 12, 0, 0, 0, 0, 0, 0),
(517, '庫存醫藥用品', 12, 0, 0, 0, 0, 0, 0),
(518, '特殊藥品', 12, 0, 0, 0, 0, 0, 0),
(519, '醫藥産品加工', 12, 0, 0, 0, 0, 0, 0),
(520, '其他未分類', 12, 0, 0, 0, 0, 0, 0),
(521, '控制設備', 13, 0, 0, 0, 0, 0, 0),
(522, '鎖具', 13, 0, 0, 0, 0, 0, 0),
(523, '交通安全', 13, 0, 0, 0, 0, 0, 0),
(524, '門鈴、可視門鈴', 13, 0, 0, 0, 0, 0, 0),
(525, '運動護具', 13, 0, 0, 0, 0, 0, 0),
(526, '保險櫃', 13, 0, 0, 0, 0, 0, 0),
(527, '智能卡', 13, 0, 0, 0, 0, 0, 0),
(528, '安全、防護用品代理', 13, 0, 0, 0, 0, 0, 0),
(529, '軍需用品', 13, 0, 0, 0, 0, 0, 0),
(530, '安全防護産品項目合作', 13, 0, 0, 0, 0, 0, 0),
(531, '保安及緊急服務', 13, 0, 0, 0, 0, 0, 0),
(532, '安全、防護用品加工', 13, 0, 0, 0, 0, 0, 0),
(533, '作業保護', 13, 0, 0, 0, 0, 0, 0),
(534, '報警裝置', 13, 0, 0, 0, 0, 1, 0),
(535, '防盜設施', 13, 0, 0, 0, 0, 1, 0),
(536, '消防器材', 13, 0, 0, 0, 0, 0, 0),
(537, '避雷産品', 13, 0, 0, 0, 0, 0, 0),
(538, '防身用具', 13, 0, 0, 0, 0, 0, 0),
(539, '救生器材', 13, 0, 0, 0, 0, 0, 0),
(540, '防暴器材', 13, 0, 0, 0, 0, 0, 0),
(541, '激光防僞', 13, 0, 0, 0, 0, 0, 0),
(542, '防彈器材', 13, 0, 0, 0, 0, 0, 0),
(543, '汽車配件', 14, 0, 0, 0, 0, 0, 0),
(544, '摩托車及配件', 14, 0, 0, 0, 0, 0, 0),
(545, '汽車保養', 14, 0, 0, 0, 0, 0, 0),
(546, '汽車', 14, 0, 0, 0, 0, 0, 0),
(547, '汽摩産品制造設備', 14, 0, 0, 0, 0, 0, 0),
(548, '汽摩附屬及相關産品', 14, 0, 0, 0, 0, 0, 0),
(549, '交通安全', 14, 0, 0, 0, 0, 0, 0),
(550, '輪胎', 14, 0, 0, 0, 0, 0, 0),
(551, '專用車輛', 14, 0, 0, 0, 0, 0, 0),
(552, '汽摩及配件代理', 14, 0, 0, 0, 0, 0, 0),
(553, '庫存汽摩及配件', 14, 0, 0, 0, 0, 1, 0),
(554, '停車場、加油站設備', 14, 0, 0, 0, 0, 1, 0),
(555, '汽摩及配件加工', 14, 0, 0, 0, 0, 0, 0),
(556, '其他未分類', 14, 0, 0, 0, 0, 0, 0),
(557, '印刷、印後設備', 15, 0, 0, 0, 0, 0, 0),
(558, '簿、本、冊', 15, 0, 0, 0, 0, 0, 0),
(559, '印刷、出版加工', 15, 0, 0, 0, 0, 0, 0),
(560, '印刷出版物', 15, 0, 0, 0, 0, 0, 0),
(561, '油墨', 15, 0, 0, 0, 0, 1, 0),
(562, '不幹膠制品', 15, 0, 0, 0, 0, 0, 0),
(563, '廣告材料', 15, 0, 0, 0, 0, 0, 0),
(564, '音像制品及電子讀物', 15, 0, 0, 0, 0, 0, 0),
(565, '台曆、挂曆、賀卡', 15, 0, 0, 0, 0, 0, 0),
(566, '排版、制版設備', 15, 0, 0, 0, 0, 0, 0),
(567, '激光防僞', 15, 0, 0, 0, 0, 1, 0),
(568, '媒體和傳播', 15, 0, 0, 0, 0, 1, 0),
(569, '印刷出版産品代理', 15, 0, 0, 0, 0, 0, 0),
(570, '其他未分類', 15, 0, 0, 0, 0, 0, 0),
(571, '保健食（藥）品', 16, 0, 0, 0, 0, 0, 0),
(572, '食品飲料加工設備', 16, 0, 0, 0, 0, 0, 0),
(573, '水果及制品', 16, 0, 0, 0, 0, 0, 0),
(574, '水産及制品', 16, 0, 0, 0, 0, 0, 0),
(575, '休閑食品', 16, 0, 0, 0, 0, 0, 0),
(576, '飲料', 16, 0, 0, 0, 0, 0, 0),
(577, '食品飲料項目合作', 16, 0, 0, 0, 0, 0, 0),
(578, '速凍食品', 16, 0, 0, 0, 0, 0, 0),
(579, '方便食品', 16, 0, 0, 0, 0, 0, 0),
(580, '咖啡、可可及制品', 16, 0, 0, 0, 0, 0, 0),
(581, '面條、粉絲', 16, 0, 0, 0, 0, 0, 0),
(582, '豆制品', 16, 0, 0, 0, 0, 0, 0),
(583, '蜜制品', 16, 0, 0, 0, 0, 0, 0),
(584, '蛋制品', 16, 0, 0, 0, 0, 0, 0),
(585, '食品添加劑', 16, 0, 0, 0, 0, 1, 0),
(586, '調味品', 16, 0, 0, 0, 0, 1, 0),
(587, '茶葉及制品', 16, 0, 0, 0, 0, 0, 0),
(588, '酒類', 16, 0, 0, 0, 0, 0, 0),
(589, '禽畜肉及制品', 16, 0, 0, 0, 0, 0, 0),
(590, '食品飲料代理', 16, 0, 0, 0, 0, 0, 0),
(591, '罐頭食品', 16, 0, 0, 0, 0, 0, 0),
(592, '乳制品', 16, 0, 0, 0, 0, 0, 0),
(593, '澱粉', 16, 0, 0, 0, 0, 0, 0),
(594, '食用油', 16, 0, 0, 0, 0, 0, 0),
(595, '糖類', 16, 0, 0, 0, 0, 0, 0),
(596, '食品飲料加工', 16, 0, 0, 0, 0, 0, 0),
(597, '炊事設備', 16, 0, 0, 0, 0, 0, 0),
(598, '糕餅面包', 16, 0, 0, 0, 0, 0, 0),
(599, '庫存食品、飲料', 16, 0, 0, 0, 0, 0, 0),
(600, '香煙', 16, 0, 0, 0, 0, 0, 0),
(601, '其他未分類', 16, 0, 0, 0, 0, 0, 0),
(602, '電腦外設', 17, 0, 0, 0, 0, 0, 0),
(603, '數碼産品', 17, 0, 0, 0, 0, 0, 0),
(604, '主機配件', 17, 0, 0, 0, 0, 0, 0),
(605, '筆記本電腦', 17, 0, 0, 0, 0, 0, 0),
(606, 'UPS與電源', 17, 0, 0, 0, 0, 1, 0),
(607, '插卡類', 17, 0, 0, 0, 0, 1, 0),
(608, '計算機', 17, 0, 0, 0, 0, 0, 0),
(609, '庫存電腦産品', 17, 0, 0, 0, 0, 0, 0),
(610, '消耗品', 17, 0, 0, 0, 0, 0, 0),
(611, '軟件', 17, 0, 0, 0, 0, 0, 0),
(612, '網絡設備、配件', 17, 0, 0, 0, 0, 0, 0),
(613, '電腦相關用品', 17, 0, 0, 0, 0, 0, 0),
(614, '電腦、軟件産品代理', 17, 0, 0, 0, 0, 0, 0),
(615, '服務器、工作站', 17, 0, 0, 0, 0, 0, 0),
(616, '機箱', 17, 0, 0, 0, 0, 0, 0),
(617, '信息技術項目合作', 17, 0, 0, 0, 0, 0, 0),
(618, '網絡工程', 17, 0, 0, 0, 0, 0, 0),
(619, '軟件開發', 17, 0, 0, 0, 0, 0, 0),
(620, '電子記事簿', 17, 0, 0, 0, 0, 0, 0),
(621, '電腦産品制造設備', 17, 0, 0, 0, 0, 0, 0),
(622, '電腦袋', 17, 0, 0, 0, 0, 0, 0),
(623, '電腦産品加工', 17, 0, 0, 0, 0, 0, 0),
(624, '其他未分類', 17, 0, 0, 0, 0, 0, 0),
(625, '照明與燈具', 18, 0, 0, 0, 0, 0, 0),
(626, '炊具廚具', 18, 0, 0, 0, 0, 0, 0),
(627, '箱包、袋、皮具', 18, 0, 0, 0, 0, 0, 0),
(628, '衛浴設施', 18, 0, 0, 0, 0, 1, 0),
(629, '家用塑料制品', 18, 0, 0, 0, 0, 1, 0),
(630, '家用金屬制品', 18, 0, 0, 0, 0, 0, 0),
(631, '裝飾用紡織品', 18, 0, 0, 0, 0, 0, 0),
(632, '清潔用具', 18, 0, 0, 0, 0, 0, 0),
(633, '刀、剪、刷', 18, 0, 0, 0, 0, 0, 0),
(634, '傘、雨具、太陽傘', 18, 0, 0, 0, 0, 0, 0),
(635, '寵物及用品', 18, 0, 0, 0, 0, 0, 0),
(636, '熏香及熏香爐', 18, 0, 0, 0, 0, 0, 0),
(637, '家用玻璃制品', 18, 0, 0, 0, 0, 0, 0),
(638, '門鈴、可視門鈴', 18, 0, 0, 0, 0, 0, 0),
(639, '鞋套機、擦鞋機', 18, 0, 0, 0, 0, 0, 0),
(640, '廚房用紡織品', 18, 0, 0, 0, 0, 0, 0),
(641, '廚房設施', 18, 0, 0, 0, 0, 0, 0),
(642, '家居用品項目合作', 18, 0, 0, 0, 0, 0, 0),
(643, '家用衡器', 18, 0, 0, 0, 0, 0, 0),
(644, '縫紉編織', 18, 0, 0, 0, 0, 0, 0),
(645, '日用化學品', 18, 0, 0, 0, 0, 0, 0),
(646, '家具', 18, 0, 0, 0, 0, 0, 0),
(647, '個人保養', 18, 0, 0, 0, 0, 0, 0),
(648, '床上用品', 18, 0, 0, 1, 0, 0, 0),
(649, '鍾表', 18, 0, 0, 0, 0, 0, 0),
(650, '餐具', 18, 0, 0, 0, 0, 0, 0),
(651, '打火機、煙具', 18, 0, 0, 0, 0, 0, 0),
(652, '園藝用具', 18, 0, 0, 0, 0, 0, 0),
(653, '相框、畫框', 18, 0, 0, 0, 0, 0, 0),
(654, '家用竹、木制品', 18, 0, 0, 0, 0, 0, 0),
(655, '保溫容器', 18, 0, 0, 0, 0, 0, 0),
(656, '家用紙品', 18, 0, 0, 0, 0, 0, 0),
(657, '家用陶瓷、搪瓷制品', 18, 0, 0, 0, 0, 0, 0),
(658, '嬰兒用品', 18, 0, 0, 0, 0, 0, 0),
(659, '家居用品代理', 18, 0, 0, 0, 0, 0, 0),
(660, '童車及配件', 18, 0, 0, 0, 0, 0, 0),
(661, '定時器', 18, 0, 0, 0, 0, 0, 0),
(662, '其他未分類', 18, 0, 0, 0, 0, 0, 0),
(663, '文具', 19, 0, 0, 0, 0, 0, 0),
(664, '辦公家具', 19, 0, 0, 0, 0, 0, 0),
(665, '電話機、可視電話', 19, 0, 0, 0, 0, 0, 0),
(666, '實驗室用品', 19, 0, 0, 0, 0, 0, 0),
(667, '考勤機', 19, 0, 0, 0, 0, 0, 0),
(668, '背包', 19, 0, 0, 0, 0, 0, 0),
(669, '教學模型、用具', 19, 0, 0, 0, 0, 0, 0),
(670, '複印機', 19, 0, 0, 0, 0, 0, 0),
(671, 'CD袋', 19, 0, 0, 0, 0, 0, 0),
(672, '辦公紙張', 19, 0, 0, 0, 0, 0, 0),
(673, '傳真機', 19, 0, 0, 0, 0, 1, 0),
(674, '碎紙機', 19, 0, 0, 0, 0, 1, 0),
(675, '庫存辦公、文教用品', 19, 0, 0, 0, 0, 0, 0),
(676, '辦公文教用品代理', 19, 0, 0, 0, 0, 0, 0),
(677, '辦公、文教項目合作', 19, 0, 0, 0, 0, 0, 0),
(678, '打字機', 19, 0, 0, 0, 0, 0, 0),
(679, '繪圖機、曬圖機', 19, 0, 0, 0, 0, 0, 0),
(680, '辦公文教用品加工', 19, 0, 0, 0, 0, 0, 0),
(681, '筆袋', 19, 0, 0, 0, 0, 0, 0),
(682, '光學及照相器材', 19, 0, 0, 0, 0, 0, 0),
(683, '簿、本、冊', 19, 0, 0, 0, 0, 0, 0),
(684, '打印機', 19, 0, 0, 0, 0, 0, 0),
(685, '計算器', 19, 0, 0, 0, 0, 0, 0),
(686, '耗材', 19, 0, 0, 0, 0, 0, 0),
(687, '投影機', 19, 0, 0, 0, 0, 0, 0),
(688, '教學設施', 19, 0, 0, 0, 0, 0, 0),
(689, '視訊會議系統', 19, 0, 0, 0, 0, 0, 0),
(690, '集團電話', 19, 0, 0, 0, 0, 0, 0),
(691, '其他未分類', 19, 0, 0, 0, 0, 0, 0),
(692, '石油及制品', 20, 0, 0, 0, 0, 0, 0),
(693, '電池', 20, 0, 0, 0, 0, 0, 0),
(694, '發電機、發電機組', 20, 0, 0, 0, 0, 0, 0),
(695, '礦業設備', 20, 0, 0, 0, 0, 0, 0),
(696, '煤及制品', 20, 0, 0, 0, 0, 0, 0),
(697, 'UPS與電源', 20, 0, 0, 0, 0, 0, 0),
(698, '太陽能及再生能源', 20, 0, 0, 0, 0, 0, 0),
(699, '石油加工設備', 20, 0, 0, 0, 0, 0, 0),
(700, '能源項目合作', 20, 0, 0, 0, 0, 0, 0),
(701, '能源産品代理', 20, 0, 0, 0, 0, 1, 0),
(702, '電力', 20, 0, 0, 0, 0, 1, 0),
(703, '天然氣', 20, 0, 0, 0, 0, 0, 0),
(704, '能源産品加工', 20, 0, 0, 0, 0, 0, 0),
(705, '煤氣', 20, 0, 0, 0, 0, 0, 0),
(706, '其他未分類', 20, 0, 0, 0, 0, 0, 0),
(707, '水處理設施', 21, 1, 0, 0, 0, 0, 0),
(708, '水處理化學品', 21, 0, 0, 0, 0, 0, 0),
(709, '廢金屬', 21, 0, 0, 0, 0, 0, 0),
(710, '化工廢料', 21, 0, 0, 0, 0, 0, 0),
(711, '廢氣處理設施', 21, 0, 0, 0, 0, 0, 0),
(712, '公共環衛設施', 21, 0, 0, 0, 0, 0, 0),
(713, '廢紙', 21, 0, 0, 0, 0, 0, 0),
(714, '廢料回收再利用', 21, 0, 0, 0, 0, 0, 0),
(715, '環保項目合作', 21, 0, 0, 0, 0, 0, 0),
(716, '紡織廢料', 21, 0, 0, 0, 0, 0, 0),
(717, '皮革廢料', 21, 0, 0, 0, 0, 0, 0),
(718, '降噪音設備', 21, 0, 0, 0, 0, 0, 0),
(719, '環保産品代理', 21, 0, 1, 0, 0, 1, 0),
(720, '環保産品加工', 21, 0, 0, 0, 0, 1, 0),
(721, '其他未分類', 21, 0, 0, 0, 0, 1, 0),
(722, '網絡通信産品', 22, 0, 0, 0, 0, 0, 0),
(723, '锂電池、鎳氫電池', 22, 0, 0, 0, 0, 0, 0),
(724, '通訊産品配件部件', 22, 0, 0, 0, 0, 0, 0),
(725, '電話機、可視電話', 22, 0, 0, 0, 0, 0, 0),
(726, '移動電話', 22, 0, 0, 0, 0, 0, 0),
(727, '相關産品', 22, 0, 0, 0, 0, 0, 0),
(728, '充電器', 22, 0, 0, 0, 0, 0, 0),
(729, '廣電、電信設備', 22, 0, 0, 0, 0, 0, 0),
(730, '通信電纜', 22, 0, 0, 0, 0, 0, 0),
(731, '通訊、聲訊系統', 22, 0, 0, 0, 0, 0, 0),
(732, '對講機', 22, 0, 0, 0, 0, 0, 0),
(733, '天線', 22, 0, 0, 0, 0, 1, 0),
(734, '交換機', 22, 0, 0, 0, 0, 1, 0),
(735, '磁卡、IP卡、IC卡', 22, 0, 0, 0, 0, 0, 0),
(736, '集團電話', 22, 0, 0, 0, 0, 0, 0),
(737, '通信産品代理', 22, 0, 0, 0, 0, 0, 0),
(738, 'GPS系統', 22, 0, 0, 0, 0, 0, 0),
(739, '撥號器', 22, 0, 0, 0, 0, 0, 0),
(740, '傳真機', 22, 0, 0, 0, 0, 0, 0),
(741, '通訊産品制造設備', 22, 0, 0, 0, 0, 0, 0),
(742, '控制和調整設備', 22, 0, 0, 0, 0, 0, 0),
(743, '雷達及無線導航', 22, 0, 0, 0, 0, 0, 0),
(744, '尋呼機', 22, 0, 0, 0, 0, 0, 0),
(745, '手機袋', 22, 0, 0, 0, 1, 0, 0),
(746, '來電顯示器', 22, 0, 0, 0, 0, 0, 0),
(747, '通訊産品加工', 22, 0, 0, 0, 0, 0, 0),
(748, '其他未分類', 22, 0, 0, 0, 0, 0, 0),
(749, '體育用品', 23, 0, 0, 0, 0, 0, 0),
(750, '健身', 23, 0, 0, 0, 0, 0, 0),
(751, '遊藝設施', 23, 0, 0, 0, 0, 0, 0),
(752, '紀念品', 23, 0, 0, 0, 0, 0, 0),
(753, '樂器', 23, 0, 0, 0, 0, 0, 0),
(754, '旅遊、戶外用品', 23, 0, 0, 0, 0, 0, 0),
(755, '寵物及用品', 23, 0, 0, 0, 0, 0, 0),
(756, '賓館酒店用品', 23, 0, 0, 0, 0, 0, 0),
(757, '釣魚', 23, 0, 0, 0, 0, 0, 0),
(758, '庫存運動休閑産品', 23, 0, 0, 0, 0, 1, 0),
(759, '棋類', 23, 0, 0, 0, 0, 1, 0),
(760, '撲克', 23, 0, 0, 0, 0, 0, 0),
(761, '運動休閑用品代理', 23, 0, 0, 0, 0, 0, 0),
(762, '運動休閑用品項目合作', 23, 0, 0, 0, 0, 0, 0),
(763, '舞蹈用品', 23, 0, 0, 0, 0, 0, 0),
(764, '運動休閑用品加工', 23, 0, 0, 0, 0, 0, 0),
(765, '其他未分類', 23, 0, 0, 0, 0, 0, 0),
(766, '廣告', 24, 0, 0, 0, 0, 0, 0),
(767, '物流', 24, 0, 0, 0, 0, 0, 0),
(768, '移民、簽證', 24, 0, 0, 0, 0, 0, 0),
(769, '招聘', 24, 0, 0, 0, 0, 0, 0),
(770, '工程承包', 24, 0, 0, 0, 0, 0, 0),
(771, '旅遊服務', 24, 0, 0, 0, 0, 0, 0),
(772, '産權轉讓', 24, 0, 0, 0, 0, 0, 0),
(773, '風險投資', 24, 0, 0, 0, 0, 0, 0),
(774, '地區、政府招商引資', 24, 0, 0, 0, 0, 0, 0),
(775, '軟件開發', 24, 0, 0, 0, 0, 0, 0),
(776, '保險', 24, 0, 0, 0, 0, 0, 0),
(777, '專利轉讓', 24, 0, 0, 0, 0, 0, 0),
(778, '商標注冊', 24, 0, 0, 0, 0, 0, 0),
(779, '拍賣', 24, 0, 0, 0, 0, 0, 0),
(780, '中介服務', 24, 0, 0, 0, 0, 1, 0),
(781, '超市、百貨、便利店', 24, 0, 0, 0, 0, 1, 0),
(782, '項目合作', 24, 0, 0, 0, 0, 0, 0),
(783, '商展、會議', 24, 0, 0, 0, 0, 0, 0),
(784, '技術合作', 24, 0, 0, 0, 0, 0, 0),
(785, '咨詢、調研', 24, 0, 0, 0, 0, 0, 0),
(786, '策劃、設計', 24, 0, 0, 0, 0, 0, 0),
(787, '公司注冊', 24, 0, 0, 0, 0, 0, 0),
(788, '教育、培訓', 24, 0, 0, 0, 0, 0, 0),
(789, '維修、安裝、清洗', 24, 0, 0, 0, 0, 0, 0),
(790, '票務', 24, 0, 0, 0, 0, 0, 0),
(791, '勞務輸出', 24, 0, 0, 0, 0, 0, 0),
(792, '賓館、餐飲', 24, 1, 0, 0, 0, 0, 0),
(793, '配額、批文', 24, 1, 0, 0, 0, 0, 0),
(794, '翻譯', 24, 0, 0, 0, 0, 0, 0),
(795, '醫療服務', 24, 0, 0, 0, 0, 0, 0),
(796, '快遞', 24, 0, 0, 0, 0, 0, 0),
(797, '法律服務', 24, 0, 0, 0, 0, 0, 0),
(798, '租賃、典當', 24, 0, 0, 0, 0, 0, 0),
(799, '代理報關', 24, 0, 0, 0, 0, 0, 0),
(800, '招標、投標', 24, 0, 0, 0, 0, 0, 0),
(801, '其他未分類', 24, 0, 0, 0, 0, 0, 0),
(802, '物流', 25, 0, 0, 0, 0, 0, 0),
(803, '交通安全', 25, 0, 0, 0, 0, 0, 0),
(804, '輪胎', 25, 0, 0, 0, 0, 0, 0),
(805, '船舶及配件', 25, 0, 0, 0, 0, 0, 0),
(806, '電梯、纜車及配件', 25, 0, 0, 0, 1, 0, 0),
(807, '鐵路、地鐵用設備器材', 25, 0, 0, 1, 0, 0, 0),
(808, '庫存交通産品及用具', 25, 0, 0, 0, 0, 0, 0),
(809, '交通運輸産品加工', 25, 0, 0, 0, 0, 0, 0),
(810, '電動車和配件', 25, 0, 0, 0, 0, 0, 0),
(811, '自行車、三輪車及配件', 25, 0, 0, 0, 0, 0, 0),
(812, '廢氣處理設施', 25, 0, 0, 0, 0, 1, 0),
(813, '交通産品代理', 25, 0, 0, 0, 0, 1, 0),
(814, '集裝箱', 25, 0, 0, 0, 0, 0, 0),
(815, '交通項目合作', 25, 0, 0, 0, 0, 0, 0),
(816, '飛行器及配件', 25, 0, 0, 0, 0, 0, 0),
(817, '其他未分類', 25, 1, 0, 0, 0, 0, 0),
(818, '交通工具.配件.飾品', 25, 0, 0, 0, 0, 0, 0),
(819, '木制玩具', 26, 0, 0, 0, 0, 0, 0),
(820, '塑料玩具', 26, 0, 0, 0, 0, 0, 0),
(821, '填充、絨毛玩具', 26, 0, 0, 0, 0, 0, 0),
(822, '電子玩具', 26, 0, 0, 0, 0, 0, 0),
(823, '電動玩具', 26, 0, 0, 0, 0, 0, 0),
(824, '玩具珠、球', 26, 0, 0, 0, 0, 0, 0),
(825, '娃娃', 26, 0, 0, 0, 0, 0, 0),
(826, '玩具車', 26, 0, 0, 0, 0, 0, 0),
(827, '玩具槍', 26, 0, 0, 0, 0, 0, 0),
(828, '模型玩具', 26, 0, 0, 0, 0, 0, 0),
(829, '益智玩具', 26, 0, 0, 0, 0, 0, 0),
(830, '童車及配件', 26, 0, 0, 0, 0, 0, 0),
(831, '玩具配件', 26, 0, 0, 0, 0, 1, 0),
(832, '庫存玩具', 26, 0, 0, 0, 0, 1, 0),
(833, '禮品工藝品加工', 26, 0, 0, 0, 0, 0, 0),
(834, '禮品、工藝品項目合作', 26, 0, 0, 0, 0, 0, 0),
(835, '玩具項目合作', 26, 0, 0, 0, 0, 0, 0),
(836, '玩具加工', 26, 0, 0, 1, 0, 0, 0),
(837, '玩具代理', 26, 0, 0, 0, 0, 0, 0),
(838, '其他未分類', 26, 0, 0, 0, 0, 0, 0),
(839, '庫存服飾', 27, 0, 0, 0, 0, 0, 0),
(840, '庫存設備及工業用品', 27, 0, 0, 0, 0, 0, 0),
(841, '家居用品庫存', 27, 0, 0, 0, 0, 0, 0),
(842, '庫存工藝品、禮品', 27, 0, 0, 0, 0, 0, 0),
(843, '庫存玩具', 27, 0, 0, 0, 0, 0, 0),
(844, '庫存運動休閑産品', 27, 0, 0, 0, 0, 0, 0),
(845, '庫存化工品', 27, 0, 0, 0, 0, 0, 0),
(846, '庫存辦公、文教用品', 27, 0, 0, 0, 0, 0, 0),
(847, '庫存安全防護産品', 27, 0, 0, 0, 0, 1, 0),
(848, '庫存皮革及制品', 27, 0, 0, 0, 0, 1, 0),
(849, '庫存醫藥用品', 27, 0, 0, 0, 0, 0, 0),
(850, '庫存産品代理', 27, 0, 0, 0, 0, 0, 0),
(851, '庫存紡織品', 27, 0, 0, 0, 0, 0, 0),
(852, '庫存電子産品', 27, 0, 0, 0, 0, 0, 0),
(853, '庫存鞋及鞋材', 27, 0, 0, 0, 0, 0, 0),
(854, '庫存家用電器', 27, 0, 0, 0, 0, 0, 0),
(855, '庫存電腦産品', 27, 0, 0, 0, 0, 0, 0),
(856, '庫存通訊産品', 27, 0, 0, 0, 0, 0, 0),
(857, '庫存農副産品', 27, 0, 0, 0, 0, 0, 0),
(858, '庫存汽摩及配件', 27, 0, 0, 0, 0, 0, 0),
(859, '庫存建材', 27, 0, 0, 0, 0, 0, 0),
(860, '庫存冶金礦産', 27, 0, 0, 0, 0, 0, 0),
(861, '庫存食品、飲料', 27, 0, 0, 0, 0, 0, 0),
(862, '庫存交通産品及用具', 27, 0, 0, 0, 0, 1, 0),
(863, '其他未分類庫存', 27, 0, 0, 0, 0, 0, 0);

INSERT INTO eos_areas (`id`, `spelling`, `name`, `code_id`, `brief_name`) VALUES
(1, 'BJ', '北京市', 110000, '京'),
(2, 'TJ', '天津市', 120000, '津'),
(3, 'HE', '河北省', 130000, '冀'),
(4, 'SX', '山西省', 140000, '晉'),
(5, 'NM', '內蒙古自治區', 150000, '蒙'),
(6, 'LN', '遼甯省', 210000, '遼'),
(7, 'JL', '吉林省', 220000, '吉'),
(8, 'HL', '黑龍江省', 230000, '黑'),
(9, 'SH', '上海市', 310000, '滬'),
(10, 'JS', '江蘇省', 320000, '蘇'),
(11, 'ZJ', '浙江省', 330000, '浙'),
(12, 'AH', '安徽省', 340000, '皖'),
(13, 'FJ', '福建省', 350000, '閩'),
(14, 'JX', '江西省', 360000, '贛'),
(15, 'SD', '山東省', 370000, '魯'),
(16, 'HA', '河南省', 410000, '豫'),
(17, 'HB', '湖北省', 420000, '鄂'),
(18, 'HN', '湖南省', 430000, '湘'),
(19, 'GD', '廣東省', 440000, '粵'),
(20, 'GX', '廣西壯族自治區', 450000, '桂'),
(21, 'HI', '海南省', 460000, '瓊'),
(22, 'CQ', '重慶市', 500000, '渝'),
(23, 'SC', '四川省', 510000, '川'),
(24, 'GZ', '貴州省', 520000, '貴'),
(25, 'YN', '雲南省', 530000, '滇'),
(26, 'XZ', '西藏自治區', 540000, '藏'),
(27, 'SN', '陝西省', 610000, '陝'),
(28, 'GS', '甘肅省', 620000, '甘'),
(29, 'QH', '青海省', 630000, '青'),
(30, 'NX', '甯夏回族自治區', 640000, '甯'),
(31, 'XJ', '新疆維吾爾自治區', 650000, '新'),
(32, 'TW', '台灣省', 710000, '台'),
(33, 'HK', '香港特別行政區', 810000, '港'),
(34, 'MO', '澳門特別行政區', 820000, '澳'),
(50, NULL, '北京', 110100, NULL),
(51, NULL, '天津', 120100, NULL),
(52, NULL, '石家莊', 130101, NULL),
(53, NULL, '唐山', 130201, NULL),
(54, NULL, '秦皇島', 130301, NULL),
(55, NULL, '張家口', 130701, NULL),
(56, NULL, '承德', 130801, NULL),
(57, NULL, '廊坊', 131001, NULL),
(58, NULL, '邯鄲', 130401, NULL),
(59, NULL, '邢台', 130501, NULL),
(60, NULL, '保定', 130601, NULL),
(61, NULL, '滄州', 130901, NULL),
(62, NULL, '衡水', 133001, NULL),
(63, NULL, '太原', 140101, NULL),
(64, NULL, '大同', 140201, NULL),
(65, NULL, '陽泉', 140301, NULL),
(66, NULL, '晉城', 140501, NULL),
(67, NULL, '朔州', 140601, NULL),
(68, NULL, '忻州', 142201, NULL),
(69, NULL, '離石', 142331, NULL),
(70, NULL, '榆次', 142401, NULL),
(71, NULL, '臨汾', 142601, NULL),
(72, NULL, '運城', 142701, NULL),
(73, NULL, '長治', 140401, NULL),
(74, NULL, '呼和浩特', 150101, NULL),
(75, NULL, '包頭', 150201, NULL),
(76, NULL, '烏海', 150301, NULL),
(77, NULL, '集甯', 152601, NULL),
(78, NULL, '東勝', 152701, NULL),
(79, NULL, '臨河', 152801, NULL),
(80, NULL, '阿拉善左旗', 152921, NULL),
(81, NULL, '赤峰', 150401, NULL),
(82, NULL, '通遼', 152301, NULL),
(83, NULL, '錫林浩特', 152502, NULL),
(84, NULL, '海拉爾', 152101, NULL),
(85, NULL, '烏蘭浩特', 152201, NULL),
(86, NULL, '沈陽', 210101, NULL),
(87, NULL, '大連', 210201, NULL),
(88, NULL, '鞍山', 210301, NULL),
(89, NULL, '撫順', 210401, NULL),
(90, NULL, '本溪', 210501, NULL),
(91, NULL, '錦州', 210701, NULL),
(92, NULL, '營口', 210801, NULL),
(93, NULL, '阜新', 210901, NULL),
(94, NULL, '盤錦', 211101, NULL),
(95, NULL, '鐵嶺', 211201, NULL),
(96, NULL, '朝陽', 211301, NULL),
(97, NULL, '錦西', 211401, NULL),
(98, NULL, '丹東', 210601, NULL),
(99, NULL, '長春', 220101, NULL),
(100, NULL, '吉林', 220201, NULL),
(101, NULL, '四平', 220301, NULL),
(102, NULL, '遼源', 220401, NULL),
(103, NULL, '渾江', 220601, NULL),
(104, NULL, '白城', 222301, NULL),
(105, NULL, '延吉', 222401, NULL),
(106, NULL, '通化', 220501, NULL),
(107, NULL, '哈爾濱', 230101, NULL),
(108, NULL, '雞西', 230301, NULL),
(109, NULL, '鶴崗', 230401, NULL),
(110, NULL, '雙鴨山', 230501, NULL),
(111, NULL, '伊春', 230701, NULL),
(112, NULL, '佳木斯', 230801, NULL),
(113, NULL, '七台河', 230901, NULL),
(114, NULL, '牡丹江', 231001, NULL),
(115, NULL, '綏化', 232301, NULL),
(116, NULL, '齊齊哈爾', 230201, NULL),
(117, NULL, '大慶', 230601, NULL),
(118, NULL, '黑河', 232601, NULL),
(119, NULL, '加格達奇', 232700, NULL),
(120, NULL, '上海', 310100, NULL),
(121, NULL, '南京', 320101, NULL),
(122, NULL, '無錫', 320201, NULL),
(123, NULL, '徐州', 320301, NULL),
(124, NULL, '常州', 320401, NULL),
(125, NULL, '蘇州', 320501, NULL),
(126, NULL, '南通', 320600, NULL),
(127, NULL, '連雲港', 320701, NULL),
(128, NULL, '淮陰', 320801, NULL),
(129, NULL, '鹽城', 320901, NULL),
(130, NULL, '揚州', 321001, NULL),
(131, NULL, '鎮江', 321101, NULL),
(132, NULL, '杭州', 330101, NULL),
(133, NULL, '甯波', 330201, NULL),
(134, NULL, '溫州', 330301, NULL),
(135, NULL, '嘉興', 330401, NULL),
(136, NULL, '湖州', 330501, NULL),
(137, NULL, '紹興', 330601, NULL),
(138, NULL, '金華', 330701, NULL),
(139, NULL, '衢州', 330801, NULL),
(140, NULL, '舟山', 330901, NULL),
(141, NULL, '麗水', 332501, NULL),
(142, NULL, '臨海', 332602, NULL),
(143, NULL, '合肥', 340101, NULL),
(144, NULL, '蕪湖', 340201, NULL),
(145, NULL, '蚌埠', 340301, NULL),
(146, NULL, '淮南', 340401, NULL),
(147, NULL, '馬鞍山', 340501, NULL),
(148, NULL, '淮北', 340601, NULL),
(149, NULL, '銅陵', 340701, NULL),
(150, NULL, '安慶', 340801, NULL),
(151, NULL, '黃山', 341001, NULL),
(152, NULL, '阜陽', 342101, NULL),
(153, NULL, '宿州', 342201, NULL),
(154, NULL, '滁州', 342301, NULL),
(155, NULL, '六安', 342401, NULL),
(156, NULL, '宣州', 342501, NULL),
(157, NULL, '巢湖', 342601, NULL),
(158, NULL, '貴池', 342901, NULL),
(159, NULL, '福州', 350101, NULL),
(160, NULL, '廈門', 350201, NULL),
(161, NULL, '莆田', 350301, NULL),
(162, NULL, '三明', 350401, NULL),
(163, NULL, '泉州', 350501, NULL),
(164, NULL, '漳州', 350601, NULL),
(165, NULL, '南平', 352101, NULL),
(166, NULL, '甯德', 352201, NULL),
(167, NULL, '龍岩', 352601, NULL),
(168, NULL, '南昌', 360101, NULL),
(169, NULL, '景德鎮', 360201, NULL),
(170, NULL, '贛州', 362101, NULL),
(171, NULL, '萍鄉', 360301, NULL),
(172, NULL, '九江', 360401, NULL),
(173, NULL, '新余', 360501, NULL),
(174, NULL, '鷹潭', 360601, NULL),
(175, NULL, '宜春', 362201, NULL),
(176, NULL, '上饒', 362301, NULL),
(177, NULL, '吉安', 362401, NULL),
(178, NULL, '臨川', 362502, NULL),
(179, NULL, '濟南', 370101, NULL),
(180, NULL, '青島', 370201, NULL),
(181, NULL, '淄博', 370301, NULL),
(182, NULL, '棗莊', 370401, NULL),
(183, NULL, '東營', 370501, NULL),
(184, NULL, '煙台', 370601, NULL),
(185, NULL, '濰坊', 370701, NULL),
(186, NULL, '濟甯', 370801, NULL),
(187, NULL, '泰安', 370901, NULL),
(188, NULL, '威海', 371001, NULL),
(189, NULL, '日照', 371100, NULL),
(190, NULL, '濱州', 372301, NULL),
(191, NULL, '德州', 372401, NULL),
(192, NULL, '聊城', 372501, NULL),
(193, NULL, '臨沂', 372801, NULL),
(194, NULL, '菏澤', 372901, NULL),
(195, NULL, '鄭州', 410101, NULL),
(196, NULL, '開封', 410201, NULL),
(197, NULL, '洛陽', 410301, NULL),
(198, NULL, '平頂山', 410401, NULL),
(199, NULL, '安陽', 410501, NULL),
(200, NULL, '鶴壁', 410601, NULL),
(201, NULL, '新鄉', 410701, NULL),
(202, NULL, '焦作', 410801, NULL),
(203, NULL, '濮陽', 410901, NULL),
(204, NULL, '許昌', 411001, NULL),
(205, NULL, '漯河', 411101, NULL),
(206, NULL, '三門峽', 411201, NULL),
(207, NULL, '商丘', 412301, NULL),
(208, NULL, '周口', 412701, NULL),
(209, NULL, '駐馬店', 412801, NULL),
(210, NULL, '南陽', 412901, NULL),
(211, NULL, '信陽', 413001, NULL),
(212, NULL, '武漢', 420101, NULL),
(213, NULL, '黃石', 420201, NULL),
(214, NULL, '十堰', 420301, NULL),
(215, NULL, '沙市', 420400, NULL),
(216, NULL, '宜昌', 420501, NULL),
(217, NULL, '襄樊', 420601, NULL),
(218, NULL, '鄂州', 420701, NULL),
(219, NULL, '荊門', 420801, NULL),
(220, NULL, '黃州', 422103, NULL),
(221, NULL, '孝感', 422201, NULL),
(222, NULL, '鹹甯', 422301, NULL),
(223, NULL, '江陵', 422421, NULL),
(224, NULL, '恩施', 422801, NULL),
(225, NULL, '長沙', 430101, NULL),
(226, NULL, '衡陽', 430401, NULL),
(227, NULL, '邵陽', 430501, NULL),
(228, NULL, '郴州', 432801, NULL),
(229, NULL, '永州', 432901, NULL),
(230, NULL, '大庸', 430801, NULL),
(231, NULL, '懷化', 433001, NULL),
(232, NULL, '吉首', 433101, NULL),
(233, NULL, '株洲', 430201, NULL),
(234, NULL, '湘潭', 430301, NULL),
(235, NULL, '嶽陽', 430601, NULL),
(236, NULL, '常德', 430701, NULL),
(237, NULL, '益陽', 432301, NULL),
(238, NULL, '婁底', 432501, NULL),
(239, NULL, '廣州', 440101, NULL),
(240, NULL, '深圳', 440301, NULL),
(241, NULL, '汕尾', 441501, NULL),
(242, NULL, '惠州', 441301, NULL),
(243, NULL, '河源', 441601, NULL),
(244, NULL, '佛山', 440601, NULL),
(245, NULL, '清遠', 441801, NULL),
(246, NULL, '東莞', 441901, NULL),
(247, NULL, '珠海', 440401, NULL),
(248, NULL, '江門', 440701, NULL),
(249, NULL, '肇慶', 441201, NULL),
(250, NULL, '中山', 442001, NULL),
(251, NULL, '湛江', 440801, NULL),
(252, NULL, '茂名', 440901, NULL),
(253, NULL, '韶關', 440201, NULL),
(254, NULL, '汕頭', 440501, NULL),
(255, NULL, '梅州', 441401, NULL),
(256, NULL, '陽江', 441701, NULL),
(257, NULL, '南甯', 450101, NULL),
(258, NULL, '梧州', 450401, NULL),
(259, NULL, '玉林', 452501, NULL),
(260, NULL, '桂林', 450301, NULL),
(261, NULL, '百色', 452601, NULL),
(262, NULL, '河池', 452701, NULL),
(263, NULL, '欽州', 452802, NULL),
(264, NULL, '柳州', 450201, NULL),
(265, NULL, '北海', 450501, NULL),
(266, NULL, '海口', 460100, NULL),
(267, NULL, '三亞', 460200, NULL),
(268, NULL, '成都', 510101, NULL),
(269, NULL, '康定', 513321, NULL),
(270, NULL, '雅安', 513101, NULL),
(271, NULL, '馬爾康', 513229, NULL),
(272, NULL, '自貢', 510301, NULL),
(273, NULL, '重慶', 500100, NULL),
(274, NULL, '南充', 512901, NULL),
(275, NULL, '泸州', 510501, NULL),
(276, NULL, '德陽', 510601, NULL),
(277, NULL, '綿陽', 510701, NULL),
(278, NULL, '遂甯', 510901, NULL),
(279, NULL, '內江', 511001, NULL),
(280, NULL, '樂山', 511101, NULL),
(281, NULL, '宜賓', 512501, NULL),
(282, NULL, '廣元', 510801, NULL),
(283, NULL, '達縣', 513021, NULL),
(284, NULL, '西昌', 513401, NULL),
(285, NULL, '攀枝花', 510401, NULL),
(286, NULL, '黔江土家族苗族自治縣', 500239, NULL),
(287, NULL, '貴陽', 520101, NULL),
(288, NULL, '六盤水', 520200, NULL),
(289, NULL, '銅仁', 522201, NULL),
(290, NULL, '安順', 522501, NULL),
(291, NULL, '凱裏', 522601, NULL),
(292, NULL, '都勻', 522701, NULL),
(293, NULL, '興義', 522301, NULL),
(294, NULL, '畢節', 522421, NULL),
(295, NULL, '遵義', 522101, NULL),
(296, NULL, '昆明', 530101, NULL),
(297, NULL, '東川', 530201, NULL),
(298, NULL, '曲靖', 532201, NULL),
(299, NULL, '楚雄', 532301, NULL),
(300, NULL, '玉溪', 532401, NULL),
(301, NULL, '個舊', 532501, NULL),
(302, NULL, '文山', 532621, NULL),
(303, NULL, '思茅', 532721, NULL),
(304, NULL, '昭通', 532101, NULL),
(305, NULL, '景洪', 532821, NULL),
(306, NULL, '大理', 532901, NULL),
(307, NULL, '保山', 533001, NULL),
(308, NULL, '潞西', 533121, NULL),
(309, NULL, '麗江納西族自治縣', 533221, NULL),
(310, NULL, '泸水', 533321, NULL),
(311, NULL, '中甸', 533421, NULL),
(312, NULL, '臨滄', 533521, NULL),
(313, NULL, '拉薩', 540101, NULL),
(314, NULL, '昌都', 542121, NULL),
(315, NULL, '乃東', 542221, NULL),
(316, NULL, '日喀則', 542301, NULL),
(317, NULL, '那曲', 542421, NULL),
(318, NULL, '噶爾', 542523, NULL),
(319, NULL, '林芝', 542621, NULL),
(320, NULL, '西安', 610101, NULL),
(321, NULL, '銅川', 610201, NULL),
(322, NULL, '寶雞', 610301, NULL),
(323, NULL, '鹹陽', 610401, NULL),
(324, NULL, '渭南', 612101, NULL),
(325, NULL, '漢中', 612301, NULL),
(326, NULL, '安康', 612401, NULL),
(327, NULL, '商州', 612501, NULL),
(328, NULL, '延安', 612601, NULL),
(329, NULL, '榆林', 612701, NULL),
(330, NULL, '蘭州', 620101, NULL),
(331, NULL, '白銀', 620401, NULL),
(332, NULL, '金昌', 620301, NULL),
(333, NULL, '天水', 620501, NULL),
(334, NULL, '張掖', 622201, NULL),
(335, NULL, '武威', 622301, NULL),
(336, NULL, '定西', 622421, NULL),
(337, NULL, '成縣', 622624, NULL),
(338, NULL, '平涼', 622701, NULL),
(339, NULL, '西峰', 622801, NULL),
(340, NULL, '臨夏', 622901, NULL),
(341, NULL, '夏河', 623027, NULL),
(342, NULL, '嘉峪關', 620201, NULL),
(343, NULL, '酒泉', 622102, NULL),
(344, NULL, '西甯', 630100, NULL),
(345, NULL, '平安', 632121, NULL),
(346, NULL, '門源回族自治縣', 632221, NULL),
(347, NULL, '同仁', 632321, NULL),
(348, NULL, '共和', 632521, NULL),
(349, NULL, '瑪沁', 632621, NULL),
(350, NULL, '玉樹', 632721, NULL),
(351, NULL, '德令哈', 632802, NULL),
(352, NULL, '銀川', 640101, NULL),
(353, NULL, '石嘴山', 640201, NULL),
(354, NULL, '吳忠', 642101, NULL),
(355, NULL, '固原', 642221, NULL),
(356, NULL, '烏魯木齊', 650101, NULL),
(357, NULL, '克拉瑪依', 650201, NULL),
(358, NULL, '吐魯番', 652101, NULL),
(359, NULL, '哈密', 652201, NULL),
(360, NULL, '昌吉', 652301, NULL),
(361, NULL, '博樂', 652701, NULL),
(362, NULL, '庫爾勒', 652801, NULL),
(363, NULL, '阿克蘇', 652901, NULL),
(364, NULL, '阿圖什', 653001, NULL),
(365, NULL, '喀什', 653101, NULL),
(366, NULL, '伊甯', 654101, NULL),
(367, NULL, '台北', 710001, NULL),
(368, NULL, '基隆', 710002, NULL),
(369, NULL, '台南', 710020, NULL),
(370, NULL, '高雄', 710019, NULL),
(371, NULL, '台中', 710008, NULL),
(372, NULL, '遼陽', 211001, NULL),
(373, NULL, '和田', 653201, NULL),
(374, NULL, '澤當鎮', 542200, NULL),
(375, NULL, '八一鎮', 542600, NULL),
(376, NULL, '澳門', 820000, NULL),
(377, NULL, '香港', 810000, NULL);


INSERT INTO eos_membertypes (`id`, `access_id`, `name`, `picture`, `if_default`, `if_index`, `price_every_year`, `status`) VALUES
(1, 1, '免費會員', 'default.gif', 1, 0, '0', 1),
(2, 0, '外貿會員', 'default.gif', 0, 0, '1000', 1),
(3, 0, '金牌會員', 'default.gif', 0, 0, '2000', 1),
(4, 0, 'VIP會員', 'default.gif', 0, 1, '3000', 1),
(5, 0, '普通會員', 'default.gif', 0, 0, '0', 0);

INSERT INTO eos_accesses VALUES ('1', '普通權限', '1', '3', '3', '3', '3', '3', '3', '3', '1', '1', '1', '1', '1', '0', '3', '0', '0', '3', '2', '0');

##插入默認的公司類型

INSERT INTO eos_companytypes (name,avaliable,picture) VALUES ('供應商', 1,''),('采購商', 1,''),('生産商', 1,''),('加盟商', 1,''),('其他類型', 1,'');

##插入首頁頂部廣告位置
INSERT INTO eos_adzones VALUES (2, '1', NULL, '首頁頂部小圖片廣告', '6個圖片一行，首頁顯示', 'XXX元/月', 'index.php', 760, 45, 6, 12, NULL);


INSERT INTO eos_templets (`id`, `title`, `description`, `picture`, `status`) VALUES
(1, 'default', '默認的會員個人主頁', 'default.jpg', 1),
(2, 'blue', '藍色主題', 'blue.jpg', 1),
(3, 'green', '綠色主題', 'green.jpg', 1);

INSERT INTO eos_stats (`id`, `sa`, `sb`, `description`, `sc`, `sd`, `se`) VALUES
(1, 'total', 'buy', '求購總數', 1, NULL, NULL),
(2, 'total', 'buy_today', '今日求購總數', 1, NULL, NULL),
(3, 'total', 'sell', '供應總數', 1, NULL, NULL),
(4, 'total', 'sell_today', '今日供應數量', 1, NULL, NULL),
(5, 'total', 'product', '産品總數', 0, NULL, NULL),
(6, 'total', 'product_today', '今日新增産品', 0, NULL, NULL),
(7, 'total', 'company', '企業庫總數', 0, NULL, NULL),
(8, 'total', 'company_today', '今日新增企業', 0, NULL, NULL),
(9, 'total', 'member', '會員總數', 0, NULL, NULL),
(10, 'total', 'member_today', '今日新增會員', 0, NULL, NULL),
(11, 'total', 'news', '资讯总数', 0, NULL, NULL);