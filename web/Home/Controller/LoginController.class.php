<?php
namespace Home\Controller;
use Think\Controller;

/**
 * 前台登录控制器
 */
class LoginController extends Controller {

    /**
     * 显示登录页面
     */
    public function index(){

        if (IS_GET) {

            $this->display('login');
            
        } 
    }

    // 登录处理
    public function doLogin()
    {
        if (IS_POST) {
            
            // 获取用户名
            $username = I('post.username');
            $verify = I('param.verify','');  
            if(!check_verify($verify)){  
                $this->error("亲，验证码输错了哦！",$this->site_url,9);  
            }  
  


            // 获取密码
            $pwd = I('post.pwd');

            

            $login = M('user_logininfo');

            // 实例化user模型
            $user = M('user');

            // 查出该用户的信息
            $arr = $user->where('username='."'$username'")->select();

            $userinfo = $arr[0];

            if ($userinfo['status'] == 2) {
                // 用户禁用
                $this->error('该用户已被禁用');
                exit;
            }

            if ($userinfo) {
                
                // 获取数据库hash密文
                $hash = $userinfo['pwd'];

                // 验证用户输入的密码与数据库存的hash密文是否一致
                $verify = password_verify($pwd, $hash);

                // 对密码结果进行判断
                if ($verify) {
                    $level = $userinfo['glod'];
                    switch ($level) {
                    case $level<100:
                         $userinfo['level'] = '青铜';
                         $userinfo['line'] = 100;
                        break;
                    case $level>=100 && $level<500:
                         $userinfo['level'] = '白银';
                         $userinfo['line'] = 500;
                        break;
                    case $level>=500 && $level<1000:
                         $userinfo['level'] = '黄金';
                         $userinfo['line'] = 1000;
                        break;
                    case $level>=1000 && $level<1500:
                         $userinfo['level'] = '铂金';
                         $userinfo['line'] = 1500;
                        break;
                    case $level>=1500 && $level<2000:
                         $userinfo['level'] = '钻石';
                         $userinfo['line'] = 2000;
                        break;
                    case $level>=2000 && $level<3000:
                         $userinfo['level'] = '大师';
                         $userinfo['line'] = 3000;
                        break;
                    case $level>=3000:
                         $userinfo['level'] = '王者';
                        break;
                    }
                    // 获取id
                    $id = $userinfo['id'];
                    


                    
                    // 登录成功，清空错误次数表的相关信息
                    $data = array('logintime'=>NULL,'error'=>NULL);
                    $clean = $login->where('uid='.$id)->setField($data);
                    // 成功的话把用户信息写入session
                    session('homeInfo', $userinfo);
                    // 跳转首页
                    $this->success('登录成功',U('Index/index'));

                } else {
                    // 获取当前时间戳
                    $time = time();

                    // 获取id
                    $id = $userinfo['id'];

                    // 查出错误次数表相关性
                    $logininfo = $login->where('uid='.$id)->select();

                    // 获取错误时候的登录时间
                    $logintime = $logininfo[0]['logintime'];

                    // 如果错误次数为0
                    if ($logininfo[0]['error'] == '') {

                        // 则错误次数变为1 并记录错误时的登录时间
                        $logininfo = $login->where('uid='.$id)->save(['logintime'=>time(), 'error'=>1]);
                    };

                    // 如果错误次数为5
                    if ($logininfo[0]['error'] == 5) {

                        // 修改用户状态
                        $saves = $user->where('id='.$id)->save(['status'=>2]);
                        $this->error('登录错误超过5次，该用户已被禁用');
                    };

                    // 判断错误是否在半小时内
                    if ($time - $logintime < 1800) {

                        // 如果错误次数为1，在半小时内继续错误，则错误次数自增1
                        $logininfo = $login->where('uid='.$id)->setInc('error',1);
                        
                    };

                    // 密码错误
                    $this->error('账号或密码错误');
                    
                }
            } else {
                // 没有该用户
                $this->error('账号或密码错误');
            }
        }
    }

            
       

        
    

    /**
     * 注销
     */
    public function logout()
    {  
        // 清空session
        session('homeInfo',null);
        $this->redirect('Index/index');
    }

    public function register()
    {
        $this->display();
    }

    public function registere()
    {
        $this->display();
    }

    public function registerp()
    {
        $this->display();
    }

    

    public function verify_c(){  
        
        $Verify = new \Think\Verify();  
        $Verify->fontSize = 12;  
        $Verify->length   = 4;  
        $Verify->useNoise = false;  
        $Verify->codeSet = '0123456789';  
        $Verify->entry();  
    }  

      

}