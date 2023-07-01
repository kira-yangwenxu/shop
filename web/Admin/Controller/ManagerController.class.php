<?php
namespace Admin\Controller;
use Think\Controller;


class ManagerController extends CommonController 
{


    public function index(){

        $list = array();
        //搜索信息
        $search = I('search');
        $admin = M('Admin');

        $page = new \Think\Page($admin->count(), 5);
        $btns = $page->show();

        if(empty($search)){
            $res = $admin->field('id,username,addtime,email,status')->limit($page->firstRow.','.$page->listRows)->order('id')->select();
        }else{

            $res = $admin->field('id,username,addtime,email,status')->where('username','like','%'.$search.'%')->limit($page->firstRow.','.$page->listRows)->order('id')->select();
        }
        $this->assign('info', $res);
        $this->assign('btns', $btns);
        $this->display();

    }

    /**
     * 个人信息修改
     */
    public function personEdit()
    {
        if(IS_POST) {
            $_POST['id'] = $_SESSION['adminInfo']['id'];
            $admin = D('Manager');
            $adminInfo = $admin->where(['username'=>  $_SESSION['adminInfo']['username']])->find();
            // 验证密码是否正确
            if(password_verify(I('opwd'), $adminInfo['pwd'])) {

                unset($_POST['opwd']);

                $data = $admin->create();
                if ($data) {

                    if ($admin->save($data) === false) {

                        $this->error('修改失败');
                    } 

                    $this->success('修改成功', U('Index/index'));
                    exit;
                } else {
                    $this->error($admin->getError());
                } 

            }

            $this->error('密码错误');
        }


        $id = $_SESSION['adminInfo']['id'];
        $adminData = M('Admin')->field('id,username,email')->where(['id'=>$id])->find();
        $this->assign('info', $adminData);
        $this->display();


    }

    /**
     * 添加管理员
     */
    Public function adminAdd(){

    	//ajax验证用户名邮箱
    	if(IS_AJAX) {
    		$user = D('Manager');
    		$data = $user->create();
    		if(!$data) {
    			$msg = $user->getError(); 
    			$this->ajaxReturn([false, $msg]);
    		} 
    		$this->ajaxReturn(ture);
    		
    	}
    	if(IS_POST) {
    		$admin = D('Manager');
    		$data = $admin->create();


            if (empty($_POST['role_id'])) {
                $this->error('请选择角色');
            }

            //获取所属角色数据
            $role_id = $_POST['role_id'];

    		//通过验证插入数据
    		if ($data) {

                // 开启事务
                $admin->startTrans();   

    			if ($admin->add($data)) {


                    foreach ($role_id as $k => $v) {

                        $AdminRole = M('AdminRole');

                        $adminId = $admin->field('id')->where(['username'=> $data['username']])->find();

                        if(!$AdminRole->add(['role_id' => $v, 'admin_id' => $adminId['id']]))  
                        {

                        //回滚事务
                        $admin->rollback();    
                        $this->error('添加失败');

                        }
                    
                    }
                    
                    $admin->commit();
    				$this->success('添加成功', 'index');
    			} else {
                    //回滚事务
                    $admin->rollback();
    				$this->error('添加失败');
    			}

			//数据验证失败，返回错误
    		} else {
    			$this->error($admin->getError());
    		}
    	} 

        $Role = M('Role');

        $roleData = $Role->select();
	    
        $this->assign('role', $roleData);
        $this->display();
    		
    }

