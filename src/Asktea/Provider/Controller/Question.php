<?php

namespace Asktea\Provider\Controller;

use Asktea\Model;
use Asktea\Form;
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
        // ** Best questions
        // *******
        $controllers->get('best.html', function() use ($app)
        {
            $app['session']->set('menu', 'question.best');

            $oQuestion = new Model\Question($app['db']);

            $questions = $oQuestion->findAllOrderedByNbVote();

            return $app['twig']->render('question/best.html.twig', array('questions' => $questions));
        })
        ->bind('question.best');

        // *******
        // ** Question show
        // *******
        $controllers->get('{id}.html', function($id) use ($app)
        {
            $app['session']->set('menu', null);

            $oQuestion  = new Model\Question($app['db']);
            $oComment   = new Model\Comment($app['db']);

            $question = $oQuestion->findWithNbVote($id);
            
            if( !$question )
            {
                $app->abort(404, 'Cette question n\'existe pas');
            }

            $comments = $oComment->getForQuestion($id);

            return $app['twig']->render('question/show.html.twig', array('question' => $question, 'comments' => $comments));
        })
        ->assert('id', '\d+')
        ->bind('question.show');

        // *******
        // ** Question creation
        // *******
        $controllers->match('new.html', function(Request $request) use ($app)
        {
            $app['session']->set('menu', 'question.new');

            $form = $app['form.factory']->create(new Form\QuestionType());

            if( $request->getMethod() == 'POST' )
            {
                $form->bindRequest($request);
                if( $form->isValid() )
                {
                    $data = $form->getData();

                    // Save question into database
                    $oQuestion = new Model\Question($app['db']);
                    $oQuestion->author = $data['author'];
                    $oQuestion->title = $data['title'];
                    $oQuestion->body = $data['body'];
                    $oQuestion->save();

                    // Redirect on question show page
                    return $app->redirect(
                        $app['url_generator']->generate(
                            'question.show', 
                            array('id' => $oQuestion->id)
                        )
                    );
                }
            }

            return $app['twig']->render('question/new.html.twig', array('form' => $form->createView()));
        })
        ->method('GET|POST')
        ->bind('question.new');

        return $controllers;
    }
}
