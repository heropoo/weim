<?php
/**
 * Date: 2018/7/14
 * Time: 1:40
 */

namespace App\Commands;

use App\Models\Model;
use App\Services\FillModelCommentService;
use Moon\Command;
use Moon\Exception;

class FillModelCommentCommand extends Command
{
    public function run($modelName)
    {
        echo 'Filling ' . $modelName . PHP_EOL;
        if (!class_exists($modelName)) {
            throw new Exception("Class $modelName is not exists.");
        }
        if (!is_subclass_of($modelName, Model::class)) {
            throw new Exception("Class $modelName is not extends \App\Models\Model.");
        }
        /** @var Model $model */
        $model = new $modelName;
        $tableName = $model->getTableName();
        $db = $model->getDb();
        //var_dump($db);exit;
        $service = new FillModelCommentService($db, $tableName);
        $res = $service->fill($modelName);
        echo $res ? 'Success' : 'Failed';
    }
}