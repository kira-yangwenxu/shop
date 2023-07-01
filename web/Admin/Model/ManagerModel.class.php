<?php
namespace Admin\Model;
use Think\Model;

/**
 * Manager模型，用于处理繁琐的用户数据
 */
class ManagerModel extends Model {

	//定义操作数据表
	protected $tableName = 'admin'; 
	//自动验证
	protected $_validate = [
	//用户自动验证
		['username', '', '用户名已存在', 0, 'unique'],		
		['username', 'require', '请输入用户名'],
		['email', 'email', '请输入正确的邮箱地址'],
		['email', '', '该邮箱已注册', 0, 'unique'],		
		['email', 'require', '请输入邮箱地址'],
		['pwd', 'require', '请输入密码'],
		['pwd2', 'pwd', '两次密码不一致', 2, 'confirm'],
		['role', [1,2], '角色值不正确', 2, 'in'],


	];



	//自动完成
	protected $_auto = [
		['pwd', 'hash', 1, 'callback'],
		['pwd', 'hash', 2, 'callback'],
		['addtime', 'time', 1, 'function'],
	];

	/**
	 * 完成hash加密
	 */
	public function hash()
	{
		return password_hash(I('post.pwd'), PASSWORD_DEFAULT);
	}

	/**
	 * 获取所有顶级权限数据
	 * @return array 
	 */
	public function getPrivilegeData()
	{
		$data = M('Privilege')->where(['pid'=> 0])->select();
		return $data;
	}


	/**
	 * 获取所有非顶级权限数据
	 * @return array 
	 */
	public function getActionData()
	{
		$data = M('Privilege')->where(['pid' => ['neq', 0]])->select();
		return $data;
	}

	/**
	 * 获取所有角色数据
	 * @return array 
	 */
	public function getRoleData()
	{
		$roleData['name'] = I('post.name');
		return $roleData;
	}

	/**
	 * 获取所有管理员数据
	 * @return array 
	 */
	public function getAdminData()
	{	
		$adminData = M('Admin');
		$data = $adminData->select();
		foreach ($data as $k => $v) {
			 $data[$k]['addtime'] = date('Y-m-d',$v['addtime']);
		}
		return $data;
	}

}