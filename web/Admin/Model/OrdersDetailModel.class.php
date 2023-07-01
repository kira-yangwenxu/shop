<?php
namespace Admin\Model;
use Think\Model;


/**
 * 订单Model层
 */
class OrdersDetailModel extends Model
{
	/**
	 * 获取订单数据
	 * @return array 订单数据
	 */
	public function getOrders()
	{	
		//存入oid
		$oid = I('get.oid');
		//实例化大M方法
		$orders = M('Orders');
		//查询订单数据
		$ord = $orders->field(true)->where('id='.$oid)->select();
		//自定义状态数组
		$status = [ 1 =>'付款', 2 => '待发货', 3 => '待收货', 4 => '交易完成', 5 => '无效订单'];
		//遍历处理数据
		foreach ($ord as $k => $v) {
			$ord[$k]['status'] = $status[$v['status']] ;
			$arr[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
			
		}
		return $ord;
			
	}

	/**
	 * 获取商品数据
	 * @return array 商品数据
	 */
	public function getGoods()
	{	
		//存入oid
		$oid = I('get.oid');
		//多表联查获取商品数据
		$arr = $this-> field('shop_goods.name, shop_goods.price,shop_orders_detail.pic, shop_goods_sizes.sizename, shop_goods_brands.brandname, shop_goods_colors.colorname , shop_orders_detail.tid')
					-> join('left join shop_goods on shop_orders_detail.gid = shop_goods.id')
					-> join('left join shop_goods_brands on shop_orders_detail.bid = shop_goods_brands.id')
					-> join('left join shop_goods_colors on shop_orders_detail.cid = shop_goods_colors.id')
					-> join('left join shop_goods_sizes on shop_orders_detail.sid = shop_goods_sizes.id')
					-> where("shop_orders_detail.oid = $oid")
					-> select();
		//实例化大M方法
		$type = M('OrdersDetail');
		//查询分类数据
		$typename = $type-> field('shop_type.id,shop_type.name')
						 -> join('left join shop_type on shop_orders_detail.tid = shop_type.id')
						 -> where('shop_orders_detail.tid = shop_type.id')
						 -> select();

		//定义数组				 
		$typename = array_column($typename, 'name', 'id');
		//处理数据
			foreach ($arr as $k => $v) {
				$arr[$k]['typename'] = $typename[$v['tid']];
			}


			 
		 return $arr;

			 
	}


	
}