    /**
     * 修改管理员
     */
    Public function adminEdit(){



        if(IS_GET) {

            // dump($_SESSION);
            if($_GET['id'] == 1) {
                $this->error('超级管理员请在个人信息修改中修改');
            }
            $adminData = M('Admin')->field('id,username,email')->where(['id'=>I('id')])->find();
            $adminData['role_id'] = M('AdminRole')->field('role_id')->where(['admin_id' => I('id')])->find()['role_id'];
            $Role = M('Role');

            $roleData = $Role->select();
            
            $this->assign('info', $adminData);
            $this->assign('role', $roleData);
            $this->display();
        }

        if(IS_POST) {
            $admin = D('Manager');
            if(empty($_POST['pwd'])) {
                unset($_POST['pwd']);
            }
            $data = $admin->create();

            if (empty($_POST['role_id'])) {
                $this->error('请选择角色');
            }

            //获取所属角色数据
            $role_id = $_POST['role_id'];

            //通过验证插入数据
            if ($data) {


                // 开启事务
                $admin->startTrans();   

                if ($admin->save($data) === false) {
                    $admni->rollback();
                    echo 2;

                    $this->error('修改失败');
                } else {
                    foreach ($role_id as $k => $v) {

                        $AdminRole = M('AdminRole');

                        $adminId = $admin->field('id')->where(['username'=> $data['username']])->find();
                        if($AdminRole->where(['admin_id'=>$adminId])->save(['role_id' => $v, 'admin_id' => $adminId['id']]) === false)  
                        {

                        //回滚事务
                        $admin->rollback(); 
                        echo 1;
                        $this->error('修改失败');

                        }
                    
                    }

                    $admin->commit();
                    $this->success('修改成功', U('Manager/index'));
                }



            //数据验证失败，返回错误
            } else {
                $this->error($admin->getError());
            }
        } 

            
    }

    //修改状态
    public function adminAjaxStatus($id){

        if (IS_AJAX) {

            if(empty(I('id')))  $this->redirect('Index/index');

            if(I('id') == 1) {
                $this->error('超级管理员不能修改');
            }

            if(I('status') == 1) {
                if(M('Admin')->where(['id'=>I('id')])->save(['status'=> 2]))
                    $this->success('2');

            } else {
                if(M('Admin')->where(['id'=>I('id')])->save(['status'=> 1]))
                    $this->success('1');
                
            }
            
        } else {

            $this->redirect('Index/index');

        }
    }

    //删除管理员
    public function adminAjaxDel($id){

        if (IS_AJAX) {



            if(empty(I('id')))  $this->redirect('Index/index');

            //禁止删除管理员
            if(I('id') == 1) {
                $this->ajaxReturn('超级管理员不能删除');
            }

            //开启事务处理
            $admin = M('admin');
            $admin->startTrans();

            if($admin->where(['id'=>I('id')])->delete()) {

                if ($M('AdminRole')->where(['admin_id'=> I('id')])->delete()) {

                    $admin->commit();
                    $this->success('删除成功');
                } else {
                    $admin->rollback();
                    $this->error('删除失败');
                }

            } else {
                $admin->rollback();
                $this->error('删除失败');
            } 
        } 
    }

    //节点列表
    public function privilegeList(){

        $privilege = D('Privilege');
        $count = $privilege->count();
        $page = new \Think\Page($count, 10);
        $btns = $page->show();

        $info = $privilege->field("id,module_name,controller_name,action_name,pri_name,pid,path,concat(id,',',pid) as bpath")->order('bpath')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('btns', $btns);
        $this->assign('info', $info);
        $this->display();
        
    }

