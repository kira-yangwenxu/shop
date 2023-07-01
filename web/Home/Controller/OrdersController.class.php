<?php
namespace Home\Controller;
use Think\Controller;
class OrdersController extends Controller {
    public function index(){
        //判断用户是否登陆
         if (!session('?homeInfo')) {
            $this->redirect('Login/index');
            exit;
        }
        $data =  $_SESSION['ids'];
        //实例化对象
        $goodsDetailModel = M('GoodsDetail');
        $shopcar = M('Shopcar');
        //遍历取出购物车数据
        foreach ($data as $k => $v){
         $goods[] = $shopcar->field('did,buynum,name,attr,path')->where(['id'=>$v['id']])->find(); 
        }
        foreach ($goods as $k => $v) {
            $price[$k] = $goodsDetailModel->field('price')->where(['id'=>$v['did']])->find();
            $goods[$k]  = array_merge($v,$price[$k]);  
         } 
        //分配数据
       $this->assign('data',$this->findAddress());  
       $this->assign('list',$this->level1Address());
       $this->assign('goodslist',$goods);
       //显示视图层
       $this->display('orders');
    }
    /**
     * 全国一级地区省级数据
     */
    public function level1Address()
    {

    	return M('areas')->where('parent_id=1')->select();
  
    }
    /**
     * 全国二级市级分类数据
     */
    public function level2Address()
    {   $level2id = I('get.pid'); 

       $arr = M('areas')->where(['parent_id'=> $level2id])->select();
        if (IS_AJAX) {
            $this->ajaxReturn($arr);

        }
    }
    /**
     * 全国三级区级分类数据
     */
    public function level3Address()
    {
        $level3id = I('get.cid');
        $arr = M('areas')->where(['parent_id'=> $level3id, 'area_type'=> 3])->select();
        if (IS_AJAX) {
            $this->ajaxReturn($arr);

        }

    }

    /**
     * 添加收货信息
     * @return 返回受影响行数
     */
    public function doAddAddress()
    {
        
        $arr = [];    
        $data = [];    
        $provincesid = I('post.provinces');
        $cityid = I('post.city');
        $areaid = I('post.area');
        $arr['uid'] = I('post.id');
        $arr['detail'] = I('post.detail');
        $arr['user'] = I('post.name');
        $arr['phone'] = I('post.phone');

        $data['provinces'] = M('areas')->where(['id'=> $provincesid])->getField('area_name');
        $data['city'] = M('areas')->where(['id'=> $cityid])->getField('area_name');
        $data['area'] = M('areas')->where(['id'=> $areaid])->getField('area_name');
        $data['detail'] = I('post.detail');
        $arr['addr'] = implode(',', $data);
        $arr['provinces'] = $data['provinces'];
        $arr['city'] = $data['city'];
        $arr['area'] = $data['area'];
        $num = count($this->findAddress());
        if ($num < 5) {
            $end = M('UserAddr')->add($arr);
        } else {
            $this->error('地址超过5个无法添加');
        }
        if ($end) {
         $this->success('添加成功',U('Orders/index'));
       }
    }

    /**
     * 查询用户地址数据
     * @return 用户地址数据
     */
    public function findAddress()
    {
       $userid = $_SESSION['homeInfo']['id'];
       $findAddress = M('UserAddr')->field('user,phone,provinces,city,area,detail,status')->where(['uid'=> $userid])->select();
       return $findAddress;
    }
}