<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/13
 * Time: 23:38
 */

namespace App\Models;


/**
 * Class App\Models\ChatGroup 
 * @property integer $id 
 * @property string $name 组名
 * @property string $text 用户id json array: [1,2,3]
 * @property integer $status 0正常 -1删除
 * @property string $created_at 
 * @property string $updated_at 
 */
class ChatGroup extends Model
{
    protected $tableName = '{{chat_group}}';
    protected $primaryKey = 'id';
}