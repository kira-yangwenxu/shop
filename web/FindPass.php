<?php
    // 实例化缓存
    $mem = new Memcache;

    $mem->addServer('localhost', 11211);
    // 获取发送过来的邮箱
    $getemail = $_GET['key'];
    // 获取该数组
    $val = $mem->get("'$getemail'");
    // 如果找不到
    if (!$val) {
    
        echo '<script>alert("该链接已失效，请重新发送");location.href="http://119.23.235.234/shop/index.php"</script>';exit;

    } else {
        // 获取邮箱
        $email = $val['email'];
        // 获取密码
        $pwd = $val['pwd'];
        // 连接数据库
        $dsn = 'mysql:host=119.23.235.234;dbname=shop;charset=UTF8';

        $pdo = new PDO($dsn, 'root', 'zxp123');
        // 执行更新密码操作
        $sql = "update shop_user set pwd='$pwd' where email='$email'";

        $result = $pdo->exec($sql);

        if ($result) {
            // 获取该用户信息
            $search = "select * from shop_user where username='$email'";

            $user = $pdo->query($search);

            $userstmt = $user->fetch(PDO::FETCH_ASSOC);
            // 获取用户id
            $id = $userstmt['id'];
            // 执行清空登录错误次数表语句
            $upd = "update shop_user_logininfo set logintime=NULL,error=NULL where id='$id'";

            $logininfo = $pdo->exec($upd);

            if ($logininfo) {
                $mem->delete("'$getemail'");
                echo '<script>alert("修改成功");location.href="http://119.23.235.234/shop/index.php"</script>';exit;

            } else {
                echo '<script>alert("修改失败，请重新修改");location.href="http://119.23.235.234/shop/index.php"</script>';exit;
            }

        } else {

            echo '<script>alert("修改失败，请重新修改");location.href="http://119.23.235.234/shop/index.php"</script>';exit;

        }
        
    }

    