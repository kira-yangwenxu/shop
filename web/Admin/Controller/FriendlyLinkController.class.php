<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
/**
 * 友情链接控制器 
 */
class FriendlyLinkController extends CommonController
{	
    /**
     * 显示友情连接列表
     */
	public function index()
	{    
        //实例化大D方法
        $FL = D('FriendlyLink');
        //统计数据总条数
        $total = $FL->count();
        //实例化分页方法
        $page = new \Think\Page($total, 2);
        //显示分页
        $show = $page->show();
        //设定需要查询的数据并传到M层处理 
        $arr = $FL->field(true)->limit($page->firstRow, $page->listRows)->getdata();
        //分配友情链接列表页数据
        $this->assign('list' ,$arr);
        //分配分页数据 
        $this->assign('page' ,$show);
        //显示主页面
        $this->display();
        
	}

    /**
     * 添加友情连接
     */
    public function add()
    {
        if (IS_POST) {
            //实例化大D方法
            $FriendlyLink = D('FriendlyLink');
            //调用Model层
            $data = $FriendlyLink->create();
            //判断友情连接名字
            if (!$data['name']) {
                                                                                 
                $this->error($FriendlyLink->getError());
            //判断友情连接  
            } else if(!$data['link']) {
                $this->error($FriendlyLink->getError());
            }

            //实例化上传对象
            $up = new \Think\Upload();
            //定义上传路径根目录
            $up->rootPath = './web/Admin/Upload/'; 
            //定义上传路径子目录
            $up->subName  = './FriendlyLink/';
            //定义上传类型
            $up->exts = array('jpg', 'gif', 'png', 'jpeg');
                  
            //判断文件是否上传成功
            if ($info = $up->upload()) {
                //获取上传照片名存入POST
                $_POST['pic'] = $info['pic']['savename'];
                //插入数据库  
                $row = $FriendlyLink->add(I('post.'));
                //判断row是否存在
                if ($row) {
                    //存在则成功
                    $this->success('添加成功', U('FriendlyLink/index'));
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
     * 点击改变状态
     * @param  int $id 要改变状态的用户id
     */
    public function status($id)
    {
        if(IS_AJAX){
            //获取存入ID
            $id = I('get.id');
            //实例化大D方法
            $FL = D('FriendlyLink');
            //查询数据获取ID
            $info = $FL->find($id);
            //判断当前需要设定状态
            $info['status'] == 1 ? $info['status'] = 2 :$info['status'] = 1;
            //修改数据
            $res = ($FL->save($info));
            if ($res) {
            $this->ajaxReturn($res);
            }
            $this->redirect('index');
            
        }
    }

    /**
     * AJAX删除友情连接
     * @return 受影响行数
     */
    public function del()
    {
        
        //拼接友情链接图片路径名
        $path = './web/Admin/Upload/FriendlyLink/'.I('get.pic');
        //获取ID
        $id = I('get.id');
        //实例化大D方法
        $fl = D('FriendlyLink');
        //将$id传去M层处理
        $del = $fl->doDel($id); 
        if($del){
            //删除文件
            unlink($path);
            $this->redirect('index');
        }
    }


}