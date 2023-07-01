<?php
namespace Home\Model;
use Think\Model;

/**
 * User模型，用于处理繁琐的用户数据
 */
class UserModel extends Model 
{
    // 自动验证
    protected $_validate = array(

        // 验证用户名是否已经存在
        array('username','', '用户名已存在', 0, 'unique', 1),

        // 验证用户名是否合法
        array('username','/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]{3}$/', '非法用户名', 0, 'unique', 1),

        // 验证用户名长度
        

        // 验证两次密码是否一致
        array('pwd', 'pwd2', '两次密码不一致', 1, 'confirm', 1),

        // 验证密码长度
        array('pwd', '/^\w{6}$/', '密码要6位以上', 1, 'regex', 1),

        // 验证邮箱是否已经存在
        array('email','', '邮箱已存在', 0, 'unique', 1),
        
        // 验证邮箱是否合法
        array('email', '/^\w[-\w.+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z]{2,14}$/', '邮箱格式不合法', 0, 'unique', 1),
    );

    // 自动完成
    protected $_auto = array(

        array('pwd', 'password_hash', 1, 'function', (PASSWORD_DEFAULT)),
    );
    
}