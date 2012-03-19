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
            
            if (count($hits) > 0)
            {
                $scores = array();

                foreach ($hits as $hit)
                {
                    $scores[$hit->pk] = $hit->score;
                }

                $oQuestion = new Model\Question($app['db']);
                $questions = $oQuestion->findAllWithNbVote(array_keys($scores));

                $oComment = new Model\Comment($app['db']);

                foreach ($questions as $id => $question)
                {
                    $sqrtNbVote = sqrt($question['nb_vote']);
                    $scores[$id] += $sqrtNbVote * $sqrtNbVote;

                    $questions[$id]['score'] = $scores[$id];

                    $questions[$id]['comments'] = $oComment->getForQuestion($question['id']);
                    $questions[$id]['creation_date'] = $app['utils']->ago($question['creation_date']);
                }

                array_multisort($scores, SORT_ASC, $questions);
            }
            else
            {
                $questions = array();
            }

            return $app['twig']->render('search/result.html.twig', array(
                'questions' => $questions
            ));
        })
        ->bind('search.go');

        return $controllers;
    }
}
