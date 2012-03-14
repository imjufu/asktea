<?php

namespace Asktea\Provider\Controller;

use Asktea\Form;
use Asktea\Model;
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
        // ** Homepage
        // *******
        $controllers->get('/', function(Request $request) use ($app)
        {
            if (!$app['session']->has('admin'))
            {
                $app['session']->setFlash('error', 'Vous devez être authentifié pour accéder à cette ressource.');
                return new RedirectResponse($app['url_generator']->generate('admin.signin'));
            }

            // Load all question
            $oQuestion = new Model\Question($app['db']);
            $aQuestion = $oQuestion->findAllOrderedByNbVote();

            // Load all response
            $oComment   = new Model\Comment($app['db']);
            foreach ($aQuestion as $id => $question)
            {
                $aQuestion[$id]['comments'] = $oComment->getForQuestion($question['id']);
            }

            // Dispatch question
            $aQuestionAnswered = array();
            $aQuestionNotAnswered = array();
            foreach ($aQuestion as $question)
            {
                if (count($question['comments']) > 0)
                {
                    $aQuestionAnswered[] = $question;
                }
                else
                {
                    $aQuestionNotAnswered[] = $question;
                }
            }

            return $app['twig']->render('admin/homepage.html.twig', array(
                'questions' => $aQuestion,
                'questionsNotAnswered' => $aQuestionNotAnswered,
                'questionsAnswered' => $aQuestionAnswered,
            ));
        })
        ->bind('admin.homepage');

        // *******
        // ** Signin
        // *******
        $controllers->match('/signin', function(Request $request) use ($app)
        {
            $form = $app['form.factory']->create(new Form\SigninType());

            if( $request->getMethod() == 'POST' )
            {
                $form->bindRequest($request);
                if( $form->isValid() )
                {
                    $data = $form->getData();

                    $aData = Model\Admin::findOneByLogin($app['db'], $data['login']);
                
                    if ($aData && $aData['password'] == $app['utils']->hash($data['password']))
                    {
                        $app['session']->set('admin', array(
                            'id' => $aData['id'],
                            'login' => $aData['login'],
                        ));

                        // Redirect to homepage administration
                        return $app->redirect($app['url_generator']->generate('admin.homepage'));
                    }

                    $app['session']->setFlash('error', 'Identifiant / Mot de passe incorrect.');
                }
            }

            return $app['twig']->render('admin/signin.html.twig', array('form' => $form->createView()));
        })
        ->method('GET|POST')
        ->bind('admin.signin');

        // *******
        // ** Signout
        // *******
        $controllers->get('/signout', function(Request $request) use ($app)
        {
            $app['session']->clear();
            $app['session']->invalidate();
            
            return $app->redirect($app['url_generator']->generate('homepage'));
        })->bind('admin.signout');

        return $controllers;
    }
}
