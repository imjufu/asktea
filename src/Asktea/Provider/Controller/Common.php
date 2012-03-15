<?php

namespace Asktea\Provider\Controller;

use Asktea\Model\Question;
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
            $app['session']->set('menu', 'homepage');

            $oQuestion = new Question($app['db']);

            $questions = $oQuestion->findAllWithNbVote();

            return $app['twig']->render('common/homepage.html.twig', array('questions' => $questions));
        })
        ->bind('homepage');

        return $controllers;
    }
}
