<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

/**
 * 订单详情控制器
 */
class OrdersDetailController extends CommonController 
{
	/**
	 * 显示订单详情列表页
	 */
     public function index()
    {
      $oid = I('get.oid');
      $ordersDetailModel= D('OrdersDetail');
      $orders = $ordersDetailModel->getOrders($oid);
      $this->assign('data', $orders);

      $ordersgoods = $ordersDetailModel->getGoods($oid);
      $this->assign('info', $ordersgoods);

      $this->display();
    }
    
}
