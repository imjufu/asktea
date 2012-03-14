<?php

namespace Asktea\Provider\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Admin implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();
        
        // *******
        // ** Signin
        // *******
        $controllers->get('/', function(Request $request) use ($app)
        {
            
        })
        ->bind('admin.signin');

        return $controllers;
    }
}
