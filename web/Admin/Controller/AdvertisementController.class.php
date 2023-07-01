<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * 广告控制器
 */
class AdvertisementController extends CommonController 
{
	/**
	 * 显示广告列表页
	 */
	public function index()
	{
		//实例化大D方法
        $advertisement = D('Advertisement');
        //统计数据总条数
        $total = $advertisement->count();
        //实例化分页方法
        $page = new \Think\Page($total, 4);
        //显示分页
        $show = $page->show();
        //查询数据
        $arr = $advertisement->field(true)->limit($page->firstRow, $page->listRows)->select();
        // 赋值数据集
        $this->assign('list',$arr);
        //分配分页数据 
        $this->assign('page' ,$show);
        //显示主页面
        $this->display();
	}

	/**
	 * 显示广告添加表单页
	 */
	public function add()
	{
		if (IS_POST) {
            //实例化大D方法
            $advertisement = D('Advertisement');
            //调用Model层
            $data = $advertisement->create();
            //判断广告名字是否为空
            if (!$data['name']) {
                                                                                 
                $this->error($advertisement->getError());
            //判断广告连接 
            } else if(!$data['link']) {
                $this->error($advertisement->getError());
            }

            //实例化上传对象
            $up = new \Think\Upload();
            //定义上传路径根目录
            $up->rootPath = './web/Admin/Upload/'; 
            //定义上传路径子目录
            $up->subName  = './Advertisement/';
            //定义上传类型
            $up->exts = array('jpg', 'gif', 'png', 'jpeg');
                  
            //判断文件是否上传成功
            if ($info = $up->upload()) {
                //获取上传照片名存入POST
                $_POST['pic'] = $info['pic']['savename'];
                //插入数据库  
                 // dump($advertisement->_sql());
                $row = $advertisement->add(I('post.'));
                //判断row是否存在
                if ($row) {
                    //存在则成功
                    $this->success('添加成功', U('advertisement/index'));
                } else {
                    //否则失败
                    $this->error('添加失败');
                }
                       
            } else {
               //上传失败
              $this->error($up->getError());
            }
                
        } else {
            //显示页面
             $this->display();
        }

	}

    /**
     * AJAX删除
     * @return 返回受影响行数
     */
    public function del()
    {

       if(IS_AJAX){

            //拼接路径
            $path = './web/Admin/Upload/Advertisement/'.I('get.pic');
            //存入id
            $id = I('get.id');
            //实例化大D方法
            $advertisement = D('Advertisement');
            //将ID传去M层
            $res = $advertisement->doDel($id);
            //判断受影响行数
            if ($res) {
                //删除文件
                unlink($path);
                //响应前台并传输数据
                $this->ajaxReturn($res);
            }
        }   
    }
}
