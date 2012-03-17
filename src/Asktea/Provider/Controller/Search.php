<?php

namespace Asktea\Provider\Controller;

use Asktea\Model;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Search implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $controllers = new ControllerCollection();
        
        // *******
        // ** Search
        // *******
        $controllers->post('result.html', function(Request $request) use ($app)
        {
            $hits = $app['lucene']->find($request->get('search') . '~');
            $scores = array();

            foreach ($hits as $hit)
            {
                $scores[$hit->pk] = $hit->score;
            }

            $oQuestion = new Model\Question($app['db']);
            $questions = $oQuestion->findAllWithNbVote(array_keys($scores));

            foreach ($questions as $id => $question)
            {
                $sqrtNbVote = sqrt($question['nb_vote']);
                $scores[$id] += $sqrtNbVote * $sqrtNbVote;

                $questions[$id]['score'] = $scores[$id];
            }

            array_multisort($scores, SORT_ASC, $questions);

            return $app['twig']->render('search/result.html.twig', array(
                'questions' => $questions
            ));
        })
        ->bind('search.go');

        return $controllers;
    }
}
