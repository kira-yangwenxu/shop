<?php
namespace Home\Controller;
use Think\Controller;
class OrdersSuccessController extends Controller {
  /**
   * 处理订单插入数据 现实下单成功页面
   */
    public function index()
    {
        if(empty(I('post.address'))) $this->error('请输入地址以及收件信息');
  
        $arr =  $_SESSION['ids'];
        //实例化对象
        $goodsDetail = M('GoodsDetail');
        $orders = M('Orders');
        $ordersDetail = M('OrdersDetail'); 
        $integral = M('Glod');
        $Sold = M('Goods');
        $shopcar = M('Shopcar');
        //开启事务
        $orders->startTrans();

        //遍历购物车商品ID获取并导入数据 并删除购物车商品信息
        foreach ($arr as $k => $v){
            $goods[] = $shopcar->field('did,buynum,totle_price,name,attr,path,price')->where(['id' => $v['id']])->find();
            //删除购物车数据
            $delShopCarMsg =$shopcar->where('id='.$v['id'])->delete();

        }
        //判断删除是否成功 失败则回滚
       if (!$delShopCarMsg) $orders->rollback();
       //遍历购物车数据 并合并其他表修改的数据
       foreach ($goods as $k => $v)
       {
        //计算总价
        //获取商品详情id
        $tid[$k]  = $goodsDetail->field('tid,bid,gid')->where(['id'=>$v['did']])->find();
        $goodsname[$k] = $goodsDetail->field('name,price')->where(['id'=>$v['did']])->find();
        //生成购买量数组
        $buynum[$k]['buynum'] =  $v['buynum'];
        $buynum[$k]['did'] = $v['did'];
        $buynum[$k]['gid'] = $tid[$k]['gid'];
        $total += $goodsname[$k]['price'] * $v['buynum'];
       }
       //判断订单页面POST是否有传数据
       if (IS_POST) {
        //合并订单数据
         $data = I('post.'); 
         $uid = $_SESSION['homeInfo']['id'];
         $data['total'] = $total;
         $data['uid'] = $uid;
         $data['addtime'] = time();
       } 
       //插入订单数据
       $oid = $orders->data($data)->add();
       //遍历购物车 生成订单详情
        foreach ($goods as $k => $v) {
                $detail['did'] = $v['did'];
                $detail['buynum'] = $buynum[$k]['buynum'];
                $detail['path'] = $v['path'];
                $detail['tid'] = $tid[$k]['tid'];
                $detail['bid'] = $tid[$k]['bid'];
                $detail['oid'] = $oid;
                //循环插入订单详情
                $OrdersDetailOK = $ordersDetail->add($detail);
            }
        //判断订单以及订单详情是否查询成功 否则回滚
        if (!$oid && $OrdersDetailOK) {
            $orders->rollback();
        } 
        //遍历商品详情 
        foreach ($buynum as $k => $v) {
            //循环商品修改库存
            $saveStock = $goodsDetail->where(['id' => $v['did']])->setDec('stock', $v['buynum']);
            //循环商品修改购买量
            $goodsSold = $Sold->where(['id' => $v['gid']])->setInc('sold', $v['buynum']);
        }
        //判断商品修改数据是否成功 否则回滚
        if (!$saveStock && $goodsSold) $orders->rollback();
        
                 
       
        $orders->commit();
        $this->assign('total', $total); 
        $this->assign('name', $goodsname);
        $this->assign('data', $data);
        $this->assign('oid',$oid);
        $this->display('OrdersSuccess');


    }
}