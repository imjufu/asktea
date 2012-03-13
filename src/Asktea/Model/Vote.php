<?php

namespace Asktea\Model;

class Vote extends BaseVote
{
	public function haveIpAlreadyVoted($question_id, $ip)
	{
		// Find all vote for this question and this ip
		$sql = sprintf("
			SELECT COUNT(1) AS nb_vote
			FROM %s
			WHERE
				question_id = ?
				AND ip = ?",
			self::getSqlName());
		$nb_vote = $this->connection->fetchColumn($sql, array($question_id, $ip), 0);

		return $nb_vote > 0;
	}
}