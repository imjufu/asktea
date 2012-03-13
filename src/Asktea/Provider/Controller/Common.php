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
        	return $app['twig']->render('common/homepage.html.twig');
        });

        return $controllers;
    }
}
