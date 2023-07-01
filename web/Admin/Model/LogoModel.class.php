<?php
namespace Admin\Model;
use Think\Model;

/**
 * Logo模型，用于处理Logo的数据
 */
class LogoModel extends Model 
{

    /**
     * 获取所有logo数据
     */
    public function getData()
    {
        // 获取所有logo
        $arr = $this->select();

        // 处理logo状态的数据
        $status = [ 1=>'正常', 2=>'禁用'];

        // 把处理的数据放入数组
        foreach ($arr as $k=>$v) {
            $arr[$k]['status'] = $status[$v['status']];
        }

        // 把处理好的数据返回给控制器
        return $arr;
    }


    // 修改Logo状态
    public function editData($id, $status)
    {
        // 如果是Logo状态
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
            // 修改Logo状态为启用
            $result = $this->where($where)->bind($bind)->save(['status'=>'1']);

            return true;

        }
    }
}