    //添加权限节点
    public function privilegeAdd(){

        if (IS_AJAX) {
            $method = $this->getAction(I('controller'));
                
            $html = '';
            //遍历拼接页面的div   
            foreach ($method as $k => $v) {
                $html .= '<div style="width:100px;display:inline-block" class="radio"><label class="method"><input name="action_name" type="radio" class="flat" value="'.$v.'">'.$v.'</label></div>';
            }
            //用ajaxReturn会有问题 返回的字符串会加转义字符 / 
            exit($html);
        }



        //提交表单添加
        if (IS_POST) {

            if($_POST['pid'] == '') $_POST['pid'] = 0; 

            if($_POST['controller_name'] === 'null') $_POST['action_name'] = 'null'; 
            $Privilege = M('Privilege');

            //设置自动验证的规则
            $validate =       [
                ['pri_name', 'require', '请输入权限名'],
                ['pri_name', '', '权限名已存在', 0, 'unique'],
                ['pri_name', '1,30', '权限名长度不超过30', 3,'length'],
                ['module_name', 'require', '请输入模块名'],
                ['module_name', '1,30', '模块名长度不超过30', 3, 'length'],
                ['controller_name', 'require', '请选择控制器名'],
                ['controller_name', '1,30', '控制器名长度不超过30', 3, 'length'],
                ['action_name', 'require', '请选择方法名'],
                ['action_name', '1,30', '方法名长度不超过30', 3, 'length'],

            ];
            $Privilege->setProperty('_validate', $validate);

            // 自动验证字段是否合法

            $data = $Privilege->create($_POST);
            // echo strlen($_POST['pri_name']);
            // var_Dump($_POST);
            // echo $Privilege->getError();
            // var_dump($data);exit;
            //通过验证插入数据
            if ($data) {
                if ($Privilege->add($data)) {
                    $this->success('添加成功', U('Manager/privilegeList'));
                } else {
                    $this->error('添加失败');
                }
                //验证失败，返回错误
            } else {
                $this->error($Privilege->getError());
            }

        }

        $pri = M('Privilege');

        //获取admin所有控制器
        $controller = $this->getController('Admin');

        $pri_name = empty($_GET['id']) ? '顶级权限' : $pri->where(['id'=>$_GET['id']])->field('pri_name')->find()['pri_name'];
        if(!empty($_GET['id'])) {
            $info = $pri->find($_GET['id']);
            if(empty($info)){
                $this->error('非法操作！');
            }
            $this->assign('info', $info);
            $this->assign('id', $_GET['id']); 

        }

        $this->assign('pri_name', $pri_name);
        $this->assign('module', $module); 
        $this->assign('list', $controller);
        $this->display();
    }



