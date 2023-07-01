<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

/**
 * 评论控制器
 */
class CommentController extends CommonController
{

    /**
     * 显示评论主页
     */
    public function index()
    {
        // 实例化Comment模型
        $comment = D('Comment');

        //处理搜索
        if (strlen(trim(I('text'))) > 0) {
            $search['ctext'] = ['like', '%'.I('text').'%'];
        }

        $search['status'] = 1;

        // 分页类
        $total = $comment->where($search)->count();
       
        $p = new Page($total, 5);
        
        // 查出对应搜索条件的评论，并在后台CommentModel处理好响应数据，如果没有搜索条件则是搜索正常状态的评论
        $arr = $comment->limit($p->firstRow, $p->listRows)->where($search)->order('id desc')->getData();

        // 分配数据
        $this->assign('list', $arr);
        $this->assign('btn', $p->show());

        $this->display();
    }

    /**
     * 显示恢复评论主页
     */
    public function recovery()
    {
        // 实例化Comment模型
        $comment = D('Comment');

        //处理搜索
        if (strlen(trim(I('text'))) > 0) {
            $search['ctext'] = ['like', '%'.I('text').'%'];
        }

        $search['status'] = 2;

        // 分页类
        $total = $comment->where($search)->count();
       
        $p = new Page($total, 5);
        
        $arr = $comment->limit($p->firstRow, $p->listRows)->where($search)->order('id desc')->getData();

        // 分配数据
        $this->assign('list', $arr);
        $this->assign('btn', $p->show());

        $this->display();
    }

    /**
     * 恢复用户删除的评论
     * @param  int $id 评论id
     */
    public function edit($id)
    {
        // 判断是否通过get的请求
        if (IS_GET) {
            
            // 实例化User模型
            $comment = D('Comment');
            // 把状态和id传到User模型去修改状态
            $edit = $comment->editData(I('get.id'));

            if ($edit) {

                 $this->success('修改成功');
            }
            
        }
    }
}