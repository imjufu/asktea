<?php

namespace Asktea\Model;

abstract class BaseComment extends Base
{
    protected
        $id,
        $author,
        $body,
        $question_id;

    public function isNew()
    {
        return $this->id ? false : true;
    }

    protected function insert()
    {
        $stmt = $this->connection->insert(self::getSqlName(), array(
            'author' => $this->author,
            'body' => $this->body,
            'question_id' => $this->question_id,
            'creation_date' => date('c'),
        ));
        
        $this->id = $this->connection->lastInsertId();
        
        return $stmt;
    }

    protected function update()
    {
        return $this->connection->update(self::getSqlName(), array(
            'author' => $this->author,
            'body' => $this->body,
            'question_id' => $this->question_id,
        ), array('id' => $this->id));
    }

    static public function getSqlName()
    {
        return 'Comment';
    }
}