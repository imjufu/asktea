<?php

require_once __DIR__.'/autoload.php';

use Silex\Application;

$app = new Application();

// Autoloading
$app['autoloader']->registerNamespaces(array(
    'Symfony' => __DIR__.'/../vendor',
    'Asktea'  => __DIR__.'/../src/'
));

// Utils
$app['utils'] = $app->share(function() use ($app) {
    return new \Asktea\Lib\Utils($app);
});

use Silex\Provider\SymfonyBridgesServiceProvider;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\FormServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\TranslationServiceProvider;

$app->register(new SymfonyBridgesServiceProvider());
$app->register(new UrlGeneratorServiceProvider());
$app->register(new FormServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new SessionServiceProvider());
$app->register(new DoctrineServiceProvider(), array(
    'db.dbal.class_path'    => __DIR__.'/../vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/../vendor/doctrine-common/lib',
));

$app->register(new TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../src/Resources/views',
    'twig.class_path' => __DIR__.'/../vendor/twig/lib',
));

$app->register(new TranslationServiceProvider(array(
    'locale_fallback'           => 'fr',
    'locale'                    => 'fr',
    'translation.class_path'    => __DIR__.'/../Symfony/Component/Translation',
)));

// Local
$app['locale'] = 'fr';
$app['session.default_locale'] = $app['locale'];
$app['translator.messages'] = array();

// Load default configuration
require_once __DIR__.'/config.php.dist';

// Configuration overloading
if (file_exists(__DIR__.'/config.php')) 
{
    require_once __DIR__.'/config.php';
}

// Start session
$app['session']->start();

return $app;
