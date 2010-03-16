-- 程序名稱: PHPB2B
-- 程序版本: 3.2 - ATHENA
-- 最後更新: 2010-3-15

-- 
-- 導出表中的數據 `pb_adzones`
-- 

INSERT INTO `pb_adzones` VALUES (1, '1', '首頁頂部小圖片廣告', '6個圖片壹行，首頁顯示', '', '1,234元/月', 'index.php', 760, 52, 6, 12, 0, 1261133418);
INSERT INTO `pb_adzones` VALUES (2, '1', '首頁958橫幅廣告', '免費開源，支持多國語言，PHPB2B-新壹代電子商務應用平臺', '', '3000', 'index.php', 958, 62, 0, 0, 1265678633, 1265678633);

-- 
-- 導出表中的數據 `pb_companies`
-- 

INSERT INTO `pb_companies` VALUES (1, 1, 'admin', 10, 0, '', 1, 11, 24, '1', '2', '3', 2, 'PHPB2B網站管理系統', 'PHPB2B', 'UALINK', '', '張三', '4', 3, 1, 'a:1:{s:12:"templet_name";b:0;}', '北京銀行', '12342143', '友鄰', '4', '975542400', 5, '北京', '北京市東城區', '100010', '友鄰', '', '北京市', '超市', '李四', 1, 4, '(086)10-84128912', '(086)10-84128912', '13022998888', 'steven@phpb2b.com', 'http://www.phpb2b.com/', 'sample/company/1.jpg', 1, 'Z', 1, 1, 1261989229, 1261965714);

-- 
-- 導出表中的數據 `pb_membertypes`
-- 

INSERT INTO `pb_membertypes` VALUES (1, 7, '個人會員', '');
INSERT INTO `pb_membertypes` VALUES (2, 9, '企業會員', '');

-- 
-- 導出表中的數據 `pb_friendlinktypes`
-- 

INSERT INTO `pb_friendlinktypes` VALUES (1, '友情鏈接');
INSERT INTO `pb_friendlinktypes` VALUES (2, '合作夥伴');

-- 
-- 導出表中的數據 `pb_memberfields`
-- 

INSERT INTO `pb_memberfields` VALUES (1, 0, 0, 6, 7, 9, '張', '三', 1, '', '', '', '', '', '', '', '', '', '', '', '', '127.0.0.1');
INSERT INTO `pb_memberfields` VALUES (2, 0, 0, 0, 0, 0, '李', '四', 0, '', '', '', '', '', '', '', '', '', '', '', '', '127.0.0.1');

-- 
-- 導出表中的數據 `pb_members`
-- 

INSERT INTO `pb_members` VALUES (1, 'admin', 1, 'admin', '77963b7a931377ad4ab5ad6a9cd718aa', 'admin@yourdomain.com', 77, 128, 0.00, '1,2', '1', '', 2, 10, '1261985397', '', '1261495998', '1262100798', 0, '1256613871', '1261498436');
INSERT INTO `pb_members` VALUES (2, 'athena', 1, 'athena', 'e10adc3949ba59abbe56e057f20f883e', 'phpb2b@163.com', 81, 80, 0.00, '1,2', '1', '', 2, 9, '1261989658', '2130706433', '1261989039', '1262593839', 0, '1261989039', '1261989039');

-- 
-- 導出表中的數據 `pb_navs`
-- 

