<?php
/**
 * Date: 2018/7/14
 * Time: 0:20
 */
Moon::command('fmc', 'FillModelCommentCommand::run', 'Fill Model Comment');

Moon::command('ws-server::swoole', 'WSServerCommand::swoole', 'Run Websocket Server by Swoole');
Moon::command('http-server::swoole', 'HttpServerCommand::swoole', 'Run Http Server by Swoole');