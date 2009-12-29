<?php
/**
 * NOTE   :  PHP versions 4 and 5
 *
 * PHPB2B :  An Opensource Business To Business E-Commerce Script (http://www.phpb2b.com/)
 * Copyright 2007-2009, Ualink E-Commerce Co,. Ltd.
 *
 * Licensed under The GPL License (http://www.opensource.org/licenses/gpl-license.php)
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 * 
 * @copyright Copyright 2007-2009, Ualink E-Commerce Co,. Ltd. (http://phpb2b.com)
 * @since PHPB2B v 1.0.0
 * @link http://phpb2b.com
 * @package phpb2b
 * @version $Id: menu.php 427 2009-12-26 13:45:47Z steven $
 */
$menus = array(
    'dashboard' => array(
        'text'      => "首页",
        'subtext'   => "常用操作",
        'default'   => 'welcome',
        'children'  => array(
            'welcome'   => array(
                'text'  => "欢迎页面",
                'url'   => 'home.php',
            ),
            'basic_setting'  => array(
                'parent'=> 'setting',
                'text'  => "网站设置",
                'url'   => 'setting.php?do=basic',
            ),
            'member'  => array(
                'parent'=> 'members',
                'text'  => "会员管理",
                'url'   => 'member.php',
            ),
            'note'  => array(
                'parent'=> 'tools',
                'text'  => "我的笔记",
                'url'   => 'adminnote.php',
            ),
        ),
    ),
    'setting'   => array(
        'text'      => "全局",
        'default'   => 'basic_setting',
        'children'  => array(
            'basic_setting'  => array(
                'text'  => "站点信息",
                'url'   => 'setting.php?do=basic',
            ), 
            'register' => array(
                'text'  => "注册与访问",
                'url'   => 'setting.php?do=register',
            ),
			 'functions' => array(
                'text'  => "网站功能",
                'url'   => 'setting.php?do=functions',
            ),
			 'auth' => array(
                'text'  => "安全验证",
                'url'   => 'setting.php?do=auth',
            ),
			 'industry' => array(
                'text'  => "行业分类",
                'url'   => 'industry.php',
            ),
			 'area' => array(
                'text'  => "地区",
                'url'   => 'area.php',
            ),
			 'announce' => array(
                'text'  => "网站公告",
                'url'   => 'announce.php',
            ),
			 'userpage' => array(
                'text'  => "自定义页面",
                'url'   => 'userpage.php',
            ),
			 'service' => array(
                'text'  => "用户留言",
                'url'   => 'service.php',
            ),
			 'help' => array(
                'text'  => "帮助文件",
                'url'   => 'help.php',
            ),
			 'email' => array(
                'text'  => "Email邮件设置",
                'url'   => 'setting.php?do=email',
            ),
        ),
    ),
    'infocenter' => array(
        'text'      => "信息管理",
        'default'   => 'trade',
        'children'  => array(
            'trade' => array(
                'text'  => '供求信息',
                'url'   => 'offer.php',
            ),
            'product' => array(
                'text'  => '产品中心',
                'url'   => 'product.php',
            ),
            'company' => array(
                'text'  => '公司库',
                'url'   => 'company.php',
            ),
            'market' => array(
                'text'  => '专业市场',
                'url'   => 'market.php',
            ),
            'job' => array(
                'text'  => '招聘信息',
                'url'   => 'job.php',
            ),
            'fair' => array(
                'text'  => '展会信息',
                'url'   => 'fair.php',
            ),
            'news' => array(
                'text'  => '行业资讯',
                'url'   => 'news.php',
            ),
            'tag' => array(
                'text'  => '标签库',
                'url'   => 'tag.php',
            ),
            'companynews' => array(
                'text'  => '企业新闻',
                'url'   => 'companynews.php',
            ),
                                    
        ),
    ),
    'members'     => array(
        'text'      => "用户中心",
        'default'   => 'member',
        'children'  => array(
            'member' => array(
                'text'  => '会员中心',
                'url'   => 'member.php',
            ),
			'membergroup'  => array(
                'text'  => '会员组',
                'url'   => 'membergroup.php?type=define',
            ),
            'member_add' => array(
                'text'  => '添加会员',
                'url'   => 'member.php?do=edit',
            ),
            'member_add' => array(
                'text'  => '短消息',
                'url'   => 'message.php',
            ),
			 'adminer' => array(
                'text'  => '管理员',
                'url'   => 'adminer.php',
            ),
			 'adminer_passwd' => array(
                'text'  => '密码修改',
                'url'   => 'adminer.php?do=password',
            ),
        ),
    ),
    'ads' => array(
        'text'      => "广告",
        'default'   => 'ad',
        'children'  => array(
            'ad' => array(
                'text'  => '广告',
                'url'   => 'ad.php',
            ),
			 'ad_add' => array(
                'text'  => '添加广告',
                'url'   => 'ad.php?do=edit',
            ),
			 'adzone' => array(
                'text'  => '广告位',
                'url'   => 'adzone.php',
            ),
            'goods' => array(
                'text'  => '服务管理',
                'url'   => 'goods.php',
            ),
            'order' => array(
                'text'  => '订单中心',
                'url'   => 'order.php',
            ),
			 'friendlink' => array(
                'text'  => '友情链接',
                'url'   => 'friendlink.php',
            ),
        ),
    ),
    'templet' => array(
        'text'      => "模板风格",
        'default'   => 'skin',
        'children'  => array(
			 'skin' => array(
                'text'  => '企业模板',
                'url'   => 'templet.php?type=user',
            ),
			 'nav' => array(
                'text'  => '导航栏',
                'url'   => 'nav.php',
            ),
        ),
    ),
    'tools' => array(
        'text'      => '系统工具',
        'default'   => 'cache_update',
        'children'  => array(
            'cache_update' => array(
                'text'  => '缓存',
                'url'   => 'htmlcache.php',
            ),
			 'log' => array(
                'text'  => '日志查看',
                'url'   => 'log.php',
            ),
            'db' => array(
                'text'  => '数据库',
                'url'   => 'db.php',
            ),
			 'passport' => array(
                'text'  => '通行证',
                'url'   => 'passport.php',
            ),
            'payment' => array(
                'text'  => '支付方式',
                'url'   => 'payment.php',
            ),
			 'note' => array(
                'text'  => '我的笔记',
                'url'   => 'adminnote.php',
            ),
        ),
    ),
    'plugins' => array(
        'text'      => "插件",
        'default'   => 'plugin',
        'children'  => array(
            'plugin'   => array(
                'text'  => "管理",
                'url'   => 'plugin.php',
            ),
        ),
    ),
);
?>