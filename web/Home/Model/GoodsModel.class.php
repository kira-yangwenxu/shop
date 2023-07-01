<?php
namespace Home\Model;
use Think\Model;

/**
 * Goods模型
 */
class goodsModel extends Model 
{
    public function getAttrData($goodsId)
    {

    	$goodsDetail = M('GoodsDetail')->field('tid,bid,stock,attr')->where(['gid'=>$goodsId])->select();
    	//遍历获取属性
        foreach ($goodsDetail as $k => $v) {
            foreach (explode(',' ,$v['attr']) as $k => $v) {
                $tmp =  explode(':' ,$v);
                $res['attr'][$tmp[0]][] = $tmp[1];
            }
        }

        foreach ($res['attr'] as $k => $v) {
            $res['attr'][$k] = array_unique($res['attr'][$k]);
        }

        // foreach ($res['attr'] as $k => $v) {
        //     $res['default'][] = $k.':'.$value[0];
        // }

        // $res['default'] = join(',', $res['default']);

        return $res;
    }

    public function getDefaultData($gid, $arr)
    {
        //默认第一个属性值是默认值
        foreach ($arr as $k => $v) {
            foreach ($v as $key => $value) {
                $info[$key] = $value[0];
            }
        }

        foreach ($info as $k => $v) {
            $attr[] = $k.':'.$v;
        }

        $attr = join(',',$attr);

        $defaultData = M('GoodsDetail')->field('price,stock')->where(['gid'=>$gid],['attr'=>$attr]) ->find();

        return $defaultData;
        // $data = M('GoodsDetail')->field('price, stock')->where();
    }

    //
    /**
     * 获取AJAX选取不同属性的商品数据
     * @param  [string] $attr [商品属性的组合]
     * @param  [int] $gid  [商品ID]
     * @return [array]      [获取到的属性对应价格和库存]
     */
    public function getAjaxData($attr,$gid)
    {
        $defaultData = M('GoodsDetail')->field('id,price,stock')->where(['gid'=>$gid,'attr'=>$attr]) ->find();

        return $defaultData;
    }



    //获取列表页的商品数据
    public function getGoodsListData($data)
    {

        //实例化模型
        $goodsImagesModel = M('GoodsImages');
        $goodsDetailModel = M('GoodsDetail');

        foreach ($data as $key => $value) {
            //追加商品图片信息
                $data[$key]['path'] = $goodsImagesModel
                    ->where(['gid'=>$value['id']])
                    ->find()['path'];
            //追加商品价格信息
                $data[$key]['price'] = $goodsDetailModel
                    ->where(['gid'=>$value['id']])
                    ->find()['price'];

        }
        return $data;
    }
}