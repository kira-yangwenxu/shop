<?php
    // 实例化缓存
    $mem = new Memcache;

    $mem->addServer('localhost', 11211);
    // 获取发送过来的key
    $getemail = $_GET['key'];
    // 从缓存中去到该数组
    $val = $mem->get("'$getemail'");
    // 如果找不到
    if (!$val) {
    
        echo '<script>alert("该链接已失效，请重新注册");location.href="http://119.23.235.234/shop/index.php"</script>';exit;

    } else {
        // 获取邮箱
        $email = $val['email'];
        // 获取密码
        $pwd = $val['pwd'];
        // 获取当前时间戳
        $addtime = $val['addtime'];
        // 连接数据库
        $dsn = 'mysql:host=119.23.235.234;dbname=shop;charset=UTF8';

        $pdo = new PDO($dsn, 'root', 'zxp123');
        // 准备插入语句
        $sql = "insert into shop_user(username,pwd,email,addtime) values('$email','$pwd','$email','$addtime')";
        // 获取结果
        $result = $pdo->exec($sql);
        // 如果成功
        if ($result) {
            // 找到新增的信息
            $search = "select * from shop_user where username='$email'";

            $user = $pdo->query($search);

            $userstmt = $user->fetch(PDO::FETCH_ASSOC);
            // 获取该id
            $id = $userstmt['id'];
            // 把该用户信息添加到登录错误次数表
            $insert1 = "insert into shop_user_logininfo(uid) values('$id')";
            $insert2 = "insert into shop_glod(uid) values('$id')";

            $logininfo = $pdo->exec($insert1);
            $gscore = $pdo->exec($insert2);

            if ($logininfo) {
                $mem->delete("'$getemail'");
                echo '<script>alert("激活成功");location.href="http://119.23.235.234/shop/index.php"</script>';exit;

            } else {
                echo '<script>alert("注册失败，请重新注册");location.href="http://119.23.235.234/shop/index.php"</script>';exit;
            }

        } else {

            echo '<script>alert("注册失败，请重新注册");location.href="http://119.23.235.234/shop/index.php"</script>';exit;

        }
        
    }

    