<?php

namespace Asktea\Model;

abstract class BaseAnswer extends Base
{
    protected
        $id,
        $value;

    public function isNew()
    {
        return $this->id ? false : true;
    }

    protected function insert()
    {
        $stmt = $this->connection->insert('Answer', array(
            'value' => $this->value,
        ));
        
        $this->id = $this->connection->lastInsertId();
        
        return $stmt;
    }

    protected function update()
    {
        return $this->connection->update('Answer', array(
            'value' => $this->value,
        ), array('id' => $this->id));
    }
}