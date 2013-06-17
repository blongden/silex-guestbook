<?php
require_once 'vendor/autoload.php';
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\TranslationServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\HttpCacheServiceProvider;
use Blongden\Guestbook;

class Application extends Silex\Application {
    use Silex\Application\TwigTrait;
    use Silex\Application\UrlGeneratorTrait;
}

$app = new Application();

$app->register(new TwigServiceProvider(), [ 'twig.path' => __DIR__.'/views' ]);
$app->register(new TranslationServiceProvider(), [ 'locale_fallback' => 'en' ]);
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new HttpCacheServiceProvider(), [
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
