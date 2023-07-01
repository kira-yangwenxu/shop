<?php
namespace Admin\Model;
use Think\Model;


/**
 * 广告Model层
 */
class AdvertisementModel extends Model
{
	protected $_validate = [
		
		['name', 'require','请输入广告名'],
		['link', 'require','请输入广告连接地址'],
		


	];

	public function doDel($id)
	{
		//执行删除
        $arr = $this->where("id={$id}")->delete();
        //返回数据给C层
        return $arr;
        
	}
}