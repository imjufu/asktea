<?php

namespace Asktea\Model;

use Doctrine\DBAL\Connection;

abstract class Base
{
	protected $connection;

	abstract protected function isNew();
	abstract protected function insert();
	abstract protected function update();
    
    static public function getSqlName()
    { 
        return null;
    }

	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}

    public function save()
    {
        return $this->isNew() ? $this->insert() : $this->update();
    }

    public function __set($property, $value)
    {
    	$this->$property = $value;
    	return $this;
    }

    public function __get($property)
    {
    	return $this->$property;
    }
}