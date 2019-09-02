<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/13
 * Time: 23:39
 */

namespace App\Models;


/**
 * Class App\Models\ChatMsgLog 
 * @property integer $id 
 * @property integer $group_id 组id
 * @property integer $user_id 用户id
 * @property string $user_nickname 用户昵称
 * @property string $user_head_img 用户头像
 * @property string $msg 消息内容
 * @property integer $status 0正常 -1删除
 * @property string $created_at 
 * @property string $updated_at 
 */
class ChatMsgLog extends Model
{
    protected $tableName = '{{chat_msg_log}}';
    protected $primaryKey = 'id';
}