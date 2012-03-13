<?php

namespace Asktea\Model;

abstract class BaseComment extends Base
{
    protected
        $id,
        $author,
        $body;

    public function isNew()
    {
        return $this->id ? false : true;
    }

    protected function insert()
    {
        $stmt = $this->connection->insert(self::getSqlName(), array(
            'author' => $this->author,
            'body' => $this->body,
        ));
        
        $this->id = $this->connection->lastInsertId();
        
        return $stmt;
    }

    protected function update()
    {
        return $this->connection->update(self::getSqlName(), array(
            'author' => $this->author,
            'body' => $this->body,
        ), array('id' => $this->id));
    }

    static public function getSqlName()
    {
        return 'Comment';
    }
}