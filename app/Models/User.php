<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2018/7/12
 * Time: 23:29
 */
namespace App\Models;

use Moon\Db\Table;

class User extends Table
{
    protected $tableName = '{{user}}';
    protected $primaryKey = 'id';
}