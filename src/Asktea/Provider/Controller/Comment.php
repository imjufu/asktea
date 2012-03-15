<?php

namespace Asktea\Provider\Controller;

use Asktea\Form;
use Asktea\Model;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Comment implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();

        // *******
        // ** Create
        // *******
        $controllers->post('{id}/create.html', function(Request $request, $id) use ($app)
        {
            if (!$app['session']->has('admin'))
            {
                $app['session']->setFlash('error', 'Vous devez être authentifié pour accéder à cette ressource.');
                return new RedirectResponse($app['url_generator']->generate('admin.signin'));
            }
            
            $form = $app['form.factory']->create(new Form\CommentType(), array('question_id' => $id));

            $form->bindRequest($request);
            if( $form->isValid() )
            {
                $data = $form->getData();

                // Save comment into database
                $oComment = new Model\Comment($app['db']);
                $oComment->title = $data['title'];
                $oComment->body = $data['body'];
                $oComment->question_id = $data['question_id'];
                // FIXME author hardcoded
                $oComment->author = 'the ebook alternative';

                $oComment->save();

                // Redirect to question page
                $app['session']->setFlash('success', 'Réponse publiée avec succès.');
                return $app->redirect($app['url_generator']->generate('question.show', array('id' => $id)));
            }

            return $app['twig']->render('comment/new.html.twig', array(
                'form' => $form->createView(),
                'question_id' => $id,
            ));
        })
        ->bind('comment.create');

        return $controllers;
    }
}
