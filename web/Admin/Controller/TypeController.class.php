<?php
namespace Admin\Controller;
use Think\Controller;

class TypeController extends CommonController 
{
    /**
     * 显示分类列表
     */
    public function index()
    {
    	//实例化分类对象
		$type = D('Type');
		//查询所有分类表数据
		$arr = $type->order('concat(path,id)')->select();
		//分配数据
        $this->assign('list',$arr);
		//显示页面
        $this->display();
    }

    /**
     * 添加分类
     */
    public function add()
    {
    	if(IS_POST){
    		//实例化分类对象
    		$type = D('Type');
            //默认获取post传来的值
    		$data = $type->create();
            //判断分类名是否为空
    		if($data['name'])
    		{
    			//判断是否添加分类成功
    			if($type->add($data))
    			{
    				//添加成功
    				$this->success('添加成功!', U('index'));
    			}else
    			{
    				//添加失败
    				$this->error('添加失败，请重新添加!');
    			}
    		}else
    		{
    			//分类名为false，报错
    			$this->error($type->getError());
    		}
    	}else
    	{
			//如果得到分类id，就是添加子类，如果没有得到分类id，就是添加顶级分类
			$id = I('get.id');
			//如果得到分类id
			if($id)
			{
    			//实例化分类对象
    			$type = D('Type');				
				//找到子类的信息
				$info = $type->find($id);
				//分配数据
				$this->assign('type',$info);
				//如果找不到对应id的子类信息
				if(empty($info))
				{
					//手贱用户
					$this->error('非法访问');
				}
			}
    		$this->display();
    	}
    }

    /**
     * 删除分类
     * @param  [int] $id [要删除分类的id]
     */
    public function del($id)
    {
        // 实例化分类对象
        $type = M('Type');
        //查询该分类下的子类
        $subclass = $type->where('pid='.$id)->select();
        //判断分类下是否有子类
        if($subclass)
        {   
            $this->error('请删除该分类下的子类');
        }   
        //实例化商品详情对象
        $detail = M('GoodsDetail');
        //查询该分类下的商品详情
        $shop = $detail->where('tid='.$id)->select();
        //如果该分类下存在商品详情
        if($shop)
        {
            $this->error('请删除该分类下的商品');
        }
        //删除分类 
        $row = $type->delete($id);
        if($row){
            $this->success('删除成功',U('index'));
        }else{
            $this->error('删除失败');
        }
    }
}