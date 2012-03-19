<?php

namespace Asktea\Lib;

class Utils
{
    protected $app;
    
    public function __construct($app)
    {
        $this->app = $app;
    }
    
    public function hash($str, $salt = null)
    {
        $salt = $salt ? $salt : $this->app['secret'];
        return sha1($str.$salt);
    }

    public function ago($date, $granularity=1)
    {
        $date       = strtotime($date);
        $difference = time() - $date;
        $periods    = array(
            'décennie'  => 315360000,
            'année'     => 31536000,
            'mois'      => 2628000,
            'semaine'   => 604800,
            'jour'      => 86400,
            'heure'     => 3600,
            'minute'    => 60,
            'seconde'   => 1
        );

        $retval = '';

        // less than 5 seconds ago, let's say "just now"
        if ($difference < 5) 
        { 
            $retval = 'à l\'instant';
        } 
        else 
        {
            foreach ($periods as $key => $value) 
            {
                if ($difference >= $value) 
                {
                    $time       = floor($difference/$value);
                    $difference %= $value;

                    $retval     .= (isset($retval) ? ' ' : '') . $time . ' ';
                    $retval     .= (($time > 1 && $key != 'mois') ? $key.'s' : $key);

                    $granularity--;
                }

                if ($granularity == 0) 
                {
                    break;
                }
            }

            $retval = 'il y a ' . $retval;
        }

        return $retval;
    }
}