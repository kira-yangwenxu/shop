<?php
namespace Admin\Model;
use Think\Model;


class FeedbackModel extends Model
{
    /**
     * getdata 处理index方法数据
     * @return array
     */
    public function getData()
    {   
        //查询数据
        $arr = $this->select();
        //定义类型
        $type = [1 => '建议' , 2 => '投诉'];
        //遍历及修改数据
        foreach($arr as $k => $v) {
            $arr[$k]['type'] = $type[$v['type']];

        }
        //返回数据给C层
        return $arr;
            
    }

    /**
     * 处理del方法数据
     * @param  $Id  int
     * @return 受影响行数
     */
    public function doDel($id)
    {   
        
        //执行删除
        $arr = $this->where("id={$id}")->delete();
        //返回数据给C层
        return $arr;
        
    }

}