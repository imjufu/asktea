<?php

namespace Asktea\Model;

abstract class BaseQuestion extends Base
{
    protected
        $id,
        $title,
        $body,
        $creation_date;

    public function isNew()
    {
        return $this->id ? false : true;
    }

    protected function insert()
    {
        $stmt = $this->connection->insert(self::getSqlName(), array(
            'title' => $this->title,
            'body' => $this->body,
            'creation_date' => date('c'),
        ));
        
        $this->id = $this->connection->lastInsertId();
        
        return $stmt;
    }

    protected function update()
    {
        return $this->connection->update(self::getSqlName(), array(
            'title' => $this->title,
            'body' => $this->body,
        ), array('id' => $this->id));
    }

    static public function getSqlName()
    {
        return 'Question';
    }
}