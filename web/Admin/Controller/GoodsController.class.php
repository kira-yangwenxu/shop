<?php 
namespace Admin\Controller;
use Think\Controller;

/**
 * 商品控制器
 */
class GoodsController extends CommonController 
{
	/**
	 * 显示商品列表页面
	 */
	public function index()
	{
		//实例化商品对象
		$goods = D('Goods');
		$detail = D('GoodsDetail');
		$images = D('GoodsImages');
		$brands = D('GoodsBrands');
		$type = D('Type');
		//初始查询条件
		$str = '1=1';
		$string = ' ';
		//查询商品名
		$name = isset($_GET['name'])?$_GET['name']:'';
		if(strlen($name) > 0){
            $str .= " and g.name like '%{$_GET['name']}%'";
        }
        //查询商品状态
		$status = isset($_GET['status'])?$_GET['status']:'';
		if($status){
            $str .= " and status =".$_GET['status'];
        }
        //查询商品品牌
		$bid = isset($_GET['bid'])?$_GET['bid']:'';
		if($bid){
            $string .= " and bid =".$_GET['bid'];
        }
        //查询商品类型
		$tid = isset($_GET['tid'])?$_GET['tid']:'';
		if($tid){
            $string .= " and tid =".$_GET['tid'];
        }
		//统计数据
		$count = $detail->where($str,$string)->count();
		//实例化分页方法
		$page = new \Think\Page($count,5);
        //设置按钮
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
		//显示分页
		$btn = $page->show();
		//查询所有商品和商品详情
		$goods_detail = $detail->table('shop_goods as g,shop_goods_detail as d')
					  ->field('g.id,g.name,g.title,g.addtime,g.des,g.click,g.sold,d.id,d.gid,d.tid,d.bid,d.stock,d.attr,d.price,d.status')
					  ->where('g.id = d.gid and '.$str.$string)
					  ->order('d.id desc')
					  ->limit($page->firstRow, $page->listRows)
					  ->getdata();
					  // dump($list);exit;
		//查询商品信息
		$images_info = $images->field(true)->select();
		$brands_info = $brands->field(true)->select();
		$type_info = $type->field(true)->order('concat(path,id)')->select();
		//分配数据
		$this->assign('goods',$goods_detail);
		$this->assign('images',$images_info);
		$this->assign('brands',$brands_info);
		$this->assign('type',$type_info);
        $this->assign('page', $btn);
        //显示数据
		$this->display();
	}

