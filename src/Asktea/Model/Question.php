<?php

namespace Asktea\Model;

class Question extends BaseQuestion
{
	public function find($id)
    {
        if( !is_array($id) )
        {
            $id = array($id);
        }

        $sql = sprintf("SELECT q.id, q.author, q.title, q.body, q.creation_date FROM %s AS q WHERE q.id = ?", self::getSqlName());
        return $this->connection->fetchAssoc($sql, $id);
    }

    public function findWithNbVote($id)
    {
        if( !is_array($id) )
        {
            $id = array($id);
        }

        $sql = sprintf("
        	SELECT q.id, q.author, q.title, q.body, q.creation_date, COUNT(v.id) AS nb_vote
        	FROM %s AS q
        	LEFT JOIN %s AS v ON q.id = v.question_id
            WHERE q.id = ?
        	GROUP BY q.id", 
        	self::getSqlName(),
        	Vote::getSqlName()
        );
        return $this->connection->fetchAssoc($sql, $id);
    }

    public function findAll()
    {
        $sql = sprintf("SELECT id, author, title, body, creation_date FROM %s ORDER BY creation_date", self::getSqlName());
        $aData = $this->connection->fetchAll($sql);
        
        $result = array();
        foreach ($aData as $data)
        {
            $result[$data['id']] = array(
                'id' => $data['id'],
                'author' => $data['author'],
                'title' => $data['title'],
                'body' => $data['body'],
                'creation_date' => $data['creation_date'],
            );
        }
        
        return $result;
    }

    public function findAllWithNbVote()
    {
        $sql = sprintf("
            SELECT q.id, q.author, q.title, q.body, q.creation_date, COUNT(v.id) AS nb_vote
            FROM %s AS q
            LEFT JOIN %s AS v
                ON q.id = v.question_id
            GROUP BY q.id
            ORDER BY q.creation_date",
            self::getSqlName(),
            Vote::getSqlName()
        );
        $aData = $this->connection->fetchAll($sql);
        
        $result = array();
        foreach ($aData as $data)
        {
            $result[$data['id']] = array(
                'id' => $data['id'],
                'author' => $data['author'],
                'title' => $data['title'],
                'body' => $data['body'],
                'creation_date' => $data['creation_date'],
                'nb_vote' => $data['nb_vote'],
            );
        }
        
        return $result;
    }

    public function findAllOrderedByNbVote()
    {
        $sql = sprintf("
            SELECT q.id, q.author, q.title, q.body, q.creation_date, COUNT(v.id) AS nb_vote
            FROM %s AS q
            LEFT JOIN %s AS v
                ON q.id = v.question_id
            GROUP BY q.id
            ORDER BY nb_vote DESC",
            self::getSqlName(),
            Vote::getSqlName()
        );
        $aData = $this->connection->fetchAll($sql);
        
        $result = array();
        foreach ($aData as $data)
        {
            $result[$data['id']] = array(
                'id' => $data['id'],
                'author' => $data['author'],
                'title' => $data['title'],
                'body' => $data['body'],
                'creation_date' => $data['creation_date'],
                'nb_vote' => $data['nb_vote'],
            );
        }
        
        return $result;
    }
}