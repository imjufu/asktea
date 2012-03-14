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
}