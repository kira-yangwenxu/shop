<?php
namespace Admin\Model;
use Think\Model;

/**
 * User模型，用于处理繁琐的用户数据
 */
class UserModel extends Model {

    // 获取所有用户数据
    public function getData()
    {
        // 根据控制器那边的角色条件，找出该条件所有用户
        $arr = $this->select();

        // 处理性别的显示
        $sex = [ 1=>'男', 2=>'女', 3=>'保密'];

        // 处理用户角色的显示
        $role = [ 1=>'普通用户', 2=>'vip', 3=>'钻石用户'];

        // 处理用户状态的显示
        $status = [ 1=>'正常', 2=>'禁用'];
        // 把处理的数据放入数组
        foreach ($arr as $k=>$v) {
            $arr[$k]['sex'] = $sex[$v['sex']];
            $arr[$k]['role'] = $role[$v['role']];
            $arr[$k]['status'] = $status[$v['status']];
            $arr[$k]['addtime'] = date('Y-m-d H:i:s', $v['addtime']);
        }

        // 把数组数据返回给控制器
        return $arr;
    }

    // 修改用户状态
    public function editData($id, $status)
    {
        // 如果是正常状态
        if ($status == '正常') {
            // 防入驻处理
            // 先在where那里用:id占位符，然后通过bind那里把$id的值绑定到where里面
            $bind[':id'] = $id;
            $where['id'] = ':id';
            // 修改用户状态为禁用
            $result = $this->where($where)->bind($bind)->save(['status'=>'2']);

            return true;

        } else {
            $bind[':id'] = $id;
            $where['id'] = ':id';
            // 修改用户状态为启用
            $result = $this->where($where)->bind($bind)->save(['status'=>'1']);

            return true;

        }
    }
}