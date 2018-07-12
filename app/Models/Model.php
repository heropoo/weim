<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/13
 * Time: 0:06
 */

namespace App\Models;

use Moon\Db\Table;

class Model extends Table
{
    public function __construct($tableName = null, $db = null)
    {
        $db = \Moon::$app->get('db');
        parent::__construct($tableName, $db);
    }
}