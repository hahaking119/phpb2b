-- 程序名称: PHPB2B
-- 程序版本: 3.2 - ATHENA
-- 最后更新: 2010-3-15

-- 
-- 导出表中的数据 `pb_adzones`
-- 

INSERT INTO `pb_adzones` VALUES (1, '1', '首页顶部小图片广告', '6个图片一行，首页显示', '', '1,234元/月', 'index.php', 760, 52, 6, 12, 0, 1261133418);
INSERT INTO `pb_adzones` VALUES (2, '1', '首页958横幅广告', '免费开源，支持多国语言，PHPB2B-新一代电子商务应用平台', '', '3000', 'index.php', 958, 62, 0, 0, 1265678633, 1265678633);

-- 
-- 导出表中的数据 `pb_companies`
-- 

INSERT INTO `pb_companies` VALUES (1, 1, 'admin', 10, 0, '', 1, 11, 24, '1', '2', '3', 2, 'PHPB2B网站管理系统', 'PHPB2B', 'UALINK', '', '张三', '4', 3, 1, 'a:1:{s:12:"templet_name";b:0;}', '北京银行', '12342143', '友邻', '4', '975542400', 5, '北京', '北京市东城区', '100010', '友邻', '', '北京市', '超市', '李四', 1, 4, '(086)10-84128912', '(086)10-84128912', '13022998888', 'steven@phpb2b.com', 'http://www.phpb2b.com/', 'sample/company/1.jpg', 1, 'Z', 1, 1, 1261989229, 1261965714);

-- 
-- 导出表中的数据 `pb_membertypes`
-- 

INSERT INTO `pb_membertypes` VALUES (1, 7, '个人会员', '');
INSERT INTO `pb_membertypes` VALUES (2, 9, '企业会员', '');

-- 
-- 导出表中的数据 `pb_friendlinktypes`
-- 

INSERT INTO `pb_friendlinktypes` VALUES (1, '友情链接');
INSERT INTO `pb_friendlinktypes` VALUES (2, '合作伙伴');

-- 
-- 导出表中的数据 `pb_memberfields`
-- 

INSERT INTO `pb_memberfields` VALUES (1, 0, 0, 6, 7, 9, '张', '三', 1, '', '', '', '', '', '', '', '', '', '', '', '', '127.0.0.1');
INSERT INTO `pb_memberfields` VALUES (2, 0, 0, 0, 0, 0, '李', '四', 0, '', '', '', '', '', '', '', '', '', '', '', '', '127.0.0.1');

-- 
-- 导出表中的数据 `pb_members`
-- 

INSERT INTO `pb_members` VALUES (1, 'admin', 1, 'admin', '77963b7a931377ad4ab5ad6a9cd718aa', 'admin@yourdomain.com', 77, 128, 0.00, '1,2', '1', '', 2, 10, '1261985397', '', '1261495998', '1262100798', 0, '1256613871', '1261498436');
INSERT INTO `pb_members` VALUES (2, 'athena', 1, 'athena', 'e10adc3949ba59abbe56e057f20f883e', 'phpb2b@163.com', 81, 80, 0.00, '1,2', '1', '', 2, 9, '1261989658', '2130706433', '1261989039', '1262593839', 0, '1261989039', '1261989039');

-- 
-- 导出表中的数据 `pb_navs`
-- 

