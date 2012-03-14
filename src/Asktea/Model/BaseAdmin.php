<?php

namespace Asktea\Model;

abstract class BaseAdmin extends Base
{
    protected
        $id,
        $login,
        $password;

    public function isNew()
    {
        return $this->id ? false : true;
    }

    public function insert()
    {
        $stmt = $this->connection->insert(self::getSqlName(), array(
            'login' => $this->login,
            'password' => $this->password,
        ));
        
        $this->id = $this->connection->lastInsertId();
        
        return $stmt;
    }

    public function update()
    {
        // Not implemented.
        return false;
    }

    static public function getSqlName()
    {
        return 'Admin';
    }
}