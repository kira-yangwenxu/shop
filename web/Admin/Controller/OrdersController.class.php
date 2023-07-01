<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

/**
 * 订单控制器
 */
class OrdersController extends CommonController 
{
	/**
	 * 显示订单列表页
	 */
    public function index()
    {
      //搜索
       if (null != I('get.id')) {
          $search['id'] = ['like', I('id').'%'];
        }

       if (null != I('get.status')) {
          $search['status'] = ['eq',I('status')];
        }
       //实例化大D对象
       $orders = D('Orders');
       //统计数据总条数
       $count = $orders->where($search)->count();
       //实例化分页类
       $page = new \Think\Page($count, 4);
       //现实分页
       $show = $page->show();
       //传值到M层
       $data = $orders->field(true)
                      ->limit($page->firstRow, $page->listRows)
                      ->where($search)
                      ->order('addtime desc')
                      ->getdata();

       $this->assign('data', $data);
       $this->assign('page', $show);

       $this->display();
    }
    /**
     * 商城状态修改
     */
    public function ordersStatus()
    {
      $id = I('get.oid');
      $ordersModel = M('Orders');
      $data['status'] = 3;
      $saveStatus = $ordersModel->where(['id'=>$id])->save($data); 
      if ($saveStatus) {
        $this->success('发货成功');
      }
    }

    public function ordersState()
    {
      $id = I('get.oid');
      $ordersModel = M('Orders');
      $val = $ordersModel->field('state')->where(['id'=>$id])->find();
      if ($val['state'] == 2) {
        $val['state'] = 1;
      } else {
        $val['state'] = 2;
      }
      $saveState = $ordersModel->where(['id'=>$id])->save($val);
      if ($saveState) {
        $this->success('修改成功');
      }

    }

}
