<?php

namespace Asktea\Model;

class Comment extends BaseComment
{
	public function getForQuestion($question_id)
	{
		$sql = sprintf("
			SELECT id, body, creation_date 
			FROM %s 
			WHERE question_id = ?
			ORDER BY creation_date ASC", self::getSqlName());
		$aData = $this->connection->fetchAll($sql, array($question_id));

		$result = array();
		foreach( $aData as $data )
		{
			$result[$data['id']] = array(
				'body' => $data['body'],
				'creation_date' => $data['creation_date'],
			);
		}

		return $result;
	}
}