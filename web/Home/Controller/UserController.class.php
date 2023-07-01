<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload;
use Think\Storage\Driver;
use Think\Page;

class UserController extends Controller {

    // 显示用户订单
    public function myOrder(){
        if (IS_GET) {
            if (!$_SESSION['homeInfo']['id']) {
                $this->error('请先登录',U('Login/index'));
            }
            $id = $_SESSION['homeInfo']['id'];
            $order = M('orders');
            $orderdetail = M('orders_detail');
            $goodsdetail = M('goods_detail');
            $oid = $order->where('uid='.$id)->getField('id',true);
            // 用户所有订单
            $orders = $order->where('uid='.$id)->select();
            foreach ($oid as $k => $v) {
                // 所有订单详情
                $orderdetails[] = $orderdetail->where('oid='.$v)->select();
                
            }
            foreach ($oid as $k => $v) {
                // 获取商品详情id
                $detailid[] = $orderdetail->where('oid='.$v)->getField('did',true);
                
            }

            foreach ($detailid as $k1 => $v1) {
                foreach ($v1 as $key => $value) {
                    // 获取到商品详情名
                    $goodsdetailname[] = $goodsdetail->where('id='.$value)->getField('name',true);
                    $goodsdetailgid[] = $goodsdetail->where('id='.$value)->getField('gid',true);
                }
                
            }

            // 把数组转为二维数组
            foreach ($orderdetails as $key => $value) {
                foreach ($value as $k1 => $v1) {
                    // $v1['name'] = $goodsdetailname[$k1];
                    // $v1['gid'] = $goodsdetailgid[$k1];
                    $drr[] = $v1;
                    

                }
            }

            // 循环加入数据
            foreach ($drr as $key => $value) {
                $value['name'] = $goodsdetailname[$key];
                $value['gid'] = $goodsdetailgid[$key];
                $arr[] = $value;
            }
            
            $this->assign('orderdetail', $arr);
            $this->assign('order', $orders);
            $this->display();
        }
        
    }

    // ajax全国三级联动
    public function addAddress()
    {
        if (IS_GET) {
            $area = M('areas');
            // 找出全国的省级
            $result = $area->where('parent_id = 1')->select();
            $this->assign('list', $result);
            $this->display();
            
        }
        if (IS_POST) {

            // 获取用户id
            $id = $_POST['id'];
            $address = M('areas');
            $useraddr = M('user_addr');
            $count = $useraddr->where('uid='.$id)->count();
            if ($count == 5) {
                $this->error('收货地址已超过5个，已不能再去添加');
            }

            // 获取省级id
            $provinces = $_POST['provinces'];
            // 获取市级id
            $city = $_POST['city'];
            // 获取县级id
            $area = $_POST['area'];
            // 获取详细住址
            $detail = $_POST['detail'];
            // 获取手机
            $phone = $_POST['phone'];
            // 获取收件人
            $name = $_POST['name'];
            if (empty($provinces)) {
                 $this->error('无效地址');
            }
            // 获取省份
            $provincesname = $address->where('id='.$provinces)->getField('area_name');
            // 获取城市
            $cityname = $address->where('id='.$city)->getField('area_name');
            // 获取县区
            $areaname = $address->where('id='.$area)->getField('area_name');
            // 拼接完整的详细地址
            $detailaddress = $provincesname.','.$cityname.','.$areaname.','.$detail;
            // 存入用户id
            $data['uid'] = $id;
            // 存入完整详细地址
            $data['addr'] = $detailaddress;
            // 存入收货人
            $data['user'] = $name;
            // 存入手机号码
            $data['phone'] = $phone;
            // 存入省份
            $data['provinces'] = $provincesname;
            // 存入城市
            $data['city'] = $cityname;
            // 存入县区
            $data['area'] = $areaname;
            // 存入详细地址
            $data['detail'] = $detail;
            $useraddrinfo = $useraddr->data($data)->add();
            
            if ($useraddrinfo) {
                $this->success('地址添加成功');
            } else {
                $this->error('地址添加失败');
            }
        }
        
    }

    // 地址三级联动
    public function ajaxAddress()
    {
        if (IS_AJAX) {
            // 获取地方id
            $id = $_GET['id'];
            $address = M('areas');
            // 查找该地方下的所属地方
            $areas = $address->where('parent_id='.$id)->select();
            // ajax返回
            $this->ajaxReturn($areas);
        }
    }

    // 修改头像的主页
    public function pic()
    {
        $this->display();
    }

    // 地址主页
    public function myAddress()
    {
        // 获取用户id
        $id = $_SESSION['homeInfo']['id'];
        // 实例化用户地址数据库
        $address = M('user_addr');
        // 查出该用户的所有地址
        $useraddr = $address->where('uid='.$id)->select();
        $this->assign('list', $useraddr);
        $this->display();
    }


