<?php
namespace Admin\Model;
use Think\Model;

class GoodsModel extends Model
{
    //自动验证
    protected  $_validate = [
    	//判断商品名是否为空
        ['name','require','商品名不能为空'],
        //正则匹配商品名
        ['name','/^[\w\x{4e00}-\x{9fa5}]+$/u','请输入字母、数字、下划线或者中文的商品名'],
        //判断商品标题是否为空
        ['title','require','商品标题不能为空'],
        //正则匹配商品标题
        ['title','/^[\w\x{4e00}-\x{9fa5}]+$/u','请输入字母、数字、下划线或者中文的标题'],
        //判断商品描述是否为空
        ['des','require','描述不能为空'],
        //正则匹配商品描述
        // ['des','/^[\w\x{4e00}-\x{9fa5}]+$/u','请输入至少一位的字母、数字、下划线或者中文的描述'],
    ];

    //自动完成
    protected $_auto = [
        ['addtime','time',1,'function'],
    ];

    public function getdata()
    {
        $arr = $this->select();
        
        // 处理addtime字段
        foreach ($arr as $k => $v) {
            $arr[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
        }

        return $arr;
    }
}

