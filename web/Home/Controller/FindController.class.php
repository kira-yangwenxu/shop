<?php
namespace Home\Controller;
use Think\Controller;
class FindController extends Controller 
{
	public function find()
	{
		if (IS_GET) {
			$this->display();
		}

		if (IS_POST) {
			// 实例化User模型
            $user = M('user'); 
            $email = $_POST['email'];
            $pwd = $_POST['pwd'];
            $pwd2 = $_POST['pwd2'];
            if ($pwd != $pwd2) {
            	$this->error('两次密码不一致');
            }

            $hash = password_hash($pwd, PASSWORD_DEFAULT);

            $arr['pwd'] = $hash;
            $arr['email'] = $email;
            
            // 获取邮箱作为键名
            $cachename = $arr['email'];

            // 以邮箱作为键名，把该用户数据存到memcache缓存
            S("'$cachename'",$arr,array('type'=>'memcache','expire'=>86400));

            // 获取缓存数据
            $cache = S("'$cachename'");

            // 获取邮箱
            $email = $cache['email'];

            // PHPMailer生效
            vendor('PHPMailer.class', '', '.pop3.php');

            vendor('PHPMailer.classphpmailer');

            // 发送邮件把邮箱地址作为key值传过去
            sendMail("$email", 'shop密码找回', "<h1>请在24小时内点击下面链接修改密码</a></br><h2><a href='http://120.78.184.24/shop/web/FindPass.php?key=$email'>激活</a></h2>");

            $this->success('邮箱发送成功，请求激活连接');

                
		}
	}
}