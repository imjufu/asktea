<?php

namespace Asktea\Provider\Controller;

use Asktea\Model;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Vote implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();
        
        // *******
        // ** Vote for a question
        // *******
        $controllers->get('{question_id}', function(Request $request, $question_id) use ($app)
        {
            $oQuestion = new Model\Question($app['db']);
            $oVote = new Model\Vote($app['db']);

            $question = $oQuestion->find($question_id);
            if( !$question )
            {
                return $app->abort(404, 'This question does not exists');
            }

            $oVote->question_id = $question['id'];
            $oVote->ip = $request->getClientIp();
            $oVote->save();

            // Redirect on question show page
            return $app->redirect(
                $app['url_generator']->generate(
                    'question.show', 
                    array('id' => $question_id)
                )
            );
        })
        ->bind('vote.new');

        return $controllers;
    }
}
