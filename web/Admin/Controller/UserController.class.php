<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

/**
 * 用户控制器
 */
class UserController extends CommonController 
{

    /**
     * 显示普通用户列表
     */
    public function user()
    {
        
        // 实例化User模型
        $user = D('User');

        //处理搜索
        if (strlen(trim(I('username'))) > 0) {
            $search['username'] = ['like', '%'.I('username').'%'];
        }
        if (strlen(trim(I('sex'))) > 0) {
            $search['sex'] = I('sex');
        }

        // 查找普通用户条件
        $search['role'] = 1;

        // 分页类
        $total = $user->where($search)->count();
       
        $p = new Page($total, 5);

        // 查出对应搜索条件的普通用户，并在后台UserModel处理好响应数据，如果没有搜索条件则是搜索所有普通用户
        $arr = $user->limit($p->firstRow, $p->listRows)->where($search)->order('id desc')->getData();
        
        // 分配数据
        $this->assign('list', $arr);
        $this->assign('btn', $p->show());

        // 显示普通用户的模板
        $this->display();
    }

    /**
     * 显示vip用户列表
     */
    public function vip()
    {
        // 实例化User模型
        $user = D('User');

        //处理搜索
        if (strlen(trim(I('username'))) > 0) {
            $search['username'] = ['like', '%'.I('username').'%'];
        }
        if (strlen(trim(I('sex'))) > 0) {
            $search['sex'] = I('sex');
        }

        // 查找vip用户条件
        $search['role'] = 2;

        // 分页类
        $total = $user->where($search)->count();
        $p = new Page($total, 5);

        // 查出对应搜索条件的vip用户，并在后台UserModel处理好响应数据，如果没有搜索条件则是搜索所有vip用户
        $arr = $user->limit($p->firstRow, $p->listRows)->where($search)->order('id desc')->getData();
        
        // 分配数据
        $this->assign('list', $arr);
        $this->assign('btn', $p->show());

        // 显示普通用户的模板
        $this->display();
    }

    public function diamond()
    {
        // 实例化User模型
        $user = D('User');

        //处理搜索
        if (strlen(trim(I('username'))) > 0) {
            $search['username'] = ['like', '%'.I('username').'%'];
        }
        if (strlen(trim(I('sex'))) > 0) {
            $search['sex'] = I('sex');
        }

        // 查找钻石用户条件
        $search['role'] = 3;

        // 分页类
        $total = $user->where($search)->count();
        $p = new Page($total, 5);

        // 查出对应搜索条件的钻石用户，并在后台UserModel处理好响应数据，如果没有搜索条件则是搜索所有钻石用户
        $arr = $user->limit($p->firstRow, $p->listRows)->where($search)->order('id desc')->getData();
        
        // 分配数据
        $this->assign('list', $arr);
        $this->assign('btn', $p->show());

        // 显示普通用户的模板
        $this->display();
    }

    
    /**
     * 修改用户状态的方法
     * @param  int $id     用户id
     * @param  string $status 用户状态
     */
    public function edit($id, $status)
    {
        // 判断是否通过get的请求
        if (IS_GET) {
            
            // 实例化User模型
            $user = D('User');
            // 把状态和id传到User模型去修改状态
            $edit = $user->editData(I('get.id'), I('get.status'));

            if ($edit) {
                 $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
            
        }
    }

}