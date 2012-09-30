<?php
use Blongden\Guestbook;
require_once 'vendor/autoload.php';

class Application extends Silex\Application
{
    use Silex\Application\TwigTrait;
    use Silex\Application\UrlGeneratorTrait;
}

$app = new Application();
$app['debug'] = true;
$app->register(new Silex\Provider\TwigServiceProvider(), [ 'twig.path' => __DIR__.'/views' ]);
$app->register(new Silex\Provider\TranslationServiceProvider(), [ 'locale_fallback' => 'en' ]);
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\HttpCacheServiceProvider(), [
    'http_cache.cache_dir' => __DIR__.'/cache',
    'http_cache.options' => [
        'debug' => true
    ]
]);

$app['guestbook'] = $app->share(function() {
    return new Guestbook('guestbook.json');
});

$app['request_time'] = $_SERVER['REQUEST_TIME'];

return $app;
