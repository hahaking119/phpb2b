<?php

define('UC_CONNECT', 'mysql');				// ���� UCenter �ķ�ʽ: mysql/NULL, Ĭ��Ϊ��ʱΪ fscoketopen()
							// mysql ��ֱ�����ӵ����ݿ�, Ϊ��Ч��, ������� mysql

//���ݿ���� (mysql ����ʱ, ����û������ UC_DBLINK ʱ, ��Ҫ�������±���)
define('UC_DBHOST', 'localhost');			// UCenter ���ݿ�����
define('UC_DBUSER', 'root');				// UCenter ���ݿ��û���
define('UC_DBPW', '123456');					// UCenter ���ݿ�����
define('UC_DBNAME', 'discuz');				// UCenter ���ݿ�����
define('UC_DBCHARSET', 'utf8');				// UCenter ���ݿ��ַ���
define('UC_DBTABLEPRE', 'discuz.cdb_uc_');			// UCenter ���ݿ��ǰ׺

//ͨ�����
define('UC_KEY', 'xFy9W2GuK8RCMe6');				// �� UCenter ��ͨ����Կ, Ҫ�� UCenter ����һ��
define('UC_API', 'http://localhost/discuz/uc_server/');	// UCenter �� URL ��ַ, �ڵ���ͷ��ʱ�����˳���
define('UC_CHARSET', 'utf-8');				// UCenter ���ַ���
define('UC_IP', '127.0.0.1');					// UCenter �� IP, �� UC_CONNECT Ϊ�� mysql ��ʽʱ, ���ҵ�ǰӦ�÷�������������������ʱ, �����ô�ֵ
define('UC_APPID', 3);					// ��ǰӦ�õ� ID