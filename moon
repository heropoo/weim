#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

$app = new \Moon\Application(__DIR__);
$app->runConsole();