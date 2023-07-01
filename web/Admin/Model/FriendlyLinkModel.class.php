<?php
namespace Admin\Model;
use Think\Model;

/**
 * 友情连接数据处理层
 */
class FriendlyLinkModel extends Model
{
	/**
	 * 自动验证
	 */
	protected $_validate = [
		
		['name', 'require','请输入友情连接名'],
		['link', 'require','请输入友情连接'],
		


	];

	/**
	 * 查询友情连接数据
	 * @return array
	 */
	public function getData()
	{
		//查询数据
		$arr = $this->select();
		return $arr;
	}

	/**
	 * 删除友情连接
	 * @return 受影响行数
	 */
	public function doDel()
	{
		//获取ID
		$id = I('get.id');
		//占位符
		$where['id'] = ':id';
		//绑定占位符
		$bind[':id'] = $id;
		//删除数据
		$arr = $this->where($where)->bind($bind)->delete();
		//返回受影响行数
		return $arr;
	}
}