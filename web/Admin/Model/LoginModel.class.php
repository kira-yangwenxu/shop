<?php
namespace Admin\Model;
use Think\Model;

/**
 *登录模型
 */
class LoginModel extends Model 
{

    protected $tableName = 'admin';
    protected $_validate = [

    ['username', 'require', '用户名不能为空', 1 ],
    ['password', 'require', '密码不能为空', 1],

    ];


}