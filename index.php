<?php
$app = require 'bootstrap.php';
$app['debug'] = 1;
$app->match(
    '/',
    'Blongden\Controller\Index::indexAction'
)->method('GET|POST')->bind('homepage');

$app->get(
    '/messages',
    'Blongden\Controller\Index::messagesAction'
)->bind('messages');

$app['http_cache']->run();
