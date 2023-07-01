<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 登录控制器
 */
class LoginController extends Controller 
{
    
    /**
     * 显示登录页面
     */
    public function index()
    {
        if (IS_POST) {

        $login = D('Login');
        $login->create($_POST, 1);

        $admin = M('Admin');
        //查询有没有账号
        $admin = $admin->where(['username' => ['eq', I('username')]])->find();


            //判断有没有账号
            if($admin) {
                //判断是否启用,超级管理员不需要验证
                if($admin['id'] == 1 || $admin['status'] == 1) {
                  //   var_dump($adm);
                  // var_dump(password_verify($pwd, $admin['pwd']));exit;
                    //验证密码
                    if(password_verify(I('pwd'), $admin['pwd'])) {

                        //验证成功进入

                        session('adminInfo', $admin);
                        
                        //超级管理员拥有所有权限
                        if($admin['id'] == 1) {
                            $this->redirect('Index/index');

                        }
                        //1.根据用户id获取当前用户的角色id
                        $roleIds = M('AdminRole')->where(['admin_id'=>$admin['id']])->getField('role_id', true);

                        //2.根据角色id查节点id
                        $privilegeIds = M('RolePrivilege')->where(['role_id'=>['in', $roleIds]])->getField('pri_id', true);

                        //3.根据节点id查出所有权限
                        $arr = M('Privilege')->field('controller_name,action_name')->where(['id'=>['in', $privilegeIds]])->select();

                        foreach ($arr as $v) {
                            $list[] = join($v, '/');
                        }

                        //追加首页权限
                        $list[] = 'Index/index';
                        $list[] = 'Login/logout';
                        $list[] = 'Manager/personEdit';
                        session('privilegeList', $list);

                        //跳转到首页
                        $this->redirect('Index/index');
                    } else {

                        $this->error('用户名或密码错误');
                    }
                } else {
                    $this->error('你已被禁用');
                }

            } else {
                $this->error('用户名或密码错误');
                return false;
            }
        }
        $this->display();
    }

    /**
     * 注销
     */
    public function logout()
    {
    	session('adminInfo', null);
        $this->redirect('Login/index');
    }



}