INSERT INTO `pb_navs` VALUES (1, 0, '首页', '', 'index.php', '_self', 1, 1, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (2, 0, '求购', '', 'buy/', '_self', 1, 2, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (3, 0, '供应', '', 'sell/', '_self', 1, 3, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (4, 0, '公司库', '', 'company/index.php', '_self', 1, 5, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (5, 0, '产品库', '', 'product/index.php', '_self', 1, 6, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (6, 0, '资讯', '', 'news/index.php', '_self', 1, 7, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (7, 0, '市场库', '', 'market/index.php', '_self', 1, 8, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (8, 0, '展会', '', 'fair/index.php', '_self', 1, 9, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (9, 0, '人才招聘', '', 'hr/index.php', '_self', 1, 10, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (10, 0, '库存', '', 'offer/list.php?typeid=8&navid=10', '_self', 1, 4, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (11, 0, '行业词典', '', 'dict/', '_self', 1, 11, 0, 0, '', 0, 0);

-- 
-- 导出表中的数据 `pb_plugins`
-- 

INSERT INTO `pb_plugins` VALUES (1, 'hello', '演示的插件', '这是一个演示的插件， 显示在前台的图片轮换上', 'PB TEAM', '1.0', 'a:5:{s:5:"movie";s:24:"plugins/hello/bcastr.swf";s:5:"width";s:3:"473";s:6:"height";s:3:"170";s:7:"bgcolor";s:7:"#ff0000";s:9:"flashvars";s:27:"xml=plugins/hello/hello.xml";}', 1, 1260213787, 1260213787);
INSERT INTO `pb_plugins` VALUES (2, 'googlesitemap', 'Googlesitemap', '使用Google sitemap能提高网站/网页在SERP中的排名', 'PB TEAM', '1.0', 'a:1:{s:7:"lastmod";s:19:"2009-12-08 12:12:12";}', 1, 1260263957, 1260263957);
INSERT INTO `pb_plugins` VALUES (4, 'vcastr', '企业视频展播', '此插件可以调用企业视频，使用方法见插件调用：<{plugin name="vcastr"}>', 'PB TEAM', '1.0', 'a:4:{s:5:"movie";s:27:"plugins/vcastr/vcastr22.swf";s:9:"flashvars";s:24:"plugins/vcastr/video.xml";s:5:"width";s:3:"410";s:6:"height";s:3:"190";}', 1, 1260949966, 1260949966);
INSERT INTO `pb_plugins` VALUES (5, 'qqservice', 'QQ在线客服', '本插件现支持在线QQ，在线MSN和邮件服务', 'PB TEAM', '1.0', 'a:4:{s:3:"url";s:22:"http://www.phpb2b.com/";s:5:"email";s:17:"steven@phpb2b.com";s:2:"qq";s:8:"47731473";s:3:"msn";s:21:"stevenchow811@163.com";}', 1, 1260950430, 1260950430);
INSERT INTO `pb_plugins` VALUES (3, 'baidusitemap', '百度sitemap', '使用百度互联网论坛收录开放协议能提高网站流量', 'PB TEAM', '1.0', '', 1, 1261303439, 1261303439);

-- 
-- 导出表中的数据 `pb_settings`
-- 

INSERT INTO `pb_settings` (variable,valued) VALUES ('site_name', 'B2B网站的名称');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_title', 'B2B网站的标题-显示在标题栏');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_banner_word', '网站的宣传语');
INSERT INTO `pb_settings` (variable,valued) VALUES ('company_name', '网站的版权者');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_url', 'http://localhost/athena/');
INSERT INTO `pb_settings` (variable,valued) VALUES ('icp_number', 'ICP备案号码<ID>');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_tel', '(86)10-84128912');
INSERT INTO `pb_settings` (variable,valued) VALUES ('sale_tel', '(86)10-84128912');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_qq', '100864825');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_msn', 'service_msn@yourdomain.com');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_email', 'service_email@yourdomain.com');
INSERT INTO `pb_settings` (type_id,variable,valued) VALUES (1,'site_description', '<p>网站的详细描述</p>');
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
INSERT INTO `pb_settings` (variable,valued) VALUES ('mail_fromwho', '网站管理员');
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
-- 导出表中的数据 `pb_friendlinks`
-- 

INSERT INTO `pb_friendlinks` VALUES (1, 0, 0, 0, 'PHPB2B', '', 'http://www.phpb2b.com/', 0, 1, '', 0, 0);
INSERT INTO `pb_friendlinks` VALUES (2, 0, 0, 0, 'PHP B2B电子商务网演示', '', 'http://demo.phpb2b.com/', 0, 1, '', 0, 0);

-- 
-- 导出表中的数据 `pb_tradetypes`
-- 

INSERT INTO `pb_tradetypes` VALUES (1, '求购', 0);
INSERT INTO `pb_tradetypes` VALUES (2, '供应', 0);
INSERT INTO `pb_tradetypes` VALUES (3, '代理', 0);
INSERT INTO `pb_tradetypes` VALUES (4, '合作', 0);
INSERT INTO `pb_tradetypes` VALUES (5, '招商', 0);
INSERT INTO `pb_tradetypes` VALUES (6, '加盟', 0);
INSERT INTO `pb_tradetypes` VALUES (7, '批发', 0);
INSERT INTO `pb_tradetypes` VALUES (8, '库存', 0);

-- 
-- 导出表中的数据 `pb_typemodels`
-- 

INSERT INTO `pb_typemodels` VALUES (1, '过期时间', 'offer_expire');
INSERT INTO `pb_typemodels` VALUES (2, '公司类型', 'manage_type');
INSERT INTO `pb_typemodels` VALUES (3, '主要市场', 'main_market');
INSERT INTO `pb_typemodels` VALUES (4, '注册资金', 'reg_fund');
INSERT INTO `pb_typemodels` VALUES (5, '年营业额', 'year_annual');
INSERT INTO `pb_typemodels` VALUES (6, '经济类型', 'economic_type');
INSERT INTO `pb_typemodels` VALUES (7, '审核状态', 'check_status');
INSERT INTO `pb_typemodels` VALUES (8, '员工人数', 'employee_amount');
INSERT INTO `pb_typemodels` VALUES (9, '状态', 'common_status');
INSERT INTO `pb_typemodels` VALUES (10, '建议类型', 'service_type');
INSERT INTO `pb_typemodels` VALUES (11, '教育经历', 'education');
INSERT INTO `pb_typemodels` VALUES (12, '薪资水平', 'salary');
INSERT INTO `pb_typemodels` VALUES (13, '工作性质', 'work_type');
INSERT INTO `pb_typemodels` VALUES (14, '职位名称', 'position');
INSERT INTO `pb_typemodels` VALUES (15, '性别', 'gender');
INSERT INTO `pb_typemodels` VALUES (16, '电话类别', 'phone_type');
INSERT INTO `pb_typemodels` VALUES (17, '即时通讯类别', 'im_type');
INSERT INTO `pb_typemodels` VALUES (18, '选项', 'common_option');

-- 
-- 导出表中的数据 `pb_typeoptions`
-- 

INSERT INTO `pb_typeoptions` VALUES (1, 1, '10', '10天');
INSERT INTO `pb_typeoptions` VALUES (2, 1, '30', '一个月');
INSERT INTO `pb_typeoptions` VALUES (3, 1, '90', '三个月');
INSERT INTO `pb_typeoptions` VALUES (4, 1, '180', '六个月');
INSERT INTO `pb_typeoptions` VALUES (5, 2, '1', '生产型');
INSERT INTO `pb_typeoptions` VALUES (6, 2, '2', '贸易型');
INSERT INTO `pb_typeoptions` VALUES (7, 2, '3', '服务型');
INSERT INTO `pb_typeoptions` VALUES (8, 2, '4', '政府或其他机构');
INSERT INTO `pb_typeoptions` VALUES (9, 3, '1', '大陆');
INSERT INTO `pb_typeoptions` VALUES (10, 3, '2', '港澳台');
INSERT INTO `pb_typeoptions` VALUES (11, 3, '3', '北美');
INSERT INTO `pb_typeoptions` VALUES (12, 3, '4', '南美');
INSERT INTO `pb_typeoptions` VALUES (13, 3, '5', '欧洲');
INSERT INTO `pb_typeoptions` VALUES (14, 3, '6', '亚洲');
INSERT INTO `pb_typeoptions` VALUES (15, 3, '7', '非洲');
INSERT INTO `pb_typeoptions` VALUES (16, 3, '8', '大洋洲');
INSERT INTO `pb_typeoptions` VALUES (17, 3, '9', '其他市场');
INSERT INTO `pb_typeoptions` VALUES (18, 4, '0', '不公开');
INSERT INTO `pb_typeoptions` VALUES (19, 4, '1', '人民币10万元以下');
INSERT INTO `pb_typeoptions` VALUES (20, 4, '2', '人民币10-30万');
INSERT INTO `pb_typeoptions` VALUES (21, 4, '3', '人民币30-50万');
INSERT INTO `pb_typeoptions` VALUES (22, 4, '4', '人民币50-100万');
INSERT INTO `pb_typeoptions` VALUES (23, 4, '5', '人民币100-300万');
INSERT INTO `pb_typeoptions` VALUES (24, 4, '6', '人民币300-500万');
INSERT INTO `pb_typeoptions` VALUES (25, 4, '7', '人民币500-1000万');
INSERT INTO `pb_typeoptions` VALUES (26, 4, '8', '人民币1000-5000万');
INSERT INTO `pb_typeoptions` VALUES (27, 4, '9', '人民币5000万以上');
INSERT INTO `pb_typeoptions` VALUES (28, 4, '10', '其他');
INSERT INTO `pb_typeoptions` VALUES (29, 5, '1', '人民币10万以下/年');
INSERT INTO `pb_typeoptions` VALUES (30, 5, '2', '人民币10-30万/年');
INSERT INTO `pb_typeoptions` VALUES (31, 5, '3', '人民币30-50万/年');
INSERT INTO `pb_typeoptions` VALUES (32, 5, '4', '人民币50-100万/年');
INSERT INTO `pb_typeoptions` VALUES (33, 5, '5', '人民币100-300万/年');
INSERT INTO `pb_typeoptions` VALUES (34, 5, '6', '人民币300-500万/年');
INSERT INTO `pb_typeoptions` VALUES (35, 5, '7', '人民币500-1000万/年');
INSERT INTO `pb_typeoptions` VALUES (36, 5, '8', '人民币1000-5000万/年');
INSERT INTO `pb_typeoptions` VALUES (37, 5, '9', '人民币5000万以上/年');
INSERT INTO `pb_typeoptions` VALUES (38, 5, '10', '其他');
INSERT INTO `pb_typeoptions` VALUES (39, 6, '1', '国有企业');
INSERT INTO `pb_typeoptions` VALUES (40, 6, '2', '集体企业');
INSERT INTO `pb_typeoptions` VALUES (41, 6, '3', '股份合作企业');
INSERT INTO `pb_typeoptions` VALUES (42, 6, '4', '联营企业');
INSERT INTO `pb_typeoptions` VALUES (43, 6, '5', '有限责任公司');
INSERT INTO `pb_typeoptions` VALUES (44, 6, '6', '股份有限公司');
INSERT INTO `pb_typeoptions` VALUES (45, 6, '7', '私营企业');
INSERT INTO `pb_typeoptions` VALUES (46, 6, '8', '个人独资企业');
INSERT INTO `pb_typeoptions` VALUES (47, 6, '9', '非盈利组织');
INSERT INTO `pb_typeoptions` VALUES (48, 6, '10', '其他');
INSERT INTO `pb_typeoptions` VALUES (49, 7, '0', '无效');
INSERT INTO `pb_typeoptions` VALUES (50, 7, '1', '有效');
INSERT INTO `pb_typeoptions` VALUES (51, 7, '2', '等待审核');
INSERT INTO `pb_typeoptions` VALUES (52, 7, '3', '审核不通过');
INSERT INTO `pb_typeoptions` VALUES (53, 8, '1', '5人以下');
INSERT INTO `pb_typeoptions` VALUES (54, 8, '2', '5-10人');
INSERT INTO `pb_typeoptions` VALUES (55, 8, '3', '11-50人');
INSERT INTO `pb_typeoptions` VALUES (56, 8, '4', '51-100人');
INSERT INTO `pb_typeoptions` VALUES (57, 8, '5', '101-500人');
INSERT INTO `pb_typeoptions` VALUES (58, 8, '6', '501-1000人');
INSERT INTO `pb_typeoptions` VALUES (59, 8, '7', '1000人以上');
INSERT INTO `pb_typeoptions` VALUES (60, 10, '1', '咨询');
INSERT INTO `pb_typeoptions` VALUES (61, 10, '2', '建议');
INSERT INTO `pb_typeoptions` VALUES (62, 10, '3', '投诉');
INSERT INTO `pb_typeoptions` VALUES (63, 11, '0', '其他');
INSERT INTO `pb_typeoptions` VALUES (64, 11, '-1', '不要求');
INSERT INTO `pb_typeoptions` VALUES (65, 11, '-2', '不限');
INSERT INTO `pb_typeoptions` VALUES (66, 11, '1', '博士');
INSERT INTO `pb_typeoptions` VALUES (67, 11, '2', '硕士');
INSERT INTO `pb_typeoptions` VALUES (68, 11, '3', '本科');
INSERT INTO `pb_typeoptions` VALUES (69, 11, '4', '大专');
INSERT INTO `pb_typeoptions` VALUES (70, 11, '5', '中专');
INSERT INTO `pb_typeoptions` VALUES (71, 11, '6', '技校');
INSERT INTO `pb_typeoptions` VALUES (72, 11, '7', '高中');
INSERT INTO `pb_typeoptions` VALUES (73, 11, '8', '初中');
INSERT INTO `pb_typeoptions` VALUES (74, 11, '9', '小学');
INSERT INTO `pb_typeoptions` VALUES (75, 12, '0', '不选择');
INSERT INTO `pb_typeoptions` VALUES (76, 12, '-1', '面议');
INSERT INTO `pb_typeoptions` VALUES (77, 12, '1', '1500以下');
INSERT INTO `pb_typeoptions` VALUES (78, 12, '2', '1500-1999元/月');
INSERT INTO `pb_typeoptions` VALUES (79, 12, '3', '2000-2999元/月');
INSERT INTO `pb_typeoptions` VALUES (80, 12, '4', '3000-4999元/月');
INSERT INTO `pb_typeoptions` VALUES (81, 12, '5', '5000以上');
INSERT INTO `pb_typeoptions` VALUES (82, 13, '0', '不选择');
INSERT INTO `pb_typeoptions` VALUES (83, 13, '1', '全职');
INSERT INTO `pb_typeoptions` VALUES (84, 13, '2', '兼职');
INSERT INTO `pb_typeoptions` VALUES (85, 13, '3', '临时');
INSERT INTO `pb_typeoptions` VALUES (86, 13, '4', '实习');
INSERT INTO `pb_typeoptions` VALUES (87, 13, '5', '其他');
INSERT INTO `pb_typeoptions` VALUES (88, 14, '0', '不选择');
INSERT INTO `pb_typeoptions` VALUES (89, 14, '1', '董事长、总裁及副职，企业主、企业合伙人，总经理/副总经理');
INSERT INTO `pb_typeoptions` VALUES (90, 14, '2', '行政部门经理/行政人员');
INSERT INTO `pb_typeoptions` VALUES (91, 14, '3', '技术部门经理/技术人员');
INSERT INTO `pb_typeoptions` VALUES (92, 14, '4', '生产部门经理/生产人员');
INSERT INTO `pb_typeoptions` VALUES (93, 14, '5', '市场部门经理/市场人员');
INSERT INTO `pb_typeoptions` VALUES (94, 14, '6', '采购部门经理/采购人员');
INSERT INTO `pb_typeoptions` VALUES (95, 14, '7', '销售部门经理/销售人员');
INSERT INTO `pb_typeoptions` VALUES (96, 14, '8', '其他');
INSERT INTO `pb_typeoptions` VALUES (97, 15, '0', '不选择');
INSERT INTO `pb_typeoptions` VALUES (98, 15, '1', '男');
INSERT INTO `pb_typeoptions` VALUES (99, 15, '2', '女');
INSERT INTO `pb_typeoptions` VALUES (100, 15, '-1', '不限');
INSERT INTO `pb_typeoptions` VALUES (101, 16, '1', '移动电话');
INSERT INTO `pb_typeoptions` VALUES (102, 16, '2', '住宅电话');
INSERT INTO `pb_typeoptions` VALUES (103, 16, '3', '商务电话');
INSERT INTO `pb_typeoptions` VALUES (104, 16, '4', '其他');
INSERT INTO `pb_typeoptions` VALUES (105, 17, '1', 'QQ');
INSERT INTO `pb_typeoptions` VALUES (106, 17, '2', 'ICQ');
INSERT INTO `pb_typeoptions` VALUES (107, 17, '3', 'MSN Messenger');
INSERT INTO `pb_typeoptions` VALUES (108, 17, '4', 'Yahoo Messenger');
INSERT INTO `pb_typeoptions` VALUES (109, 17, '5', 'Skype');
INSERT INTO `pb_typeoptions` VALUES (110, 17, '6', '其他');
INSERT INTO `pb_typeoptions` VALUES (111, 17, '0', '不选择');
INSERT INTO `pb_typeoptions` VALUES (112, 16, '0', '不选择');
INSERT INTO `pb_typeoptions` VALUES (113, 6, '0', '不选择');
INSERT INTO `pb_typeoptions` VALUES (114, 9, '0', '无效');
INSERT INTO `pb_typeoptions` VALUES (115, 9, '1', '有效');
INSERT INTO `pb_typeoptions` VALUES (116, 18, '0', '否');
INSERT INTO `pb_typeoptions` VALUES (117, 18, '1', '是');

-- 
-- 导出表中的数据 `pb_userpages`
-- 

INSERT INTO `pb_userpages` VALUES (1, '','aboutus', '关于我们', '', '关于网站的说明', '', 0, 1260534240, 1261735115);
INSERT INTO `pb_userpages` VALUES (2, '','contactus', '联系我们', '', '联系方式', '', 0, 1260534240, 1261735050);
INSERT INTO `pb_userpages` VALUES (3, '','aboutads', '广告服务', '', '广告以及价格的说明', '', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (4, '','sitemap', '网站地图', '', '网站站内地图', 'sitemap.php', 0, 1260534240, 1261885046);
INSERT INTO `pb_userpages` VALUES (5, '','agreement', '法律声明', '', '法律声明', 'agreement.php', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (6, '','friendlink', '友情链接', '', '申请友情链接', 'friendlink.php', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (7, '','help', '帮助中心', '', '帮助中心', '', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (8, '','service', '意见投诉', '', '意见与建议、投诉', '', 0, 1260534240, 0);

-- 
-- 导出表中的数据 `pb_forms`
-- 

INSERT INTO `pb_forms` VALUES (1, 1, '供求自定义字段', '1,2,3,4,5,6');
INSERT INTO `pb_forms` VALUES (2, 2, '产品自定义字段', '1,2,3,4,5,6');

-- 
-- 导出表中的数据 `pb_formitems`
-- 

INSERT INTO `pb_formitems` VALUES (1, 1, '产品数量', '', 'product_quantity', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (2, 1, '包装说明', '', 'packing', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (3, 1, '价格说明', '', 'product_price', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (4, 1, '产品规格', '', 'product_specification', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (5, 1, '产品编号', '', 'serial_number', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (6, 1, '产地', '', 'production_place', 'text', '', 0);

-- 
-- 导出表中的数据 `pb_templets`
-- 

INSERT INTO `pb_templets` VALUES (1, 'default', 'PHPB2B默认模板套系', 'skins/default/', 'user', '友邻电子商务科技有限公司', 'PHPB2B默认模板套系', 1, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (2, 'orange', '橙色系列模板', 'skins/orange/', 'user', 'PB TEAM', '适合医疗企事业', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (3, 'brown', '棕色系列模板', 'skins/brown/', 'user', 'PB TEAM', '适合工业企业', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (4, 'green', '绿色系列模板', 'skins/green/', 'user', 'PB TEAM', '适合农产品网站', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (5, 'red', '红色系列模板', 'skins/red/', 'user', 'PB TEAM', '适合中小企业', 0, '0', '0', 1);

-- 
-- 导出表中的数据 `pb_membergroups`
-- 

INSERT INTO `pb_membergroups` VALUES (1, 1, '非正式会员', '', 'system', 'private', 'informal.gif', 0, -32767, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (2, 1, '正式会员', '', 'system', 'private', 'formal.gif', 32767, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 2, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (3, 1, '待审核会员', '等待验证', 'special', 'private', 'special_checking.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (4, 1, '禁止访问', '禁止访问网站', 'special', 'private', 'special_novisit.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (5, 1, '禁止发布', '禁止在商务室发表任何信息', 'special', 'private', 'special_noperm.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (6, 1, '禁止登陆', '禁止登陆商务室', 'special', 'private', 'special_nologin.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (7, 1, '普通会员', '普通级别会员', 'define', 'public', 'copper.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 2, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (8, 1, '正式会员', '比普通高一级的个人会员，但是还是个人会员', 'define', 'public', 'silver.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 6, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (9, 2, '企业会员', '企业会员一般此级别', 'define', 'public', 'gold.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 3, 1, 1, 2, 15, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (10, 2, 'VIP会员', '高级企业会员', 'define', 'public', 'vip.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 3, 1, 1, 2, 15, 0, 1261303629);