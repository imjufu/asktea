<?php

namespace Asktea\Provider\Controller;

use Asktea\Model;
use Asktea\Listener;
use Asktea\Lib;
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

            $form = $app['form.factory']->create(new Form\CommentType(), array('question_id' => $id));

            return $app['twig']->render('question/show.html.twig', array(
                'question' => $question, 
                'comments' => $comments,
                'form'     => $form->createView(),
            ));
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

                    // Inject Zend Lucene index
                    $oQuestion->attach(new Listener\LuceneIndexQuestion(new Lib\LuceneQuestionIndexer($app['lucene'])));

                    $oQuestion->author = $data['author'];
                    $oQuestion->contact = $data['contact'];
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

        // *******
        // ** Question delete
        // *******
        $controllers->get('remove/{id}.html', function(Request $request, $id) use ($app)
        {
            if (!$app['session']->has('admin'))
            {
                $app['session']->setFlash('error', 'Vous devez être authentifié pour accéder à cette ressource.');
                return new RedirectResponse($app['url_generator']->generate('admin.signin'));
            }

            $oQuestion  = new Model\Question($app['db']);
            $question = $oQuestion->find($id);
            
            if( !$question )
            {
                $app->abort(404, 'Cette question n\'existe pas');
            }

            if ($oQuestion->delete($id))
            {
                $app['session']->setFlash('success', 'Suppression effectuée avec succès.');
            }
            else
            {
                $app['session']->setFlash('error', 'Une erreur est survenue lors de la suppression de cette question.');
            }

            return $app->redirect($app['url_generator']->generate('admin.homepage'));
        })
        ->bind('question.remove');

        return $controllers;
    }
}
