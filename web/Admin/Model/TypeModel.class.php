<?php
namespace Admin\Model;
use Think\Model;

class TypeModel extends Model
{
    //自动验证
    protected  $_validate = [
    	//判断验证名是否为空
        ['name','require','分类名不能为空'],
        //正则匹配分类名
        ['name','/^[\w\x{4e00}-\x{9fa5}]{1,18}$/u','请输入1~18位的字母、数字、下划线或者中文'],
    ];
}