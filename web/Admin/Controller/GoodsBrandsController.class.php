<?php
namespace Admin\Controller;
use Think\Controller;

class GoodsBrandsController extends CommonController 
{
    /**
     * 显示品牌列表
     */
    public function index()
    {
    	//实例化品牌类
    	$brands = D('GoodsBrands');
        //实例化分类对象
        $type = M('Type');
        //查询条件
        if (isset($_GET['search']) && strlen($_GET['search']) > 0){
            $map['search'] = ['like','%'.I('get.search').'%'];
        }
        //统计品牌总数
        $count = $brands->where($map)->count();
        //实例化分页类
        $page = new \Think\Page($count,5);
        //设置按钮
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');

        //查询所有品牌
        $arr = $brands->where($map)
                      ->order('id desc')
                      ->limit($page->firstRow.','.$page->listRows)
                      ->getdata();
        //查询所有一级分类
        $res = $type->order('concat(path,id)')->select();
        // $res = $type->where('pid=0')->select();
        //显示分页按钮
        $btn = $page->show();   
        //分配数据
        $this->assign('list',$arr);
        $this->assign('btn',$btn);
        $this->assign('type',$res);
    	//显示页面
        $this->display();
    }

    /**
     * 添加品牌
     */
    public function add()
    {
    	if(IS_POST)
    	{
    		//实例化对象
    		$brands = D('GoodsBrands');

            //实例化上传类
            $up = new \Think\Upload();
            //定义上传路径根目录
            $up->rootPath = './web/Admin/Upload/'; 
            //定义上传路径子目录
            $up->subName  = './Brands/';
            //定义上传类型
            $up->exts = array('jpg', 'gif', 'png', 'jpeg');
            //接受返回值
            $res = $up->upload();
            //判断是否上传成功
            if(!$res)
            {
                $this->error($up->getError());
            }

            //获取随机生成的上传文件名
            $logo = $res['logo']['savename'];
            //将上传的文件名存进post
            $_POST['logo'] = $logo;
            //商品类型id
            $_POST['tid'] = I('post.tid');
            //获取所有post的数据并验证
    		$data = $brands->create();
            //判断验证是否正确
    		if($data)
    		{
                //验证通过
                //判断品牌名是否添加成功
    			if($brands->add($data))
    			{
                    //成功添加
    				$this->success('添加成功',U('index'));
    			}else
    			{
                    //添加失败
    				$this->error('添加失败，请重新添加');
    			}
    		}else
    		{
                //验证错误
    			$this->error($brands->getError());
    		}
    	}else
    	{
            //显示页面
        	$this->display();
    	}
    }

    /**
     * 删除品牌
     * @param  int $id 要删除的品牌id
     */
    public function del($id)
    {
        //实例化商品详情类
        $detail = M('GoodsDetail');
        //判断该品牌下是否有商品
        $arr = $detail->where('bid='.$id)->select();
        if($arr)
        {
            $this->error('请删除该品牌下的商品');
        }
        //实例化品牌类
        $brands = M('GoodsBrands');
        //删除该品牌类
        $row = $brands->delete($id);
        //判断是否删除成功
        if($row)
        {
            //删除成功
            $this->success('删除成功');
        }else
        {
            //删除失败
            $this->error('删除失败',U('index'));
        }
    }
}