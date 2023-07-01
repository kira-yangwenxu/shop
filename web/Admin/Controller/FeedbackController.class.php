<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
/**
 * 用户反馈信息控制器 
 */
class FeedbackController extends CommonController
{	
    /**
     * 显示用户反馈信息列表
     */
	public function index()
	{
		//实例化大D方法
        $fb = D('Feedback');
        //搜索
        if (null != I('get.uid')) {
			$search['uid'] = ['like', '%'.I('uid').'%'];
		}

		if (null != I('get.type')) {
			$search['type'] = ['eq',I('type')];
		}
		//统计数据
		$count = $fb->where($search)->count();
		//实例化分页方法
		$page = new \Think\Page($count, 4);
		//显示分页
		$btn = $page->show();
		//查询数据库
        $arr = $fb->field('shop_feedback.content, shop_feedback.type, shop_user.username, shop_feedback.uid, shop_feedback.id , shop_feedback.status')
                  ->join('left join shop_user on shop_feedback.uid = shop_user.id' )
        		  ->limit($page->firstRow, $page->listRows)
                  ->where($search)
                  ->getdata();
        //判断是否为AJAX发起请求          
        if (IS_AJAX) {
        	//把数据存入$data
        	$data = $arr;
        	// dump($data);exit;
        	// 将存入page下标下
        	$data['page'] = $btn;
        	//响应前台并传输数据
        	$this->ajaxReturn($data);
        	exit;
        }
        //分配数据
        $this->assign('list',$arr); 
        //分配分页数据  	
        $this->assign('page', $btn);
        $this->display();
        
	}

	/**
	 * 用户信息删除
	 * @return  受影响行数
	 */
	public function del() 
	{
		//存入id
		$id = I('get.id');
		//实例化大D方法
		$fl = D('Feedback');
		//将ID传去M层
		$res = $fl->doDel($id);
		//响应前台并传输数据
		$this->ajaxReturn($res);
			
		
	}

	/**
	 * 用户状态修改
	 * @return  受影响行数
	 */
	public function status()
	{
		if(IS_AJAX){
            //获取存入ID
            $id = I('get.id');
            //实例化大D方法
            $FB = D('Feedback');
            //查询数据获取ID
            $info = $FB->find($id);
            //判断当前需要设定状态
            if ($info['status'] == 1) {
            	$info ['status'] = 2;
            	//修改数据
            	$res = ($FB->save($info));

            }
            $this->ajaxReturn($res);
            
            $this->redirect('index');
            
        }
	}
  
}