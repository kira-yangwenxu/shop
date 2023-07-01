<?php
namespace Admin\Model;
use Think\Model;

class GoodsBrandsModel extends Model
{
    //自动验证
    protected  $_validate = [
    	//判断品牌名是否为空
        ['brandname','require','品牌名不能为空'],
        //正则匹配品牌名
        // ['brandname','/^[\w\x{4e00}-\x{9fa5}]{1,18}$/u','请输入1~18位的数字、字母、下划线或者中文的品牌名'],
    ];

    public function getdata()
    {
    	//查询出的品牌表的字段
    	$arr = $this->select();
    	//实例化分类对象
    	$type = M('Type'); 
    	//查询分类表的tid,name字段
		$info = $type->Field('id,name')->select();
		$info = array_column($info,'name','id');
		// 处理tid字段
		foreach ($arr as $k => $v) {
			$arr[$k]['tid'] = $info[$v['tid']];
		}
		return $arr;
    }
}