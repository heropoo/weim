<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/10
 * Time: 11:45
 */
namespace App\Services;

use App\Models\WxAccountFans;
use Moon\Config\Config;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
class WSService
{
    protected $user_list = [];

    public function run($ip, $port, $daemon = false)
    {
        $ws = new Server($ip, $port);

        if($daemon){
            //设置server运行时的各项参数
            $ws->set(array(
                'daemonize' => true, //是否作为守护进程
            ));
        }

        $ws->on('open', function (Server $ws, Request $request) {
            echo "Server: handshake success with fd '{$request->fd}'" . PHP_EOL;
            //通知其他童鞋们
            $openid = !empty($request->get['openid']) ? $request->get['openid'] : '';
            $group_id = !empty($request->get['group_id']) ? $request->get['group_id'] : '';
            $new_user = $this->setUser($request->fd, $openid, $group_id);

            if (!empty($new_user) && !empty($this->user_list[$group_id])) {
                $data = [
                    'type' => 'sys',
                    'user' => $new_user,
                    'msg' => "欢迎\"{$new_user['nickname']}\"上线，快和大家聊天吧~",
                    'time' => date('Y-m-d H:i')
                ];
                $ws->push($request->fd, json_encode($data));

                foreach ($this->user_list[$group_id] as $fd => $user) {
                    if ($fd == $request->fd) {
                        continue;
                    }
                    $data = [
                        'type' => 'sys',
                        'user' => $new_user,
                        'msg' => "您的好友\"{$new_user['nickname']}\"已上线，快和TA聊天吧~",
                        'time' => date('Y-m-d H:i')
                    ];
                    $ws->push($fd, json_encode($data));
                }
            }
        });

        $ws->on('message', function (Server $ws, Frame $frame) {
            echo "Receive from fd: {$frame->fd} data: {$frame->data} opcode: {$frame->opcode} finish: {$frame->finish}" . PHP_EOL;

            $user = $this->getUserByFd($frame->fd);
            if ($user) {
                $data = [
                    'type' => 'user',
                    'is_me' => true,
                    'user' => $user,
                    'msg' => htmlspecialchars($frame->data),
                    'time' => date('Y-m-d H:i')
                ];
                $ws->push($frame->fd, json_encode($data));

                $group_id = $user['group_id'];
                foreach ($this->user_list[$group_id] as $fd => $v) {
                    if ($fd == $frame->fd) {
                        continue;
                    }

                    $data = [
                        'type' => 'user',
                        'is_me' => false,
                        'user' => $user,
                        'msg' => htmlspecialchars($frame->data),
                        'time' => date('Y-m-d H:i')
                    ];
                    $ws->push($fd, json_encode($data));
                }
            }
        });

        $ws->on('close', function (Server $ws, $fd) {
            echo "client {$fd} closed" . PHP_EOL;
            $user = $this->popUser($fd);
            if ($user) {
                $data = [
                    'type' => 'sys',
                    'user' => $user,
                    'msg' => "您的好友\"{$user['nickname']}\"已下线",
                    'time' => date('Y-m-d H:i')
                ];
                $ws->push($fd, json_encode($data));
            }
        });

        echo "Swoole Websocket Server listening on $ip:$port" . PHP_EOL;
        echo 'Waiting for client to connect...' . PHP_EOL;
        $ws->start();
    }

    protected function getUserByFd($fd)
    {
        foreach ($this->user_list as $group_list) {
            if (key_exists($fd, $group_list)) {
                return $group_list[$fd];
            }
        }
        return false;
    }

    protected function setUser($fd, $openid, $group_id)
    {
        if (empty($openid) || empty($group_id)) {
            return false;
        }

        $user = WxAccountFans::whereOpenid($openid)->first();
        if (!empty($user)) {
            if (empty($this->user_list[$group_id])) {
                $this->user_list[$group_id] = [];
            }
            $this->user_list[$group_id][$fd] = [
                'openid' => $user['openid'],
                'nickname' => $user['nickname'],
                'headimgurl' => $user['headimgurl'],
                'group_id' => $group_id,
            ];
        } else {
            return false;
        }
        return $user;
    }

    protected function popUser($fd)
    {
        $user = $this->getUserByFd($fd);
        if (empty($user)) {
            return false;
        }
        $group_id = $user['group_id'];
        $user = $this->user_list[$group_id][$fd];
        unset($this->user_list[$group_id][$fd]);
        return $user;
    }
}