<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:29
 */
namespace App\Models;

/**
 * Class App\Models\User 
 * @property integer $id 
 * @property string $username 用户名
 * @property string $nickname 昵称
 * @property string $head_img 头像
 * @property integer $sex 性别：0未知 1男 2女
 * @property string $password 密码
 * @property integer $status 0正常 -1删除
 * @property string $created_at 
 * @property string $updated_at 
 */
class User extends Model
{
    protected $tableName = '{{user}}';
    protected $primaryKey = 'id';
}