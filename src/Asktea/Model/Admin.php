<?php

namespace Asktea\Model;

class Admin extends BaseAdmin
{
	static public function findOneByLogin($connection, $login)
    {
        return $connection->fetchAssoc('SELECT * FROM Admin WHERE login = ?', array($login));
    }
}