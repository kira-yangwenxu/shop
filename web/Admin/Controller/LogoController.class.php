<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
use Think\Page;

/**
 * Logo控制器
 */
class LogoController extends CommonController 
{
    /**
     * 显示Logo主页
     */
    public function index()
    {
        if (IS_GET) {
            // 实例化Logo模型
            $logo = D('Logo');

            // 分页类
            $total = $logo->count();
           
            $p = new Page($total, 2);

            // 获取Logo模型处理好的数据
            $arr = $logo->limit($p->firstRow, $p->listRows)->order('id desc')->getData();

            // 分配数据
            $this->assign('list', $arr);
            $this->assign('btn', $p->show());
            
            // 显示模板
            $this->display();

        } else {

            // 实例化上传类
            $upload = new Upload();

            // 文件上传配置
            // 保存路径
            $upload->rootPath = './web/Admin/Upload/';
            $upload->subName = './Logo/';

            // 上传文件类型
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg');

            // 上传文件
            $info = $upload->upload();

            if (!$info) {

                // 上传错误信息
                $this->error($upload->getError());
            } else {

                // 获取图片的数据
                $pic = $info['pic'];
                
                // 获取图片名
                $name = $pic['savename'];


                // 实例化Logo模型
                $result = M('Logo');

                // 添加该图片信息到数据库
                $res = $result->add(array('pic'=>$name));
                
                // 文件上传成功
                $this->success('文件上传成功', U('Logo/index'));
            }
        }
    }

    /**
     * 修改Logo状态的方法
     * @param  int $id     Logoid
     * @param  string $status Logo状态
     */
    public function edit($id, $status)
    {
        // 判断是否通过get的请求
        if (IS_GET) {
            
            // 实例化User模型
            $user = D('Logo');
            // 把状态和id传到Logo模型去修改状态
            $edit = $user->editData(I('get.id'), I('get.status'));

            if ($edit) {
                 $this->success('修改成功');
            }
            
        }
    }


    public function del($id, $pic)
    {
        // 判断是否通过get的请求
        if (IS_GET) {

            // 实例化User模型
            $user = D('Logo');

            // 根据ID删除数据
            $del = $user->where(array('id'=>$id))->delete();

            // 拼接路径
            $path = './web/Admin/Upload/Logo/'.$pic;

            if ($del) {

                // 删除图片
                unlink($path);

                $this->success('删除成功');

            } else {

                $this->error('删除失败');
            }
        }
    }
}