<?php
defined('IN_UALINK') or exit('Permission Denied');
$ul_lang = array(
"user_feedback"=>"用户评论",
"member_not_exists"=>"用户不存在",
"member_exists"=>"用户名已经存在",
"companyname_exists"=>"公司名已经存在",
"login_pwd_false"=>"登陆密码错误",
"member_checking"=>"用户名审核中",
"login_false"=>"登陆失败",
"pls_input_username"=>"请输入用户名",
"pls_input_right_username"=>"请输入正确的用户名",
"pls_input_password"=>"请输入密码",
"pls_input_email"=>"请输入正确的Email",
"pls_input_companyname"=>"请输入正确的公司名称",
"pls_reinstall_program"=>"请重新安装程序包",
"save_false"=>"数据保存失败",
"data_not_exists"=>"该信息不存在",
"action"=>"操作",
"success"=>"成功",
"false"=>"失败",
"complete"=>"完成",
"error"=>"错误",
"sys_error"=>"系统错误",
"get_passwd_success"=>"发送成功，请尽快更改您的密码",
"get_passwd_false"=>"邮件格式错误，不能发送",
"confirm_iconv"=>"由于服务器不支持编码转换函数,可能会出现乱码,是否继续?",
"no_sell_data"=>"没有此供应的任何信息",
"pls_input_sell_id"=>"请输入供应信息编号",
"register_false"=>"会员注册失败",
"file_open_error"=>"文件打开错误",
"ad_quote_error"=>"广告文件调用失败",
"wait_check"=>"您的信息已提交,我们会尽快审核",
"wait_add"=>"您的数据已经提交，我们会尽快处理并及时添加",
"wait_apply"=>"您的申请已经成功提交,我们会尽快与贵站联系",
"email_good_reg"=>"该email地址可以注册",
"email_exists"=>"该email地址已经存在",
"wrong_username"=>"您输入的用户名有误",
"username_length"=>"用户名长度须为5-20个字符",
"username_numeric"=>"用户名不能全为数字",
"market_checking"=>"<h3>该市场库信息正在审核...</h3>",
"company_checking"=>"该企业信息不存在或还在审核中",
"aboutus"=>"关于我们",
"sitemap"=>"网站地图",
"action_success"=>"操作成功",
"action_false"=>"操作失败",
"apply_friendlink"=>"申请友情链接",
"wrong_validate"=>"验证码错误!",
"visitor_forbid"=>"%s 禁止了游客发布信息!",
"congratulate"=>"恭喜您!",
"sth_wrong"=>"出错啦!",
"commend_prod"=>"推荐产品",
"auth_error"=>"验证码错误",
"no_phpgd"=>"你没有安装GD库",
"login_false"=>"登陆失败",
"msg_wait_check"=>"您的信息已经提交，请等待审核！",
"pic_upload_error"=>"图片上传错误",
"pic_upload_false"=>"图片上传失败",
"old_pwd_error"=>"旧密码检测错误",
"not_defined_error"=>"未定义操作提示",
"company_not_exists"=>"您的公司资料还未填写,请补充完整!",
"data_not_exists"=>"该信息不存在",
"pls_login_first"=>"您必须先登陆才能继续执行此操作",
"no_data_deleted"=>"没有删除任何数据",
"action_complete"=>"操作完成,请返回",
"off_trade_amount"=>"您每天只能发布 %s 条供求信息",
"pls_select_picture"=>"必须选择相关图片文件",
"honour_false"=>"证书上传失败",
"link_name"=>"姓名",
"link_tel"=>"联系电话",
"link_im"=>"即时通讯",
"no_limit"=>"无限制",
"pls_del_first"=>"该分类下还有数据,请先删除",
"mx_prod_day"=>"您每天只能发布 %s 条产品信息",
"re_complete_corp"=>"您还没有输入您的公司资料，请补全或重新提交<font color=red><a href=./company.php>基本资料</a></font>再增加商品！",
"repeat_not_allowed"=>"不允许重复添加",
"auth_error"=>"验证码错误",
"no_phpgd"=>"你没有安装GD库",
"login_false"=>"登陆失败",
"attach_wrong"=>"图片上传错误",
"attach_false"=>"附件上传失败",
"action_false"=>"保存错误或者没有更新",
"by_hand"=>"手动备份",
"by_auto"=>"自动备份",
"backup_to"=>"原有的数据已经备份到",
"file_open_error"=>"文件打开错误",
"all_parent_ind"=>"所有大分类",
"start_upd_ind"=>"该操作比较耗时,点击开始",
"clear_memberlogs"=>"清空用户登陆日志",
"compile_file_clear"=>"所有编译文件已经清理完毕",
"system_error"=>"系统错误",
"static_file_clear"=>"所有静态文件已经清理完毕",
"gif_ok"=>"支持GIF",
"jpg_ok"=>"支持GIF",
"png_ok"=>"支持GIF",
"wbmp_ok"=>"支持手机Wap浏览图片BMP",
"without_this_ext"=>"您的系统不支持该php扩展",
"add"=>"添加",
"modify"=>"修改",
"delete"=>"删除",
"preview"=>"预览",
"return"=>"返回",
"cancel"=>"取消",
"complete"=>"完成",
"update"=>"更新",
"view"=>"查看",
"save"=>"保存",
"check_in"=>"审核通过",
"check_out"=>"审核不通过",
"check_in"=>"审核通过",
"search"=>"查询",
"record_not_exists"=>"%s 不存在",
"feedback_already_submit"=>"您的评论已经提交,如果您的浏览器没有自动跳转,请点击这里",
"more_permission"=>"查看%s 需要更多权限",
"record_status"=>"%s已经%s",
"page_not_exist"=>"%s 这个页面不存在",
"no_sub_industry"=>"<div id='divNextTwenty' align='center' class='time'>目前没有任何子分类。</div>",
"data_format_error"=>"<font color=red>数据格式错误</font>",
"file_open_error"=>"文件 %s 打开错误",
"file_wt_error"=>"文件 %s 写入错误",
"token_error"=>"生成文件 %s 时出现参数错误",
"picture_upload_error"=>"上传文件到 %s 的时候出错",
"allow_refresh_day"=>"网站设置了 %s 天之内允许重发一次",
"allow_update_hours"=>"%s 小时之内允许更新一次",
"yes_no"=>"否,是",
"if_valid"=>"无效,有效",
"product_sorts"=>'普通商品,最新产品,库存商品',
"product_status"=>'等待审核,有效信息,审核不通过,无效',
"corp_by_letter"=>"搜索以英文字母 %s 开头的企业库",
"company_checking"=>"%s 正在审核中",
"link_not_exists"=>"指定的链接对象不存在",
"link_add_ok"=>"添加链接成功",
"live_times"=>"1周,1个月,3个月,6个月,1年,5年",
"after_livetimes_do"=>"不取消任何权限,只在商务室首页提醒,禁止登陆,可以进入商务室_但是不允许发布任何信息",
"modules"=>"首页,求购,供应,公司库,产品库,行业资讯,市场库,展会",
"not_any_datas"=>"目前没有任何数据",
"common_coins"=>"元,美元,日元,英镑,法郎,卢布,台币",
"common_measures"=>"件,吨,千克,个,克",
"visit_limit"=>"游客每天只允许发布 %s 条该信息",
"buy_and_sell"=>"供求信息",
"search_additional"=>"搜索含有%s的%s数据",
"wrong_email_format"=>'Email地址格式有误',
"wrong_email_data"=>'Email地址出错',
"your_new_email"=>"%s,这是您在%s的新密码",
"email_send_false"=>'邮件发送不成功,错误信息: %s',
"company_center"=>'公司库',
"recommend"=>'推荐',
"corp_member"=>'企业会员',
"personal_member"=>'个人会员',
"expo_not_exists"=>'该展会不存在或者已过期',
"expo_channel"=>'展会频道',
"market_center"=>'市场库',
"info_center"=>'行业资讯',
"search_info_center"=>'搜索含有%s的资讯',
"view_info_center"=>'查看分类%s下的资讯',
"product_center"=>'产品库频道',
"urgent_offer"=>'紧急采购信息',
"offer_center"=>'供求信息',
"offer_by_corp"=>'企业发布的求购信息',
"upload_error"=>'上传失败,错误代码 #',
"one_day_max"=>'不能超过%s条',
"update_end"=>"<div id='update_end'>更新成功,是否现在就<a href='./industry.php?action=recache'>更新统计数据</a>到各首页？</div>",
"db_connect_error"=>'数据库主机连接错误',
"change_static_file_first"=>"请先打开静态文件设置,把 app/configs/core.php中的 STATIC_HTML_LEVEL 的值(原来为0) 改为1或2",
"ready_to_add_type"=>"你还没有添加任何分类，是否现在<a href='./newstype.php?action=mod'>添加</a>?",
"format_not_support"=>"暂不支持该文件格式，请用图片处理软件将图片转换为GIF、JPG、PNG格式。",
"water_image_not_exists"=>"需要加水印的图片不存在！",
"no_permission"=>"只有会员才能查看该信息",
"point_not_enough"=>"您的点数不够",
"have_expired"=>"已过期",
"page_header"=>"共<strong><span style=\"COLOR: #ff6600\">%s</span></strong>页&nbsp;&nbsp;每页显示<strong><span style=\"COLOR: #ff6600\">%s</span></strong>条记录,目前显示的是第<strong><span style=\"COLOR: #ff6600\">%s</span></strong>页.",
"adzone_position"=>"广告位置#%s",
"hr_channel"=>"人才",
"site_closed"=>"网站关闭了注册",
"invite_code_error"=>"邀请码错误",
);
?>