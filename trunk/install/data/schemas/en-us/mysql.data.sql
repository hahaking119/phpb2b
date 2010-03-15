-- Program Name: PHPB2B
-- Program version: 3.2 - ATHENA
-- Last Updated: 2010-3-15

-- 
-- Export data in the table `pb_adzones`
-- 

INSERT INTO `pb_adzones` VALUES (1, '1', 'Home at the top of a small image ad', '6 pictures line, Home Show', '', '1,234 RMB/month', 'index.php', 760, 52, 6, 12, 0, 1261133418);
INSERT INTO `pb_adzones` VALUES (2, '1', 'Home 958 Banner Ad', 'Free open-source, supports multiple languages, PHPB2B-generation e-commerce application platform', '', '3000', 'index.php', 958, 62, 0, 0, 1265678633, 1265678633);

-- 
-- Export data in the table `pb_companies`
-- 

INSERT INTO `pb_companies` VALUES (1, 1, 'admin', 10, 0, '', 1, 11, 24, '1', '2', '3', 2, 'PHPB2B Site Management System', 'PHPB2B', 'UALINK', '', 'Steven', '4', 3, 1, 'a:1:{s:12:"templet_name";b:0;}', 'Bank of Beijing', '12342143', 'Ualink', '4', '975542400', 5, 'Beijing', 'Beijing Andelu Street', '100010', 'Ualink', '', 'Beijing City', 'Super market', 'Chow', 1, 4, '(086)10-84128912', '(086)10-84128912', '13022998888', 'steven@phpb2b.com', 'http://www.phpb2b.com/', 'sample/company/1.jpg', 1, 'Z', 1, 1, 1261989229, 1261965714);

-- 
-- Export data in the table `pb_membertypes`
-- 

INSERT INTO `pb_membertypes` VALUES (1, 7, 'Individual Member', '');
INSERT INTO `pb_membertypes` VALUES (2, 9, 'Corporate Member', '');

-- 
-- Export data in the table `pb_friendlinktypes`
-- 

INSERT INTO `pb_friendlinktypes` VALUES (1, 'Link');
INSERT INTO `pb_friendlinktypes` VALUES (2, 'Partners');

-- 
-- Export data in the table `pb_memberfields`
-- 

INSERT INTO `pb_memberfields` VALUES (1, 0, 0, 6, 7, 9, 'Steven', 'chow', 1, '', '', '', '', '', '', '', '', '', '', '', '', '127.0.0.1');
INSERT INTO `pb_memberfields` VALUES (2, 0, 0, 0, 0, 0, 'Jonny', 'wu', 0, '', '', '', '', '', '', '', '', '', '', '', '', '127.0.0.1');

-- 
-- Export data in the table `pb_members`
-- 

INSERT INTO `pb_members` VALUES (1, 'admin', 1, 'admin', '77963b7a931377ad4ab5ad6a9cd718aa', 'admin@yourdomain.com', 77, 128, 0.00, '1,2', '1', '', 2, 10, '1261985397', '', '1261495998', '1262100798', 0, '1256613871', '1261498436');
INSERT INTO `pb_members` VALUES (2, 'athena', 1, 'athena', 'e10adc3949ba59abbe56e057f20f883e', 'phpb2b@163.com', 81, 80, 0.00, '1,2', '1', '', 2, 9, '1261989658', '2130706433', '1261989039', '1262593839', 0, '1261989039', '1261989039');

-- 
-- Export data in the table `pb_navs`
-- 

