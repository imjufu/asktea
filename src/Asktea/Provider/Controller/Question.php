<?php

namespace Asktea\Provider\Controller;

use Asktea\Model as Model;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Question implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();
        
        // *******
        // ** Question show
        // *******
        $controllers->get('{id}.html', function($id) use ($app)
        {
            $oQuestion  = new Model\Question($app['db']);
            $oComment   = new Model\Comment($app['db']);

            $question = $oQuestion->findWithNbVote($id);

            if( is_null($question) )
            {
                $app->abort(404, 'Cette question n\'existe pas');
            }

            $comments = $oComment->getForQuestion($id);

            return $app['twig']->render('question/show.html.twig', array('question' => $question, 'comments' => $comments));
        })
        ->assert('id', '\d+')
        ->bind('question_show');

        // *******
        // ** Question creation form
        // *******
        $controllers->get('new.html', function() use ($app)
        {
            return $app['twig']->render('question/new.html.twig');
        })
        ->bind('question_new');

        return $controllers;
    }
}
