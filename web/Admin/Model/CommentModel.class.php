<?php
namespace Admin\Model;
use Think\Model;

/**
 * Comment模型，用于处理繁琐的评论数据
 */
class CommentModel extends Model
{
    // 获取所有评论数据
    public function getData()
    {
        // 根据控制器那边的角色条件，找出该条件所有评论
        $arr = $this->select();

        // 处理评论状态的显示
        $status = [ 1=>'正常', 2=>'禁用'];

        // 把处理的数据放入数组
        foreach ($arr as $k=>$v) {
            $arr[$k]['status'] = $status[$v['status']];
            $arr[$k]['ctime'] = date('Y-m-d H:i:s', $v['ctime']);
        }
        
        // 把数组数据返回给控制器
        return $arr;
    }

    // 修改评论状态
    public function editData($id)
    {
        // 防入驻处理
        // 先在where那里用:id占位符，然后通过bind那里把$id的值绑定到where里面
        $bind[':id'] = $id;
        $where['id'] = ':id';
        // 修改评论状态为禁用
        $result = $this->where($where)->bind($bind)->save(['status'=>'1']);

        return true;
    }
}