    // 显示用户评论
    public function myAssess()
    {
        if (IS_GET) {
            // 获取用户id
            $uid = $_SESSION['homeInfo']['id'];
            $comment = M('comment');
            $image = M('goods_images');
            $good = M('goods');

            
            // 找出该用户有效状态的评论的商品id
            $comments = $comment->where(['uid'=>$uid,'status'=>1])->field('gid')->select();

            // 获取找出该用户有效状态的评论的id
            $comments2 = array_column($comment->where(['uid'=>$uid,'status'=>1])->field('id')->select(), 'id');

            // 获取评论商品id
            $cid = array_column($comment->limit($p->firstRow, $p->listRows)->where(['uid'=>$uid,'status'=>1])->field('gid')->select(), 'gid');
            // 获取评论id
            $ccid = array_column($comment->limit($p->firstRow, $p->listRows)->where(['uid'=>$uid,'status'=>1])->field('id')->select(), 'id');
            // 循环查找数据并循环加入数据
            foreach ($cid as $k => $v) {
                $data[$k]['path'] = $image->where(['gid'=>$v])->find();
                $data[$k]['info'] = $good->where(['id'=>$v])->find();
                
                $data[$k]['cid'] = $ccid[$k];
            }

            // 循环查找数据并循坏加入数据
            foreach ($comments2 as $k => $v) {
                $data[$k]['comment'] = $comment->where(['id'=>$v])->find();
                $data[$k]['comment']['ctime'] = date('Y-m-d H:i:s', $data[$k]['comment']['ctime']);
            }
            
            $this->assign('list', $data);
            
            
            $this->display();
        }
    }