INSERT INTO `pb_navs` VALUES (1, 0, 'Home', '', 'index.php', '_self', 1, 1, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (2, 0, 'Buy', '', 'buy/', '_self', 1, 2, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (3, 0, 'Sell', '', 'sell/', '_self', 1, 3, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (4, 0, 'Company', '', 'company/index.php', '_self', 1, 5, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (5, 0, 'Product', '', 'product/index.php', '_self', 1, 6, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (6, 0, 'Info', '', 'news/index.php', '_self', 1, 7, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (7, 0, 'Market', '', 'market/index.php', '_self', 1, 8, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (8, 0, 'Fair', '', 'fair/index.php', '_self', 1, 9, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (9, 0, 'Job', '', 'hr/index.php', '_self', 1, 10, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (10, 0, 'Invent', '', 'offer/list.php?typeid=8&navid=10', '_self', 1, 4, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (11, 0, 'Dictionary', '', 'dict/', '_self', 1, 11, 0, 0, '', 0, 0);

-- 
-- Export data in the table `pb_plugins`
-- 

INSERT INTO `pb_plugins` VALUES (1, 'hello', 'Demo plug-ins', 'This is a demonstration of plug-in, showing in the foreground image rotation on the', 'PB TEAM', '1.0', 'a:5:{s:5:"movie";s:24:"plugins/hello/bcastr.swf";s:5:"width";s:3:"473";s:6:"height";s:3:"170";s:7:"bgcolor";s:7:"#ff0000";s:9:"flashvars";s:27:"xml=plugins/hello/hello.xml";}', 1, 1260213787, 1260213787);
INSERT INTO `pb_plugins` VALUES (2, 'googlesitemap', 'Googlesitemap', 'Using the Google sitemap can improve the site/web pages ranking in the SERP', 'PB TEAM', '1.0', 'a:1:{s:7:"lastmod";s:19:"2009-12-08 12:12:12";}', 1, 1260263957, 1260263957);
INSERT INTO `pb_plugins` VALUES (4, 'vcastr', 'Enterprise Video Zhanbo', 'This plug-in can call corporate video, use the method see the plug-in call:<{plugin name="vcastr"}>', 'PB TEAM', '1.0', 'a:4:{s:5:"movie";s:27:"plugins/vcastr/vcastr22.swf";s:9:"flashvars";s:24:"plugins/vcastr/video.xml";s:5:"width";s:3:"410";s:6:"height";s:3:"190";}', 1, 1260949966, 1260949966);
INSERT INTO `pb_plugins` VALUES (5, 'qqservice', 'QQ Online Service', 'This plug-in now support online QQ, online MSN and email services', 'PB TEAM', '1.0', 'a:4:{s:3:"url";s:22:"http://www.phpb2b.com/";s:5:"email";s:17:"steven@phpb2b.com";s:2:"qq";s:8:"47731473";s:3:"msn";s:21:"stevenchow811@163.com";}', 1, 1260950430, 1260950430);
INSERT INTO `pb_plugins` VALUES (3, 'baidusitemap', 'Baidu sitemap', 'Baidu Internet Forum included the use of open protocols can increase Web Site Traffic', 'PB TEAM', '1.0', '', 1, 1261303439, 1261303439);

-- 
-- Export data in the table `pb_settings`
-- 

INSERT INTO `pb_settings` (variable,valued) VALUES ('site_name', 'B2B Web site name');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_title', 'B2B website title - appear in the title bar');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_banner_word', 'Web site promotion language');
INSERT INTO `pb_settings` (variable,valued) VALUES ('company_name', 'Web site of copyright');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_url', 'http://localhost/athena/');
INSERT INTO `pb_settings` (variable,valued) VALUES ('icp_number', 'ICP record number of<ID>');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_tel', '(86)10-84128912');
INSERT INTO `pb_settings` (variable,valued) VALUES ('sale_tel', '(86)10-84128912');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_qq', '100864825');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_msn', 'service_msn@yourdomain.com');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_email', 'service_email@yourdomain.com');
INSERT INTO `pb_settings` (type_id,variable,valued) VALUES (1,'site_description', '<p>Site detailed description of the</p>');
INSERT INTO `pb_settings` (variable,valued) VALUES ('cp_picture', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('register_picture', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('login_picture', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('vispost_auth', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('watermark', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('watertext', 'athena');
INSERT INTO `pb_settings` (variable,valued) VALUES ('watercolor', '#990000');
INSERT INTO `pb_settings` (variable,valued) VALUES ('add_market_check', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('regcheck', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('vis_post', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('vis_post_check', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('sell_logincheck', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('buy_logincheck', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('install_dateline', '1259471740');
INSERT INTO `pb_settings` (variable,valued) VALUES ('last_backup', '1259471740');
INSERT INTO `pb_settings` (variable,valued) VALUES ('smtp_server', 'smtp.yourdomain.com');
INSERT INTO `pb_settings` (variable,valued) VALUES ('smtp_port', '25');
INSERT INTO `pb_settings` (variable,valued) VALUES ('smtp_auth', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('mail_from', 'admin@yourdomain.com');
INSERT INTO `pb_settings` (variable,valued) VALUES ('mail_fromwho', 'Webmasters');
INSERT INTO `pb_settings` (variable,valued) VALUES ('auth_username', 'username@yourdomain.com');
INSERT INTO `pb_settings` (variable,valued) VALUES ('auth_password', 'password');
INSERT INTO `pb_settings` (variable,valued) VALUES ('send_mail', '2');
INSERT INTO `pb_settings` (variable,valued) VALUES ('sendmail_silent', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('mail_delimiter', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('reg_filename', 'register.php');
INSERT INTO `pb_settings` (variable,valued) VALUES ('new_userauth', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('post_filename', 'post.php');
INSERT INTO `pb_settings` (variable,valued) VALUES ('forbid_ip', '');
INSERT INTO `pb_settings` (variable,valued) VALUES ('ip_reg_sep', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('backup_dir', 'JretqR');
INSERT INTO `pb_settings` (variable,valued) VALUES ('capt_logging', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('capt_register', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('capt_post_free', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('capt_add_market', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('capt_login_admin', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('capt_apply_friendlink', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('capt_service', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('backup_type', '1');
INSERT INTO `pb_settings` (variable,valued) VALUES ('register_type', 'open_common_reg');
INSERT INTO `pb_settings` (variable,valued) VALUES ('auth_key', 'xFy9W2GuK8RCMe6');
INSERT INTO `pb_settings` (variable,valued) VALUES ('keyword_bidding', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('passport_support', '0');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_logo', 'images/logo.jpg');

-- 
-- Export data in the table `pb_friendlinks`
-- 

INSERT INTO `pb_friendlinks` VALUES (1, 0, 0, 0, 'PHPB2B', '', 'http://www.phpb2b.com/', 0, 1, '', 0, 0);
INSERT INTO `pb_friendlinks` VALUES (2, 0, 0, 0, 'PHPB2B E-commerce Web Demo', '', 'http://demo.phpb2b.com/', 0, 1, '', 0, 0);

-- 
-- Export data in the table `pb_tradetypes`
-- 

INSERT INTO `pb_tradetypes` VALUES (1, 'Buy', 0);
INSERT INTO `pb_tradetypes` VALUES (2, 'Sell', 0);
INSERT INTO `pb_tradetypes` VALUES (3, 'Agent', 0);
INSERT INTO `pb_tradetypes` VALUES (4, 'Cooperation', 0);
INSERT INTO `pb_tradetypes` VALUES (5, 'Merchants', 0);
INSERT INTO `pb_tradetypes` VALUES (6, 'Join', 0);
INSERT INTO `pb_tradetypes` VALUES (7, 'Wholesale', 0);
INSERT INTO `pb_tradetypes` VALUES (8, 'Inventory', 0);

-- 
-- Export data in the table `pb_typemodels`
-- 

INSERT INTO `pb_typemodels` VALUES (1, 'Expiration', 'offer_expire');
INSERT INTO `pb_typemodels` VALUES (2, 'Company Type', 'manage_type');
INSERT INTO `pb_typemodels` VALUES (3, 'Major markets', 'main_market');
INSERT INTO `pb_typemodels` VALUES (4, 'Registered capital', 'reg_fund');
INSERT INTO `pb_typemodels` VALUES (5, 'An annual turnover of', 'year_annual');
INSERT INTO `pb_typemodels` VALUES (6, 'Economic type', 'economic_type');
INSERT INTO `pb_typemodels` VALUES (7, 'Audit Status', 'check_status');
INSERT INTO `pb_typemodels` VALUES (8, 'Employees', 'employee_amount');
INSERT INTO `pb_typemodels` VALUES (9, 'State', 'common_status');
INSERT INTO `pb_typemodels` VALUES (10, 'Suggestion type', 'service_type');
INSERT INTO `pb_typemodels` VALUES (11, 'Educational experience', 'education');
INSERT INTO `pb_typemodels` VALUES (12, 'Wages', 'salary');
INSERT INTO `pb_typemodels` VALUES (13, 'The nature of work', 'work_type');
INSERT INTO `pb_typemodels` VALUES (14, 'Job Title', 'position');
INSERT INTO `pb_typemodels` VALUES (15, 'Gender', 'gender');
INSERT INTO `pb_typemodels` VALUES (16, 'Phone Type', 'phone_type');
INSERT INTO `pb_typemodels` VALUES (17, 'Instant Messaging Category', 'im_type');
INSERT INTO `pb_typemodels` VALUES (18, 'Options', 'common_option');

-- 
-- Export data in the table `pb_typeoptions`
-- 

INSERT INTO `pb_typeoptions` VALUES (1, 1, '10', '10 days');
INSERT INTO `pb_typeoptions` VALUES (2, 1, '30', 'Month');
INSERT INTO `pb_typeoptions` VALUES (3, 1, '90', 'Months');
INSERT INTO `pb_typeoptions` VALUES (4, 1, '180', 'Six');
INSERT INTO `pb_typeoptions` VALUES (5, 2, '1', 'Production');
INSERT INTO `pb_typeoptions` VALUES (6, 2, '2', 'Trade Type');
INSERT INTO `pb_typeoptions` VALUES (7, 2, '3', 'Service-oriented');
INSERT INTO `pb_typeoptions` VALUES (8, 2, '4', 'Government or other agencies');
INSERT INTO `pb_typeoptions` VALUES (9, 3, '1', 'China');
INSERT INTO `pb_typeoptions` VALUES (10, 3, '2', 'Hong Kong, Macao and Taiwan');
INSERT INTO `pb_typeoptions` VALUES (11, 3, '3', 'North');
INSERT INTO `pb_typeoptions` VALUES (12, 3, '4', 'South');
INSERT INTO `pb_typeoptions` VALUES (13, 3, '5', 'Europe');
INSERT INTO `pb_typeoptions` VALUES (14, 3, '6', 'Asia');
INSERT INTO `pb_typeoptions` VALUES (15, 3, '7', 'Africa');
INSERT INTO `pb_typeoptions` VALUES (16, 3, '8', 'Oceania');
INSERT INTO `pb_typeoptions` VALUES (17, 3, '9', 'Other markets');
INSERT INTO `pb_typeoptions` VALUES (18, 4, '0', 'Closed');
INSERT INTO `pb_typeoptions` VALUES (19, 4, '1', '100,000 yuan the following');
INSERT INTO `pb_typeoptions` VALUES (20, 4, '2', 'RMB 10-30 million');
INSERT INTO `pb_typeoptions` VALUES (21, 4, '3', '30-50 million yuan');
INSERT INTO `pb_typeoptions` VALUES (22, 4, '4', '50-100 million yuan');
INSERT INTO `pb_typeoptions` VALUES (23, 4, '5', 'RMB 100-300 million');
INSERT INTO `pb_typeoptions` VALUES (24, 4, '6', 'RMB 300-500 million');
INSERT INTO `pb_typeoptions` VALUES (25, 4, '7', '500-1000 10000 yuan');
INSERT INTO `pb_typeoptions` VALUES (26, 4, '8', 'RMB 1000-5000 10000');
INSERT INTO `pb_typeoptions` VALUES (27, 4, '9', 'More than 50 million yuan');
INSERT INTO `pb_typeoptions` VALUES (28, 4, '10', 'Other');
INSERT INTO `pb_typeoptions` VALUES (29, 5, '1', 'RMB 10 million or less/year');
INSERT INTO `pb_typeoptions` VALUES (30, 5, '2', 'RMB 10-30 million/year');
INSERT INTO `pb_typeoptions` VALUES (31, 5, '3', 'RMB 30-50 million/year');
INSERT INTO `pb_typeoptions` VALUES (32, 5, '4', 'RMB 50-100 million/year');
INSERT INTO `pb_typeoptions` VALUES (33, 5, '5', 'RMB 100-300 million/year');
INSERT INTO `pb_typeoptions` VALUES (34, 5, '6', 'RMB 300-500 million/year');
INSERT INTO `pb_typeoptions` VALUES (35, 5, '7', '500-1000 10000 RMB/year');
INSERT INTO `pb_typeoptions` VALUES (36, 5, '8', '1000-5000 10000 RMB/year');
INSERT INTO `pb_typeoptions` VALUES (37, 5, '9', 'More than RMB 50 million/year');
INSERT INTO `pb_typeoptions` VALUES (38, 5, '10', 'Other');
INSERT INTO `pb_typeoptions` VALUES (39, 6, '1', 'State-owned enterprises');
INSERT INTO `pb_typeoptions` VALUES (40, 6, '2', 'Collective enterprise');
INSERT INTO `pb_typeoptions` VALUES (41, 6, '3', 'Joint-stock cooperative');
INSERT INTO `pb_typeoptions` VALUES (42, 6, '4', 'Consortium');
INSERT INTO `pb_typeoptions` VALUES (43, 6, '5', 'Co., Ltd.');
INSERT INTO `pb_typeoptions` VALUES (44, 6, '6', 'Limited');
INSERT INTO `pb_typeoptions` VALUES (45, 6, '7', 'Private');
INSERT INTO `pb_typeoptions` VALUES (46, 6, '8', 'Sole Proprietorship');
INSERT INTO `pb_typeoptions` VALUES (47, 6, '9', 'Non-profit organization');
INSERT INTO `pb_typeoptions` VALUES (48, 6, '10', 'Other');
INSERT INTO `pb_typeoptions` VALUES (49, 7, '0', 'Invalid');
INSERT INTO `pb_typeoptions` VALUES (50, 7, '1', 'Effective');
INSERT INTO `pb_typeoptions` VALUES (51, 7, '2', 'Pending review');
INSERT INTO `pb_typeoptions` VALUES (52, 7, '3', 'Examination is not passed');
INSERT INTO `pb_typeoptions` VALUES (53, 8, '1', 'Less than 5');
INSERT INTO `pb_typeoptions` VALUES (54, 8, '2', '5-10 people');
INSERT INTO `pb_typeoptions` VALUES (55, 8, '3', '11-50 people');
INSERT INTO `pb_typeoptions` VALUES (56, 8, '4', '51-100 people');
INSERT INTO `pb_typeoptions` VALUES (57, 8, '5', '101-500 people');
INSERT INTO `pb_typeoptions` VALUES (58, 8, '6', '501-1000 people');
INSERT INTO `pb_typeoptions` VALUES (59, 8, '7', 'More than 1000');
INSERT INTO `pb_typeoptions` VALUES (60, 10, '1', 'Consulting');
INSERT INTO `pb_typeoptions` VALUES (61, 10, '2', 'Advice');
INSERT INTO `pb_typeoptions` VALUES (62, 10, '3', 'Complaints');
INSERT INTO `pb_typeoptions` VALUES (63, 11, '0', 'Other');
INSERT INTO `pb_typeoptions` VALUES (64, 11, '-1', 'Does not require');
INSERT INTO `pb_typeoptions` VALUES (65, 11, '-2', 'Open');
INSERT INTO `pb_typeoptions` VALUES (66, 11, '1', 'Dr.');
INSERT INTO `pb_typeoptions` VALUES (67, 11, '2', 'Master');
INSERT INTO `pb_typeoptions` VALUES (68, 11, '3', 'Undergraduate');
INSERT INTO `pb_typeoptions` VALUES (69, 11, '4', 'College');
INSERT INTO `pb_typeoptions` VALUES (70, 11, '5', 'Secondary');
INSERT INTO `pb_typeoptions` VALUES (71, 11, '6', 'Technical school');
INSERT INTO `pb_typeoptions` VALUES (72, 11, '7', 'High');
INSERT INTO `pb_typeoptions` VALUES (73, 11, '8', 'Junior');
INSERT INTO `pb_typeoptions` VALUES (74, 11, '9', 'Primary');
INSERT INTO `pb_typeoptions` VALUES (75, 12, '0', 'Do not choose to');
INSERT INTO `pb_typeoptions` VALUES (76, 12, '-1', 'Negotiable');
INSERT INTO `pb_typeoptions` VALUES (77, 12, '1', '1500 following');
INSERT INTO `pb_typeoptions` VALUES (78, 12, '2', '1,500-1,999 RMB/month');
INSERT INTO `pb_typeoptions` VALUES (79, 12, '3', '2000-2999 yuan/month');
INSERT INTO `pb_typeoptions` VALUES (80, 12, '4', '3000-4999 yuan/month');
INSERT INTO `pb_typeoptions` VALUES (81, 12, '5', 'More than 5000');
INSERT INTO `pb_typeoptions` VALUES (82, 13, '0', 'Do not choose to');
INSERT INTO `pb_typeoptions` VALUES (83, 13, '1', 'Full');
INSERT INTO `pb_typeoptions` VALUES (84, 13, '2', 'Part-time');
INSERT INTO `pb_typeoptions` VALUES (85, 13, '3', 'Provisional');
INSERT INTO `pb_typeoptions` VALUES (86, 13, '4', 'Internship');
INSERT INTO `pb_typeoptions` VALUES (87, 13, '5', 'Other');
INSERT INTO `pb_typeoptions` VALUES (88, 14, '0', 'Do not choose to');
INSERT INTO `pb_typeoptions` VALUES (89, 14, '1', 'Chairman');
INSERT INTO `pb_typeoptions` VALUES (90, 14, '2', 'Administration Manager/administrative staff');
INSERT INTO `pb_typeoptions` VALUES (91, 14, '3', 'Technical department manager/technical staff');
INSERT INTO `pb_typeoptions` VALUES (92, 14, '4', 'Production Manager/Production staff');
INSERT INTO `pb_typeoptions` VALUES (93, 14, '5', 'Marketing manager/marketing people');
INSERT INTO `pb_typeoptions` VALUES (94, 14, '6', 'Purchasing Manager/Procurement staff');
INSERT INTO `pb_typeoptions` VALUES (95, 14, '7', 'Sales Manager/Sales');
INSERT INTO `pb_typeoptions` VALUES (96, 14, '8', 'Other');
INSERT INTO `pb_typeoptions` VALUES (97, 15, '0', 'Do not choose to');
INSERT INTO `pb_typeoptions` VALUES (98, 15, '1', 'Male');
INSERT INTO `pb_typeoptions` VALUES (99, 15, '2', 'Female');
INSERT INTO `pb_typeoptions` VALUES (100, 15, '-1', '不限');
INSERT INTO `pb_typeoptions` VALUES (101, 16, '1', 'Mobile');
INSERT INTO `pb_typeoptions` VALUES (102, 16, '2', 'Residential');
INSERT INTO `pb_typeoptions` VALUES (103, 16, '3', 'Business Telephone');
INSERT INTO `pb_typeoptions` VALUES (104, 16, '4', 'Other');
INSERT INTO `pb_typeoptions` VALUES (105, 17, '1', 'QQ');
INSERT INTO `pb_typeoptions` VALUES (106, 17, '2', 'ICQ');
INSERT INTO `pb_typeoptions` VALUES (107, 17, '3', 'MSN Messenger');
INSERT INTO `pb_typeoptions` VALUES (108, 17, '4', 'Yahoo Messenger');
INSERT INTO `pb_typeoptions` VALUES (109, 17, '5', 'Skype');
INSERT INTO `pb_typeoptions` VALUES (110, 17, '6', 'Other');
INSERT INTO `pb_typeoptions` VALUES (111, 17, '0', 'Do not choose to');
INSERT INTO `pb_typeoptions` VALUES (112, 16, '0', 'Do not choose to');
INSERT INTO `pb_typeoptions` VALUES (113, 6, '0', 'Do not choose to');
INSERT INTO `pb_typeoptions` VALUES (114, 9, '0', 'Invalid');
INSERT INTO `pb_typeoptions` VALUES (115, 9, '1', 'Effective');
INSERT INTO `pb_typeoptions` VALUES (116, 18, '0', 'No');
INSERT INTO `pb_typeoptions` VALUES (117, 18, '1', 'Yes');

-- 
-- Export data in the table `pb_userpages`
-- 

INSERT INTO `pb_userpages` VALUES (1, '','aboutus', 'About', '', 'Note on the site', '', 0, 1260534240, 1261735115);
INSERT INTO `pb_userpages` VALUES (2, '','contactus', 'Contact', '', 'Contact', '', 0, 1260534240, 1261735050);
INSERT INTO `pb_userpages` VALUES (3, '','aboutads', 'Advertising', '', 'Description of advertising and price', '', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (4, '','sitemap', 'Sitemap', '', 'Web Site Map', 'sitemap.php', 0, 1260534240, 1261885046);
INSERT INTO `pb_userpages` VALUES (5, '','agreement', 'Legal Notices', '', 'Legal Notices', 'agreement.php', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (6, '','friendlink', 'Link', '', 'Application Link', 'friendlink.php', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (7, '','help', 'Help', '', 'Help', '', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (8, '','service', 'Comments complaints', '', 'Comments and suggestions, complaints', '', 0, 1260534240, 0);

-- 
-- Export data in the table `pb_forms`
-- 

INSERT INTO `pb_forms` VALUES (1, 1, 'Supply and demand of Custom Fields', '1,2,3,4,5,6');
INSERT INTO `pb_forms` VALUES (2, 2, 'Supply and demand of Custom Fields', '1,2,3,4,5,6');

-- 
-- Export data in the table `pb_formitems`
-- 

INSERT INTO `pb_formitems` VALUES (1, 1, 'The number of products', '', 'product_quantity', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (2, 1, 'Package Description', '', 'packing', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (3, 1, 'Price Description', '', 'product_price', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (4, 1, 'Specifications', '', 'product_specification', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (5, 1, 'No', '', 'serial_number', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (6, 1, 'Origin', '', 'production_place', 'text', '', 0);

-- 
-- Export data in the table `pb_templets`
-- 

INSERT INTO `pb_templets` VALUES (1, 'default', 'PHPB2B default template', 'skins/default/', 'user', 'Ualink E-commerce', 'PHPB2B default template sets of the Department of', 1, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (2, 'orange', 'Orange Series template', 'skins/orange/', 'user', 'PB TEAM', 'For health care enterprises', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (3, 'brown', 'Brown Series template', 'skins/brown/', 'user', 'PB TEAM', 'Suitable for industrial enterprises', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (4, 'green', 'Green Series template', 'skins/green/', 'user', 'PB TEAM', 'Suitable for agricultural web site', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (5, 'red', 'Red Series template', 'skins/red/', 'user', 'PB TEAM', 'Suitable for small and medium enterprises', 0, '0', '0', 1);

-- 
-- Export data in the table `pb_membergroups`
-- 

INSERT INTO `pb_membergroups` VALUES (1, 1, 'Associate members', '', 'system', 'private', 'informal.gif', 0, -32767, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (2, 1, 'Member', '', 'system', 'private', 'formal.gif', 32767, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 2, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (3, 1, 'For check', 'Awaiting verification', 'special', 'private', 'special_checking.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (4, 1, 'No visit', 'Block access to Web site', 'special', 'private', 'special_novisit.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (5, 1, 'No publish', 'Prohibition of any information in the business office issued a statement', 'special', 'private', 'special_noperm.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (6, 1, 'No landing', 'Prohibition of landing Commercial Office', 'special', 'private', 'special_nologin.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (7, 1, 'Ordinary Member', 'Ordinary Level Member', 'define', 'public', 'copper.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 2, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (8, 1, 'Member', 'Higher level than ordinary individual members, but individual members, or', 'define', 'public', 'silver.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 6, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (9, 2, 'Corporate Member', 'Corporate members in general this level', 'define', 'public', 'gold.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 3, 1, 1, 2, 15, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (10, 2, 'VIP Member', 'Senior Corporate Member', 'define', 'public', 'vip.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 3, 1, 1, 2, 15, 0, 1261303629);