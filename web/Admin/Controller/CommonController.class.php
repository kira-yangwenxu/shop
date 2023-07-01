<?php
namespace Admin\Controller;
use Think\Controller;


class CommonController extends Controller 
{
    
    public function _initialize()
    {
    	if (!session('?adminInfo')) {
    		$this->redirect('Login/index');
    		exit;
    	}

    	//获取当前操作的节点
    	$privilege = CONTROLLER_NAME.'/'.ACTION_NAME;
    	
    	if($_SESSION['adminInfo']['id'] == 1) {
    		return true;
    	}

    	if (!in_array_case($privilege, session('privilegeList'))) {
    		$this->error('没有权限进行此操作！');
    	}



    }
}