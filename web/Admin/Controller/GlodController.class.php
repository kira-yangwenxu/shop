<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;


/**
 * 积分控制器
 */
class GlodController extends CommonController
{

    /**
     * 显示主页
     */
    public function index()
    {

        if (IS_GET) {
            // 实例化Glod模型
            $glod = M('Glod');

            // 分页类
            $total = $glod->count();
           
            $p = new Page($total, 5);

            // 获取积分规则内容
            $result = $glod->limit($p->firstRow, $p->listRows)->select();

            // 分配数据
            $this->assign('list' ,$result);
            $this->assign('btn', $p->show());
            // 显示模板
            $this->display();

        } else {

            
        }
        
    }

    
}