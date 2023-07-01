<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;

/**
 * 促销控制器
 */
class OnsaleController extends CommonController 
{
    /**
     * 显示促销列表页
     */
    public function index()
    {
        $onsale = M('onsale');
        //处理搜索
        if (strlen(trim(I('text'))) > 0) {
            $search['gid'] = ['like', '%'.I('text').'%'];
        }
        
        
        // 分页类
        $total = $onsale->where($search)->count();
       
        $p = new Page($total, 5);
        $info = $onsale->limit($p->firstRow, $p->listRows)->where($search)->select();
        $this->assign('list', $info);
        $this->assign('btn', $p->show());
        $this->display();
    }

    public function add()
    {
       if (IS_AJAX) {
            // 获取传过来的pid
            $tid = $_GET['tid'];
            //实例化品牌对象
            $goods = M('goods_detail');
            // /查询pid下的所有品牌
            $arr = $goods->where(['tid'=>$tid])->field('id,name')->select();
            
            //返回pid下的所有品牌数据
            $this->ajaxReturn($arr); 
       }else
       {
            //实例化对象
            $type = M('Type');
            //查询所有分类
            $arr = $type->field(true)->order('concat(path,id)')->select();
            //分配数据
            $this->assign('type',$arr);
            $this->display();

       }

        

       
    }

    public function tradd()
    {
        if (IS_POST) {
            $id = $_POST['gid'];
            $reduce = $_POST['reduce'];
            $goods = M('goods');
            $detail = M('goods_detail');
            $onsale = M('onsale');
            $detailid = $detail->where('id='.$id)->select();
            $gid = $detailid[0]['gid'];
            $good = $goods->where('id='.$gid)->select();
            $onsaleshop = $good[0];
            $data['gid'] = $gid;
            $data['reprice'] = $reduce;
            $insert = $onsale->data($data)->add();
            if ($insert) {
                $this->success('添加成功',U('Onsale/index'));
            } else {
                $this->error('添加失败');
            }
       }
    }

    public function del($id)
    {
        if (IS_GET) {
            $id = $_GET['id'];
            $onsale = M('onsale');
            $del = $onsale->where('id='.$id)->delete();
            if ($del) {
                $this->success('删除成功');
            } else {
                $this->error('删除失败');
            }
        }
    }

    public function edit($id)
    {
        if (IS_POST) {
            $id = $_POST['id'];
            $reduce = $_POST['reprice'];
            $onsale = M('onsale');
            $upd = $onsale->where('id='.$id)->save(['reprice'=>$reduce]);
            if ($upd) {
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
        }
    }

    public function ajaxs()
    {
        if (IS_AJAX) {
            $id = $_GET['id'];
            $good = M('goods_detail');
            $goods = $good->where('bid='.$id)->select();
            $this->ajaxReturn($goods);
        }
    }
}
