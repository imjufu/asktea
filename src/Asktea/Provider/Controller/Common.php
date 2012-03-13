<?php

namespace Asktea\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Common implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();
        
        // *******
        // ** Homepage
        // *******
        $controllers->get('/', function(Request $request) use ($app)
        {
            $oQuestion = new \Asktea\Model\Question($app['db']);

            $oQuestion->value = 'How are you ?';
            $oQuestion->save();

            die;

        	return $app['twig']->render('common/homepage.html.twig');
        });

        return $controllers;
    }
}
