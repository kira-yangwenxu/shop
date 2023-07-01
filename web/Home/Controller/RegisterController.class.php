<?php
namespace Home\Controller;
use Think\Controller;
use Aliyun\Core\Config;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use Aliyun\Api\Sms\Request\V20170525\SendSmsRequest;
use Aliyun\Api\Sms\Request\V20170525\QuerySendDetailsRequest;

/**
 * 前台注册控制器
 */
class RegisterController extends Controller {

    /**
     * 显示用户名注册主页页面，并用户名注册进行相关处理
     */
    public function register()
    {
        if (IS_POST) {

            // 添加当前注册时间戳
            $_POST['addtime'] = time();

            // 实例化User模型
            $user = D('User'); 

            $glod = M('glod');

            // 实例化登陆次数模型
            $login = M('user_logininfo');

            // 进行自动验证
            $arr = $user->create(I('post.'));
            
            // 对结果进行判断
            if (!$arr) {

                // 返回错误信息
                $this->error($user->getError());

            } else {

                // 执行自动完成添加信息
                $result = $user->add();

                // 对结果进行判断
                if ($result) {

                    $name = $arr['username'];

                    $userinfo = $user->where('username='."'$name'")->select();
                    
                    $id = $userinfo[0]['id'];

                    $data['uid'] = $id;

                    $logininfo = $login->data($data)->add();

                    $gscore = $glod->data($data)->add();

                    if ($logininfo) {

                        // 跳转
                        $this->success('注册成功');
                    } else {
                        $this->error('注册失败');
                    }

                } else {
                    // 返回错误信息
                    $this->error('注册失败');
                }

            }
        } else {
            // 渲染模板
            $this->display();
        }
        
    }

    /**
     * 显示邮箱注册主页页面，并邮箱注册进行相关处理
     */
    public function registere()
    {
        if (IS_POST) {

            // 添加当前注册时间戳
            $_POST['addtime'] = time();

            // 实例化User模型
            $user = D('User'); 
            
            // 进行自动验证
            $arr = $user->create(I('post.'));
            
            // 对结果进行判断
            if (!$arr) {

                // 返回错误信息
                $this->error($user->getError());

            } else {

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
                sendMail("$email", 'shop账号注册', "<h1>请在24小时内点击下面链接激活账号</a></br><h2><a href='http://119.23.235.234/shop/web/EmailVerify.php?key=$email'>激活</a></h2>");

                $this->success('注册成功，请去邮箱激活该账号。');
                

            }
        } else {
            // 渲染模板
            $this->display();
        }
        
    }

    public function ajaxRequests()
    {
        if (IS_AJAX) {
            $phone = $_GET['phone'];
            require_once './api_sdk/vendor/autoload.php';
            Config::load();
            $accessKeyId = "LTAI6WbMmRl2rSRG"; // AccessKeyId

            $accessKeySecret = "HYRdUQ59yTuHCezkGE7hjLtwFCNbbz"; // AccessKeySecret

            $code = rand(1000, 9999);

            $templateParam = array("code"=>"'$code'");

            $signName = "陈林康的网站手机注册验证";

            $templateCode = "SMS_113450359";

            //产品名称:云通信流量服务API产品,开发者无需替换
            $product = "Dysmsapi";

            //产品域名,开发者无需替换
            $domain = "dysmsapi.aliyuncs.com";

            // 暂时不支持多Region
            $region = "cn-hangzhou";

            $profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);

            DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);

            $acsClient = new DefaultAcsClient($profile);

            $request = new SendSmsRequest();

            $request->setPhoneNumbers($phone);

            $request->setSignName($signName);

            $request->setTemplateCode($templateCode);

            if ($templateParam) {
                $request->setTemplateParam(json_encode($templateParam));
                $acsResponse = $acsClient->getAcsResponse($request);
                $data['codes'] = $code;
                $data['phone'] = $phone;
                $this->ajaxReturn($data);
            } else {
                $this->ajaxReturn(2);
            }

            

            $result = json_decode(json_encode($acsResponse), true);

            

        }
    }

    public function registerp()
    {
        if (IS_POST) {
            $yzm = $_POST['yzm'];
            $code = $_POST['code'];
            if (!($yzm == $code)) {
               $this->error('验证码错误');
            }
            // 添加当前注册时间戳
            $_POST['addtime'] = time();

            $glod = M('glod');
            
            // 实例化User模型
            $user = D('User'); 

            $login = M('user_logininfo');
            
            // 进行自动验证
            $arr = $user->create(I('post.'));
            
            $phone = $arr['phone'];
            $pwd = $arr['pwd'];
            $addtime = $arr['addtime'];
            $data['username'] = $phone;
            $data['pwd'] = $pwd;
            $data['phone'] = $phone;
            $data['addtime'] = $addtime;
            // 对结果进行判断
            if (!$arr) {

                // 返回错误信息
                $this->error($user->getError());

            } else {
                
                $result = $user->data($data)->add();

                if ($result) {

                    $name = $data['phone'];

                    $userinfo = $user->where('username='."'$name'")->select();
                    
                    $id = $userinfo[0]['id'];

                    $datal['uid'] = $id;

                    $logininfo = $login->data($datal)->add();
                    $gscore = $glod->data($datal)->add();

                    if ($logininfo) {

                        // 跳转
                        $this->success('注册成功');
                    } else {
                        $this->error('注册失败');
                    }
                } else {
                    $this->error('注册失败');
                }
                
            }
        } else {
            // 渲染模板
            $this->display();
        }
    }

    public function ajaxRequest()
    {
        if (IS_AJAX) {
            
            // 获取AJAX发来的数据
            $name = $_GET['username'];
            
            // 实例化User模型
            $user = D('user');

            // 查询该用户名是否存在
            $result = $user->where('username='."'$name'")->select();
            
            // 对结果进行判断
            if ($result) {

                // 1为已存在
                $this->ajaxReturn(1);
                
            } else {

                // 2为不存在
                $this->ajaxReturn(2);

            }
            
        }
    }

    public function ajaxRequeste()
    {
        
        if (IS_AJAX) {
            
            // 获取AJAX发来的数据
            $email = $_GET['email'];

            // 实例化User模型
            $user = D('user');

            // 查询该用户名是否存在
            $result = $user->where('email='."'$email'")->select();
            
            // 对结果进行判断
            if ($result) {

                // 1为已存在
                $this->ajaxReturn(1);
                
            } else {

                // 2为不存在
                $this->ajaxReturn(2);

            }
            
        }
    }

    public function ajaxRequestp()
    {
        if (IS_AJAX) {

            // 获取手机号码
            $phone = $_GET['phone'];

            // 实例化user模型
            $user = D('user');

            // 查询该用户是否存在
            $result = $user->where('phone='."'$phone'")->select();
            
            if ($result) {

                // 1为已存在
                $this->ajaxReturn(1);
                
            } else {

                // 2为不存在
                $this->ajaxReturn(2);

            }
        }
    }

} 