INSERT INTO `pb_navs` VALUES (1, 0, '首頁', '', 'index.php', '_self', 1, 1, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (2, 0, '求購', '', 'buy/', '_self', 1, 2, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (3, 0, '供應', '', 'sell/', '_self', 1, 3, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (4, 0, '公司庫', '', 'company/index.php', '_self', 1, 5, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (5, 0, '產品庫', '', 'product/index.php', '_self', 1, 6, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (6, 0, '資訊', '', 'news/index.php', '_self', 1, 7, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (7, 0, '市場庫', '', 'market/index.php', '_self', 1, 8, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (8, 0, '展會', '', 'fair/index.php', '_self', 1, 9, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (9, 0, '人才招聘', '', 'hr/index.php', '_self', 1, 10, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (10, 0, '庫存', '', 'offer/list.php?typeid=8&navid=10', '_self', 1, 4, 0, 0, '', 0, 0);
INSERT INTO `pb_navs` VALUES (11, 0, '行業詞典', '', 'dict/', '_self', 1, 11, 0, 0, '', 0, 0);

-- 
-- 導出表中的數據 `pb_plugins`
-- 

INSERT INTO `pb_plugins` VALUES (1, 'hello', '演示的插件', '這是壹個演示的插件， 顯示在前臺的圖片輪換上', 'PB TEAM', '1.0', 'a:5:{s:5:"movie";s:24:"plugins/hello/bcastr.swf";s:5:"width";s:3:"473";s:6:"height";s:3:"170";s:7:"bgcolor";s:7:"#ff0000";s:9:"flashvars";s:27:"xml=plugins/hello/hello.xml";}', 1, 1260213787, 1260213787);
INSERT INTO `pb_plugins` VALUES (2, 'googlesitemap', 'Googlesitemap', '使用Google sitemap能提高網站/網頁在SERP中的排名', 'PB TEAM', '1.0', 'a:1:{s:7:"lastmod";s:19:"2009-12-08 12:12:12";}', 1, 1260263957, 1260263957);
INSERT INTO `pb_plugins` VALUES (4, 'vcastr', '企業視頻展播', '此插件可以調用企業視頻，使用方法見插件調用：<{plugin name="vcastr"}>', 'PB TEAM', '1.0', 'a:4:{s:5:"movie";s:27:"plugins/vcastr/vcastr22.swf";s:9:"flashvars";s:24:"plugins/vcastr/video.xml";s:5:"width";s:3:"410";s:6:"height";s:3:"190";}', 1, 1260949966, 1260949966);
INSERT INTO `pb_plugins` VALUES (5, 'qqservice', 'QQ在線客服', '本插件現支持在線QQ，在線MSN和郵件服務', 'PB TEAM', '1.0', 'a:4:{s:3:"url";s:22:"http://www.phpb2b.com/";s:5:"email";s:17:"steven@phpb2b.com";s:2:"qq";s:8:"47731473";s:3:"msn";s:21:"stevenchow811@163.com";}', 1, 1260950430, 1260950430);
INSERT INTO `pb_plugins` VALUES (3, 'baidusitemap', '百度sitemap', '使用百度互聯網論壇收錄開放協議能提高網站流量', 'PB TEAM', '1.0', '', 1, 1261303439, 1261303439);

-- 
-- 導出表中的數據 `pb_settings`
-- 

INSERT INTO `pb_settings` (variable,valued) VALUES ('site_name', 'B2B網站的名稱');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_title', 'B2B網站的標題-顯示在標題欄');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_banner_word', '網站的宣傳語');
INSERT INTO `pb_settings` (variable,valued) VALUES ('company_name', '網站的版權者');
INSERT INTO `pb_settings` (variable,valued) VALUES ('site_url', 'http://localhost/athena/');
INSERT INTO `pb_settings` (variable,valued) VALUES ('icp_number', 'ICP備案號碼<ID>');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_tel', '(86)10-84128912');
INSERT INTO `pb_settings` (variable,valued) VALUES ('sale_tel', '(86)10-84128912');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_qq', '100864825');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_msn', 'service_msn@yourdomain.com');
INSERT INTO `pb_settings` (variable,valued) VALUES ('service_email', 'service_email@yourdomain.com');
INSERT INTO `pb_settings` (type_id,variable,valued) VALUES (1,'site_description', '<p>網站的詳細描述</p>');
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
INSERT INTO `pb_settings` (variable,valued) VALUES ('mail_fromwho', '網站管理員');
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
-- 導出表中的數據 `pb_friendlinks`
-- 

INSERT INTO `pb_friendlinks` VALUES (1, 0, 0, 0, 'PHPB2B', '', 'http://www.phpb2b.com/', 0, 1, '', 0, 0);
INSERT INTO `pb_friendlinks` VALUES (2, 0, 0, 0, 'PHP B2B電子商務網演示', '', 'http://demo.phpb2b.com/', 0, 1, '', 0, 0);

-- 
-- 導出表中的數據 `pb_tradetypes`
-- 

INSERT INTO `pb_tradetypes` VALUES (1, '求購', 0);
INSERT INTO `pb_tradetypes` VALUES (2, '供應', 0);
INSERT INTO `pb_tradetypes` VALUES (3, '代理', 0);
INSERT INTO `pb_tradetypes` VALUES (4, '合作', 0);
INSERT INTO `pb_tradetypes` VALUES (5, '招商', 0);
INSERT INTO `pb_tradetypes` VALUES (6, '加盟', 0);
INSERT INTO `pb_tradetypes` VALUES (7, '批發', 0);
INSERT INTO `pb_tradetypes` VALUES (8, '庫存', 0);

-- 
-- 導出表中的數據 `pb_typemodels`
-- 

INSERT INTO `pb_typemodels` VALUES (1, '過期時間', 'offer_expire');
INSERT INTO `pb_typemodels` VALUES (2, '公司類型', 'manage_type');
INSERT INTO `pb_typemodels` VALUES (3, '主要市場', 'main_market');
INSERT INTO `pb_typemodels` VALUES (4, '註冊資金', 'reg_fund');
INSERT INTO `pb_typemodels` VALUES (5, '年營業額', 'year_annual');
INSERT INTO `pb_typemodels` VALUES (6, '經濟類型', 'economic_type');
INSERT INTO `pb_typemodels` VALUES (7, '審核狀態', 'check_status');
INSERT INTO `pb_typemodels` VALUES (8, '員工人數', 'employee_amount');
INSERT INTO `pb_typemodels` VALUES (9, '狀態', 'common_status');
INSERT INTO `pb_typemodels` VALUES (10, '建議類型', 'service_type');
INSERT INTO `pb_typemodels` VALUES (11, '教育經歷', 'education');
INSERT INTO `pb_typemodels` VALUES (12, '薪資水平', 'salary');
INSERT INTO `pb_typemodels` VALUES (13, '工作性質', 'work_type');
INSERT INTO `pb_typemodels` VALUES (14, '職位名稱', 'position');
INSERT INTO `pb_typemodels` VALUES (15, '性別', 'gender');
INSERT INTO `pb_typemodels` VALUES (16, '電話類別', 'phone_type');
INSERT INTO `pb_typemodels` VALUES (17, '即時通訊類別', 'im_type');
INSERT INTO `pb_typemodels` VALUES (18, '選項', 'common_option');

-- 
-- 導出表中的數據 `pb_typeoptions`
-- 

INSERT INTO `pb_typeoptions` VALUES (1, 1, '10', '10天');
INSERT INTO `pb_typeoptions` VALUES (2, 1, '30', '壹個月');
INSERT INTO `pb_typeoptions` VALUES (3, 1, '90', '三個月');
INSERT INTO `pb_typeoptions` VALUES (4, 1, '180', '六個月');
INSERT INTO `pb_typeoptions` VALUES (5, 2, '1', '生產型');
INSERT INTO `pb_typeoptions` VALUES (6, 2, '2', '貿易型');
INSERT INTO `pb_typeoptions` VALUES (7, 2, '3', '服務型');
INSERT INTO `pb_typeoptions` VALUES (8, 2, '4', '政府或其他機構');
INSERT INTO `pb_typeoptions` VALUES (9, 3, '1', '大陸');
INSERT INTO `pb_typeoptions` VALUES (10, 3, '2', '港澳臺');
INSERT INTO `pb_typeoptions` VALUES (11, 3, '3', '北美');
INSERT INTO `pb_typeoptions` VALUES (12, 3, '4', '南美');
INSERT INTO `pb_typeoptions` VALUES (13, 3, '5', '歐洲');
INSERT INTO `pb_typeoptions` VALUES (14, 3, '6', '亞洲');
INSERT INTO `pb_typeoptions` VALUES (15, 3, '7', '非洲');
INSERT INTO `pb_typeoptions` VALUES (16, 3, '8', '大洋洲');
INSERT INTO `pb_typeoptions` VALUES (17, 3, '9', '其他市場');
INSERT INTO `pb_typeoptions` VALUES (18, 4, '0', '不公開');
INSERT INTO `pb_typeoptions` VALUES (19, 4, '1', '人民幣10萬元以下');
INSERT INTO `pb_typeoptions` VALUES (20, 4, '2', '人民幣10-30萬');
INSERT INTO `pb_typeoptions` VALUES (21, 4, '3', '人民幣30-50萬');
INSERT INTO `pb_typeoptions` VALUES (22, 4, '4', '人民幣50-100萬');
INSERT INTO `pb_typeoptions` VALUES (23, 4, '5', '人民幣100-300萬');
INSERT INTO `pb_typeoptions` VALUES (24, 4, '6', '人民幣300-500萬');
INSERT INTO `pb_typeoptions` VALUES (25, 4, '7', '人民幣500-1000萬');
INSERT INTO `pb_typeoptions` VALUES (26, 4, '8', '人民幣1000-5000萬');
INSERT INTO `pb_typeoptions` VALUES (27, 4, '9', '人民幣5000萬以上');
INSERT INTO `pb_typeoptions` VALUES (28, 4, '10', '其他');
INSERT INTO `pb_typeoptions` VALUES (29, 5, '1', '人民幣10萬以下/年');
INSERT INTO `pb_typeoptions` VALUES (30, 5, '2', '人民幣10-30萬/年');
INSERT INTO `pb_typeoptions` VALUES (31, 5, '3', '人民幣30-50萬/年');
INSERT INTO `pb_typeoptions` VALUES (32, 5, '4', '人民幣50-100萬/年');
INSERT INTO `pb_typeoptions` VALUES (33, 5, '5', '人民幣100-300萬/年');
INSERT INTO `pb_typeoptions` VALUES (34, 5, '6', '人民幣300-500萬/年');
INSERT INTO `pb_typeoptions` VALUES (35, 5, '7', '人民幣500-1000萬/年');
INSERT INTO `pb_typeoptions` VALUES (36, 5, '8', '人民幣1000-5000萬/年');
INSERT INTO `pb_typeoptions` VALUES (37, 5, '9', '人民幣5000萬以上/年');
INSERT INTO `pb_typeoptions` VALUES (38, 5, '10', '其他');
INSERT INTO `pb_typeoptions` VALUES (39, 6, '1', '國有企業');
INSERT INTO `pb_typeoptions` VALUES (40, 6, '2', '集體企業');
INSERT INTO `pb_typeoptions` VALUES (41, 6, '3', '股份合作企業');
INSERT INTO `pb_typeoptions` VALUES (42, 6, '4', '聯營企業');
INSERT INTO `pb_typeoptions` VALUES (43, 6, '5', '有限責任公司');
INSERT INTO `pb_typeoptions` VALUES (44, 6, '6', '股份有限公司');
INSERT INTO `pb_typeoptions` VALUES (45, 6, '7', '私營企業');
INSERT INTO `pb_typeoptions` VALUES (46, 6, '8', '個人獨資企業');
INSERT INTO `pb_typeoptions` VALUES (47, 6, '9', '非盈利組織');
INSERT INTO `pb_typeoptions` VALUES (48, 6, '10', '其他');
INSERT INTO `pb_typeoptions` VALUES (49, 7, '0', '無效');
INSERT INTO `pb_typeoptions` VALUES (50, 7, '1', '有效');
INSERT INTO `pb_typeoptions` VALUES (51, 7, '2', '等待審核');
INSERT INTO `pb_typeoptions` VALUES (52, 7, '3', '審核不通過');
INSERT INTO `pb_typeoptions` VALUES (53, 8, '1', '5人以下');
INSERT INTO `pb_typeoptions` VALUES (54, 8, '2', '5-10人');
INSERT INTO `pb_typeoptions` VALUES (55, 8, '3', '11-50人');
INSERT INTO `pb_typeoptions` VALUES (56, 8, '4', '51-100人');
INSERT INTO `pb_typeoptions` VALUES (57, 8, '5', '101-500人');
INSERT INTO `pb_typeoptions` VALUES (58, 8, '6', '501-1000人');
INSERT INTO `pb_typeoptions` VALUES (59, 8, '7', '1000人以上');
INSERT INTO `pb_typeoptions` VALUES (60, 10, '1', '咨詢');
INSERT INTO `pb_typeoptions` VALUES (61, 10, '2', '建議');
INSERT INTO `pb_typeoptions` VALUES (62, 10, '3', '投訴');
INSERT INTO `pb_typeoptions` VALUES (63, 11, '0', '其他');
INSERT INTO `pb_typeoptions` VALUES (64, 11, '-1', '不要求');
INSERT INTO `pb_typeoptions` VALUES (65, 11, '-2', '不限');
INSERT INTO `pb_typeoptions` VALUES (66, 11, '1', '博士');
INSERT INTO `pb_typeoptions` VALUES (67, 11, '2', '碩士');
INSERT INTO `pb_typeoptions` VALUES (68, 11, '3', '本科');
INSERT INTO `pb_typeoptions` VALUES (69, 11, '4', '大專');
INSERT INTO `pb_typeoptions` VALUES (70, 11, '5', '中專');
INSERT INTO `pb_typeoptions` VALUES (71, 11, '6', '技校');
INSERT INTO `pb_typeoptions` VALUES (72, 11, '7', '高中');
INSERT INTO `pb_typeoptions` VALUES (73, 11, '8', '初中');
INSERT INTO `pb_typeoptions` VALUES (74, 11, '9', '小學');
INSERT INTO `pb_typeoptions` VALUES (75, 12, '0', '不選擇');
INSERT INTO `pb_typeoptions` VALUES (76, 12, '-1', '面議');
INSERT INTO `pb_typeoptions` VALUES (77, 12, '1', '1500以下');
INSERT INTO `pb_typeoptions` VALUES (78, 12, '2', '1500-1999元/月');
INSERT INTO `pb_typeoptions` VALUES (79, 12, '3', '2000-2999元/月');
INSERT INTO `pb_typeoptions` VALUES (80, 12, '4', '3000-4999元/月');
INSERT INTO `pb_typeoptions` VALUES (81, 12, '5', '5000以上');
INSERT INTO `pb_typeoptions` VALUES (82, 13, '0', '不選擇');
INSERT INTO `pb_typeoptions` VALUES (83, 13, '1', '全職');
INSERT INTO `pb_typeoptions` VALUES (84, 13, '2', '兼職');
INSERT INTO `pb_typeoptions` VALUES (85, 13, '3', '臨時');
INSERT INTO `pb_typeoptions` VALUES (86, 13, '4', '實習');
INSERT INTO `pb_typeoptions` VALUES (87, 13, '5', '其他');
INSERT INTO `pb_typeoptions` VALUES (88, 14, '0', '不選擇');
INSERT INTO `pb_typeoptions` VALUES (89, 14, '1', '董事長、總裁及副職，企業主、企業合夥人，總經理/副總經理');
INSERT INTO `pb_typeoptions` VALUES (90, 14, '2', '行政部門經理/行政人員');
INSERT INTO `pb_typeoptions` VALUES (91, 14, '3', '技術部門經理/技術人員');
INSERT INTO `pb_typeoptions` VALUES (92, 14, '4', '生產部門經理/生產人員');
INSERT INTO `pb_typeoptions` VALUES (93, 14, '5', '市場部門經理/市場人員');
INSERT INTO `pb_typeoptions` VALUES (94, 14, '6', '采購部門經理/采購人員');
INSERT INTO `pb_typeoptions` VALUES (95, 14, '7', '銷售部門經理/銷售人員');
INSERT INTO `pb_typeoptions` VALUES (96, 14, '8', '其他');
INSERT INTO `pb_typeoptions` VALUES (97, 15, '0', '不選擇');
INSERT INTO `pb_typeoptions` VALUES (98, 15, '1', '男');
INSERT INTO `pb_typeoptions` VALUES (99, 15, '2', '女');
INSERT INTO `pb_typeoptions` VALUES (100, 15, '-1', '不限');
INSERT INTO `pb_typeoptions` VALUES (101, 16, '1', '移動電話');
INSERT INTO `pb_typeoptions` VALUES (102, 16, '2', '住宅電話');
INSERT INTO `pb_typeoptions` VALUES (103, 16, '3', '商務電話');
INSERT INTO `pb_typeoptions` VALUES (104, 16, '4', '其他');
INSERT INTO `pb_typeoptions` VALUES (105, 17, '1', 'QQ');
INSERT INTO `pb_typeoptions` VALUES (106, 17, '2', 'ICQ');
INSERT INTO `pb_typeoptions` VALUES (107, 17, '3', 'MSN Messenger');
INSERT INTO `pb_typeoptions` VALUES (108, 17, '4', 'Yahoo Messenger');
INSERT INTO `pb_typeoptions` VALUES (109, 17, '5', 'Skype');
INSERT INTO `pb_typeoptions` VALUES (110, 17, '6', '其他');
INSERT INTO `pb_typeoptions` VALUES (111, 17, '0', '不選擇');
INSERT INTO `pb_typeoptions` VALUES (112, 16, '0', '不選擇');
INSERT INTO `pb_typeoptions` VALUES (113, 6, '0', '不選擇');
INSERT INTO `pb_typeoptions` VALUES (114, 9, '0', '無效');
INSERT INTO `pb_typeoptions` VALUES (115, 9, '1', '有效');
INSERT INTO `pb_typeoptions` VALUES (116, 18, '0', '否');
INSERT INTO `pb_typeoptions` VALUES (117, 18, '1', '是');

-- 
-- 導出表中的數據 `pb_userpages`
-- 

INSERT INTO `pb_userpages` VALUES (1, '','aboutus', '關於我們', '', '關於網站的說明', '', 0, 1260534240, 1261735115);
INSERT INTO `pb_userpages` VALUES (2, '','contactus', '聯系我們', '', '聯系方式', '', 0, 1260534240, 1261735050);
INSERT INTO `pb_userpages` VALUES (3, '','aboutads', '廣告服務', '', '廣告以及價格的說明', '', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (4, '','sitemap', '網站地圖', '', '網站站內地圖', 'sitemap.php', 0, 1260534240, 1261885046);
INSERT INTO `pb_userpages` VALUES (5, '','agreement', '法律聲明', '', '法律聲明', 'agreement.php', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (6, '','friendlink', '友情鏈接', '', '申請友情鏈接', 'friendlink.php', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (7, '','help', '幫助中心', '', '幫助中心', '', 0, 1260534240, 0);
INSERT INTO `pb_userpages` VALUES (8, '','service', '意見投訴', '', '意見與建議、投訴', '', 0, 1260534240, 0);

-- 
-- 導出表中的數據 `pb_forms`
-- 

INSERT INTO `pb_forms` VALUES (1, 1, '供求自定義字段', '1,2,3,4,5,6');
INSERT INTO `pb_forms` VALUES (2, 2, '產品自定義字段', '1,2,3,4,5,6');

-- 
-- 導出表中的數據 `pb_formitems`
-- 

INSERT INTO `pb_formitems` VALUES (1, 1, '產品數量', '', 'product_quantity', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (2, 1, '包裝說明', '', 'packing', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (3, 1, '價格說明', '', 'product_price', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (4, 1, '產品規格', '', 'product_specification', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (5, 1, '產品編號', '', 'serial_number', 'text', '', 0);
INSERT INTO `pb_formitems` VALUES (6, 1, '產地', '', 'production_place', 'text', '', 0);

-- 
-- 導出表中的數據 `pb_templets`
-- 

INSERT INTO `pb_templets` VALUES (1, 'default', 'PHPB2B默認模板套系', 'skins/default/', 'user', '友鄰電子商務科技有限公司', 'PHPB2B默認模板套系', 1, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (2, 'orange', '橙色系列模板', 'skins/orange/', 'user', 'PB TEAM', '適合醫療企事業', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (3, 'brown', '棕色系列模板', 'skins/brown/', 'user', 'PB TEAM', '適合工業企業', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (4, 'green', '綠色系列模板', 'skins/green/', 'user', 'PB TEAM', '適合農產品網站', 0, '0', '0', 1);
INSERT INTO `pb_templets` VALUES (5, 'red', '紅色系列模板', 'skins/red/', 'user', 'PB TEAM', '適合中小企業', 0, '0', '0', 1);

-- 
-- 導出表中的數據 `pb_membergroups`
-- 

INSERT INTO `pb_membergroups` VALUES (1, 1, '非正式會員', '', 'system', 'private', 'informal.gif', 0, -32767, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (2, 1, '正式會員', '', 'system', 'private', 'formal.gif', 32767, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 0, 2, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (3, 1, '待審核會員', '等待驗證', 'special', 'private', 'special_checking.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (4, 1, '禁止訪問', '禁止訪問網站', 'special', 'private', 'special_novisit.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (5, 1, '禁止發布', '禁止在商務室發表任何信息', 'special', 'private', 'special_noperm.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (6, 1, '禁止登陸', '禁止登陸商務室', 'special', 'private', 'special_nologin.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 0, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (7, 1, '普通會員', '普通級別會員', 'define', 'public', 'copper.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 2, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (8, 1, '正式會員', '比普通高壹級的個人會員，但是還是個人會員', 'define', 'public', 'silver.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 2, 6, 12, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (9, 2, '企業會員', '企業會員壹般此級別', 'define', 'public', 'gold.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 3, 1, 1, 2, 15, 0, 1261303629);
INSERT INTO `pb_membergroups` VALUES (10, 2, 'VIP會員', '高級企業會員', 'define', 'public', 'vip.gif', 0, 0, 0, 0, 0, 0, 3, 0, 0, 0, 0, 0, 3, 3, 3, 3, 3, 3, 3, 1, 1, 2, 15, 0, 1261303629);