    // 删除评论
    public function delComment()
    {
        if (IS_AJAX) {
            // 获取评论id
            $id = $_GET['cid'];
            $collection = M('comment');
            // 执行删除
            $del = $collection->where('id='.$id)->save(['status'=>2]);
            if ($del) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn(2);
            }
        }
    }


    // 收藏主页
    public function myCollection()
    {
        if (IS_GET) {
            if (!$_SESSION['homeInfo']['id']) {
                $this->error('请先登录',U('Login/index'));
            }
            // 获取用户id
            $id = $_SESSION['homeInfo']['id'];
            $collection = M('collection');
            $image = M('goods_images');
            $good = M('goods');

            // 分页类
            $total = $collection->where('uid='.$id)->count();
            $p = new Page($total, 5);

            // 查出该用户所有的收藏商品
            $collections = $collection->limit($p->firstRow, $p->listRows)->where('uid='.$id)->select();
            // 获取收藏商品的相关信息
            $cid = array_column($collection->limit($p->firstRow, $p->listRows)->where('uid='.$id)->field('gid')->select(), 'gid');
            $ccid = array_column($collection->limit($p->firstRow, $p->listRows)->where('uid='.$id)->field('id')->select(), 'id');
            foreach ($cid as $k => $v) {
                $data[$k]['path'] = $image->where(['gid'=>$v])->find();
                $data[$k]['info'] = $good->where(['id'=>$v])->find();
                $data[$k]['cid'] = $ccid[$k];

            }
            ;
            $this->assign('list', $data);
            $this->assign('btn', $p->show());
            
            $this->display();
        }
    }

    // 删除收藏
    public function delCollection()
    {
        if (IS_AJAX) {
            // 获取收藏id
            $id = $_GET['cid'];
            $collection = M('collection');
            // 执行删除
            $del = $collection->where('id='.$id)->delete();
            if ($del) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn(2);
            }
        }
    }

    // 显示用户反馈
    public function feedBack()
    {
        // 用户id
        $id = $_SESSION['homeInfo']['id'];
        $feedBack = M('feedback');
        // 查出用户的反馈
        $feedBacks = $feedBack->where('uid='.$id)->select();

        $this->assign('list', $feedBacks);
        $this->display();
    }


    // 添加用户反馈
    public function addFeedback()
    {
        if (IS_GET) {
            // 显示用户
            $this->display();
        }

        if (IS_POST) {
            // 获取类型
            $type = $_POST['type'];
            // 获取内容
            $content = $_POST['content'];
            // 用户id
            $id = $_SESSION['homeInfo']['id'];
            $feedback = M('feedback');
            $data['type'] = $type;
            $data['content'] = $content;
            $data['uid'] = $id;
            // 执行添加
            $insert = $feedback->data($data)->add();
            $this->success('反馈成功');
        }
    }

    // 用户订单详情
    public function myOrderInfo()
    {
        // 获取订单id
        $oid = $_GET['oid'];
        $good = M('goods_detail');
        $order = M('orders');
        $detail = M('orders_detail');
        // 找到该订单
        $orderinfo = $order->where('id='.$oid)->select();
        // 找出该订单的所有商品
        $orderdetail = $detail->where('oid='.$oid)->select();
        // 获取该订单所有详情商品id
        $orderdetailid = $detail->where('oid='.$oid)->field('did')->select();
        foreach ($orderdetailid as $key => $value) {
            foreach ($value as $k1 => $v1) {
                // 找出详情商品名
                $gname[] = $good->where('id='.$v1)->field('name')->select();
            }
        }
        foreach ($gname as $key => $value) {
            // 把商品名写入数组
            foreach ($value as $k1 => $v1) {
                $orderdetail[$key]['name'] = $v1;
            }
        }
        
        $this->assign('order', $orderinfo);
        $this->assign('detail', $orderdetail);
        $this->display();
    }

    // 个人账号安全
    public function myUser()
    {
        $this->display();
    }

    public function request()
    {
        $this->display();
    }

    public function retreat()
    {
        $this->display();
    }

    public function retreatCheck()
    {
        $this->display();
    }

    // 个人中心ajax请求修改密码
    public function ajaxPass()
    {
        // 判断是否ajax请求
        if (IS_AJAX) {
            // 如果密码为空
            if (empty($_GET['pwd'])) {
                $this->ajaxReturn('请输入密码');
                exit;
            }
            // 获取密码和id
            $pwd = $_GET['pwd'];
            $id = $_GET['id'];
            // hash加密密文
            $hash = password_hash($pwd, PASSWORD_DEFAULT);
            // 实例化user模型
            $user = M('user');
            $upd = $user->where('id='.$id)->save(['pwd'=>$hash]);
            if ($upd) {
                // 修改成功返回1
                $this->ajaxReturn('1');
            } else {
                // 修改失败返回2
                $this->ajaxReturn('2');
            }

        }
    }

    // 文件上传的方法
    public function upload()
    {
        // 获取用户id
        $id = $_POST['id'];

        // 实例化上传类
        $upload = new Upload();

        // 文件上传配置
        // 保存路径
        $upload->rootPath = './Public/home/img/';
        $upload->subName = './user/';

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


            // 实例化user模型
            $user = M('user');
            $userinfo = $user->where('id='.$id)->select();
            $userpic = $userinfo[0]['pic'];
            $file = './Public/home/img/user/'.$userpic;
            unlink($file);
            $data['pic'] = $name;
            // 添加该图片信息到数据库
            $res = $user->where('id='.$id)->data($data)->save();
            session("homeInfo['pic']", $name);
            $_SESSION['homeInfo']['pic'] = $name;
            // 文件上传成功
            $this->success('文件上传成功', U('User/myOrder'));
        }
    }

   
    // 删除地址
    public function delAddress()
    {
        if (IS_AJAX) {
            // 获取地址id
            $id = $_GET['id'];
            $addr = M('user_addr');
            // 执行删除
            $del = $addr->where('id='.$id)->delete();
            if ($del) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn(2);
            }
        }
    }


    // 修改地址
    public function updAddress()
    {
        if (IS_GET) {

            // 获取地址id
            $id = $_GET['id'];
            $area = M('areas');
            $addr = M('user_addr');
            // 找出全国的省级
            $result = $area->where('parent_id = 1')->select();
            // 查出该地址的详细信息
            $userinfo = $addr->where('id='.$id)->select();
            $this->assign('info', $userinfo);
            $this->assign('list', $result);
            $this->display();
        }

        if (IS_POST) {
            // 获取地址id
            $aid = $_POST['aid'];
            // 获取省级id
            $provinces = $_POST['provinces'];
            // 获取市级id
            $city = $_POST['city'];
            // 获取县级id
            $area = $_POST['area'];
            // 获取详细住址
            $detail = $_POST['detail'];
            // 获取手机
            $phone = $_POST['phone'];
            // 获取收件人
            $name = $_POST['name'];
            if (empty($provinces)) {
                 $this->error('无效地址');
            }
            $address = M('areas');
            $useraddr = M('user_addr');
            // 获取省份
            $provincesname = $address->where('id='.$provinces)->getField('area_name');
            // 获取城市
            $cityname = $address->where('id='.$city)->getField('area_name');
            // 获取县区
            $areaname = $address->where('id='.$area)->getField('area_name');
            // 拼接完整的详细地址
            $detailaddress = $provincesname.','.$cityname.','.$areaname.','.$detail;
            // 存入完整详细地址
            $data['addr'] = $detailaddress;
            // 存入收货人
            $data['user'] = $name;
            // 存入手机号码
            $data['phone'] = $phone;
            // 存入省份
            $data['provinces'] = $provincesname;
            // 存入城市
            $data['city'] = $cityname;
            // 存入县区
            $data['area'] = $areaname;
            // 存入详细地址
            $data['detail'] = $detail;
            $useraddrinfo = $useraddr->where('id='.$aid)->data($data)->save();
            
            if ($useraddrinfo) {
                $this->success('地址修改成功');
            } else {
                $this->error('地址修改失败');
            }
        }
    }

    // 修改默认地址
    public function addressstatus()
    {
        if (IS_AJAX) {
            // 获取用户id
            $uid = $_GET['uid'];
            // 获取地址id
            $id = $_GET['id'];
            $addr = M('user_addr');
            // 取消原来的默认地址状态
            $map['uid'] = $uid;
            $map['status'] = 1;  
            $upd = $addr->where($map)->save(['status'=>2]);
            if ($upd) {
                // 修改最新的默认地址状态
                $updstatus = $addr->where('id='.$id)->save(['status'=>1]);
                if ($updstatus) {
                    $this->ajaxReturn(1);
                } else {
                    $this->ajaxReturn(2);
                }
            } else {
                $this->ajaxReturn(2);
            }
        }
    }

    // 签到
    public function sign()
    {
        if (IS_AJAX) {
            // 获取id
            $id = $_GET['id'];
            $user = M('user');
            // 修改签到状态
            $upd = $user->where('id='.$id)->save(['sign'=>2]);
            if ($upd) {
                // 积分+5，修改签到状态
                $glod = $user->where('id='.$id)->setInc('glod', 5);
                $_SESSION['homeInfo']['sign'] = 2;
                $_SESSION['homeInfo']['glod'] = $_SESSION['homeInfo']['glod']+5;
                $this->ajaxReturn(1);
            }
        }
    }

    // 支付方法
    public function pay()
    {
        if (IS_GET) {
            // 获取订单id
            $oid = $_GET['oid'];
            $order = M('orders');
            // 支付就是修改订单状态
            $pay = $order->where('id='.$oid)->save(['status'=>2]);
            if ($pay) {
                $this->success('付款成功');
            } else {
                $this->error('付款失败');
            }
        }
        
    }

    // 收货方法
    public function receive()
    {
        if (IS_GET) {
            // 获取订单id
            $oid = $_GET['oid'];
            $order = M('orders');
            // 收货就是修改订单状态
            $receive = $order->where('id='.$oid)->save(['status'=>4]);
            if ($receive) {
                $this->success('收货成功');
            } else {
                $this->error('收货失败');
            }
        }
    }

    // 取消订单方法
    public function cancel()
    {
        if (IS_AJAX) {
            // 获取订单id
            $id = $_GET['oid'];
            $order = M('orders');
            // 把订单改为无效订单
            $cancel = $order->where('id='.$id)->save(['status'=>5]);
            if ($cancel) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn(2);
            }
        }
    }

    // 删除订单
    public function delord()
    {
        if (IS_AJAX) {
            // 获取订单id
            $id = $_GET['oid'];
            $order = M('orders');
            // 修改state
            $del = $order->where('id='.$id)->save(['state'=>2]);
            if ($del) {
                $this->ajaxReturn(1);
            } else {
                $this->ajaxReturn(2);
            }
        }
    }

    // 添加评论
    public function addComment()
    {
        if (IS_GET) {
            // 获取商品id，图片路径，商品名，用户id
            $arr['gid'] = $_GET['gid'];
            $arr['path'] = $_GET['path'];
            $arr['name'] = $_GET['name'];
            $arr['deid'] = $_GET['deid'];
            $arr['id'] = $_SESSION['homeInfo']['id'];
            
            $this->assign('list', $arr);
            $this->display();
        }
    }


    // 执行添加方法
    public function doAddComment()
    {
        if (IS_POST) {
            // 获取用户id，商品id，评论内容，评论时间，订单详情商品id
            $deid = $_POST['deid'];
            $id = $_POST['id'];
            $gid = $_POST['gid'];
            $ctext = $_POST['ctext'];
            $ctime = $_POST['ctime'];
            $data['uid'] = $id;
            $data['gid'] = $gid;
            $data['ctext'] = $ctext;
            $data['ctime'] = time();
            $comment = M('comment');
            $orderdetail = M('orders_detail');
            
            // 执行添加
            $add = $comment->data($data)->add();
            if ($add) {
                // 把该订单详情的商品评论状态改为已评论
                $upd = $orderdetail->where('id='.$deid)->save(['comment'=>2]);
                if ($upd) {
                    $this->success('评论成功', U('User/myAssess'));
                } else {
                    $this->error('评论失败');
                }
            } else {
                $this->error('评论失败');
            }
        }
    }
    
}