	/**
	 * 显示修改商品页面
	 */
	public function add()
	{
		if(IS_POST)
		{
			
            //实例化商品、商品详情对象
			$goods = D('Goods');
			$detail = D('GoodsDetail');
			//获取post数据并且验证
			$goods_data = $goods->create();
			$detail_data = $detail->create();
			// 判断商品验证是否通过
			if($goods_data && $detail_data)
			{
				//配置上传类
				$config = [
					'exts' => ['jpg', 'gif', 'png', 'jpeg'],
					'rootPath' => './web/Admin/Upload/',
					'subName' => './Goods/',
				];
				//实例化上传类
				$up = new \Think\Upload($config);
	            //多文件上传
				$pic = $up->upload([$_FILES['pic']]);
				
				// 判断是否上传成功
	            if($pic)
	            {
	            	//上传成功
	                for($i = 0; $i < count($pic); $i++)
	                {
	                	//获取上传文件的文件名
	                    $pic_path[] = $pic[$i]['savename'];
	                }
	            }else{
					//上传失败
					$this->error($up->getError());
				}
				//实例化对象
				$images = M('GoodsImages');
				//开启事务
				$goods->startTrans();
				//取第一个价格，用于排序
				$goods_data['price'] = $detail_data['price'][0];
				//添加商品数据,返回最后的商品ID
				$row_goods = $goods->add($goods_data);
				if(!$row_goods)
				{
					//事务回滚
					$goods->rollback();
				}else
				{
					//查询添加的这个商品ID的信息
					$goods_info = $goods->find($row_goods);
					//添加商品id到商品图片表
					$images_info['gid'] = $goods_info['id'];
					//循环添加商品图片到图片表
					for ($i=0; $i < count($pic_path); $i++) 
					{ 
						//添加商品图片path字段
						$images_info['path'] = $pic_path[$i];
						//添加商品图片数据,返回最后的商品图片ID
						$row_img = $images->add($images_info);
						//判断添加商品图片是否成功
						if(!$row_img)
						{
							//添加商品图片失败,事务回滚
							$goods->rollback();
						}
					}

					//获取post数据
					$detail_info = I('post.');
					//获取属性
					$attrname = $_POST['attrname'];
					//获取属性值
					$val = $_POST['val'];
					//属性数组
					$attr = [];
					for ($i=0; $i < count($val); $i++) 
					{
						//属性名和属性值不为空才拼接
						if(!empty($attrname[$i]) && !empty($val[$i]))
						{
							$attr[$i] = $attrname[$i].':'.$val[$i];
						}
					}
					//属性一下标			
					$one = 0;
					//属性二下标
					$two = 1;
					//拼接属性数组
					$attrs = [];
					for ($i=0; $i < count($val)/2; $i++) 
					{ 
						if(!empty($attr[$one]) && !empty($attr[$two]))
						{
							//属性一二不为空用逗号拼接
							$attrs[] = $attr[$one].','.$attr[$two];
						}elseif(empty($attr[$one]))
						{
							//属性一为空
							$attrs[] = $attr[$two];
						}elseif(empty($attr[$two]))
						{
							//属性二为空
							$attrs[] = $attr[$one];
						}				
						//下一个属性一
						$one += 2;
						//下一个属性二
						$two += 2;
					}
					//添加商品数据到商品详情表
					$detail_infos = ['gid'=>$goods_info['id'],'attr'=>$attrs,'tid'=>I('post.tid'),'bid'=>I('post.bid'),'name'=>I('post.name'),'status'=>I('post.status')];
					$detail_info = I('post.');
					//每一个或一对属性添加一个商品
					for ($i=0; $i < count($attrs); $i++) { 
						$detail_infos['stock'] = $detail_info['stock'][$i];
						$detail_infos['price'] = $detail_info['price'][$i];
						$detail_infos['attr'] =  $attrs[$i];
						//添加商品详情数据,返回最后的商品详情ID
						$row_detail = $detail->add($detail_infos);
						//判断添加商品详情是否成功
						if(!$row_detail)
						{
							//添加商品详情失败，事务回滚
							$goods->rollback();
						}
					}
				}
				//添加完成,事务提交
	            $goods->commit();
	            $this->success('成功添加商品',U('index'));
			}else
            {
            	//验证商品信息失败
                $this->error($goods->getError().'<br>'.$detail->getError());
            }				
		}

		//判断是否是ajax提交数据
		if(IS_AJAX){
			// 获取传过来的pid
			$pid = $_GET['pid'];
			//实例化品牌对象
			$brands = M('GoodsBrands');
			// /查询pid下的所有品牌
			$arr = $brands->where(['tid'=>$pid])->field('id,brandname')->select();
			//返回pid下的所有品牌数据
			$this->ajaxReturn($arr);			
		}else
		{
			//实例化对象
			$type = M('Type');
			//查询所有分类
       	 	$arr = $type->field(true)->order('concat(path,id)')->select();
			//分配数据
			$this->assign('type',$arr);
			//显示页面
			$this->display();
		}
	}

	
	/**
	 * 编辑商品信息
	 * @param  int $id 要修改的商品ID
	 */
	public function edit($id)
	{
		if(IS_POST)
		{
			
            //实例化商品、商品详情对象
			$goods = D('Goods');
			$detail = D('GoodsDetail');
			//获取post数据并且验证
			$goods_data = $goods->create();
			$detail_data = $detail->create();
			// 判断商品验证是否通过
			if($goods_data && $detail_data)
			{	
				//开启事务
				$goods->startTrans();
				//查出商品信息
				$goods_find = $goods->field('name,title,status,des')->find($id);
				//判断是否修改了商品信息
				if($goods_data != $goods_find)
				{
					//修改商品数据,返回影响行数
					$row_goods = $goods->field('name,title,status,des')->where(['id'=>$id])->setField($goods_data);
				}

				//配置上传类
				$config = [
					'exts' => ['jpg', 'gif', 'png', 'jpeg'],
					'rootPath' => './web/Admin/Upload/',
					'subName' => './Goods/',
				];
				//实例化上传类
				$up = new \Think\Upload($config);
	            //多文件上传
				$pic = $up->upload([$_FILES['pic']]);
				//判断是否有上传
				if($pic)
				{
	            	//上传成功
	                for($i = 0; $i < count($pic); $i++)
	                {
	                	//获取上传文件的文件名
	                    $pic_path[] = $pic[$i]['savename'];
	                }
					//实例化对象
					$images = M('GoodsImages');
					//获取商品的ID
					$images_info['gid'] = $id;
					//循环修改商品图片到图片表
					for ($i=0; $i < count($pic_path); $i++) 
					{ 
						//修改商品图片path字段
						$images_info['path'] = $pic_path[$i];
						//修改商品图片数据,返回最后的商品图片ID
						$row_img = $images->add($images_info);	
					}
            	}

	            //查出商品详情的信息
				$detail_id = $detail->field('id')->where(['gid'=>$id])->select();		
				//获取修改的数据
				$detail_info = ['price'=>I('post.price'),'stock'=>I('post.stock')];
				//获取价格的个数
				$price_num = count($_POST['price']);
				//修改信息数组
				$detail_infos = [];
				//每个属性修改一个商品
				for ($i=0; $i < $price_num; $i++) { 
					$detail_infos['stock'] = $detail_info['stock'][$i];
					$detail_infos['price'] = $detail_info['price'][$i];	
					//修改商品条件
					$map['gid'] = $id;
					$map['id'] = $detail_id[$i]['id'];
					//修改商品详情数据,返回最后的商品详情ID
					$row_detail = $detail->where($map)->setField($detail_infos);
				}
				//修改完成,事务提交
	            $goods->commit();
	            $this->success('成功修改商品',U('index'));
			}else
            {
            	//验证商品信息失败
                $this->error($goods->getError().'<br>'.$detail->getError());
            }				
		}else
		{
			//实例化商品对象
			$goods = D('Goods');
			$detail = D('GoodsDetail');
			$images = D('GoodsImages');
			//查询商品信息
			$info = $goods->field('id,name,title,status,des')->find($id);
			//查询商品详情
			$obj = $detail->field('stock,price,attr')->where(['gid'=>$id])->getdata();
			//查询商品图片
			$arr = $images->field('id,gid,path')->where(['gid'=>$id])->select();
			// dump($info);
			// dump($obj);
			// dump($arr);exit;
			//分配数据
			$this->assign('goods',$info);
			$this->assign('detail',$obj);
			$this->assign('images',$arr);
			//显示页面
			$this->display();	
		}
	}

	/**
	 * 删除商品信息
	 * @param  int $id  商品的ID
	 * @param  array $paths 商品图片的路径
	 */
	public function del($id,$path)
	{
		if(IS_AJAX)
		{
			//删除图片
			foreach ($path as $v) {
				unlink('.'.substr($v, 5));
			}	

			// 实例化商品、商品详情和商品图片对象
			$goods = M('Goods');
			$detail = M('GoodsDetail');
			$images = M('GoodsImages');
			//开启事务
			$goods->startTrans();
			//执行删除
			$row_goods = $goods->delete($id);
			$row_detail = $detail->where('gid='.$id)->delete();
			$row_images = $images->where('gid='.$id)->delete();
			//定义返回对象
			$arr = [];
			//判断是否删除成功
			if($row_goods > 0 && $row_detail > 0 && $row_images > 0)
			{
				//返回的对象值
				$arr['row_images'] = $row_images;
				$arr['row_detail'] = $row_detail;
				$arr['row_goods'] = $row_goods;
				//提交事务
				$goods->commit();
				$this->ajaxReturn($arr);
			}else
			{
				//事件回滚
				$goods->rollback();
			}
		}
	}

}