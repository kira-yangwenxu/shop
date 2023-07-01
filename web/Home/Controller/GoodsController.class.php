<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {

    /**
     * 商品详情页
     */
    public function goodsDetail($id = 15)
    {

        //判断是否AJAX传输
        //ajax下拉加载数据
        if (IS_AJAX) {

            $goodsId = I('get.id');
            $p = I('get.p');

            // 初始化缓存
            S(array( 'type'=>'memcache',
                'host'=>'localhost',    
                'port'=>'11211',    
                'expire'=> 3360 
                )
            ); 

            //实例化详情图片模型
            $detailImageModel = M ('GoodsImages');

            //取出图片路径
            $data['path'] = array_column($detailImageModel->field('path')->where(['gid'=>$goodsId])->limit($p.',1')->select(), 'path')[0];

            if(!$data) {
                $this->ajaxReturn(false);
            }

            $data['page'] = ++$p;
            $this->ajaxReturn($data);


        }
        // 需要在修改商品的方法中删除缓存
        // 初始化缓存
        S(array( 'type'=>'memcache',
            'host'=>'localhost',    
            'port'=>'11211',
            'prefix'=>'shop_detail',  
            'expire'=> 3360 
            )
        ); 

        $cache = S($id);

        //如果有缓存则读取缓存数据
        if ($cache) {
            echo '缓存中获取';
                $info = $cache['info'];
                $gidata = $cache['gidata'];
                $attrData = $cache['attrData'];
                $defaultData = $cache['defaultData'];
                $detailImage = $cache['detailImage'];

        } else {
            echo '请求数据库';
            //1.获取商品ID
            // $goodsId = I('get.id');
             $goodsId = $id;

            //获取商品基本信息
            $goodsModel = M('Goods');

            $info = $goodsModel->find($goodsId);

            //获取商品图片信息
            $goodsImagesModel = M('GoodsImages');

            $gidata = $goodsImagesModel->field('path')->where(['gid'=>$goodsId])->select();


            //2.通过商品ID获取所有商品详情并处理 (多条数据) ;
            $attrData = D('goods')->getAttrData($goodsId);
            // 获取默认的商品价格和库存
            $defaultData = D('goods')->getDefaultData($goodsId,$attrData);

            //获取详情图片
            $detailImageModel = M ('GoodsImages');

            $detailImage = $detailImageModel->field('path')->where(['gid'=>$goodsId])->find();
            // 如果点击量大于某个数，则加入缓存
            if($info['click'] > 3) {
                $cache['info'] = $info;
                $cache['gidata'] = $gidata;
                $cache['attrData'] = $attrData;
                $cache['defaultData'] = $defaultData;
                $cache['detailImage'] = $detailImage;
                echo '存入缓存';
                S($id, $cache);

            }

        }
        // //1.获取商品ID
        // // $goodsId = I('get.id');
        //  $goodsId = 111;

        // //获取商品基本信息
        // $goodsModel = M('Goods');

        // $info = $goodsModel->find($goodsId);

        // //获取商品图片信息
        // $goodsImagesModel = M('GoodsImages');

        // $gidata = $goodsImagesModel->field('path')->where(['gid'=>$goodsId])->select();

        // //2.通过商品ID获取所有商品详情并处理 (多条数据) ;
        
        // $attrData = D('goods')->getAttrData();

        // //
        // // 获取默认的商品价格和库存
        // $defaultData = D('goods')->getDefaultData($goodsId,$attrData);


        // 分配属性数据
        $this->assign('attrData', $attrData);
        //分配商品基本信息
        $this->assign('info', $info);
        //分配商品图片信息
        $this->assign('gidata', $gidata);
        //分配默认价格和库存
        $this->assign('defaultData', $defaultData);
        //分配详情图片第一张
        $this->assign('detailImage', $detailImage);



    	$this->display();
    }

    //ajax判断加入的购买数量是否合法
    public function ajaxConfirmNum($gid, $num, $attr)
    {
        if(IS_AJAX) {


        //查看该商品库存
            $goodsDetailModel = M('GoodsDetail');

            //取出对应属性的库存
            $data = M('GoodsDetail')->field('id,stock')->where(['gid'=>$gid,'attr'=>$attr]) ->find();

            //用户选择的值与库存比较
            //当库存为0时
            if($data['stock'] == 0){
                $info['status'] = 2;
                $info['msg'] = '当前商品无货，正在补货中...';
                $this->ajaxReturn($info);
            } 

            //当用户选择的大于库存时
            if ($num > $data['stock']) {
                $info['status'] = 2;
                $info['msg'] = '库存不足，您只能买'.$data['stock'].'件';
                $this->ajaxReturn($info);

            }

            $info['status'] = 1;
            $info['did'] = $data['id'];
            $this->ajaxReturn($info);
            
        }
    }

    //ajax获取不同库存，价格
    public function ajaxPrice($attr, $gid)
    {
        if( IS_AJAX) {
            
            $data = D('goods')->getAjaxData($attr,$gid);
            $this->success($data);
        }
    }



    /**
     * 商品列表页
     */
    public function goodsList()
    {
        $id = 42;

        if(!$id) $this->redirect('Index/index');
        //操作分类表
        $typeModel = M('Type');

        $me = $typeModel->where(['id' => $id])->find();

        //操作商品表
        $goodsModel = M('Goods');
        //操作商品详情表
        $goodsDetailModel = M('GoodsDetail');
        //查看是否有子类
        $tmp = $typeModel->where(['pid' => $id])->select();
        if($tmp)
        {   
            //二级分类ID
            $ids = array_column($tmp, 'id');
            // 查询是否含有子类，有则不是三级分类
            $tmp1 = $typeModel->where(['pid' => ['in', join(',', $ids)]])->select();

            //还有子类则是顶级分类
            if($tmp1)
            {
                $parent[] = $typeModel->where(['id'=>$id])->find();
                // 通过二级分类找三级分类
                $ids = array_column($tmp1, 'id');//三级分类的ID
                
            } else {
                //没有子类就是点击了二级分类
                $parent[] = $typeModel->where(['id' => $me['pid']])->find();
                $parent[] = $typeModel->where(['id'=>$id])->find();

            }

            $gids = array_unique($goodsDetailModel
                        ->field('gid')
                        ->where(['tid'=>['in',join(',',$ids)]])
                        ->select());

            $gids = array_column($gids, 'gid');
            // 通过商品ID找到所有属于顶级分类的商品
            $data = D('Goods')->getGoodsListData($gids);

            if(IS_AJAX)
            {
                $data['data'] = $data;
                $data['page'] = ($page->firstRow/$page->listRows)+2;
                $data['type'] = $tmpScroll;
                $this->ajaxReturn($data);
                exit;
            }

        } else {
            //无子类的情况
            //查询父类用来做面包屑
            $son = $typeModel->where(['id' => $me['pid']])->find();
            $parent[] = $typeModel->where(['id' => $son['pid']])->find();
            $parent[] = $son;
            $parent[] = $typeModel->where(['id'=>$id])->find();


        }
        //没有子类就是点击了三级分类

        //操作品牌表
        //找出该分类下的品牌
        $brandModel = M('GoodsBrands');
        //查询该分类下所有的品牌信息  只查二级分类的品牌
        $brand = $brandModel->where(['tid' => $parent[1]['id']])->select();
        //添加where条件
        $where = ['tid' => $id, 'status' => 1];
        // dump(I('get.'));
        //是否带有品牌条件
        if(I('get.brand')) $where['bid'] = I('get.brand');

        //是否带有排序条件
        if(I('get.sort')) $order = I('get.sort');
        //是否带有商品名模糊搜索
        // if(I('get.name')) $where['name'] = ['like', '%'.I('get.name').'%'];
        // 是否带有价格区间条件
        $minprice = I('get.minprice') ? I('get.minprice') : 0;
        $maxprice = I('get.maxprice') ? I('get.maxprice') : pow(10, 9);
        $where['price'] = ['BETWEEN', [$minprice, $maxprice]];
        // //统计数据总条数
        // 查询详情表列出符合条件的商品id
        $goodsIds = $goodsDetailModel->field('gid')->where($where)->select();
        $gids = array_unique(array_column($goodsIds, 'gid'));

        //总页面数
        $dataTotal = count($goodsIds);
        //实例化分页类
        $page = new \Think\Page($dataTotal, 12);
        $btns = $page->show();

        //获取所有商品id 

        //查询商品数据
        $info = $goodsModel->where(['id'=>['in',join(',',$gids)], 'status' => 1])->limit($page->firstRow.','.$page->listRows)->select();

        //通过商品ID查询商品数据
        $data = D('Goods')->getGoodsListData($info);

        // if(IS_AJAX)
        // {
        //     $tmp['data'] = $data;
        //     $tmp['btns'] = $btns;
        //     // echo $goods->_sql();
        //     $this->ajaxReturn($tmp);   
        // }
        $this->assign([
            'data' => $data, 
            'parent' => $parent,
            'brand' => $brand,
            'btns' => $btns,
            'totalPages' => $totalPages,
            'me' => $me
        ]);

        $this->display();
    }

    public function shopcar(){
    	$this->display();
    }
}