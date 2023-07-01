<?php
namespace Admin\Controller;
use Think\Controller;


class TimingTaskController extends Controller 
{
	
     public function index()
    {
        $ordersModel = M('Orders');
        $ordersDetailModel = M('OrdersDetail');
        $goodsDetailModel = M('GoodsDetail');
        $goods = M('Goods');
        $glod = M('glod');
        $ordersModel->startTrans();
        $Obsolete = $ordersModel->field(true)->where(['status'=>['in',[1,5]]])->select();
        dump($Obsolete);
        foreach ($Obsolete as $k => $v)
      {
         $time = time() - $v['addtime'];
         if ($time >=  200 || $v['status'] == 5) {
            $oid[$k] = $v['id'];
            $uid[$k]['uid'] = $v['uid'];
            $uid[$k]['total'] = $v['total'] * 0.1;
            $delorders = $ordersModel -> delete($v['id']);
         }
      }

      if (!$delorders) $ordersModel->rollback(); 
        $goodsDetail = $ordersDetailModel->field('did,buynum')->where(['oid'=> ['in', $oid]])->select();
        $delordersDetail = $ordersDetailModel->where(['oid'=> ['in', $oid]])->delete();
        if (!$delordersDetail) $ordersModel->rollback();
        foreach ($goodsDetail as $k => $v) {
          $gid[$k] = $goodsDetailModel->field('gid')->where('id='.$v['did'])->find();
          $gid[$k]['buynum'] = $v['buynum'];
          $saveStock = $goodsDetailModel->where(['id'=>$v['did']])->setInc('stock',$v['buynum']);
        }
        if (!$saveStock) $ordersModel->rollback();
        foreach ($gid as $k => $v)
        {

          $saveGoods = $goods->where(['id'=>$v['gid']])->setDec('sold', $v['buynum']);
        }
        if (!$saveGoods) $ordersModel->rollback();

        foreach ($uid as $k => $v) {
          $integral = $glod->where(['uid'=> $v['uid']])->setDec('glod', $v['total']);
        }
        if (!$integral) $ordersModel->rollback();

        $ordersModel->commit();
        
      // $status = $ordersModel->field(true)->where('status=5')->select();

      //   foreach ($status as $k => $v)
      //   {
      //       $oids[$k] = $v['id'];
      //       $uids[$k]['uid'] = $v['uid'];
      //       $uids[$k]['total'] = $v['total'] * 0.1;
      //       $deleteOrders = $ordersModel -> delete($v['id']);

      //   }
      // if (!$deleteOrders) $ordersModel->rollback(); 
      // $goodsDetails = $ordersDetailModel->field('did,buynum')->where(['oid'=> ['in', $oid]])->select();
      // foreach ($goodsDetails as $k => $v) {
      //     $gids[$k] = $goodsDetailModel->field('gid')->where('id='.$v['did'])->find();
      //     $gids[$k]['buynum'] = $v['buynum'];
      //     $saveStocks = $goodsDetailModel->where(['id'=>$v['did']])->setInc('stock',$v['buynum']);
      //   }
      // if (!$saveStocks) $ordersModel->rollback();
      //   foreach ($gids as $k => $v)
      //   {

      //     $saveGood = $goods->where(['id'=>$v['gid']])->setDec('sold', $v['buynum']);
      //   }
      //   if (!$saveGood) $ordersModel->rollback();


      //   foreach ($uid as $k => $v) {
      //     $integrals = $glod->where(['uid'=> $v['uid']])->setDec('glod', $v['total']);
      //   }
      //   if (!$integrals) $ordersModel->rollback();


    }
    
}
