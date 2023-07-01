<?php
namespace Admin\Model;
use Think\Model;

/**
 * 商品详情数据处理层
 */
class GoodsDetailModel extends Model
{
	/**
	 * 自动验证
	 */
	protected $_validate = [
        //判断商品类型是否为空
        ['tid','require','类型不能为空'],
        //判断商品品牌是否为空
        ['bid','require','品牌不能为空'],
        //判断商品属性是否为空
        ['attr','require','商品属性不能为空'],
	];


    public function getdata()
    {
        $arr = $this->select();

        //实例化分类、品牌和图片对象
        $type = M('Type');
        $brands = M('GoodsBrands');

        // 处理tid字段
        $info = $type->Field('id,name')->select();
        $info = array_column($info,'name','id');
        foreach ($arr as $k => $v) {
            $arr[$k]['tid'] = $info[$v['tid']];
        }

        // 处理bid字段
        $res = $brands->Field('id,brandname')->select();
        $res = array_column($res,'brandname','id');
        foreach ($arr as $k => $v) {
            $arr[$k]['bid'] = $res[$v['bid']];
        }

        // 处理status字段
        $status = ['1'=>'新添加','在售中','已下架'];
        foreach ($arr as $k => $v) {
            $arr[$k]['status'] = $status[$v['status']];
        }

        // 处理addtime字段
        foreach ($arr as $k => $v) {
            $arr[$k]['addtime'] = date('Y-m-d H:i:s',$v['addtime']);
        }

        
        return $arr;
    }

}