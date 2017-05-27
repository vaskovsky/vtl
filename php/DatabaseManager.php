<?php
// Copyright © 2017 Alexey Vaskovsky.
//
// This file is free software; you can redistribute it and/or
// modify it under the terms of the GNU Lesser General Public
// License as published by the Free Software Foundation; either
// version 3.0 of the License, or (at your option) any later version.
//
// This file is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// Lesser General Public License for more details.
//
// You should have received a copy of the GNU Lesser General Public
// License along with this file. If not, see
// <http://www.gnu.org/licenses/>
namespace VTL;
/**
 * Database connection manager.
 *
 * @author Alexey Vaskovsky
 */
class DatabaseManager
{
	/**
	 * Returns a database connection.
	 *
	 * @param string $dsn
	 *        	is a string that contains the information required to connect
	 *        	to the database.
	 *
	 * @param string $user
	 *        	is a user name for the DSN string.
	 *
	 * @param string $password
	 *        	is a password for the DSN string.
	 *
	 * @throws PDOException if a database access error occurs.
	 *
	 * @throws InvalidArgumentException :
	 *         if `$dsn` is null;
	 *         if `$user` is null;
	 *         if `$password` is null.
	 */
	public static function getConnection(
		$dsn = "", $user = "", $password = "")
	{
		// dsn: -null
		if (! is_string($dsn)) {
			throw new \InvalidArgumentException();
		}
		// user: -null
		if (! is_string($user)) {
			throw new \InvalidArgumentException();
		}
		// password: -null
		if (! is_string($password)) {
			throw new \InvalidArgumentException();
		}
		//
		static $pdo = null;
		if(empty($dsn)) {
			if(is_null($pdo)) {
				return Database::getConnection("pgsql:", "", "");
			}
		} else {
			if (empty($user)) {
				$user = null;
			}
			if (empty($password)) {
				$password = null;
			}
			$pdo = new \PDO(
				$dsn,
				$user,
				$password,
				array(
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
				));
		}
		return $pdo;
	}
}
