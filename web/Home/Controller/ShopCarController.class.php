<?php
namespace Home\Controller;
use Think\Controller;

class ShopCarController extends Controller {

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
     * 显示购物车页面
     */
    public function shopCarList()
    {
        if(IS_AJAX)
        {   
            //返回ajax对象
            $obj = [];
            //操作
            $action  = I('get.action');

            // 增加数量
            if($action == 'plus')
            {
                //获取详情ID
                $id = I('get.id');
                $stock = I('get.stock');
                //实例化对象
                $detail = D('GoodsDetail');
                //查询该商品的库存
                $detail_info = $detail->field('stock')->find($id);
                //返回对象
                $this->ajaxReturn($detail_info);
            }
        }else
        {
            //有登陆,遍历mysql商品和redis的商品到购物车
            if(session('?homeInfo'))
            {
                //设置获取商品详情ID的键
                $setKey  = 'car:ids::'.session_id();
                //从集合中获取商品详情的所有ID
                $ids = $this->redis->sMembers($setKey);
                foreach ($ids as $k=>$v) {
                    //通过商品详情ID获取redis商品信息
                    $carKey = 'car:datas:'.session_id().':'.$v;
                    if($this->redis->exists($carKey))
                    {
                        //获取redis键的所有值
                        $redisData[] = $this->redis->hGetAll($carKey);
                        //加入购物车 单个商品的总价
                        $redisData[$k]['totle_price'] = (int)$redisData[$k]['buynum']*(float)$redisData[$k]['price'];
                        foreach($redisData as $k=>$v)
                        { 
                            //加入登录用户ID到redis商品信息
                            $redisData[$k]['uid'] = $_SESSION['homeInfo']['id'];
                        }
                    }
                }
                //实例化对象
                $shopcar = M('Shopcar');
                //登陆用户的id
                $uid = $_SESSION['homeInfo']['id'];
                //遍历redis的商品信息
                foreach ($redisData as $key => $value) 
                {
                    //当用户商品的详情ID和radis中的详情ID一样时覆盖，反之则添加
                    if($shopcar->where(['uid'=>$value['uid'], 'did'=>$value['did']])->find()) {
                        //修改操作
                        $row = $shopcar->where(['uid'=>$value['uid'], 'did'=>$value['did']])->save($value);
                    } else {
                        //添加操作
                        $row = $shopcar->add($value);
                    }
                }
                //操作成功
                if($row)
                {
                    //删除redis的商品信息
                    foreach ($ids as $k=>$v) { 
                        $carKey  = 'car:datas:'.session_id().':'.$v;
                        if($this->redis->exists($carKey))
                        {
                            //删除哈希里的商品信息
                            $row_hdel = $this->redis->del($carKey);
                            //删除集合里的详情id
                            $row_sdel = $this->redis->srem($setKey,$v);    
                        }              
                    }
                }
                $userGoods = $shopcar->field(true)->where(['uid'=>$uid])->select();
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
                //分配数据
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
                    // 判断redis是否存在$carKey
                    if($this->redis->exists($carKey))
                    {
                        //遍历
                        $redisData[] = $this->redis->hGetAll($carKey);
                        //加入购物车 单个商品的总价
                        $redisData[$k]['totle_price'] = (int)$redisData[$k]['buynum']*(float)$redisData[$k]['price'];
                    }
                }
                if(!empty($redisData))
                {
                    foreach($redisData as $k=>$v)
                    { 
                        // dump()
                        //统计全部商品的总价
                        $allTotle += $v['totle_price'];
                        //统计全部商品的总数量
                        $allNum += $v['buynum'];
                    }
                }
                //分配数据
                $this->assign('goods_car',$redisData);
            }
            
            //分配数据
            $this->assign('allTotle',$allTotle);
            $this->assign('allNum',$allNum);
            //显示购物车页面
            $this->display('Goods/shopcar2');
        }
    }

    /**
     * 加入购物车
     */
    public function addToCar()
    {
        if(IS_AJAX)
        {
            //ajax获取传值
            $did = I('get.did');
            $buynum = I('get.num');
            //实例化对象
            $detail = M('GoodsDetail');
            $images = M('GoodsImages');
            //查询该商品详情和商品
            $detail_info = $detail->table('shop_goods g , shop_goods_detail d')
                                  ->field('g.title,g.id,d.id,d.gid,d.name,d.price,d.attr,d.status,d.stock')
                                  ->where('d.gid=g.id and d.id='.$did)
                                  ->find();
            //判断有无该商品
            if(!$detail_info)
            {
                //无该商品
                $this->error('没有该商品',U('Login/logout'));
            }
            $images_info = $images->field('path')->where('gid='.$detail_info['gid'])->limit(1)->find();
            
            //设置键 商品详情
            $carKey = 'car:datas:'.session_id().':'.$did;
            //判断redis购物车中是否有相对应的商品数据
            if(!$this->redis->exists($carKey))
            {
                $detail_info['buynum'] = $buynum;
                $detail_info['did'] = $detail_info['id'];
                unset($detail_info['id']);
                //合并数组
                $detail_info = array_merge($detail_info,$images_info);
                //将商品详情存入哈希中
                $this->redis->hMSet($carKey,$detail_info);
                //设置键存放商品详情ID
                $setKey  = 'car:ids::'.session_id();
                //将商品详情ID存入集合中
                $this->redis->sAdd($setKey,$did);
            }else
            {
                //购物车已经有对应的商品,修改对应购物车商品的数量
                $this->redis->hIncrBy($carKey, 'buynum', 1);
            }
            

            // 返回对象
            $obj = [];
            //判断是否加入成功j
            if($this->redis->exists($carKey))
            {
                $obj['status'] = 1;
                $obj['msg'] = '成功加入购物车~~~';
            }else
            {
                $obj['status'] = 2;
                $obj['msg'] = '加入购物车失败!!!';
            }
            //返回ajax对象
            $this->ajaxReturn($obj);
        }
    }

    /**
     * 选中删除
     */
    public function selectDel()
    {
        if(IS_AJAX)
        {
            //根据详情id删除redids的商品数据
            $setKey  = 'car:ids::'.session_id();
            //详情ID
            $ids = I('get.ids');

            //判断是否有多个的详情ID
            if(strpos($ids,','))
            {
                $ids = explode(',',I('get.ids'));
                foreach ($ids as $k=>$v) { 
                    $carKey[]  = 'car:datas:'.session_id().':'.$v;
                    //删除哈希里的商品信息
                    $row_hdel = $this->redis->del($carKey);
                    //删除集合里的详情id
                    $row_sdel = $this->redis->srem($setKey,$v);                  
                }
            }else
            {
                $carKey[]  = 'car:datas:'.session_id().':'.$ids;
                //删除哈希里的商品信息
                $row_hdel = $this->redis->del($carKey);
                //删除集合里的详情id
                $row_sdel = $this->redis->srem($setKey,$ids);    
            }
            $obj['row'] = $row_sdel;

            //判断是否登陆
            if(session('?homeInfo'))
            {
                $uid = $_SESSION['homeInfo']['id'];
                //实例化对象
                $shopcar = M('Shopcar');
                //删除购物车表的对应数据
                $row_shopcar = $shopcar->where(['did'=>['in', $ids], 'uid'=>$uid])->delete();
                $obj['row'] = $row_shopcar;
            }
            //ajax返回
            $this->ajaxReturn($obj);
        }
    }

    /**
     * 小购物车删除
     */
    public function shopcarDel()
    {
        if(IS_AJAX)
        {
            //实例化对象
            $shopcar = M('Shopcar');
            //单个详情ID
            $id = I('get.id'); 
            //判断是否登录
            if(session('?homeInfo'))
            {
                //删除购物车表的对应数据
                $row = $shopcar->where(['did'=>$id,'uid'=>$_SESSION['homeInfo']['id']])->delete();
            }else
            {
                $carKey  = 'car:datas:'.session_id().':'.$id;
                //删除集合里的详情id
                $setKey  = 'car:ids::'.session_id();
                $srow = $this->redis->srem($setKey,$id);
                //删除哈希里的商品信息
                if($srow)
                {
                    $row = $this->redis->del($carKey);
                }
            }
            //ajax返回
            $this->ajaxReturn($row);
        }
        
    }

    /**
     * 去付款
     */
    public function toPay()
    {
        if(IS_AJAX)
        {
            //判断是否登录
            if(session('?homeInfo'))
            {
                //获取数量字符串
                $nums = explode(',',I('get.nums'));
                //获取id字符串
                $ids = explode(',',I('get.ids'));
                //获取小计字符串
                $totle_price = explode(',',I('get.totle_price'));
                // 实例化对象
                $shopcar = M('Shopcar');
                //登录用户ID
                $uid = $_SESSION['homeInfo']['id'];
                for ($i=0; $i < count($nums); $i++) { 
                    //修改购买数量
                    $info['buynum'] = $nums[$i];
                    //查询该用户商品的单价
                    $shopcar_info = $shopcar->field('price')->where(['uid'=>$uid,'did'=>$ids[$i]])->select();
                    //修改小计
                    $info['totle_price'] = $nums[$i] * (float)$shopcar_info[$i]['price'];
                    $row = $shopcar->where(['uid'=>$uid,'did'=>$ids[$i]])->save($info); 
                } 
                $shopcar_ids = $shopcar->field('id')->where(['uid'=>$uid])->select();
                $_SESSION['ids'] = $shopcar_ids;
                $this->ajaxReturn($_SESSION['ids']);
            }else
            {
                $this->error('请登陆后再支付');
            }
        }
    }

}