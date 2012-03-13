    id INTEGER PRIMARY KEY NOT NULL,
    question_id INTEGER NOT NULL,
    ip VARCHAR(255) NOT NULL,
    creation_date DATETIME NOT NULL
<?php

namespace Asktea\Model;

abstract class BaseVote extends Base
{
    protected
        $id,
        $question_id,
        $ip,
        $creation_date;

    public function isNew()
    {
        return $this->id ? false : true;
    }

    protected function insert()
    {
        $stmt = $this->connection->insert(self::getSqlName(), array(
            'question_id' => $this->question_id,
            'ip' => $this->ip,
            'creation_date' => date('c'),
        ));
        
        $this->id = $this->connection->lastInsertId();
        
        return $stmt;
    }

    protected function update()
    {
        return $this->connection->update(self::getSqlName(), array(
            'question_id' => $this->question_id,
            'ip' => $this->ip,
        ), array('id' => $this->id));
    }

    static public function getSqlName()
    {
        return 'Vote';
    }
}