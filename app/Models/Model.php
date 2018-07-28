<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/13
 * Time: 0:06
 */

namespace App\Models;

use Moon\Db\Table;
use Moon\Exception;

class Model extends Table
{
    public function __construct($tableName = null, $db = null)
    {
        $db = \Moon::$app->get('db');
        parent::__construct($tableName, $db);
    }

    public static function model(){
        return new static();
    }
//    public static function __callStatic($name, $arguments)
//    {
//        if(in_array($name, ['select', 'join', 'union', 'where', 'insert', 'update', 'delete'])){
//            $model = new static();
//            return call_user_func_array([$model, $name], $arguments);
//        }
//        throw new Exception('Call to undefined method ' . get_class() . '::' . $name . '()');
//    }
}