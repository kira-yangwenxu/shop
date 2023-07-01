<?php
// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录
define('APP_PATH','./web/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';



// 亲^_^ 后面不需要任何代码了 就是如此简单

/*
tp框架由3个参数决定访问的位置
	m 模块，默认为Home，一般网站有两个模块：前台、后台
	c 控制器：默认为Index
	a 方法名：默认为index

	http://localhost/index.php?c=User&a=index  普通模式
	http://localhost/index.php/c/User/a/index.html  pathinfo模式
	http://localhost/c/User/a/index.html  重写模式

URL模式
	http://192.168.32.153/tp/index.php?m=Admin&c=Fuck&a=add
	http://192.168.32.153/tp/index.php/Admin/Fuck/add
	http://192.168.32.153/tp/Admin/Fuck/add

如何开启重写？
	1. httpd.conf配置文件中加载了mod_rewrite.so模块
		vim /usr/local/apache2/etc/httpd.conf 
	2. 将htdocs目录下AllowOverride None 将None改为 All 
	3. 把下面的内容保存为.htaccess文件放到应用入口文件的同级目录下 
		<IfModule mod_rewrite.c> 
			RewriteEngine on 
			RewriteCond %{REQUEST_FILENAME} !-d 
			RewriteCond %{REQUEST_FILENAME} !-f 
			RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
		</IfModule>
 */

