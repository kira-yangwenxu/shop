<?php
namespace Admin\Model;
use Think\Model;


/**
 * 订单Model层
 */
class OrdersModel extends Model
{
	/**
	 * 获取订单信息
	 * @return array 订单信息
	 */
	public function getData()
	{
		//查询订单信息
		$arr = $this->select();
		//实力话大M方法
		$user = M('User');
		//查询用户名以及ID
		$uid = $user->field('username,id')->select();
		//生成一维数组
		$res = array_column($uid,'username','id');
					
		//定义数组
		$type = [1 => '待付款', 2 => '待发货', 3 => '待收货', 4 => '交易完成', 5 => '无效订单'];
		//处理数据
		foreach ($arr as $k => $v) {

			$arr[$k]['status'] = $type[$v['status']];
			$arr[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
			$arr[$k]['username'] = $res[$v['uid']];

		}
		return $arr;
	}

	
}