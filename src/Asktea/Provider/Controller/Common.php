<?php

namespace Asktea\Provider\Controller;

use Asktea\Model;
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

            // Load all question
            $oQuestion = new Model\Question($app['db']);
            $questions = $oQuestion->findAllWithNbVote();

            // Load all response
            $oComment   = new Model\Comment($app['db']);
            foreach ($questions as $id => $question)
            {
                $questions[$id]['comments'] = $oComment->getForQuestion($question['id']);
                $questions[$id]['creation_date'] = $app['utils']->ago($question['creation_date']);
            }

            return $app['twig']->render('common/homepage.html.twig', array('questions' => $questions));
        })
        ->bind('homepage');

        return $controllers;
    }
}