    //删除权限节点
    public function privilegeAjaxDel($id){

        if (IS_AJAX) {


            if(empty(I('id')))  exit;

            if(M('Privilege')->delete($id)) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            } 
        } 
    }


    /**
     * 角色列表
     */
    public function roleList(){

        
        $role = M('role');

        $page = new \Think\Page($role->count(), 10);
        $btns = $page->show();

        $info = $role->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('info', $info);
        $this->assign('btns', $btns);

        $this->display();

    }

    /**
     * 添加角色
     */
    public function roleAdd(){

        if (IS_POST) {
            $Role =  M('Role');

            //设置自动验证的规则
            $validate = [
                //角色自动验证
                ['name', 'require', '请输入角色名'],
                ['name', '', '改角色已存在', 0, 'unique', 1],
                ['name', '1,30', '角色名长度不超过30', 3, 'length'],

            ];
            $Role->setProperty('_validate', $validate);

            // 自动验证字段是否合法

            $data = $Role->create($_POST);

            $roleData = D('Manager')->getRoleData();


            if($data){ 
                //验证成功后进入

                //开启事务
                $Role->startTrans();

                //实例化Role表插入角色名数据同时插入到Role_Privilege表
                if ($Role->add($roleData)) {
                    
                    $rolePrivilege = M('RolePrivilege');

                    $rid = $Role->field('id')->where(['name'=> $roleData['name']])->find();
                    //所有权限ID
                    $pri_id = $_POST['pri_id'];
                    //遍历插入数据
                    foreach ($pri_id as $k => $v) {

                        if(!$rolePrivilege->add(['pri_id' => $v, 'role_id' => $rid['id']]))  

                            $Role->rollback();
                    }

                    $Role->commit();

                    $this->success('添加成功', 'roleList');

                } else {

                    $Role->rollback();

                    $this->error('添加失败');
                }

            } else {
                $this->error($Manager->getError());

            }

        }


        $module = D('Manager')->getPrivilegeData();
        $action = D('Manager')->getActionData();

        $this->assign('module', $module);
        $this->assign('action', $action);

        $this->display();

    }

    /**
     * 角色ajax删除
     * @return [type]     [description]
     */
    public function roleAjaxDel($id)
    {
        if (IS_AJAX) {



            if(empty(I('id')))  $this->redirect('Index/index');

            //如果该角色下有管理员不予删除
            if (M('AdminRole')->where(['role_id'=>I('id')])->select()) {
                $this->ajaxReturn('请先删除该角色下的管理员');
            }

            $del = M('Role');
            $del->startTrans();
            if(M('Role')->delete($id)) {

                if(M('RolePrivilege')->where(['role_id'=>I('id')])->delete()){

                    $del->commit();

                    $this->success('删除成功');
                } else {

                    $del->rollback();

                    $this->error('删除失败');
                } 

            } else {

                $del->rollback();

                $this->error('删除失败');
            } 
        } 
    }

    /**
     * 角色修改
     */
    public function roleEdit()
    {
        //进行修改
        if (IS_POST) {
            $Role =  M('Role');

            //判断是否修改了角色名, 通过ID查找数据库中的该角色与post穿过来的比较
            if ($_POST['name'] == $Role->where(['id'=>$_GET['id']])->find()['name']){

                unset($_POST['name']);


            } else if (empty($_POST['name'])){
                    $this->error('输入角色名');
            } else {
                //设置自动验证的规则
                $validate = [
                    //角色自动验证
                    ['name', '', '该角色已存在', 0, 'unique', 2],
                    ['name', '1,30', '角色名长度不超过30', 3, 'length', 2],

                ];
                $Role->setProperty('_validate', $validate);

                // 自动验证字段是否合法
                $data = $Role->create($_POST, 2);
                
                if(!$data) 
                $this->error($Role->getError());

                $roleData = D('Manager')->getRoleData();

                $Role->where(['id'=>$_GET['id']])->save($roleData);

            }
            // 修改权限

            //实例化Role表插入角色名数据同时插入到Role_Privilege表
                
            $rolePrivilege = M('RolePrivilege');

            //开启事务
            $rolePrivilege->startTrans();
// 删除所有角色ID为当前角色的权限
            if(!$rolePrivilege->where(['role_id'=>$_GET['id']])->delete()) 

            $rolePrivilege->rollback();

            //插入修改输入
            $pri_id = $_POST['pri_id'];
            //遍历插入数据
            foreach ($pri_id as $k => $v) {

                if(!$rolePrivilege->add(['pri_id' => $v, 'role_id' => $_GET['id']]))  $Role->rollback();
            
            }

            $Role->commit();

            $this->success('修改成功' , U('Manager/roleList'));




        }

        if(IS_GET) {

            $priRole = M('RolePrivilege');

            $priRoleData = array_column($priRole->field('pri_id')->where(['role_id' => $_GET['id']])->select(),'pri_id');

            $Role = M('Role'); 
            $data = $Role->where(['id' => $_GET['id']])->find();

            $module = D('Manager')->getPrivilegeData();
            $action = D('Manager')->getActionData();


            $this->assign('priRoleData', $priRoleData);
            $this->assign('data', $data);
            $this->assign('module', $module);
            $this->assign('action', $action);

            $this->display();
        }
    }


    /**
     * 获取指定模块所有控制器
     * @param  [string] $module [模块名]
     * @return [array]         [控制器数组]
     */
    protected function getController($module){
        if(empty($module)) return null;
        $module_path = APP_PATH . '/' . $module . '/Controller/';  //控制器路径
        if(!is_dir($module_path)) return null;
        $module_path .= '/*.class.php';
        $ary_files = glob($module_path);
        foreach ($ary_files as $file) {
            if (is_dir($file)) {
                continue;
            }else {
                $files[] = basename($file, C('DEFAULT_C_LAYER').'.class.php');
            }
        }
        return $files;
    }

    /**
     * 获取指定模块所有方法
     * @param  [string] $module [控制器名]
     * @return [array]         [方法数组]
     */
    protected function getAction($controller){
        if(empty($controller)) return null;
        $con = A($controller);
        $functions = get_class_methods($con);
        //排除部分方法
        $inherents_functions = array('_initialize','__construct','getActionName','isAjax','display','show','fetch','buildHtml','assign','__set','get','__get','__isset','__call','error','success','ajaxReturn','redirect','__destruct', '_empty', 'getController', 'getAction', '_initialize', 'theme');
        foreach ($functions as $func){
            if(!in_array($func, $inherents_functions)){
                $customer_functions[] = $func;
            }
        }
        return $customer_functions;
    }
}