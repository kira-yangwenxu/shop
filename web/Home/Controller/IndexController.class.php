<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

  /**
     * 准备操作
     */
    public function __construct()
    {
        // 设置session的周期
        // 3600*24*7
        ini_set("session.gc_maxlifetime", 3600*24*7);
        setcookie(session_name(), session_id(), time() + 3600*24*7);

        session_start();
        parent::__construct();
        $set = [
            'type'=>'redis',
            'host'=>'127.0.0.1',
            'port'=>'6379',
        ];
        $this->redis = new \Redis;
        $this->redis = S($set);
    }


	/**
	 * 显示前台首页
	 */
    public function index(){
    	
        //菜单栏左边分类
        $arr = [];
        if ($arr['type']) {
          $this->assign('info', $arr['type']);
        } else {
          $type = $this->type();
          $arr['type'] = $type; 
          $this->assign('info', $type);

        }
        
        //女装专区模块分类
        $typeLevelTwoWomen = $this->typeLevelTwoWomen();
        $this->assign('Women', $typeLevelTwoWomen);	
        //女装专区模块品牌
        $Brands = $this->getWomenBrands();
        $this->assign('womenBrands', $Brands['womenBrands']);
        //女装专区模块商品
        $goods = $this->woMenShop();
        $this->assign('womengoods', $goods['womengoods']);
        
        //男装专区模块分类
        $typeLevelTwoMenSwear = $this->typeLevelTwoMenSwear();
        $this->assign('menswear', $typeLevelTwoMenSwear);
        //男装专区模块品牌
        $Brand = $this->getMenBrands();
        $this->assign('menBrands', $Brand);
        //男装专区模块商品
        $goods = $this->MenShop();
        $this->assign('mengoods', $goods);

        //数组缓存促销商品
        $data = [];
        if ($data) {
          $this->assign('promotions', $data);
        } else {
          $data = $this->promotions();
          $this->assign('promotions', $data);
        }


        // //小购物车
        //遍历mysql商品和redis的商品到购物车
        if(session('?homeInfo'))
        {
            //设置获取商品详情ID的键
            $setKey  = 'car:ids::'.session_id();
            //从集合中获取商品详情的所有ID
            $ids = $this->redis->sMembers($setKey);
            foreach ($ids as $k=>$v) {
                //通过商品详情ID获取商品的信息
                $carKey = 'car:datas:'.session_id().':'.$v;
                if($this->redis->exists($carKey))
                {
                    $redisData[] = $this->redis->hGetAll($carKey);
                    //加入购物车 单个商品的总价
                    $redisData[$k]['totle_price'] = (int)$redisData[$k]['buynum']*(float)$redisData[$k]['price'];
                }
            }


            // 判断商品信息是否为空
            if(!empty($redisData))
            {
                foreach($redisData as $k=>$v)
                { 
                    $redisData[$k]['uid'] = $_SESSION['homeInfo']['id'];
                }
            }
            //实例化对象
            $shopcar = M('Shopcar');
            //登陆用户的id
            $uid = $_SESSION['homeInfo']['id'];
            //找到该用户的商品
            $userGoods = $shopcar->field(true)->where(['uid'=>$uid])->select();

            foreach ($redisData as $key => $value) {
                //当用户商品的详情ID和radis中的详情ID一样时覆盖
                if($shopcar->where(['uid'=>$value['uid'], 'did'=>$value['did']])->find()) {

                    $shopcar->where(['uid'=>$value['uid'], 'did'=>$value['did']])->save($value);
                } else {
                    $shopcar->add($value);
                }
            }
          $userGoods = $shopcar->field(true)->where(['uid'=>$uid])->select();
          //判断
          if(!empty($userGoods))
          {
              foreach($userGoods as $k=>$v)
              { 
                  //统计全部商品的总价
                  $allTotle += $v['totle_price'];
                  //统计全部商品的总数量
                  $allNum += $v['buynum'];
              }
          }
          $count = count($userGoods);
          $this->assign('goods_car',$userGoods);

        }else
        {
            //无登陆遍历redis商品
            //设置获取商品详情ID的键
            $setKey  = 'car:ids::'.session_id();
            //从集合中获取商品详情的所有ID
            $ids = $this->redis->sMembers($setKey);
            foreach ($ids as $k=>$v) {
                //通过商品详情ID获取商品的信息
                $carKey = 'car:datas:'.session_id().':'.$v;
                if($this->redis->exists($carKey))
                {
                    $redisData[] = $this->redis->hGetAll($carKey);
                    //加入购物车 单个商品的总价
                    $redisData[$k]['totle_price'] = (int)$redisData[$k]['buynum']*(float)$redisData[$k]['price'];
                }
            }
            if(!empty($redisData))
            {
                foreach($redisData as $k=>$v)
                { 
                    //统计全部商品的总价
                    $allTotle += $v['totle_price'];
                    //统计全部商品的总数量
                    $allNum += $v['buynum'];
                }
            }
            $count = count($redisData);
            $this->assign('goods_car',$redisData);
        }
        //分配数据
        $this->assign('count',$count);  
        $this->assign('allTotle',$allTotle);
        $this->assign('allNum',$allNum);	
        $this->display();
    }

    /**
     * 查询分类数据
     * @return [array] [多维数组]
     */
    public function type()
    {
    	//查询数据
    	$type = M('Type');
    	$res = $type->field(true)->select();
    	
    	return $res; 

    }

    /**
     * 查询女装分类
     * @return array  返回女装子分类
     */
    public function typeLevelTwoWomen()
    {
        $woWomen = M('Type');
        $woWomenType = $woWomen->field(true)->where('pid=20')->limit(8)->select();
        return $woWomenType;
    }

    /**
     * 女装专区获取商品
     * @return 返回数组 
     */
    public function woMenShop()
    {    
        //获取女装商品分类ID
        $id = I('get.tid'); 
        $arr = [];
        $data = [];
        $goodsdetail = M('GoodsDetail');
        $womenimg   = M('GoodsImages');
        $goods = M('Goods');
        if (IS_AJAX) {
          //获取女装专区商品信息
          $womengoodsid = $goodsdetail->field('gid')->where('tid='.$id)->select();
          //变成一维数组
          $goodsid = array_column($womengoodsid, 'gid');
          //去除重复ID
          $gids = array_unique($goodsid);
          
          foreach ($gids as $k => $v) {
            $arr[] = $goodsdetail->field('gid , price, name')->where('gid='.$v)->find();
            $data[] = $womenimg->field('path ')->where('gid='.$v)->find();
          }
         
          //将以上二维数组合并为商品数据二维数组
          foreach( $arr as $k => $v){
              $info[] = array_merge($v,$data[$k]);
            }
         //AJAX返回数据
          $this->ajaxReturn($info);  
         } else {
          //默认占位模块
          $womenshop = $goodsdetail->field(true)->where(['tid'=>'42'])->limit(6)->select();

         }
        //存入数组并返回
        $list['womengoods'] = $womenshop;
        return $list;
        
    }

    /**
     * 获取女装品牌信息
     * @return array 返回女装品牌数据
     */
    public function getWomenBrands()
    {
        //实例化对象
        $BrandsModel = M('GoodsBrands');
        //查询品牌占位数据
        $womenBrands = $BrandsModel->field('logo')->where(['tid'=>'20'])->select();

        if (IS_AJAX) {
            //获取AJAX传过来的PID
            $girlId = I('get.pid');
            //查询品牌
            $girlBrands = $BrandsModel->field('logo')->where(['tid' => $girlId])->limit(6)->select();
            //返回AJAX请求
            $this->ajaxReturn($girlBrands);
        }
        //返回占位数据
        $list['womenBrands'] = $womenBrands;
        return $list;

    }


    /**
     * 查询男装分类
     * @return array 返回男装子分类数组
     */
    public function typeLevelTwoMenSwear()
    {   //实例化对象
        $menswear = M('Type');
        //查询数据
        $menswearType = $menswear->field(true)->where('pid=19')->limit(8)->select();
        //返回站位数据
        return $menswearType; 
    }

    /**
     * 获取男装模块品牌
     * @return array 返回男装品牌数据
     */
    public function getMenBrands()
    {
      //实例化对象
      $BrandsModel = M('GoodsBrands');
       //查询品牌占位数据
      $Brands = $BrandsModel->field('logo')->where(['tid'=>'19'])->select();

      if (IS_AJAX) {
            //获取AJAX传过来的PID
            $menId = I('get.pid');
            //查询品牌
            $menBrands = $BrandsModel->field('logo')->where(['tid' => $menId])->limit(6)->select();
            //返回AJAX请求
            $this->ajaxReturn($menBrands);
        }

      return $Brands;
    }
    /**
     * 获取男装模块商品
     * @return array 返回男装数据
     */
    public function MenShop()
    {    
        //获取男装商品分类ID
        $id = I('get.tid'); 
        //定义空数组
        $arr = [];
        $data = [];
        $goodsdetail = M('GoodsDetail');
        $menimg   = M('GoodsImages');
        $goods = M('Goods');
        if (IS_AJAX) {
          //获取男装专区商品信息
          $mengoodsid = $goodsdetail->field('gid')->where('tid='.$id)->select();
          //变成一维数组
          $goodsid = array_column($mengoodsid, 'gid');
          //去除重复ID
          $gids = array_unique($goodsid);
          //遍历并查询
          foreach ($gids as $k => $v) {
            $arr[] = $goodsdetail->field('gid , price, name')->where('gid='.$v)->find();
            $data[] = $menimg->field('path ')->where('gid='.$v)->find();
          }
         
          //将以上二维数组合并为商品数据二维数组
          foreach( $arr as $k => $v){
              $info[] = array_merge($v,$data[$k]);
            }
         //AJAX返回数据
          $this->ajaxReturn($info);  
         } else {
          //默认占位模块
          $menshop = $goodsdetail->field(true)->where(['tid'=>'42'])->limit(6)->select();

         }
     
        return $menshop;
    }
    /**
     * 遍历促销以及热销
     * @return array 返回促销减价数据
     */
    public function promotions()
    {
      //定义空数组
      $arr = []; 
      $data = [];
      $img = [];
      //实例化对象
      $goodsdetailmodel = M('GoodsDetail');
      $goodsonsalemodel = M('onsale');
      $goodsimgmodel = M('GoodsImages');
      //获取gid
      $goodsid = $goodsonsalemodel->limit('6')->getField('gid',true);
      //遍历并查询数据
      foreach ($goodsid as $v) {
        $arr[] = $goodsdetailmodel->field('gid, price, name')->where(['gid'=>$v])->find();
        $data[] = $goodsonsalemodel->where(['gid'=>$v])->find();
        $img[] = $goodsimgmodel->field('path')->where(['gid'=>$v])->find();
      }
      //合并成二维数组
      foreach( $arr as $k => $v)
      {
        $info[] = array_merge($v, $data[$k],$img[$k]);
      }



      return $info;

    }
}